<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Videopilot grab Controller
 *
 * This class handles user account related functionality
 *
 * @package		Modules
 * @subpackage	Grab
 * @author		skywebit
 * @link		https://skywebit.com
 */



class Grab_model_core extends CI_model {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/content_model');
		$this->load->model('admin/video_model');

		$info = (empty($_SERVER['REMOTE_ADDR']))?'cli':'browser';
        if($info=='cli' || (!isset($_SERVER['SERVER_SOFTWARE']) && (php_sapi_name() == 'cli' || (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0))))
		{
		}
		else
		{
			ini_set('max_execution_time', 300);
		}
	}
	

	public function init()
	{

		$this->load->helper('date');
		$datestring = "%H%i%s";
		$time = time();

		$query = $this->db->get_where('sources',array('status'=>1,'auto_grabbing'=>1));
		$info = "";

		foreach($query->result() as $source)
		{
			$schedules = $this->get_cron_execution_times($source);

			$time = date('H:00:00', time());
			$current_time = strtotime($time);

			if(in_array($current_time, $schedules))
			{
				$this->grabsingle($source->id,'cron');
				$info .= $source->source_name." ".date('Y-m-d h:i:a', time())."\n"; 
			}
		}

		$this->write_in_log($info);

        $info = (empty($_SERVER['REMOTE_ADDR']))?'cli':'browser';
        if($info=='cli' || (!isset($_SERVER['SERVER_SOFTWARE']) && (php_sapi_name() == 'cli' || (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0))))
		{
			echo 'Cron executed';
			die;
		}

	}

    public function get_cron_execution_times($source)
    { 		
        $schedule_time = array();
    
    	$diff = (isset($source->grab_duration))?$source->grab_duration:2;

    	$j = 0;
        for($i=0;$i<24;$i+=$diff)
        {
        	if($j==0)
	        $schedule_time[0] = strtotime($source->start_on);
	        else
	        $schedule_time[$j] = $schedule_time[$j-1] + $source->grab_duration*60*60;
        	
        	$j++;
        }
        
        return $schedule_time;
    }


	public function grabsingle($source_id='',$action='cron',$nextPageToken='',$already_inserted=0)
	{
		$source = $this->content_model->get_source_data_by_id($source_id);

		$yt_api_key = get_settings('global_settings','yt_api_key','');
		if($yt_api_key=='')
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.lang_key('define_api_key_msg').'</div>');
			if($action=='cron')
			{
				$info = 'Empty api key'."\n";
				$this->write_in_log($info);
			}
			else
			{
				redirect(site_url('admin/content/allsources'));				
			}
		}


		$max_results = ($source->item_per_grab!=0)?$source->item_per_grab:10;

		if($source->source_type=='youtube_channel' || $source->source_type=='youtube_user')
		{
			$segments = explode('/',$source->rss_url);
			$channel_id = $segments[count($segments)-1];
	 		$url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&videoEmbeddable=true&maxResults=".$max_results."&channelId=".$channel_id."&order=date&key=".$yt_api_key;
		}
		elseif($source->source_type=='youtube_playlist')
		{
			$playlist_id = $source->rss_url;
			$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&type=video&videoEmbeddable=true&maxResults=".$max_results."&playlistId=".$playlist_id."&order=date&key=".$yt_api_key;
		}
		elseif($source->source_type=='youtube_search')
		{
			$search_keys = urlencode($source->rss_url);
			$url = "https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&videoEmbeddable=true&maxResults=".$max_results."&key=".$yt_api_key."&order=date&q=".$search_keys;
		}
		
		if(!empty($nextPageToken))
		{
			$url .= '&pageToken='.$nextPageToken;
		}

		$res_info = check_youtube_url_validity($url);

		if(!$res_info['result'])
		{

			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.lang_key('url_not_valid').' [Actual url to error: <a target="blank" href="'.$url.'">Click</a>]</div>');
			if($action=='cron')
			{
				$info = 'Invalid '.$source->source_type.' url/id for '.$source->source_name.'[id:'.$source_id.'])'.'Actual url to error: '.$url."\n";
				$this->write_in_log($info);
			}
			else
			{
				redirect(site_url('admin/content/allsources'));				
			}
		}

		$content = get_url_content($url);
		$videos = json_decode($content);
		
		$insert_count = 0;

		foreach ($videos->items as $item) 
		{
			if(!isset($item->snippet->thumbnails->high->url) || empty($item->snippet->thumbnails->high->url))
				continue;

			if($source->source_type=='youtube_channel' || $source->source_type=='youtube_user')
			{
				$youtube_id = (isset($item->id->videoId))?$item->id->videoId:'';
			}
			elseif($source->source_type=='youtube_playlist')
			{
				$youtube_id = (isset($item->snippet->resourceId->videoId))?$item->snippet->resourceId->videoId:'';
			}
			else
			{
				$youtube_id = (isset($item->id->videoId))?$item->id->videoId:'';
			}

			if(empty($youtube_id))
				continue;

			$description = $item->snippet->description;
			$description = get_excerpt($description); 

			$data = array();
			$data['source_id'] 			= $source_id;
			$data['youtube_id']			= $youtube_id;
			$data['category'] 			= $source->parent_category;
			$data['sub_category'] 		= $source->sub_category;
			$data['title'] 				= $item->snippet->title;
			$data['description'] 		= $description;
			$data['full_description'] 	= $item->snippet->description;
			$data['media'] 				= get_media_url(get_max_thumb_url($item->snippet->thumbnails),$youtube_id);

			$info = $this->get_single_video_info($youtube_id,'array');

			if(is_array($info['tags']))
			$data['tags'] 				= implode(",",$info['tags']);
			else
			$data['tags'] 				= $info['tags'];

			$time = time();
			if($source->use_youtube_publish_time==1)
			$data['publish_time'] 		= isset($item->snippet->publishedAt)?strtotime($item->snippet->publishedAt):$time;
			else
			$data['publish_time'] 		= $time;
		

			$data['search_meta'] 		= $data['title'].' '.$data['description'].' '.$data['tags'].' '.get_category_title_by_id($source->parent_category).' '.get_source_title_by_id($source_id);


			$this->load->config('webhelios');
			$blocked_words = $this->config->item('blocked_words');
			if(!empty($blocked_words))
			{
				$blocked_words_array = explode(",", $blocked_words);
				if(0 < count(array_intersect(array_map('strtolower', explode(' ', $data['title']." ".$data['full_description'])), $blocked_words_array)))
					continue;
			}

			$match_words = $this->config->item('match_words');
			if(!empty($match_words))
			{
				$match_words_array = explode(",", $match_words);
				if(0 >= count(array_intersect(array_map('strtolower', explode(' ', $data['title']." ".$data['full_description'])), $match_words_array)))
					continue;
			}

			
			$result = $this->video_model->check_if_unique_video(array('youtube_id'=>$youtube_id));
			
			if($result<=0)
			{				
				$insert_count++;
				$data['grab_time'] 		= time();
				$data['grab_action'] 	= 'manual';
				$data['status'] 		= 1;
				
				$this->video_model->insert_video($data);
			}
			else
			{
				//not unique videos goes here
			}

		}

		$data = array();
		$data['last_grab_time'] = time();
		$this->db->update('sources',$data,array('id'=>$source_id));
		//
		if(!empty($videos->nextPageToken) && $already_inserted+$insert_count<$max_results && $insert_count>0)
		{
			$nextPageToken = $videos->nextPageToken;
			$this->grabsingle($source_id,$action,$nextPageToken,$insert_count);
		}
		else
		{
			if($action!='cron')
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('videos_grabbed').'</div>');
				redirect(site_url('admin/content/allsources'));
			}
		}		
	}

	function get_channel_id_from_user($user_name='')
	{

    	$yt_api_key = get_settings('global_settings','yt_api_key','');
    	$channel_url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&forUsername='.$user_name.'&key='.$yt_api_key;
    	$content = get_url_content($channel_url);
		$info = json_decode($content);
		
		if(isset($info->items[0]->id))
			return $info->items[0]->id;
		else
			return '';
	}

	function get_single_video_info($url,$return_type = 'json')
	{
		$video_id = get_youtube_video_id_from_url($url);

		$yt_api_key = get_settings('global_settings','yt_api_key','');
		$json = get_url_content('https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key='.$yt_api_key.'&part=snippet');
		$yt_data = json_decode($json);

		$data = array();
		$data['youtube_id'] 	= $yt_data->items[0]->id;
		$data['title'] 			= $yt_data->items[0]->snippet->title;
		$data['description'] 	= $yt_data->items[0]->snippet->description;
		$data['media'] 			= get_max_thumb_url($yt_data->items[0]->snippet->thumbnails);
		$data['tags'] 			= $yt_data->items[0]->snippet->tags;

		if($return_type!='json')
			return $data;
		else
		{
			echo json_encode($data);
			die;			
		}
	}

	function write_in_log($info)
	{
		$this->load->helper('file');
		if ( ! write_file('./assets/logs/cron_log.txt', $info,"a+"))
		{
		     #echo 'Unable to write the file';
		}
		else
		{
		     #echo 'File written!';
		}
	}
}
/* End of file grab_model_core.php */
/* Location: ./application/modules/show/controllers/grab_model_core.php */
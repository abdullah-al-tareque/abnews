<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classified admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ShowCore
 * @author		skywebit
 * @link		https://skywebit.com
 */



class Show_core extends CI_controller {

	var $PER_PAGE;
	var $active_theme = '';

	public function __construct()
	{
		parent::__construct();
		//is_installed(); #defined in auth helper		
		
		$this->PER_PAGE = get_per_page_value();#defined in auth helper
		if(get_settings('global_settings','enable_cache','No')=='Yes')
		{
			$this->output->cache(2);			
		}

		$this->active_theme = get_active_theme();
		
		$this->load->model('admin/video_model');
		$this->load->model('show/show_model');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        #updated on version 1.4
        $info = (empty($_SERVER['REMOTE_ADDR']))?'cli':'browser';
        if($info=='cli' || (!isset($_SERVER['SERVER_SOFTWARE']) && (php_sapi_name() == 'cli' || (is_numeric($_SERVER['argc']) && $_SERVER['argc'] > 0))))
	    {
	        $this->load->model('grab/grab_model');
	        $this->grab_model->init();	    	
	    }
	    #end
	}

	public function index()
	{
		$this->home();	
	}

	public function home($banner_type='layer-slider')
	{			
		$value = array();
		
		if($banner_type=='google-map')
		$value['banner_type'] = 'Google Map';
		elseif($banner_type=='parallax-slider')
		$value['banner_type'] = 'Parallax Slider';
		else
		$value['banner_type'] = 'Layer Slider';

		$data['content'] 	= load_view('home_view',$value,TRUE);
		$data['alias']	    = 'home';
		load_template($data,$this->active_theme);
	}

	public function video($id='')
	{			
		$value = array();
		$this->load->model('admin/video_model');
		$value['post'] = $this->video_model->get_video_by_id($id);

		$title = '';
		$description = '';

		$data['alias']	    = 'detail';
		$id = 0;
		$status = 0;
		if($value['post']->num_rows()>0)
		{
			$row = $value['post']->row();
            $value['similar_posts'] = $this->video_model->get_similar_videos_by_category($row->category, $row->sub_category, $row->id);
            $data['content'] 		= load_view('detail_view',$value,TRUE);
			$status = $row->status;			
			$id = $row->id;
			$seo['key_words'] 	= $row->tags;
			$title 				= $row->title;
			$description 		= $row->description;
			$this->video_model->inc_view_count_by_id($id);
		}


		if($status!=1)
		{
			// added on version 1.4
			$this->output->set_status_header('404');
			$data['content'] 	= load_view('404_view','',TRUE);
	        load_template($data,$this->active_theme,'template_view');			
		}
		else
		{
			$data['sub_title']			= $title;
			$description 	= strip_tags($description);
			$description 	= str_replace("'","",$description);
			$description 	= str_replace('"',"",$description);
			$seo['meta_description']	= $description;
			$data['seo']				= $seo;
			load_template($data,$this->active_theme);			
		}
	}

	public function categoryvideos($category_id='',$start='0')
    {
    	$value['icon'] 		  = get_category_fa_icon($category_id);
    	$value['category_id'] = $category_id;
    	$value['posts'] 	= $this->video_model->get_category_videos_by_range($category_id,$start,$this->PER_PAGE);
		$total 				= $this->video_model->get_category_videos_by_range($category_id,'total');
		$value['pages']		= configPagination('show/categoryvideos/'.$category_id,$total,4,$this->PER_PAGE);
		$value['title']		= get_category_title_by_id($category_id);
        $data['content'] 	= load_view('allvideos_view',$value,TRUE);
        $data['alias']	    = 'categoryvideos';
        $data['meta_desc']  = get_category_title_by_id($category_id); //added on version 1.5
        $data['sub_title']	= get_category_title_by_id($category_id);
        load_template($data,$this->active_theme);
    }

    public function sourcevideos($source_id='',$start='0')
    {
    	$value['icon'] 		  = '';
    	$value['source_id'] = $source_id;
    	$value['posts'] 	= $this->video_model->get_source_videos_by_range($source_id,$start,$this->PER_PAGE);
		$total 				= $this->video_model->get_source_videos_by_range($source_id,'total');
		$value['pages']		= configPagination('show/sourcevideos/'.$source_id,$total,4,$this->PER_PAGE);
		$value['title']		= get_source_title_by_id($source_id);
        $data['content'] 	= load_view('allvideos_view',$value,TRUE);
        $data['alias']	    = 'sourcevideos';
        $data['meta_desc']	= get_source_title_by_id($source_id); //added on version 1.5
        $data['sub_title']	= get_source_title_by_id($source_id);
        load_template($data,$this->active_theme);
    }

    public function datevideos($publish_time='',$start='0')
    {
    	$value['icon'] 		  = '';
    	$value['publish_time'] = $publish_time;
    	$value['posts'] 	= $this->video_model->get_date_videos_by_range($publish_time,$start,$this->PER_PAGE);
		$total 				= $this->video_model->get_date_videos_by_range($publish_time,'total');
		$value['pages']		= configPagination('show/datevideos/'.$publish_time,$total,4,$this->PER_PAGE);
		$value['title']		= translateable_date($publish_time);
        $data['content'] 	= load_view('allvideos_view',$value,TRUE);
        $data['meta_desc']	= translateable_date($publish_time); //added on version 1.5
        $data['sub_title']	= translateable_date($publish_time);
        $data['alias']	    = 'datevideos';
        load_template($data,$this->active_theme);
    }

    public function search()
    {
		$string = '';
    	foreach ($_POST as $key => $value) {

    		if(is_array($value))
    		{
    			$val = '';
    			foreach ($value as $row) 
    			{
    				$val .= urlencode($row).',';
    			}

    			$string .= $key.'='.$val.'|';	
    		}
    		else
			{
	    		$string .= $key.'='.urlencode($value).'|';			
			}    			
    	}
    	redirect(site_url('show/searchvideos/'.$string));
    }

    public function searchvideos($string='',$start='0')
    {
    	$data = array();
    	$string = rawurldecode($string);
    	$values = explode("|",$string);

    	foreach ($values as $value) {
    		$get 	= explode("=",$value);
    		$s 		= (isset($get[1]))?$get[1]:'';
    		$val 	= explode(",",$s);

    		if(count($val)>1)
    		{
	    		$data[$get[0]] = $val;
    		}
    		else
	    		$data[$get[0]] = (isset($get[1]))?$get[1]:'';
    	}

    	array_filter($data);
    	$value = array();
    	$value['posts'] 	= $this->video_model->get_videos_search_result($data,$start,$this->PER_PAGE);
		$total 				= $this->video_model->get_videos_search_result($data,'total');
		$value['pages']		= configPagination('show/searchvideos/'.$string,$total,4,$this->PER_PAGE);
		$value['title']		= lang_key('search_result_for');
		$data 				= array();
        $data['content'] 	= load_view('allvideos_view',$value,TRUE);
        $data['alias']	    = 'search';
        load_template($data,$this->active_theme);

    }


    public function terms()
    {
        $data['content'] 	= load_view('termscondition_view','',TRUE);
        $data['alias']	    = 'terms';
        load_template($data,$this->active_theme);
    }


	public function terms_check($str)
	{
		if (isset($_POST['terms_conditon'])==FALSE)
		{
			$this->form_validation->set_message('terms_check', lang_key('must_accept_terms'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	
    #********** page functions start**************#
	public function page($alias='')
	{	
		$value['alias']  = $alias;
		$value['page']  = TRUE;
		$value['query']  = $this->show_model->get_page_by_alias($alias);
		$data['content'] = load_view('page_view',$value,TRUE,$this->active_theme);
		$data['alias']   = $alias;
		load_template($data,$this->active_theme);
	}
    #********** page functions end**************#


    #********** Other page functions start**************#
    public function contact()
	{
		$a = rand (1,10);
		$b = rand (1,10);
		$c = rand (1,10)%3;
		if($c==0)
		{
			$operator = '+';
			$ans = $a+$b;
		}
		else if($c==1)
		{
			$operator = 'X';
			$ans = $a*$b;
		}
		else if($c==2)
		{
			$operator = '-';
			$ans = $a-$b;
		}

		$this->session->set_userdata('security_ans',$ans);
		$value['question']  = $a." ".$operator." ".$b." = ?";

		$data['content'] 	= load_view('contact_view',$value,TRUE);
		$data['alias']	    = 'contact';
		load_template($data,$this->active_theme);
	}

	function check_code($str)
	{
		if ($str != $this->session->userdata('security_ans'))
		{
			$this->form_validation->set_message('check_code', 'The %s is not correct');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function sendcontactemail()
	{
		$this->form_validation->set_rules('sender_name', 'Name', 'required');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('msg', 'Message', 'required');
		$this->form_validation->set_rules('ans', 'Code', 'required|callback_check_code');

		if ($this->form_validation->run() == FALSE)
		{
			$this->contact();	
		}
		else
		{

			$this->load->library('email');
			$this->email->from($this->input->post('sender_email'),$this->input->post('sender_name'));
			$this->email->to(get_settings('webadmin_email','contact_email','support@example.com'));

			$this->email->subject(lang_key('contact_subject'));
			$this->email->message($this->input->post('msg').'<br/>'.lang_key('phone').': '.$this->input->post('phone'));
			$this->email->send();

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('mail_sent').'</div>');
			redirect(site_url('show/contact/'));			

		}

	}

	public function feed($type='all',$id='')
	{
		# updated on version 1.4
		$this->load->model('show_model');
		$this->load->helper('xml');
		$this->load->helper('text');
		$this->load->helper('date');

		$curr_lang = default_lang();

		$value = array();	
		$value['curr_lang'] = $curr_lang;	
		$value['feed_name'] = translate(get_settings('site_settings','site_title','Videopilot'));
        $value['encoding'] = 'utf-8';
        $value['feed_url'] = site_url('show/feed/'.$type.'/'.$id);
        $value['page_description'] = lang_key('latest_videos');
        $value['page_language'] = $curr_lang.'-'.$curr_lang;
        $value['creator_email'] = get_settings('webadmin_email','contact_email','');
        if($type=='category' && $id!='')
        {
	        $value['posts'] 	= $this->video_model->get_category_videos_by_range($id,'0',20);
			$value['feed_name'] = translate(get_settings('site_settings','site_title','Videopilot')).': '.get_category_title_by_id($id);        	
        }
        elseif($type=='source' && $id!='')
        {
	    	$value['posts'] 	= $this->video_model->get_source_videos_by_range($id,'0',20);
			$value['feed_name'] = translate(get_settings('site_settings','site_title','Videopilot')).': '.get_source_title_by_id($id);        	        	
        }
        elseif($type=='date' && $id!='')
        {
    		$value['posts'] 	= $this->video_model->get_date_videos_by_range($id,'0',20);
    		$value['feed_name'] = translate(get_settings('site_settings','site_title','Videopilot')).': '.translateable_date($id);        	        	
        }
        else
        $value['posts']	=  $this->show_model->get_videos_by_range(0,20,'publish_time','desc');
        header("Content-Type: application/rss+xml");
		load_view('rss_view',$value,FALSE,$this->active_theme);
	}

    public function sitemap(){
        $this->load->helper('xml');
        $this->load->helper('file');
        $xml = read_file('./sitemap.xml');

        $value['title']='site map';

        $value['links'] = simplexml_load_string($xml);

        $data['content'] = load_view('sitemap_view',$value,TRUE,$this->active_theme);

        $data['alias']   = 'sitemap';

        load_template($data,$this->active_theme);
    }

    public function load_sub_categories($category_id,$any=FALSE)
    {
    	$this->load->model('admin/category_model');
    	$query = $this->category_model->get_all_subcategories_by_parent($category_id);
    	
    	if($any)
    	$options = '<option value="">'.lang_key('any_subcategory').'</option>';
		else    		
    	$options = '<option value="">'.lang_key('select_one').'</option>';
    	foreach($query->result() as $row)
    	{
    		$options .= '<option value="'.$row->id.'">'.$row->title.'</option>';
    	}

    	echo $options;
    	die;
    }

    public function show404()
	{
		$this->output->set_status_header('404');
		$data['content'] 	= load_view('404_view','',TRUE);
        load_template($data,$this->active_theme,'template_view');
	}
	
	// added on version 1.3
	function allsubcat($id='')
	{
		$this->load->model('post_model');
		$value['posts'] = $this->post_model->get_all_child_categories($id,'all');
		load_view('subcategory_view',$value,FALSE);
	}
	//end

}





/* End of file install.php */

/* Location: ./application/modules/show/controllers/show_core.php */
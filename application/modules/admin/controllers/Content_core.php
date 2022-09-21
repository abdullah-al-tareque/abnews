<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Content  Controller
 *
 * This class handles only classified related functionality
 *
 * @package		Admin
 * @subpackage	admin
 * @author		skywebit
 * @link		https://skywebit.com
 */


class Content_core extends CI_Controller {

	var $per_page = 10;

	public function __construct()
	{

		parent::__construct();
		//is_installed(); #defined in auth helper

		checksavedlogin(); #defined in auth helper

		if(!is_admin() && !is_agent())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
		$this->load->helper('text');
		// $this->load->model('admin/classified_model');
		$this->load->model('admin/content_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	#****************** post function start *********************#
	public function index()
	{
		if(is_admin())
		{
			redirect(site_url('admin'));
		}
		else
		{
			redirect(site_url('admin/content/allvideos'));
		}
	}

	/*public function allposts($start='0')
	{
		$value 				= array();
        $data['title'] 		= lang_key_admin('all_posts');
		$data['content'] 	= load_admin_view('classified/all_posts_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function allposts_ajax($start='0')
	{
		$value['posts']  	= $this->classified_model->get_all_post_based_on_user_type($start,$this->per_page,'create_time','desc');
		$total  			= $this->classified_model->get_all_post_based_on_user_type('total',$this->per_page,'create_time','desc');
		$value['pages']		= configPagination('admin/classified/allposts_ajax',$total,5,$this->per_page);
		load_admin_view('classified/all_posts_ajax_view',$value);
	}*/

	#delete a post
	public function deletepost($page='0',$id='',$confirmation='')
	{
		if(!is_admin() && !is_agent())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/classified/deletepost/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					if(is_agent())
					{
						$post = $this->classified_model->get_post_by_id($id);
						if($post->created_by != $this->session->userdata('user_id')){

							$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key_admin('invalid_post_id').'</div>');
						}
						else
						{
							$this->classified_model->delete_post_by_id($id);
							$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('post_deleted').'</div>');

						}

					}
					else
					{
						$this->classified_model->delete_post_by_id($id);
						$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('post_deleted').'</div>');

					}
				}
			}
			redirect(site_url('admin/classified/allposts/'.$page));		
		}		
	}

	#approve a post
	public function approvevideo($page='0',$id='',$confirmation='')
	{		
		if(!is_admin() && !is_moderator())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data = array();

			$data['publish_time'] 		= $time;
			$data['status'] 			= 1;

			$this->content_model->update_video_data($data,$id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('post_approved').'</div>');
		}
		redirect(site_url('admin/content/allvideos/'.$page));
	}

	public function draftvideo($page='0',$id='',$confirmation='')
	{
		if(!is_admin() && !is_moderator())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$data = array();
			$data['status'] 			= 2;

			$this->content_model->update_video_data($data,$id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('post_drafted').'</div>');
		}
		redirect(site_url('admin/content/allvideos/'.$page));
	}


	#****************** post functions end *********************#

	public function allsources()
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$value 				= array();
		$value['posts']     = $this->content_model->get_all_sources();
        $value['title'] 	= lang_key_admin('all_sources');
        $data['title'] 		= lang_key_admin('all_sources');
		$data['content'] 	= load_admin_view('content/allsources_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
	

	public function addsource($id="")
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$value 				= array();
		$value['action']    = ($id=='')?'new':'edit';
		$value['id']		= $id;
		if($id!='')
		{

			$value['post'] = $this->content_model->get_source_data_by_id($id);
		}

        $value['title'] 		= ($id=='')?lang_key_admin('addsource'):lang_key_admin('edit_source');
        $data['title'] 		= ($id=='')?lang_key_admin('addsource'):lang_key_admin('edit_source');
		$data['content'] 	= load_admin_view('content/addsource_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function savesource()
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$this->form_validation->set_rules('source_name',lang_key_admin('source_name'),'required|xss_clean');
		$this->form_validation->set_rules('source_type',lang_key_admin('source_type'),'required|xss_clean');
		$this->form_validation->set_rules('rss_url',lang_key_admin('rss_url'),'required|xss_clean');
		$this->form_validation->set_rules('parent_category',lang_key_admin('parent_category'),'required|xss_clean');
		$this->form_validation->set_rules('auto_grabbing',lang_key_admin('auto_grabbing'),'required|xss_clean');

		if($this->input->post('auto_grabbing')==1)
		{
			$this->form_validation->set_rules('start_on',lang_key_admin('start_on'),'required|xss_clean');
			$this->form_validation->set_rules('grab_duration',lang_key_admin('grab_duration'),'required|xss_clean');
			$this->form_validation->set_rules('item_per_grab',lang_key_admin('item_per_grab'),'required|xss_clean');

		}

		$action = $this->input->post('action');
		$id = $this->input->post('id');

		if ($this->form_validation->run() == FALSE)
		{
			$this->addsource($id);	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				redirect(site_url('admin/content/addsource/'.$id));	
			}
			else
			{
				$data = array();
				$data['source_name'] 	 = $this->input->post('source_name');
				$data['source_type'] 	 = $this->input->post('source_type');
				if($data['source_type']=='youtube_channel')
				$data['rss_url'] 		 = get_channel_id_from_url($this->input->post('rss_url'));
				else if($data['source_type']=='youtube_user')
				$data['rss_url'] 		 = get_channel_id_from_user_url($this->input->post('rss_url'));
				else if($data['source_type']=='youtube_playlist')
				$data['rss_url'] 		 = get_playlist_id_from_url($this->input->post('rss_url'));
				else
				$data['rss_url'] 		 = $this->input->post('rss_url');
				$data['parent_category'] = $this->input->post('parent_category');
				$data['sub_category'] 	 = ($this->input->post('sub_category')!='')?$this->input->post('sub_category'):0;
				$data['auto_grabbing']   = $this->input->post('auto_grabbing');
				$data['start_on'] 		 = $this->input->post('start_on');
				$data['grab_duration']   = $this->input->post('grab_duration');
				$data['item_per_grab']   = $this->input->post('item_per_grab');
				$data['use_youtube_publish_time']   = ($this->input->post('use_youtube_publish_time')!='')?1:0;

				$time = time();

				$data['last_update_time']   = $time;
				$data['created_by']   		= $this->session->userdata('user_id');
				$data['status']   			= 1;

				if($id=='')
				{
					$data['create_time']   = $time;
					$id = $this->content_model->insert_source_data($data);
					$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key_admin('source_added').'</div>');
				}
				else
				{
					$data['create_time']   = $time;
					$this->content_model->update_source_data($data,$id);	
					$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key_admin('source_updated').'</div>');				
				}

				redirect(site_url('admin/content/addsource/'.$id));	
			}
		}
	}

	#delete a post
	public function deletesource($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/content/deletesource/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->content_model->delete_source_data_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('source_deleted').'</div>');
				}
			}
			redirect(site_url('admin/content/allsources/'.$page));		
		}		
	}



    public function uploadfeaturedimage()
    {
    	// print_r($_FILES);
    	// die;
        $dir_name 					= 'images/';
        $config['upload_path'] 		= './uploads/'.$dir_name;
        $config['allowed_types'] 	= 'gif|jpg|png|jpeg';
        $config['max_size'] 		= '5120';
        $config['min_width'] 		= '300';
        $config['min_height'] 		= '256';

        $this->load->library('dbcupload', $config);
        $this->dbcupload->display_errors('', '');

        if($this->dbcupload->do_upload('photoimg'))
        {
            $data = $this->dbcupload->data();
            $this->load->helper('date');

            $format = 'DATE_RFC822';
            $time = time();
            #create_rectangle_thumb('./uploads/'.$dir_name.$data['file_name'],'./uploads/thumbs/');

            $media['media_name'] 		= $data['file_name'];
            $media['media_url']  		= base_url().'uploads/'.$dir_name.$data['file_name'];
            $media['create_time'] 		= standard_date($format, $time);
            $media['status']			= 1;

            $status['error'] 	= 0;
            $status['name']	= $data['file_name'];
        }

        else

        {

            $errors = $this->dbcupload->display_errors();

            $errors = str_replace('<p>','',$errors);

            $errors = str_replace('</p>','',$errors);

            $status = array('error'=>$errors,'name'=>'');

        }



        echo json_encode($status);

        die;

    }

    public function featuredimguploader()

    {

        load_admin_view('content/featured_img_uploader_view');

    }

    public function createvideo($id="",$start='0')
    {
        if(check_video_edit_permission($id)==FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
            redirect(site_url('admin/content/allvideos'));        	
        }

        $value 				= array();
        $value['start']		= $start;
        $value['action']    = ($id=='')?'new':'edit';
        $value['id']		= $id;
        if($id!='')
        {

            $value['post'] = $this->content_model->get_video_data_by_id($id);
        }

        $value['title'] 	= ($id=='')?lang_key_admin('create_video'):lang_key_admin('edit_video');
        $data['title'] 		= ($id=='')?lang_key_admin('create_video'):lang_key_admin('edit_video');
        $data['content'] 	= load_admin_view('content/create_video_view',$value,TRUE);
        load_admin_view('template/template_view',$data);



        /*$value 				= array();
        $data['title'] 		= lang_key_admin('create_video');
        $data['content'] 	= load_admin_view('classified/create_video_view',$value,TRUE);
        load_admin_view('template/template_view',$data);*/

    }

    public function addvideo()
    {
       

        $this->form_validation->set_rules('youtube_id',lang_key_admin('youtube_id'),'required|xss_clean');
        $this->form_validation->set_rules('link',lang_key_admin('link_or_id'),'required|xss_clean');
        $this->form_validation->set_rules('media',lang_key_admin('media'),'required|xss_clean');
        $this->form_validation->set_rules('title',lang_key_admin('title'),'required|xss_clean');

        $action = $this->input->post('action');
        $id = $this->input->post('id');
        $start = $this->input->post('start');

        if($id!='' && check_video_edit_permission($id)==FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
            redirect(site_url('admin/content/allvideos'));        	
        }

        if ($this->form_validation->run() == FALSE)
        {
            $this->createvideo($id,$start);
        }
        else
        {
            if(constant("ENVIRONMENT")=='demo')
            {
                $this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
                redirect(site_url('admin/content/createvideo/'.$id.'/'.$start));
            }
            else
            {
            	 // echo '<pre>';print_r($_POST);
            	 // echo $this->input->post('description');
            	 // die;

                $data = array();
                $time = time();
                $data['source_id']      	= $this->input->post('source_id');
                $data['category']       	= $this->input->post('category');
                $data['sub_category']   	= ($this->input->post('sub_category')!='')?$this->input->post('sub_category'):0;
                $data['youtube_id']      	= $this->input->post('youtube_id');
                $data['title']          	= $this->input->post('title');
                $data['description']    	= get_excerpt($this->input->post('description'));
                $data['full_description'] 	= $this->input->post('description');
                $data['media']          	= get_media_url($this->input->post('media'),$data['youtube_id']);

                $data['manual_creation']= $this->input->post('manual_creation');
                $data['grab_action']	= 'none';
                $data['tags']   		= $this->input->post('tags');
                $data['grab_time']   	= $time;
                $data['publish_time']   = $time;
                if($id=='')
                $data['author']   		= $this->session->userdata('user_id');
                if(is_admin())
                	$data['status']		= 1;
                else
	                $data['status']   		= (get_settings('global_settings','publish_posts_directly','No')=='Yes')?1:2;
                $data['search_meta'] 	= $data['title'].' '.$data['description'].' '.$data['tags'].' '.get_category_title_by_id($source->parent_category).' '.get_source_title_by_id($source_id);


                $pending_msg = ($data['status']==1)?'':lang_key_admin('pending_msg');
                if($id=='')
                {
                    $data['publish_time']   = $time;
                    $id = $this->content_model->insert_video_data($data);
                    $this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key_admin('video_added').$pending_msg.'</div>');
                }
                else
                {
                    $data['publish_time']   = $time;
                    $this->content_model->update_video_data($data,$id);
                    $this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key_admin('video_updated').$pending_msg.'</div>');
                }

                redirect(site_url('admin/content/createvideo/'.$id.'/'.$start));

            }
        }
    }

    public function allvideos($start='0')
    {
        $value 				= array();
        $value['start']		= $start;
        $data['title'] 		= lang_key_admin('all_posts');
        $data['content'] 	= load_admin_view('content/all_posts_view',$value,TRUE);
        load_admin_view('template/template_view',$data);
    }

    public function allposts_ajax($start='0')
    {
    	$value['start']		= $start;
        $value['posts']  	= $this->content_model->get_all_post_based_on_user_type($start,$this->per_page,'create_time','desc');
        $total  			= $this->content_model->get_all_post_based_on_user_type('total',$this->per_page,'create_time','desc');
        $value['pages']		= configPagination('admin/content/allvideos',$total,4,$this->per_page);
        load_admin_view('content/all_posts_ajax_view',$value);
    }

    public function deletevideo($page='0',$id='',$confirmation='')
    {
    	if($id!='' && check_video_edit_permission($id)==FALSE)
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('dont_have_permission').'</div>');
            redirect(site_url('admin/content/allvideos'));        	
        }

        if($confirmation=='')
        {
            $data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/content/deletevideo/'.$page)),TRUE);
            load_admin_view('template/template_view',$data);
        }
        else
        {
            if($confirmation=='yes')
            {
                if(constant("ENVIRONMENT")=='demo')
                {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
                }
                else
                {
                    $this->content_model->delete_video_data_by_id($id);
                    $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('video_deleted').'</div>');
                }
            }
            redirect(site_url('admin/content/allvideos/'.$page));
        }
    }


    #load  settings , settings are saved as json data
	public function settings($key='global_settings')
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$this->load->model('options_model');
		
		$settings = $this->options_model->getvalues($key);
		if($settings=='')
		{
			$settings = array();
		}
		$settings = json_encode($settings);		
		$value['settings'] = $settings;
        $data['title'] = lang_key_admin('site_settings');
        $data['content'] = load_admin_view('content/settings_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	
	#save webadmin settings
	public function savesettings($key='global_settings')
	{
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		foreach($_POST as $k=>$value)
		{
			$rules = $this->input->post($k.'_rules');
			if($rules!='')
			$this->form_validation->set_rules($k,$k,$rules);
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->settings($key);
		}
		else
		{	
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$data['values'] 	= json_encode($_POST);		
				$res = $this->options_model->getvalues($key);

				if($res=='')
				{
					$data['key']	= $key;			
					$this->options_model->addvalues($data);
				}
				else
					$this->options_model->updatevalues($key,$data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('data_updated').'</div>');
			}
			redirect(site_url('admin/content/settings/'.$key));
		}	
	}

	public function clearoldvideos()
	{
		$value = array();
        $data['title'] = lang_key_admin('clear_old_videos');
        $data['content'] = load_admin_view('content/clear_oldvideos_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}

	public function clearvideos()
	{
		
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->content_model->clearvideos();
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('video_deleted').'</div>');
		}

		redirect(site_url('admin/content/clearoldvideos'));
	}

	public function makefeatured($id='',$page='0')
	{
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			redirect(site_url('admin/content/allvideos/'.$page));
		}

		$data = array('featured'=>1);
		$this->content_model->update_video_data($data,$id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('video_featured').'</div>');
		redirect(site_url('admin/content/allvideos/'.$page));
	}

	public function removefeatured($id='',$page='0')
	{
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			redirect(site_url('admin/content/allvideos/'.$page));
		}

		$data = array('featured'=>0);
		$this->content_model->update_video_data($data,$id);
		$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('video_un_featured').'</div>');
		redirect(site_url('admin/content/allvideos/'.$page));
	}
	

	public function bulkdeletevideo()
    {

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			redirect(site_url('admin/content/allvideos'));
		}

        $ids = (isset($_POST['id']))?$_POST['id']:array();

        foreach ($ids as $id) {
        	$this->content_model->delete_video_data_by_id($id);
        }

        echo 'done';
    }

    public function updateoldmedia($key='global_settings')
    {
		if(!is_admin())
		{
			echo lang_key_admin('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		foreach($_POST as $k=>$value)
		{
			$rules = $this->input->post($k.'_rules');
			if($rules!='')
			$this->form_validation->set_rules($k,$k,$rules);
		}

		if ($this->form_validation->run() == FALSE)
		{
			$this->businesssettings($key);
		}
		else
		{	
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$old_base_url = $this->input->post('old_base_url');
				$new_base_url = $this->input->post('new_base_url');
				$this->content_model->replace_old_media_url($old_base_url,$new_base_url);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('data_updated').'</div>');
			}
			redirect(site_url('admin/content/settings/'.$key));
		}
    }
}

/* End of file classified_core.php */
/* Location: ./application/modules/admin/controllers/classified_core.php */
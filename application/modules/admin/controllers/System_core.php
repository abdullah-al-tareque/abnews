<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classified System Controller
 *
 * This class handles System management related functionality
 *
 * @package		Admin
 * @subpackage	System
 * @author		skywebit
 * @link		https://skywebit.com
 */

require_once'Translate.php';
class System_core extends CI_Controller {
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		//is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
							
		$this->load->model('system_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}
	
	public function index()
	{
		$this->allbackups();
	}
	
	#load all db backups view
	public function allbackups($start=0)
	{	
		$this->load->helper('directory');
		$map = directory_map('./assets/backups');
		$value['posts'] = $map;
        $data['title'] = lang_key_admin('manage_backups');
        $data['content'] = load_admin_view('system/allbackups_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

	#create db backup
	public function createbackup()
	{
		
			$this->system_model->create_db_backup();		
		
		redirect(site_url('admin/system/allbackups'));
	}
	
	#restore db from a backup file
	public function restoredb($key=0)
	{
		
			$this->load->helper('directory');
			$map = directory_map('./assets/backups');
			$file = $map[$key];
			$this->system_model->restore_db_backup($file);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('database_restored').'</div>');
		

		redirect(site_url('admin/system/allbackups'));
	}
	
	#download a backup file
	public function dlbackup($key=0)
	{		
		$this->load->helper('directory');
		$this->load->helper('file');
		$map = directory_map('./assets/backups');
		$file = $map[$key];
		$backup = read_file('assets/backups/'.$file);
	    # Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($file, $backup);	
	}
	
	#delete a db backup
	public function deletebackup($key)
	{
		
			$this->load->helper('directory');
			$map = directory_map('./assets/backups');
			$file = $map[$key];
			unlink('./assets/backups/'.$file);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('backup_deleted').'</div>');
		
		redirect(site_url('admin/system/allbackups'));		
	}
	
	#load webadmin settings , settings are saved as json data
	public function settings($key='webadmin_email')
	{
		$this->load->model('options_model');
		
		$settings = $this->options_model->getvalues($key);
		if($settings=='')
		{
			$settings = array('contact_email'=>'','webadmin_email'=>'');
		}
		
		$settings = json_encode($settings);		
		$value['settings'] = $settings;
        $data['title'] = lang_key_admin('admin_settings');
        $data['content'] = load_admin_view('settings/default_view',$value,TRUE);
		 load_admin_view('template/template_view',$data);			
	}
	
	#save webadmin settings
	public function savesettings($key='webadmin_email')
	{
		$this->load->model('options_model');
	

		
				$data['values'] 	= json_encode($_POST);	
				$this->options_model->updatevalues($key,$data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('data_updated').'</div>');
		

			redirect(site_url('admin/system/settings/'));		
				
	}
	#********* smtp email settings ************#
	#load webadmin settings , settings are saved as json data
	public function smtpemailsettings()
	{
		$value = array();
        $data['title'] = lang_key_admin('smtp_email_settings');	
        $data['content'] = load_admin_view('settings/smtp_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	
	#save webadmin settings
	public function savesmtpemailsettings()
	{
		$this->load->model('options_model');
	
		foreach($_POST as $key=>$value)
		{
			$this->form_validation->set_rules($key,$key,'required');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->smtpemailsettings();	
		}
		else
		{	
			
				$key = 'smtp_settings';
				$data['values'] 	= json_encode($_POST);		
				$res = $this->options_model->getvalues($key);
				if($res=='')
				{
					$data['key']	= $key;			
					$this->options_model->addvalues($data);
				}
				else
					$this->options_model->updatevalues($key,$data);
				
				if($this->input->post('smtp_email')=='Enable')
				{
					$this->load->helper('file');
					$data = 	'<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");'."\n".''
								 .'$config["protocol"]="smtp";'."\n".''
								 .'$config["smtp_host"]="'.$this->input->post('smtp_host').'";'."\n".''
								 .'$config["smtp_port"]="'.$this->input->post('smtp_port').'";'."\n".''
								 .'$config["smtp_timeout"]="'.$this->input->post('smtp_timeout').'";'."\n".''
								 .'$config["smtp_user"]="'.$this->input->post('smtp_user').'";'."\n".''
								 .'$config["smtp_pass"]="'.$this->input->post('smtp_pass').'";'."\n".''
								 .'$config["charset"]="'.$this->input->post('char_set').'";'."\n".''
								 .'$config["newline"]="'.$this->input->post('new_line').'";'."\n".''
								 .'$config["mailtype"]="'.$this->input->post('mail_type').'";'."\n".'';
 
					if ( ! write_file('./application/config/email.php', $data))
					{
					     $this->session->set_flashdata('msg', '<div class="alert alert-danger">Unable to write file[ROOT/application/config/email.php]</div>');
					}
					else
					{
					     $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('data_updated').'</div>');
					}
				}	
				else
				{
					unlink('./application/config/email.php');
				}	
				
								
			

			redirect(site_url('admin/system/smtpemailsettings/'));		
		}			
	}
	
	
	#*************** site settings  *****************#
	#load site settings , settings are saved as json data
	public function sitesettings($key='site_settings',$msg='')
	{
		if($msg=='error')
			$value['msg'] = '<div class="alert alert-danger">'.lang_key_admin('error_occured').'</div>';
		$this->load->model('options_model');
		
		$settings = $this->options_model->getvalues($key);
		if($settings=='')
		{
			$settings = array('site_title'=>'','site_lang'=>'');
		}
		$settings = json_encode($settings);		
		$value['settings'] = $settings;
		$value['langs']    = $this->system_model->get_all_langs();
		
        $data['title'] = lang_key_admin('site_settings');
        $data['content']   = load_admin_view('settings/site_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	
	#save site settings
	public function savesitesettings($key='site_settings')
	{
		$this->load->model('options_model');
	
		foreach($_POST as $k=>$value)
		{
			if($k!='ga_tracking_code')
			$this->form_validation->set_rules($k,$k,'required');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->sitesettings($key,'error');	
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
				
			
			$current_lang =  get_current_lang();
			$url = site_url('admin/system/sitesettings/'.$key);
			$url = str_replace('/'.$current_lang.'/','/'.default_lang().'/', $url);
			redirect($url);		
		}			
	}
	
	#*************** site settings  *****************#
	#load email templates , settings are saved as json data
	public function emailtmpl($id='')
	{
		$value['email']		= $this->system_model->get_email_by_id($id);
		$value['emails']  	= $this->system_model->get_all_emails();
        $data['title'] 		= lang_key_admin('edit_email_text');
        $data['content']   	= load_admin_view('emailtmp/email_view',$value,TRUE);
		load_admin_view('template/template_view',$data);			
	}
	
	public function updateemail()
	{
		
			$email = array();
			$email['subject'] 	= $this->input->post('subject');
			$email['body'] 		= $this->input->post('body');
			$email['avl_vars'] 	= $this->input->post('avl_vars');
			
			$data['values'] = json_encode($email);
			$data['status'] = 1;
			
			$id = $this->input->post('id');
			$this->system_model->update_email_tmpl($data,$id);
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('data_updated').'</div>');
		
		redirect(site_url('admin/system/emailtmpl/'.$id));		
		
	}

	public function site_logo_uploader()
	{
		 load_admin_view('settings/logo_uploader_view');
	}
	

	public function upload_logo()
	{
		$config['upload_path'] = './assets/images/logo/';
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';
		
		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');
		
		if($this->upload->do_upload('photoimg'))
		{
			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			
			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'assets/images/logo/'.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;
			
			//create_square_thumb('./uploads/profile_photos/'.$data['file_name'],'./uploads/profile_photos/thumb/');

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}
		else
		{
			$errors = $this->upload->display_errors();
			$errors = str_replace('<p>','',$errors);
			$errors = str_replace('</p>','',$errors);
			$status = array('error'=>$errors,'name'=>'');
		}
		echo json_encode($status);
		die;
	}

	public function translate()
	{
		$value['all_langs']	= $this->system_model->get_all_langs();
        $data['title'] 		= lang_key_admin('auto_translate');
		$data['content']   	= load_admin_view('langeditor/translate_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
	

	#save webadmin settings
	public function translatelang()
	{
		ini_set('max_execution_time', 3600);
		$this->load->model('system_model');
	
	
		$this->form_validation->set_rules('base_lang','base lang','required');
		$this->form_validation->set_rules('target_lang_name','Taget lang short name','required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->translate();	
		}

		else
		{	

			$base_lang			= $this->input->post('base_lang');
			$target_lang_name	= $this->input->post('target_lang_name');

			$translator = new Translate();	

			$lang_data = $this->system_model->get_language_data($base_lang.'.yml');
			$lang_data_array = $lang_data;
			$translate_array = $translator->get_translated_data_array($base_lang,$target_lang_name,$lang_data_array);

	

			$this->load->library('yaml');
			$yaml = $this->yaml->dump($translate_array);

			$this->load->helper('file');
			$file_name = $target_lang_name.'.yml';

			if ( ! write_file('./dbc_config/locals/'.$file_name, $yaml))
			{
			     $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key_admin('unable_to_write_file').'</div>');
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('language_translated').'</div>');
			}


			redirect(site_url('admin/system/translate/'));
		}			
	}


	function createimgbackup()
	{
		$value = getdate();
        $today = $value['year']."-".$value['mon']."-".$value['mday'];

		$this->zipDir('./uploads','./assets/backups/uploads('.$today.').zip');
		$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('image_backup_created').'</div>');
		redirect(site_url('admin/system/'));
	}

	public function zipDir($sourcePath, $outZipPath)
	{
	    $pathInfo = pathInfo($sourcePath);
	    $parentPath = $pathInfo['dirname'];
	    $dirName = $pathInfo['basename'];

	    $z = new ZipArchive();
	    $z->open($outZipPath, ZIPARCHIVE::CREATE);
	    $z->addEmptyDir($dirName);
	    $this->folderToZip($sourcePath, $z, strlen("$parentPath/"));
	    $z->close();
	}

	private function folderToZip($folder, &$zipFile, $exclusiveLength) {
	    $handle = opendir($folder);
    	while (false !== $f = readdir($handle)) {
	      if ($f != '.' && $f != '..') {
	        $filePath = "$folder/$f";
	        // Remove prefix from file path before add to zip.
	        $localPath = substr($filePath, $exclusiveLength);
	        if (is_file($filePath)) {
	          $zipFile->addFile($filePath, $localPath);
	        } elseif (is_dir($filePath)) {
	          // Add sub-directory.
	          $zipFile->addEmptyDir($localPath);
	          self::folderToZip($filePath, $zipFile, $exclusiveLength);
	        }
	      }
    	}
    	closedir($handle);
  } 


    /* Generate Site Map start*/
    public function generatesitemap()
    {

        $data['title']      = lang_key_admin('generate_site_map');
        $data['content']   	= load_admin_view('sitemap/site_map_panel_view','',TRUE);
        load_admin_view('template/template_view',$data);
    }

    function get_site_map_xml()
    {
        $page_checked       = $this->input->post('pages');
        $post_news_checked  = $this->input->post('post_news');
        $videos_category_checked     = $this->input->post('video_category');

        $xml_array=array();

        if($page_checked==1 or $post_news_checked==2 or $videos_category_checked==3)
        {

            if($page_checked==1)
            {

                $menu = get_option('top_menu');
                $menu=json_decode($menu->values);
                $page_url_array=array();
                foreach($menu as $row)
                {
                    $id                 = $row->id;
                    $url                = $this->get_page_url_by_id($id);
                    $page_url_array[]   = $url;
                }
                if($page_url_array)
                {
                    $xml_array = $page_url_array;
                }
            }

            if($post_news_checked == 2){
                $this->load->model('show/show_model');
                $all_post_news = $this->show_model->get_all_videos_by_range();

                if($all_post_news->num_rows()>0)
                {
                    $all_news_array = array();
                    foreach($all_post_news->result() as $row){
                        $url        = post_detail_url($row);
                        $all_news_array[] = $url;
                    }
                }

                if($all_news_array){
                    $xml_array = array_merge($xml_array,$all_news_array);
                }

            }

            if($videos_category_checked==3){
                $estate_array = array();
                $this->load->model('show/show_model');

                $estate_data = $this->show_model->get_all_categories();

                if($estate_data->num_rows()>0)
                {
                    foreach($estate_data->result() as $row)
                    {
                        $id = $row->id;
                        $title = $row->title;
                        $url = category_video_url($id,$title);
                        $category_array[]=$url;
                    }
                }

                if($category_array){
                    $xml_array = array_merge($xml_array,$category_array);
                }
            }


            $xml = $this->prepare_xml($xml_array);

            $this->load->helper('file');
            if ( ! write_file('./sitemap.xml',$xml))
            {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">ROOT/sitemap.xml does not have write permission .</div>');
                redirect(site_url('admin/system/generatesitemap'));
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key_admin('site_map_generation_success').'</div>');
            redirect(site_url('admin/system/generatesitemap'));
        }
        else{
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key_admin('select_option').'</div>');
            redirect(site_url('admin/system/generatesitemap'));
        }

    }

    // updated on version 1.3
    function prepare_xml($xml_array='')
    {
        $xml = '';
        if(isset($xml_array) && is_array($xml_array))
        {
            $xml = '<?xml version="1.0" encoding="UTF-8" ?>'.
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
                     <url>
                         <loc>'.base_url().'</loc>
                            <priority>0.9</priority>
                            <changefreq>always</changefreq>
                        </url>';

            foreach($xml_array as $url)
            {
                $xml .= "<url>
                            <loc>".urldecode($url)."</loc>
                            <priority>0.9</priority>
                            <changefreq>always</changefreq>
                        </url>";
            }
            $xml .= "</urlset>";
        }
        return $xml;
    }
    //end

    function get_page_url_by_id($id='')
    {
        $this->load->model('page_model_core');
        $page = $this->page_model_core->get_page_by_id($id);

        if($page->content_from=='Url')
        {
            $url = site_url($page->url);
        }
        else
        {
            $url = site_url('page/'.$page->alias);
        }
        return $url;
    }

    public function translate_title_description_ajax(){
        /*during creating property*/
        $title = $this->input->post('title');
        $desc = $this->input->post('desc');
        $lang = $this->input->post('lang');
        $lang = trim($lang);
        $translator = new Translate();
        $translator->setLangFrom($lang);
        $array = array();
        $value['result'] = $this->system_model->get_all_langs();

        foreach($value['result'] as $va=>$long_name){

            if($va!=$lang){
                $title1='';
                $description1 = '';
                $translator->setLangTo($va);
                $title1 =  $translator->mm_translate($title);
                $description1 = $translator->mm_translate($desc);
                array_push($array,array('lang'=>$va,'title'=>$title1,'description'=>$description1));
            }
        }
        echo json_encode($array);
    }

    public function debugemail()
    {
    	$value = array();

    	if($this->input->post('to_email')!='')
    	{
    		$value['result'] = $this->test_email();
    	}

    	$data['title']      = lang_key_admin('debug_email');
        $data['content']   	= load_admin_view('emailtmp/debug_view',$value,TRUE);
        load_admin_view('template/template_view',$data);
    }

    public function test_email()
    {
    	$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];

    	$this->load->library('email');
		$this->email->from($admin_email, $admin_name);
		$this->email->to($this->input->post('to_email'));
		$this->email->subject('Test email');		
		$this->email->message("This is a test email. If you get this then email sending is ok.");		
		$this->email->send();

		return $this->email->print_debugger();
    }

    public function get_admin_email_and_name()
	{
		$this->load->model('admin/options_model');
		$values = $this->options_model->getvalues('webadmin_email');

		if(count($values))
		{
			$data['admin_email'] = (isset($values->webadmin_email))?$values->webadmin_email:'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = (isset($values->webadmin_name))?$values->webadmin_name:'Admin';
		}
		else
		{
			$data['admin_email'] = 'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = 'Admin';		
		}

		return $data;
	}	
}

/* End of file system.php */
/* Location: ./application/modules/admin/controllers/admin/system.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classified account Controller
 *
 * This class handles user account related functionality
 *
 * @package		Account
 * @subpackage	Account
 * @author		skywebit
 * @link		https://skywebit.com
 */





class Account_core extends CI_Controller {



	var $active_theme = '';

	var $per_page = 2;

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->active_theme = get_active_theme();

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin-bottom:0;">', '</div>');

		$this->load->helper('date');

		$this->load->model('auth_model');

	}

	function index()
	{
		$this->trylogin();
	}
	
	#loads login view(without modal)
	public function trylogin()

	{

		$data['content'] 	= load_view('login_view','',TRUE);
        $data['alias']	    = 'signup';
        load_template($data,$this->active_theme);

	}


	#check login using ajax form modals
	public function check_login_ajax(){

		$dest = $this->input->post('dest');

		if($dest!='')

			$this->session->set_userdata('req_url',$dest);

		

		echo ($this->session->userdata('user_name')=='')?'no':'yes';

	}


	#check login from login form
	public function login()

	{

		$this->form_validation->set_rules('useremail','Email','required|xss_clean');

		$this->form_validation->set_rules('password','Password','required|xss_clean');

		

		if ($this->form_validation->run() == FALSE)

		{
			
			$this->trylogin();	

		}

		else

		{

			$this->load->model('auth_model');

			$query = $this->auth_model->check_login($this->input->post('useremail'),$this->input->post('password'),'result');


			if($query->num_rows()>0)

			{				

				$row = $query->row();

				if($row->banned==1)

				{

					$msg = '<div class="alert alert-danger">'.

					        	'<button data-dismiss="alert" class="close" type="button">×</button>'.

					        	'<strong>User banned</strong>'.

					    	'</div>';

					$this->session->set_flashdata('msg', $msg);							

					redirect(site_url('account/trylogin'));

				}
				else if($row->confirmed!=1)

				{

					$msg = '<div class="alert alert-danger">'.

					        	'<button data-dismiss="alert" class="close" type="button">×</button>'.

					        	'<strong>Account not activated</strong>'.

					    	'</div>';

					$this->session->set_flashdata('msg', $msg);							

					redirect(site_url('account/trylogin'));

				}

				else

				{
					

					if(is_admin())
						create_log($row->user_name);
					
					$this->session->set_userdata('user_id',$row->id);

					$this->session->set_userdata('user_name',$row->user_name);

					$this->session->set_userdata('user_type',$row->user_type);

					$this->session->set_userdata('user_email',$this->input->post('useremail'));

					

					if($this->session->userdata('req_url')!='')

					{

						$req_url = $this->session->userdata('req_url');

						$this->session->set_userdata('req_url','');

						redirect($req_url);

					}

					redirect(site_url());					

				}

			}

			else

			{				

				$msg = '<div class="alert alert-danger">'.

					        '<button data-dismiss="alert" class="close" type="button">×</button>'.

					        '<strong>Username or password not matched</strong>'.

					    '</div>';

				$this->session->set_flashdata('msg', $msg);							

				redirect(site_url('account/trylogin'));

			}

		}



	}


	#logout a user
	public function logout()

	{

		$this->session->sess_destroy();

		redirect(site_url());

	}

	#loads signup view
	public function signup()
	{
		if(get_settings('global_settings','enable_signup','Yes')!='Yes')
		{
			redirect(site_url());
		}

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

		$data['content'] 	= load_view('register_view',$value,TRUE);
        $data['alias']	    = 'signup';
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
	
    public function signupform()
    {
		if(get_settings('global_settings','enable_signup','Yes')!='Yes')
		{
			redirect(site_url());
		}

    	if($this->session->userdata('package_id')=='')
    	{
    		if(get_settings('global_settings','enable_pricing','Yes')=='Yes')
    			redirect(site_url('account/signup'));
    		else
    			$value = array();
    	}
    	else
    	{
    		$this->load->model('admin/package_model');
			$value['package']  = $this->package_model->get_package_by_id($this->session->userdata('package_id'));
    	}


        $data['content'] 	= load_view('register_view',$value,TRUE);
        $data['alias']	    = 'signup';
        load_template($data,$this->active_theme);
    }

	#controls different signup method routing
	function newaccount($type='',$user_type='individual')
	{
		$this->session->set_userdata('signup_user_type',3);

		if($type=='fb')
			redirect(site_url('account/fbauth'));

		else if($type=='google_plus')
		{
			redirect(site_url('account/google_plus_auth'));
		}
	}


	#signup form submits to this function
	function register()
	{

		$this->form_validation->set_rules('ans', 'Code', 'required|callback_check_code');
		$this->form_validation->set_rules('first_name',	'First Name', 		'required|xss_clean');
		$this->form_validation->set_rules('last_name',	'last Name', 		'required|xss_clean');
		$this->form_validation->set_rules('gender',		'Gender', 			'required|xss_clean');
		$this->form_validation->set_rules('username', 	'Username', 		'required|callback_username_check|xss_clean');

        $this->form_validation->set_rules('useremail',	'User-email', 		'required|valid_email|xss_clean|callback_useremail_check');
		$this->form_validation->set_rules('password', 	'Password', 		'required|matches[repassword]|min_length[5]|xss_clean');
		$this->form_validation->set_rules('repassword',	'Confirm', 			'required|xss_clean');
		$this->form_validation->set_rules('terms_conditon','Terms and condition','xss_clean|callback_terms_check');
		

		if ($this->form_validation->run() == FALSE)
		{
			$this->signup();	
		}
		else
		{

			$this->load->library('encrypt');

			$userdata['user_type']	= 3;//3 = general
		
			$userdata['first_name'] = $this->input->post('first_name');
			$userdata['last_name'] 	= $this->input->post('last_name');
			$userdata['gender'] 	= $this->input->post('gender');			
			$userdata['user_name'] 	= $this->input->post('username');
			$userdata['user_email'] = $this->input->post('useremail');
			$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
			$userdata['confirmation_key'] 	= uniqid();
			$userdata['confirmed'] 	= 0;
			$userdata['status']		= 1;

			$this->load->model('user/user_model');
			$user_id = $this->user_model->insert_user_data($userdata);
						
			$this->send_confirmation_email($userdata);				
			redirect(site_url('account/success'));				
		}
	}

	#load confirmation view
	public function success()
	{
		$data['content'] 	= load_view('success_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}

	#load confirmation view
	public function confirmation()
	{
		$data['content'] 	= load_view('confirmation_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}

	#terms validation function
	public function terms_check($str)
	{
		$this->load->model('auth_model');		
		if ($_POST['terms_conditon']=='')
		{
			$this->form_validation->set_message('terms_check', lang_key('must_accept_terms'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	#recovery email validation function
	public function useremail_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);
		if ($res>0)
		{
			$this->form_validation->set_message('useremail_check', 'Email allready in use.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}



	#username validation function

	public function username_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_username_exists($str);

		if ($res>0)
		{
			$this->form_validation->set_message('username_check', 'Username allready in use.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#get web admin name and email for email sending
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


	

	#recovery email validation function
	public function check_email_validation($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);

		if ($res<=0)
		{
			$this->form_validation->set_message('check_email_validation', 'Email not found.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#confirmation email request form submits here
	public function requestconfirmation()
	{
		$this->form_validation->set_rules('useremail',	'Email', 'required|valid_email|xss_clean|callback_check_email_validation');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->showrequestconfirmation();	
		}
		else
		{
			$userdata = $this->auth_model->get_userdata_by_email($this->input->post('useremail'));
			$this->send_confirmation_email($userdata);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('confirm_email_send').'</div>');
			redirect(site_url('account'));		
		}
	}


	#confirmation email link points here
	public function confirm($email='',$code='')
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->confirm_email($email,$code);

		if($res==TRUE)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_confirmed').'</div>');
			redirect(site_url('account/showmsg'));		
		}
		else
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('email_confirmed_failed').'</div>');
			redirect(site_url('account/showmsg'));
		}
	}


	#current password validation function for password changing
	function currentpass_check($str)
	{

		$user_name = $this->session->userdata('user_name');
		$res = $this->auth_model->check_login($user_name,$str);

		if ($res<=0)
		{
			$this->form_validation->set_message('currentpass_check', 'Current password Didn\'t match');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#update password function
	function update_password()
	{
		if($this->session->userdata('recovery')!='yes')
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_currentpass_check');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|matches[re_password]');
		$this->form_validation->set_rules('re_password', 'Password Confirmation', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->changepass();	
		}
		else
		{
			$password = $this->input->post('new_password');
			$this->auth_model->update_password($password);
			$this->session->set_userdata('recovery',"no");
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('password_change_success').'</div>');
			redirect(site_url('admin/auth/changepass'));		
		}
	}

	#load forgot password view
	function forgotpass()
	{
		$data['content'] 	= load_view('recover_view','',TRUE);
        $data['alias']	    = 'recover';
        load_template($data,$this->active_theme);
	}

	#forgot password function
	#check if given email is valid or not
	#if valid then send a recovery email
	function recoverpassword()
	{
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|xss_clean|callback_useremail_match_check');

		if ($this->form_validation->run() == FALSE)
		{
			$this->forgotpass();	
		}
		else
		{
			$user_email = $this->input->post('user_email');
			$val = $this->auth_model->set_recovery_key($user_email);
			$this->_send_recovery_email($val);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_sent_inbox').'</div>');
			redirect(site_url('account/showmsg'));		
		}
	}

	

	#recovery email validation function

	function useremail_match_check($str)
	{

		$this->load->model('account/auth_model');

		$res = $this->auth_model->is_email_exists($str);

		if ($res<=0)

		{

			$this->form_validation->set_message('useremail_match_check', 'Email Not matched');

			return FALSE;

		}

		else if(is_banned($str))

		{

			$this->form_validation->set_message('useremail_match_check', 'User banned');

			return FALSE;			

		}

		else

		{

			return TRUE;

		}

	}



	#recovery email validation function

	function useremail_user_ban_check($str)

	{

		if (is_banned($str))

		{

			$this->form_validation->set_message('useremail_user_ban_check', 'User banned');

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	
	#send recovery email
	function _send_recovery_email($data)

	{



		$val = $this->get_admin_email_and_name();

		$admin_email = $val['admin_email'];

		$admin_name  = $val['admin_name'];

		$link = site_url('account/resetpassword').'/'.$data['user_email'].'/'.$data['recovery_key'];

		

		$this->load->model('admin/system_model');

		$tmpl = $this->system_model->get_email_tmpl_by_email_name('recovery_email');

		$subject = $tmpl->subject;

		$subject = str_replace("#username",$data['user_name'],$subject);

		$subject = str_replace("#recoverylink",$link,$subject);

		$subject = str_replace("#webadmin",$admin_name,$subject);



		

		$body = $tmpl->body;

		$body = str_replace("#username",$data['user_name'],$body);

		$body = str_replace("#recoverylink",$link,$body);

		$body = str_replace("#webadmin",$admin_name,$body);

				

		$this->load->library('email');

		$this->email->from($admin_email, $subject);

		$this->email->to($data['user_email']);

		$this->email->subject($subject);		

		$this->email->message($body);		

		$this->email->send();

	}

	
	#reset password email link points here
	function resetpassword($user_email='',$recovery_key='')

	{

		$query = $this->auth_model->verify_recovery($user_email,$recovery_key);	

		if($query->num_rows()>0)

		{
			$row = $query->row();

			$this->session->set_userdata('user_id',$row->id);

			$this->session->set_userdata('user_email',$row->user_email);
			
			$this->session->set_userdata('user_name',$row->user_name);

			$this->session->set_userdata('user_type',$row->user_type);

			$this->session->set_userdata('recovery',"yes");

			redirect(site_url('admin/auth/changepass'));

		}

		else

		{

			$this->session->set_flashdata('msg', '<div class="alert alert-block">'.lang_key('password_recovery_link_invalid').'</div>');

			redirect(site_url('account/forgotpass'));

		}

	}

	#send a confirmation email with confirmation link
	public function send_confirmation_email($data=array('username'=>'sc mondal','useremail'=>'shimulcsedu@gmail.com','confirmation_key'=>'1234'))
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		$link = site_url('account/confirm/'.$data['user_email'].'/'.$data['confirmation_key']); 
		
		$this->load->model('admin/system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('confirmation_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['user_name'],$subject);
		$subject = str_replace("#activationlink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);
		$subject = str_replace("#useremail",$data['user_email'],$subject);

		
		$body = $tmpl->body;
		$body = str_replace("#username",$data['user_name'],$body);
		$body = str_replace("#activationlink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		$body = str_replace("#useremail",$data['user_email'],$body);

				
		$this->load->library('email');
		$this->email->from($admin_email, $subject);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);		
		$this->email->message($body);		
		$this->email->send();
	}

	#added on version 1.5
	public function showmsg()
	{
		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}
}
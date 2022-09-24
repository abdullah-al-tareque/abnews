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



class Grab_core extends CI_controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('grab/grab_model');
	}
	public function index()
	{
		$this->init();
	}

	public function init()
	{
		if(if_possible_to_grab())
		$this->grab_model->init();
	}


	public function grabsingle($source_id='',$action='cron')
	{
		
		$this->grab_model->grabsingle($source_id,$action);
	}

	public function grabsingle_video_info()
	{
		$url = $this->input->post('url');
		$this->grab_model->get_single_video_info($url);
	}

}





/* End of file install.php */

/* Location: ./application/modules/show/controllers/show_core.php */
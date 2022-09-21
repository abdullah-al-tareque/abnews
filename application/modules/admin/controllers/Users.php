<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classified users Controller
 *
 * This class handles users management related functionality
 *
 * @package		Admin
 * @subpackage	users
 * @author		skywebit
 * @link		https://skywebit.com
 */

require_once'Users_core.php';

class Users extends Users_core {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
}

/* End of file users.php */
/* Location: ./application/modules/admin/controllers/users.php */
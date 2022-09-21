<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classified plugins Controller
 *
 * This class handles plugins management related functionality
 *
 * @package		Admin
 * @subpackage	plugins
 * @author		skywebit
 * @link		https://skywebit.com
 */
require_once'Plugins_core.php';
class Plugins extends Plugins_core {

	public function __construct()
	{
		parent::__construct();
	}
}
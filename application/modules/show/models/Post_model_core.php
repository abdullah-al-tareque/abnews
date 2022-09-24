<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classified admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		User
 * @subpackage	UserModelCore
 * @author		skywebit
 * @link		https://skywebit.com
 */



class Post_model_core extends CI_Model 

{

	function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

	function get_all_categories()
	{
		$this->db->order_by('id','asc');
		$query = $this->db->get_where('categories',array('parent'=>0,'status'=>1));
		$categories = array();
		foreach ($query->result() as $row) {
			array_push($categories,$row);
			$this->db->order_by('id','asc');
			$child_query = $this->db->get_where('categories',array('parent'=>$row->id,'status'=>1));
			foreach ($child_query->result() as $child) {
				array_push($categories,$child);
			}

		}
		return $categories;
	}

	function get_all_parent_categories()
	{
		$this->db->order_by('id','asc');
		$this->db->where('parent',0);
		$this->db->where('status',1);
		$query = $this->db->get('categories');
		return $query;
	}

	function get_all_child_categories($id, $limit = 'all')
	{
		$this->db->order_by('id','asc');
		$this->db->where('parent',$id);
		$this->db->where('status',1);
		if($limit!= 'all')
			$this->db->limit($limit);
		$query = $this->db->get('categories');
		return $query;
	}

	function count_post_by_category_id($cat_id)
	{
		$cat_id = $this->db->escape($cat_id ) ;
		$this->db->where("(parent_category = $cat_id OR category = $cat_id)");
		$this->db->where('status',1);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	function get_category_icon($cat_id)
	{
		$this->db->where('id',$cat_id);
		$query = $this->db->get('categories');
		if($query->num_rows()>0){
			$cat = $query->row();
			if($cat->fa_icon!='')
				return $cat->fa_icon;
			else
				return 'fa-picture-o';
		}
		return 'fa-picture-o';
	}

}



/* End of file install.php */
/* Location: ./application/modules/user/models/user_model_core.php */
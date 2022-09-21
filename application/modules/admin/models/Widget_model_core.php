<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classified widget_model_core model
 *
 * This class handles widget_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	widget_model_core
 * @author		skywebit
 * @link		https://skywebit.com
 */


class Widget_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_all_widgets_by_range($start,$limit='',$sort_by='')
	{
		$this->db->where('status !=','2');
		if($start=='all')
		$query = $this->db->get('widgets');
		else
		$query = $this->db->get('widgets',$limit,$start);
		return $query;
	}
	
	function get_widget_by_alias($alias)
	{
		$query 	= $this->db->get_where('widgets',array('alias'=>urldecode($alias)));
		$row 	= $query->row();
		return $row;
	}

	function set_widget_status($alias,$status)
	{
		if($status==2)
		{
			$this->db->delete('widgets',array('alias'=>urldecode($alias)));			
		}
		else
		{
			$data['status'] = $status;
			$this->db->update('widgets',$data,array('alias'=>urldecode($alias)));			
		}
	}

	function create_widget($data)
	{
		$data['alias'] = $this->get_alias($data['name']);
		$this->db->insert('widgets',$data);
	}

	function get_alias($name)
	{
		$name = underscore($name);
		$query = $this->db->get_where('widgets',array('alias'=>urldecode($name)));
		if($query->num_rows()>0)
		{
			$count = $query->num_rows();
			$count++;
			$name = $name.'_'.$count;
			return $name;
		}
		else
			return $name;
	}

	function generate_widget($data)
	{
		

		$alias = underscore($data['name']);
		
		$query = $this->db->get_where('widgets',array('alias'=>urldecode($alias)));

		if($query->num_rows()<=0)
		$this->db->insert('widgets',array('name'=>$data['name'],'alias'=>urldecode($alias),'status'=>1));
		
		$this->load->helper('file');

		$category 		= $data['parent_category'];
		$sub_category 	= $data['sub_category'];
		
		
		if($data['type']=='video_source')
		{
			$info = read_file('./application/modules/widgets/tmpl/pagebody_tmpl.php');
			$wid_title = 'get_source_title_by_id($source_id)';			
			$more_url = 'source_video_url($source_id,get_source_title_by_id($source_id))';			
		}
		else
		{
			$info = read_file('./application/modules/widgets/tmpl/pagebody_tmpl.php');
			$wid_title = 'get_category_title_by_id($category)';

			if(isset($sub_category) && $sub_category=="")
			{
				$more_url = 'category_video_url($category,get_category_title_by_id($category))';			
			}
			else
			{
				$more_url = 'category_video_url($sub_category,get_category_title_by_id($sub_category))';			
			}
		}

		if(isset($_POST['use_name_as_title']))
		$wid_title = "'".lang_key($data['name'])."'";
		
		$info = str_replace('#wid_title', $wid_title, $info);
		$info = str_replace('#more_url', $more_url, $info);


		$source_id = ($data['source_id']!='')?$data['source_id']:"'all'";
		$info = str_replace('#source_id', $source_id, $info);

		$parent_category = ($data['parent_category']!='')?$data['parent_category']:"'all'";
		$info = str_replace('#parent_category', $parent_category, $info);

		$sub_category = ($data['sub_category']!='')?$data['sub_category']:"'all'";
		$info = str_replace('#sub_category', $sub_category, $info);

		$limit = ($data['limit']!='')?$data['limit']:"'all'";
		$info = str_replace('#limit', $limit, $info);
		
		

		if ( ! write_file('./application/modules/widgets/'.$alias.'.php',$info))
		{
		     return FALSE;
		}
		else
		{
		     return TRUE;
		}

	}
	
}

/* End of file widget_model_core.php */
/* Location: ./system/application/models/widget_model_core.php */
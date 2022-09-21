<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classified admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ShowModelCore
 * @author		skywebit
 * @link		https://skywebit.com
 */



class Show_model_core extends CI_Model 
{

	function __construct()
	{

		parent::__construct();

		$this->load->database();

	}




	function get_page_by_alias($alias)

    {

    	$query = $this->db->get_where('pages',array('alias'=>urldecode($alias)));

    	return $query;

    }



    function get_alias_by_url($url)

    {

    	$query = $this->db->get_where('pages',array('content_from'=>'Url','url'=>$url));

    	if($query->num_rows()>0)

    	{

    		$row = $query->row();

    		return $row->alias;

    	}

    	else

    		return '';

    }



    function get_page_by_url($url)

    {
        $url  = urldecode($url);

    	$query = $this->db->get_where('pages',array('url'=>$url));

    	return $query;

    }

    function get_all_videos_by_range()
    {

        $this->db->order_by('publish_time', 'desc');
        $this->db->where('status',1);
        $query = $this->db->get('videos');

        return $query;
    }

    function get_all_categories()
    {
        $this->db->order_by('create_time', 'desc');
        $this->db->where('status',1);
        $query = $this->db->get('categories');

        return $query;

    }

    // added on version 1.3
    function get_videos_by_range($start,$limit='',$sort_by='',$sort='desc')
    {

        $this->db->order_by($sort_by,$sort);    
        $this->db->where('status !=',0); 

        if($start==='all')
        {
            $query = $this->db->get('videos');
        }
        else
        {
            $query = $this->db->get('videos',$limit,$start);
        }

        return $query;

    }
    //end

}



/* End of file install.php */

/* Location: ./application/modules/show/models/show_model_core.php */
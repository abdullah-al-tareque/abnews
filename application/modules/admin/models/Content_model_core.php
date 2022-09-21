<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Classified category_model_core model
 *
 * This class handles category_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	category_model_core
 * @author		skywebit
 * @link		https://skywebit.com
 */
class Content_model_core extends CI_Model 
{
	var $category,$menu;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->category = array();
	}

	function insert_source_data($data)
	{
		$this->db->insert('sources',$data);
		return $this->db->insert_id();
	}


	function update_source_data($data,$id)
	{
		$this->db->update('sources',$data,array('id'=>$id));
	}

	function get_all_sources()
	{
		$query = $this->db->get_where('sources',array('status'=>1));
		return $query;
	}

	function get_source_data_by_id($id)
	{
		$query = $this->db->get_where('sources',array('id'=>$id,'status'=>1));
		return $query->row();
	}

	function delete_source_data_by_id($id)
	{
		$this->db->delete('sources',array('id'=>$id));
	}

    function insert_video_data($data)
    {
        $this->db->insert('videos',$data);
        return $this->db->insert_id();
    }

    function update_video_data($data,$id)
    {
        $this->db->update('videos',$data,array('id'=>$id));
    }

    function get_video_data_by_id($id)
    {
        $query = $this->db->get_where('videos',array('id'=>$id));
        return $query->row();
    }

    function get_all_post_based_on_user_type($start,$limit,$order_by='id',$order_type='asc')
    {
        $key = $this->input->post('key');
        if($key!='')
        {
            $source_id = get_source_id_by_key($key);
            $category_id = get_category_id_by_key($key);
            $subcategory_id = get_category_id_by_key($key);

            $this->db->where('status !=',0);
            $this->db->where('(source_id='.$source_id.' or category='.$category_id.' or sub_category='.$subcategory_id.' or title like \'%'.$this->input->post('key').'%\')');

        }
        if(is_generaluser())
        {
            $this->db->where('author',$this->session->userdata('user_id'));
        }

        $filter_by = $this->input->post('filter_by');
        if($filter_by!='all')
        {
            if($filter_by=='only_published')
            {
                $this->db->where('status',1);
            }
            else if($filter_by=='only_pending')
            {
                $this->db->where('status',2);                
            }
            else if($filter_by=='only_featured')
            {
                $this->db->where('featured',1);                                
            }
        }
        $this->session->set_userdata('filter_by',$filter_by);

        //$this->db->order_by('id', "desc");
        $this->db->order_by('publish_time', "desc");

        if($start=='all')
        {
            $query = $this->db->get('videos');
            return $query;
        }
        elseif ($start=='total')
        {
            $query = $this->db->get('videos');
            return $query->num_rows();
        }
        else
        {
            $query = $this->db->get('videos',$limit,$start);
//            echo $this->db->last_query();die;
            return $query;
        }
    }

    // updated on version 1.3
    // updated on version 1.4
    function delete_video_data_by_id($id)
    {
        $videos = $this->get_video_data_by_id($id);
        if(strpos('-'.$videos->media,base_url())>0)
        {
            if(strripos('-'.$videos->media,'no-image.png')<=0)
            {
                $img = str_replace(base_url(), './', $videos->media);
                @unlink($img);                            
            }
        }

        $this->db->delete('videos',array('id'=>$id));
    }


    function clearvideos()
    {
        $this->prepare_delete_condition();
        $query = $this->db->get('videos');
        foreach ($query->result() as $videos) {

            if(strpos('-'.$videos->media,base_url())>0)
            {
                if(strripos('-'.$videos->media,'no-image.png')<=0)
                {
                    $img = str_replace(base_url(), './', $videos->media);
                    @unlink($img);            
                }
            }
        }

        $this->load->database();        
        $this->prepare_delete_condition();
        $this->db->delete('videos');
    }

    function prepare_delete_condition()
    {
        $publish_time = $this->input->post('videos_before');
        $publish_time = (!empty($publish_time))?strtotime($publish_time):'';

        if($publish_time!='')
        {
            $this->db->where('publish_time <',$publish_time);
        }

        $category = $this->input->post('category');
        if($category!='')
        {
            $this->db->where('category',$category);            
        }

        $sub_category = $this->input->post('sub_category');
        if($sub_category!='')
        {
            $this->db->where('sub_category',$sub_category);            
        }

        $source_id = $this->input->post('source_id');
        if($source_id!='')
        {
            $this->db->where('source_id',$source_id);            
        }

        $view_less_than = $this->input->post('view_less_than');
        $view_less_than = (!empty($view_less_than))?$view_less_than:'';

        if($view_less_than!='')
        {
            $this->db->where('total_view <',$view_less_than);
        }

        $without_image = $this->input->post('without_image');
        $without_image = (!empty($without_image))?$without_image:'';

        if($without_image==1)
        {
            $this->db->where('media','');
        }
    }
    //end

    function replace_old_media_url($old_url,$new_url)
    {
        $this->db->like('media',$old_url);
        $query = $this->db->get_where('videos',array('status'=>1));

        foreach ($query->result() as $row) 
        {
            $url = str_replace($old_url, $new_url, $row->media);
            $this->db->update('videos',array('media'=>$url),array('id'=>$row->id));
        }
    }


}

/* End of file category_model_core.php */
/* Location: ./system/application/models/category_model_core.php */
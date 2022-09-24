<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classified admin_model_core model
 *
 * This class handles admin_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model_core
 * @author		skywebit
 * @link		https://skywebit.com
 */



class Video_model_core extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insert_video($data)
	{
		$this->db->insert('videos',$data);
	}

	public function check_if_unique_video($data)
	{
		$query = $this->db->get_where('videos',$data);
		return $query->num_rows();
	}

	public function get_videos_by_source_category_subcategory($source_id,$category,$sub_category,$limit)
	{
		if($source_id!='all')
		{
			$this->db->where('source_id',$source_id);
		}

		if($category!='all')
		{
			$this->db->where('category',$category);
		}

		if($sub_category!='all')
		{
			$this->db->where('sub_category',$sub_category);
		}

		$this->db->order_by('publish_time','desc');

		$query = $this->db->get_where('videos',array('status'=>1),$limit,0);

		return $query;
	}


    public function get_releated_videos($limit)
    {
        $this->db->order_by('publish_time','desc');
        $query = $this->db->get_where('videos',array('status'=>1,'featured'=>1),$limit,0);
        return $query;
    }


    public function get_featured_videos($limit)
    {
        $this->db->order_by('publish_time','desc');
        $query = $this->db->get_where('videos',array('status'=>1,'featured'=>1),$limit,0);
        return $query;
    }

    public function get_featured_videos_all()
    {
        $this->db->order_by('publish_time','desc');
        $query = $this->db->get_where('videos',array('status'=>1,'featured'=>1));
        return $query;
    }



    public function get_popular_videos($limit)
    {
        // $this->db->order_by('publish_time','desc');
        $this->db->order_by('total_view','desc');
        $query = $this->db->get_where('videos',array('status'=>1),$limit,0);
        return $query;
    }

	public function get_popular_videos_all()
    {
        // $this->db->order_by('publish_time','desc');
        $this->db->order_by('total_view','desc');
        $query = $this->db->get_where('videos',array('status'=>1));
        return $query;
    }


	public function get_video_by_id($id)
	{
		$query = $this->db->get_where('videos',array('id'=>$id));
		return $query;
	}

	function get_similar_videos_by_category($category, $sub_category,  $post_id)
    {
        $this->db->order_by('publish_time','desc');
        $this->db->where("(category = $category AND sub_category = $sub_category)");
        $this->db->where('id !=', (int)$post_id);
        $this->db->limit(5, 0);
        $this->db->where('status',1);
        $query = $this->db->get('videos');

        if($query->num_rows()<=0)
        {
            $this->db->order_by('publish_time','desc');
            $this->db->where("(category = $category)");
            $this->db->where('id !=', (int)$post_id);
            $this->db->limit(5, 0);
            $this->db->where('status',1);
            $query = $this->db->get('videos');
        }

        return $query;

    }

    function get_category_videos_by_range($category,$start='0',$limit='5')
    {
        $this->db->order_by('publish_time','desc');
    	$this->db->where('category',$category);
    	$this->db->or_where('sub_category',$category);

    	$this->db->where('status',1);

    	if($start=='all')
    	{
    		$this->db->get('videos');
    		return $query;
    	}
    	else if($start=='total')
    	{
    		$query = $this->db->get('videos');
    		return $query->num_rows();
    	}
    	else
    	{
    		$query = $this->db->get('videos',$limit,$start);
    		return $query;
    	}
    }

    function get_source_videos_by_range($source_id,$start='0',$limit='5')
    {
        $this->db->order_by('publish_time','desc');
    	$this->db->where('source_id',$source_id);    	
    	$this->db->where('status',1);

    	if($start=='all')
    	{
    		$this->db->get('videos');
    		return $query;
    	}
    	else if($start=='total')
    	{
    		$query = $this->db->get('videos');
    		return $query->num_rows();
    	}
    	else
    	{
    		$query = $this->db->get('videos',$limit,$start);
    		return $query;
    	}
    }

    function get_date_videos_by_range($publish_time,$start='0',$limit='5')
    {
        $this->db->order_by('publish_time','desc');
    	$beginOfDay = strtotime("midnight", $publish_time);
		$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

    	$this->db->where('publish_time >=',$beginOfDay);    	
    	$this->db->where('publish_time <=',$endOfDay);    	
    	$this->db->where('status',1);

    	if($start=='all')
    	{
    		$this->db->get('videos');
    		return $query;
    	}
    	else if($start=='total')
    	{
    		$query = $this->db->get('videos');
    		return $query->num_rows();
    	}
    	else
    	{
    		$query = $this->db->get('videos',$limit,$start);
    		return $query;
    	}
    }

	function inc_view_count_by_id($id) {

		if (isset($_COOKIE['viewcookie'.$id])==FALSE)
		{
			$CI = get_instance();
			$CI->load->database();

			$query = $CI->db->get_where('videos',array('id'=>$id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				$total_view = $row->total_view;
				$total_view++;
			}		
			else
				$total_view = 0;	
			$CI->db->update('videos',array('total_view'=>$total_view),array('id'=>$id));
			setcookie("viewcookie".$id, 1, time()+1800);
			return $total_view;
		}
	}

    public function get_videos_search_result($data,$start='0',$limit='5')
    {
        if(isset($data['plainkey']) && trim($data['plainkey'])!='') 
        {
            $search_string = rawurldecode($data['plainkey']);
            $search_string = trim($search_string);
            $search_string = explode("+", $search_string);
            $sql = "";
            $flag = 0;



            foreach ($search_string as $key) 
            {
                if($flag==0) {
                    $flag = 1;
                }
                else {
                    $sql .= "AND ";
                }

                $key = str_replace("'", "\'", $key);
                $key = str_replace('"', '\"', $key);
                $key = str_replace('#', '', $key);
                $sql .= "search_meta LIKE '%".$this->db->escape_str($key)."%' ";

            }

            $this->db->where($sql);

        }


        $this->db->order_by('publish_time','desc');

        $this->db->where('status',1);

        if($start=='all')
        {
            $this->db->get('videos');
            return $query;
        }
        else if($start=='total')
        {
            $query = $this->db->get('videos');
            return $query->num_rows();
        }
        else
        {
            $query = $this->db->get('videos',$limit,$start);
            return $query;
        }
    }
}

/* End of file page_model_core.php */
/* Location: ./system/application/models/page_model_core.php */
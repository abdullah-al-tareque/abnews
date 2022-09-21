<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('add_user_meta'))
{
	function add_user_meta ($user_id,$key,$value)
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('user_meta',array('user_id'=>$user_id,'key'=>$key));
		if($query->num_rows()>0)
		{
			$CI->db->update('user_meta',array('value'=>$value),array('user_id'=>$user_id,'key'=>$key));
		}
		else
		{
			$CI->db->insert('user_meta',array('user_id'=>$user_id,'key'=>$key,'value'=>$value));
		}
	}
}

if ( ! function_exists('get_user_meta'))
{
	function get_user_meta ($user_id,$key,$default='')
	{
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('user_meta',array('user_id'=>$user_id,'key'=>$key));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->value;
		}
		else
		{
			return $default;
		}
	}
}



if ( ! function_exists('get_featured_photo_by_id'))
{
	function get_featured_photo_by_id($img='')
	{
		if($img=='')
		return base_url('assets/admin/img/preview.jpg');
		else
		return base_url('uploads/thumbs/'.$img);
	}
}


if ( ! function_exists('create_square_thumb'))
{
	function create_square_thumb($img,$dest)
	{
		$seg = explode('.',$img);
		$thumbType    = 'jpg';
		$thumbSize    = 300;
		$thumbPath    = $dest;
		$thumbQuality = 100;

		$last_index = count($seg);
		$last_index--;

		if(strcasecmp($seg[$last_index], 'jpg') == 0 || strcasecmp($seg[$last_index], 'jpeg') == 0)
		{
			if (!$full = imagecreatefromjpeg($img)) {
			    return 'error';
			}			
		}
		else if(strcasecmp($seg[$last_index], 'png') == 0)
		{
			if (!$full = imagecreatefrompng($img)) {
			    return 'error';
			}			
		}
		else if(strcasecmp($seg[$last_index], 'gif') == 0)
		{
			if (!$full = imagecreatefromgif($img)) {
			    return 'error';
			}			
		}
		 
	    $width  = imagesx($full);
	    $height = imagesy($full);
		 
	    /* work out the smaller version, setting the shortest side to the size of the thumb, constraining height/wight */
	    if ($height > $width) {
	      $divisor = $width / $thumbSize;
	    } else {
	      $divisor = $height / $thumbSize;
	    }
		 
	    $resizedWidth   = ceil($width / $divisor);
	    $resizedHeight  = ceil($height / $divisor);
		 
	    /* work out center point */
	    $thumbx = floor(($resizedWidth  - $thumbSize) / 2);
	    $thumby = floor(($resizedHeight - $thumbSize) / 2);
		 
	    /* create the small smaller version, then crop it centrally to create the thumbnail */
	    $resized  = imagecreatetruecolor($resizedWidth, $resizedHeight);
	    $thumb    = imagecreatetruecolor($thumbSize, $thumbSize);
	    imagecopyresized($resized, $full, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $width, $height);
	    imagecopyresized($thumb, $resized, 0, 0, $thumbx, $thumby, $thumbSize, $thumbSize, $thumbSize, $thumbSize);
		 
		 $name = name_from_url($img);

	    imagejpeg($thumb, $thumbPath.str_replace('_large.jpg', '_thumb.jpg', $name), $thumbQuality);
	}
	
}

if ( ! function_exists('humanTiming'))
{
	function humanTiming ($time)
	{

	    $time = time() - $time; // to get the time since that moment

	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	        1 => 'second'
	    );

	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'').' ago';
	    }

	}
}


if ( ! function_exists('social_sharing_meta_tags_for_post'))
{

	function social_sharing_meta_tags_for_post($post='')
	{

		if($post!='' && $post->num_rows()>0)
		{
			$CI = get_instance();
			$post = $post->row();
			$curr_lang = get_current_lang();
			$site_title = get_settings('site_settings','site_title','Videopilot');
			$title = $post->title;

            $detail_link = post_detail_url($post);
            $featured_img = $post->media;
            $description = truncate(strip_tags($post->description),100,'');

			$meta = '<meta name="twitter:card" content="photo" />'."\n".
					'<meta name="twitter:site" content="'.$site_title.'" />'."\n".
					'<meta name="twitter:image" content="'.$featured_img.'" />'."\n".
					'<meta property="og:title" content="'.$title.'('.lang_key('with_video').')" />'."\n".
					'<meta property="og:site_name" content="'.$site_title.'" />'."\n".
					'<meta property="og:url" content="'.$detail_link.'" />'."\n".
                    '<meta property="og:description" content="'.$description.'" />'."\n".
					'<meta property="og:type" content="article" />'."\n".
					'<meta property="og:image" content="'.$featured_img.'" />'."\n".
					'<meta name="Description" content="'.$description.'">'."\n".
					'<link rel="canonical" href="'.$detail_link.'"/>'."\n".
					'<meta name="keywords" content="'.$post->tags.'" />'."\n";


			if(get_settings('global_settings','fb_app_id','none')!='')
			{

				$meta .='<meta property="fb:app_id" content="'.get_settings('global_settings','fb_app_id','none').'" />';
			}

		 
		 	return $meta;
		}
		else
			return '';

	}
}

if ( ! function_exists('social_sharing_meta_tags_for_pages'))
{

	function social_sharing_meta_tags_for_pages($alias='',$title='',$meta_desc='',$key_words='')
	{

			$CI = get_instance();

			$site_title = get_settings('site_settings','site_title','Videopilot');
            $url = current_url();
            $description = $meta_desc;

			$meta = '<meta name="twitter:card" content="photo" />'."\n".
					'<meta name="Description" content="'.$description.'">'."\n".
					'<meta name="twitter:site" content="'.$site_title.'" />'."\n".
					'<meta property="og:title" content="'.$title.'" />'."\n".
					'<meta property="og:site_name" content="'.$site_title.'" />'."\n".
					'<meta property="og:url" content="'.$url.'" />'."\n".
                    '<meta property="og:description" content="'.$meta_desc.'" />'."\n".
					'<meta property="og:type" content="article" />'."\n".
					'<link rel="canonical" href="'.$url.'"/>';

			if(get_settings('global_settings','fb_app_id','none')!='')
			{

				$meta .='<meta property="fb:app_id" content="'.get_settings('global_settings','fb_app_id','none').'" />';
			}

		 
		 	return $meta;

	}
}



if ( ! function_exists('word_limiter'))
{
    function word_limiter($str, $limit = 100, $end_char = '&#8230;')
    {
        if (trim($str) == '')
        {
            return $str;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

        if (strlen($str) == strlen($matches[0]))
        {
            $end_char = '';
        }

        return rtrim($matches[0]).$end_char;
    }
}


if ( ! function_exists('fileinfo_from_url'))
{

	function fileinfo_from_url($filePath)
	{
	 $fileParts = pathinfo($filePath);

	 if(!isset($fileParts['filename']))
	 {$fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));}
	 
	 return $fileParts;
	}
}

if ( ! function_exists('name_from_url'))
{

	function name_from_url($filePath)
	{
	 
	 $filePath = preg_replace('/\?.*/', '', $filePath);
	 $fileParts = pathinfo($filePath);
	 // print_r($fileParts);
	 // die;

	 if(!isset($fileParts['filename']))
	 {$fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));}
	
	 

	 return $fileParts['basename'];
	}
}


if ( ! function_exists('image_from_url'))
{
	function image_from_url ($url,$name='')
	{
		$url = str_replace('https://','http://', $url);
		if($name=='')
		$name = name_from_url($url);
		$ch = curl_init($url);
		$fp = fopen('uploads/images/'.$name, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		return base_url('uploads/images/'.$name);
	}
}


if ( ! function_exists('gif2jpeg'))
{
	function gif2jpeg($p_fl, $p_new_fl='', $bgcolor=false)
	{
	  	list($wd, $ht, $tp, $at)=getimagesize($p_fl);
		$img_src=imagecreatefromgif($p_fl);
		$img_dst=imagecreatetruecolor($wd,$ht);
		$clr['red']=255;
		$clr['green']=255;
		$clr['blue']=255;
		
		if(is_array($bgcolor)) $clr=$bgcolor;
		$kek=imagecolorallocate($img_dst,
		$clr['red'],$clr['green'],$clr['blue']);
		imagefill($img_dst,0,0,$kek);
		imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $wd, $ht, $wd, $ht);
	  	$draw=true;
		if(strlen($p_new_fl)>0)
		{
		    if($hnd=fopen($p_new_fl,'w'))
		    {
		    	$draw=false;
		    	fclose($hnd);
		    }
		}
		
		if(true==$draw)
		{
			header("Content-type: image/jpeg");
		    imagejpeg($img_dst);
		}
		else 
			imagejpeg($img_dst, $p_new_fl);
		  
		imagedestroy($img_dst);
		imagedestroy($img_src);
	}
}


if ( ! function_exists('resized_to_fixed_width'))
{

	function resized_to_fixed_width($img,$width=500)
	{
		$CI = get_instance();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $img;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;

		$CI->load->library('image_lib', $config);

		$CI->image_lib->resize();
	}
}

if ( ! function_exists('create_rect_thumb'))
{

	function create_rect_thumb($img,$dest,$ratio=3)
	{

		$seg = explode('.',$img);	//explde the source to get the image extension
		$thumbType    = 'jpg';		//generated thumb will be of type jpg
		$thumbPath    = $dest;	//destination path of the thumb -- original image name will be appended
		$thumbQuality = 80;				//quality of the thumbnail (in percent)

		//chech the image type and create image accordingly
		if($seg[2]=='jpg' || $seg[2]=='JPG' || $seg[2]=='jpeg')
		{
			if (!$full = imagecreatefromjpeg($img)) {
			    return 'error';
			}
		}
		else if($seg[2]=='png')
		{
			if (!$full = imagecreatefrompng($img)) {
			    return 'error';
			}			
		}
		else if($seg[2]=='gif')
		{
			if (!$full = imagecreatefromgif($img)) {
			    return 'error';
			}			
		}

	    $width  = imagesx($full);
	    $height = imagesy($full);

	    /*wourk out the thumbnail size*/
	    $resizedHeight	= min($width*$ratio/8,$height);
	    $resizedWidth	= $width;
		 
	    /* work out starting point */
	    $thumbx = 0;	// x always starts at zero -- the thumbnail gets the same width as the source image
	    $extra_height = $height - $resizedHeight;
	    $thumby = floor(($extra_height) / 2);
		 
	    /* create the small smaller version, then crop it centrally to create the thumbnail */
	    $resized  = imagecreatetruecolor($resizedWidth, $resizedHeight);
	    imagecopy($resized, $full,0,0,$thumbx,$thumby,$resizedWidth,$resizedHeight);
		 
		$name = name_from_url($img);

	    imagejpeg($resized, $thumbPath.str_replace('_large.jpg', '_thumb.jpg', $name), $thumbQuality);
	}
}



if ( ! function_exists('put_watermark'))
{
	function put_watermark($src,$text='')
	{
		$CI = get_instance();
		$CI->load->library('image_lib');
		$config['source_image'] = $src;
		$config['wm_text'] = $text;
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = './system/fonts/texb.ttf';
		$config['wm_font_size'] = '16';
		$config['wm_font_color'] = 'ffffff';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		$config['wm_padding'] = '0';

		$CI->image_lib->initialize($config);

		$CI->image_lib->watermark();
	}
}

if ( ! function_exists('filePath'))
{
	function filePath($filePath)
	{
		$fileParts = pathinfo($filePath);

		if(!isset($fileParts['filename']))
		{
			$fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));
		}
	 
		return $fileParts;
	}
}


if ( ! function_exists('is_animated'))
{
	function is_animated($filename)
	{
        $filecontents=file_get_contents($filename);

        $str_loc=0;
        $count=0;
        while ($count < 2) # There is no point in continuing after we find a 2nd frame
        {
            $where1=strpos($filecontents,"\x00\x21\xF9\x04",$str_loc);
            if ($where1 === FALSE)
            {
                break;
            }
            else
            {
                $str_loc=$where1+1;
                $where2=strpos($filecontents,"\x00\x2C",$str_loc);
                if ($where2 === FALSE)
                {
                    break;
                }
                else
                {
                    if ($where1+8 == $where2)
                    {
                        $count++;
                    }
                                $str_loc=$where2+1;
                }
            }
        }

        if ($count > 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
	}
}

if ( ! function_exists('videoType'))
{
	function videoType($url) 
	{
	    if (strpos($url, 'youtube') > 0) 
	    {
	        return 'youtube';
	    } 
	    elseif (strpos($url, 'vimeo') > 0) 
	    {
	        return 'vimeo';
	    }
	    else 
	    {
	        return 'unknown';
	    }
	}
}

if ( ! function_exists('load_view'))
{
	function load_view($view='',$data=array(),$buffer=FALSE,$theme='')
	{
		$CI 	= get_instance();
		if($theme=='')
		$theme 	= get_active_theme();
		if($buffer==FALSE)
		{
			if(@file_exists(APPPATH."modules/themes/views/".$theme."/".$view.".php"))
			$CI->load->view('themes/'.$theme.'/'.$view,$data);
			else
			$CI->load->view('themes/default/'.$view,$data);	
		}
		else
		{
			if(@file_exists(APPPATH."modules/themes/views/".$theme."/".$view.".php"))
			$view_data = $CI->load->view('themes/'.$theme.'/'.$view,$data,TRUE);
			else
			$view_data = $CI->load->view('themes/default/'.$view,$data,TRUE);	
			return $view_data;
		}
	}
}

if ( ! function_exists('load_template'))
{
	function load_template($data=array(),$theme='',$tmpl='template_view')
	{
		$row 	= get_option('site_settings');
		if(is_array($row) && isset($row['error']))
		{
			echo 'Site settings not found.error on : epbase_helper';
			die();
		}
		else
		{
			$values 		= json_decode($row->values);
			$data['title'] 	= $values->site_title;
		}

		load_view($tmpl,$data);
	}
}

if ( ! function_exists('get_active_theme'))
{
	function get_active_theme()
	{
		$row = get_option('active_theme');
		if(is_array($row) && isset($row['error']))
		{
			return 'default';
		}
		else
			return $row->values;
	}
}

if ( ! function_exists('get_option'))
{
	function get_option($key='')
	{
		$CI = get_instance();
		$query = $CI->db->get_where('options',array('key'=>$key,'status'=>1));		
		if($query->num_rows()>0)
			return $query->row();
		else
			return array('error'=>'Key not found');
	}
}

if ( ! function_exists('update_option'))
{
	function update_option($key='',$values=array())
	{
		$CI = get_instance();
		$data['values'] = json_encode($values);
		echo $key;
		print_r($data);
		$query = $CI->db->update('options',$data,array('key'=>$key));		
	}
}


if ( ! function_exists('get_plugins'))
{
	function get_plugins()
	{
		$CI = get_instance();
		$query = $CI->db->get_where('plugins',array('status'=>1));		
		return $query;
	}
}

if ( ! function_exists('get_widgets_by_position'))
{
	function get_widgets_by_position($pos='')
	{
		$CI = get_instance();
		$positions = get_option('positions');
		$positions = json_decode($positions->values);
		$widgets = array();
		foreach($positions as $position)
		{
			if($position->name==$pos)
			{
				if(isset($position->widgets))
				$widgets = $position->widgets;
			}
		}
		return $widgets;
	}
}

if ( ! function_exists('configPagination'))
{
	function configPagination($url,$total_rows,$segment,$per_page=10)
	{
		$CI = get_instance();
		$CI->load->library('pagination');
		$config['base_url'] 		= site_url($url);
		$config['total_rows'] 		= $total_rows;
		$config['per_page'] 		= $per_page;
		$config['uri_segment'] 		= $segment;
		$config['full_tag_open'] 	= '<div class="pagination"><ul>';
		$config['full_tag_close'] 	= '</ul></div>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close']	= '</a></li>';
		$config['num_links'] 		= 5;
		$config['next_tag_open'] 	= "<li>";
		$config['next_tag_close'] 	= "</li>";
		$config['prev_tag_open'] 	= "<li>";
		$config['prev_tag_close'] 	= "</li>";
		
		$config['first_link'] 	= FALSE;
		$config['last_link'] 	= FALSE;
		$CI->pagination->initialize($config);
		
		return $CI->pagination->create_links();
	}
}

if ( ! function_exists('count_videos_by_category'))
{
	function count_videos_by_category($id='')
	{
		if($id==0)
			return '0';
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('videos',array('category'=>$id));
		return $query->num_rows();
	}
}

if ( ! function_exists('count_videos_by_subcategory'))
{
	function count_videos_by_subcategory($id='')
	{
		if($id==0)
			return '0';
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('videos',array('sub_category'=>$id));
		return $query->num_rows();
	}
}


if ( ! function_exists('get_category_title_by_id'))
{
	function get_category_title_by_id($id='')
	{
		if($id==0)
			return 'No parent';
		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('categories',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return lang_key($row->title);
		}
		else
			return '';
	}
}

if ( ! function_exists('get_source_title_by_id'))
{
    function get_source_title_by_id($id='')
    {
        if($id==0)
            return 'No Source';
        $CI = get_instance();
        $CI->load->database();
        $query = $CI->db->get_where('sources',array('id'=>$id));
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return lang_key($row->source_name);
        }
        else
            return '';
    }
}



if ( ! function_exists('get_profile_photo_by_id'))
{
	function get_profile_photo_by_id($id='',$type='')
	{
		if($id==0)
			return 'No found';

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->profile_photo=='')
				return base_url().'uploads/profile_photos/nophoto-'.strtolower($row->gender).'.jpg';
			
			if($type=='thumb')
			return base_url().'uploads/profile_photos/thumb/'.$row->profile_photo;
			else
			return base_url().'uploads/profile_photos/'.$row->profile_photo;
		}
		else
		{

			return base_url().'uploads/profile_photos/nophoto-female.jpg';
		}
	}
}

if ( ! function_exists('get_profile_photo_name_by_username'))
{
	function get_profile_photo_name_by_username($username='',$type='thumb')
	{
		if($username=='')
			return 'Not found';

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_name'=>$username));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->profile_photo!='')
			return $row->profile_photo;
			else
			return 'nophoto-'.strtolower($row->gender).'.jpg';
		}
		else
			return 'nophoto-.jpg';
	}
}

if ( ! function_exists('get_profile_photo_by_username'))
{
	function get_profile_photo_by_username($username='',$type='thumb')
	{
		if($username=='')
			return 'Not found';

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('users',array('user_name'=>$username));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			if($row->profile_photo!='')
			return base_url().'uploads/profile_photos/'.$type.'/'.$row->profile_photo;
			else
			return base_url().'uploads/profile_photos/nophoto-'.strtolower($row->gender).'.jpg';
		}
		else
			return base_url().'uploads/profile_photos/nophoto-female.jpg';
	}
}




if ( ! function_exists('get_view_count'))
{
	function get_view_count($post_id,$from='all')
	{
		if (isset($_COOKIE['viewcookie'.$post_id])==FALSE && $from=='detail')
		{
			$CI = get_instance();
			$CI->load->database();

			$query = $CI->db->get_where('posts',array('id'=>$post_id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				$total_view = $row->total_view;
				$total_view++;
			}		
			else
				$total_view = 0;	
			$CI->db->update('posts',array('total_view'=>$total_view),array('id'=>$post_id));
			setcookie("viewcookie".$post_id, 1, time()+1800);
			return $total_view;
		}
		else
		{
			$CI = get_instance();
			$CI->load->database();

			$query = $CI->db->get_where('posts',array('id'=>$post_id));
			if($query->num_rows()>0)
			{
				$row = $query->row();
				return $row->total_view;
			}		
			else
				$total_view = 0;				
		}
	}
}


if ( ! function_exists('create_rectangle_thumb'))
{
    function create_rectangle_thumb($img,$dest)
    {
        $seg = explode('.',$img);
        $thumbType    	= 'jpg';
        $thumbSize    	= 300;
        $thumbWidth 	= 300;
        $thumbHeight 	= 226;
        $thumbPath    	= $dest;
        $thumbQuality 	= 100;

        $last_index = count($seg);
        $last_index--;

        if(strcasecmp($seg[$last_index], 'jpg') == 0 || strcasecmp($seg[$last_index], 'jpeg') == 0)
        {
            if (!$full = imagecreatefromjpeg($img)) {
                return 'error';
            }
        }
        else if(strcasecmp($seg[$last_index], 'png') == 0)
        {
            if (!$full = imagecreatefrompng($img)) {
                return 'error';
            }
        }
        else if(strcasecmp($seg[$last_index], 'gif') == 0)
        {
            if (!$full = imagecreatefromgif($img)) {
                return 'error';
            }
        }

        $width  = imagesx($full);
        $height = imagesy($full);

        /* work out the smaller version, setting the shortest side to the size of the thumb, constraining height/wight */
        if ($height > $width) {
            $divisor = $width / $thumbHeight;
        } else {
            $divisor = $height / $thumbWidth;
        }

        $resizedWidth   = ceil($width / $divisor);
        $resizedHeight  = ceil($height / $divisor);

        /* work out center point */
        $thumbx = floor(($resizedWidth  - $thumbWidth) / 2);
        $thumby = floor(($resizedHeight - $thumbHeight) / 2);

        /* create the small smaller version, then crop it centrally to create the thumbnail */
        $resized  = imagecreatetruecolor($resizedWidth, $resizedHeight);
        $thumb    = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresized($resized, $full, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $width, $height);
        imagecopyresized($thumb, $resized, 0, 0, $thumbx, $thumby, $thumbWidth, $thumbHeight, $thumbWidth, $thumbHeight);

        $name = name_from_url($img);

        imagejpeg($thumb, $thumbPath.str_replace('_large.jpg', '_thumb.jpg', $name), $thumbQuality);
    }

}

if ( ! function_exists('get_category_parent_by_id'))
{
    function get_category_parent_by_id($id)
    {

    	$CI = get_instance();
    	$CI->load->database();
    	$query = $CI->db->get_where('categories',array('id'=>$id,'status'=>1));
        if($query->num_rows()>0)
        {
        	$row = $query->row();
        	if($row->parent==0)
        		return $id;
        	else
        		return $row->parent;
        }
        else
        {
        	return $id;
        }
    }
}


if ( ! function_exists('get_category_fa_icon'))
{
	function get_category_fa_icon($id)
	{

		$CI = get_instance();
		$CI->load->database();
		$query = $CI->db->get_where('categories',array('id'=>$id,'status'=>1));
		if($query->num_rows()>0)
		{
			$row = $query->row();

			if($row->fa_icon != '')
				return $row->fa_icon;
			else
				return 'fa-picture-o';
		}
		else
		{
			return 'fa-picture-o';
		}
	}
}

if ( ! function_exists('translateable_date'))
{
	function translateable_date($time)
	{
		$mon  = date('F', $time);
		$day  = date('d', $time);
		$year = date('Y', $time);
		return lang_key(strtolower($mon)).' '.$day.', '.$year;
	}
}

if ( ! function_exists('grab_duration_options'))
{
	function grab_duration_options()
	{
		$diff = 1; // change this value on version 1.3
		$options = array();
		for($i=$diff;$i<=24;$i=$i+$diff)
		{
			$options[$i] = $i.' '.lang_key('hours');
		}

		return $options;
	}
}

if ( ! function_exists('start_time_options'))
{
	function start_time_options()
	{
		$diff = 6;
		$options = array();
		
		$start = "0:00";
		$end = "23:00";

		$tStart = strtotime($start);
		$tEnd = strtotime($end);
		$tNow = $tStart;

		$i = 0;
		while($tNow <= $tEnd){
		  #echo date("h:i a",$tNow)."\n";
		  $options[$i] = date("h:i a",$tNow);
		  $tNow = strtotime('+60 minutes',$tNow);
		  $i++;
		}
		return $options;
	}
}

if ( ! function_exists('item_per_grab_options'))
{
	function item_per_grab_options()
	{
		$diff = 5;
		$options = array();
		for($i=$diff;$i<=50;$i=$i+$diff)
		{
			$options[$i] = $i;
		}

		return $options;
	}
}

if ( ! function_exists('get_category_id_by_key'))
{
    function get_category_id_by_key($key)
    {
        $CI = get_instance();
        $CI->load->database();
        $CI->db->where('title',$key);
        $query= $CI->db->get('categories');
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return $row->id;
        }
        else
            return -1;
    }
}

if ( ! function_exists('get_source_id_by_key'))
{
    function get_source_id_by_key($key)
    {
        $CI = get_instance();
        $CI->load->database();
        $CI->db->where('source_name',$key);
        $query= $CI->db->get('sources');
        if($query->num_rows()>0)
        {
            $row = $query->row();
            return $row->id;
        }
        else
            return -1;

    }
}

if ( ! function_exists('get_excerpt'))
{
    function get_excerpt($description='')
    {
        $description = preg_replace("/<img[^>]+\>/i", "", $description); 
        $description = strip_tags($description); 
        return $description;
    }
}
// added on version 1.4
if ( ! function_exists('check_video_edit_permission'))
{
    function check_video_edit_permission($id='')
    {
    	$CI = get_instance();
    	if($id=='')
    	{
			if(is_admin())
	    		return TRUE;
	    	else if(is_moderator() && get_settings('global_settings','moderator_can_create_post','No')=='Yes')
	    		return TRUE;
	    	else if(is_generaluser() && get_settings('global_settings','generaluser_can_create_post','No')=='Yes')
	    	{
	    		return TRUE;
	    	}
	    	else
	    		return FALSE; 
    	}
    	else
    	{
	    	$CI->load->model('admin/content_model');
	    	$videos = $CI->content_model->get_video_data_by_id($id);
	    	if(is_admin())
	    		return TRUE;
	    	else if(is_moderator() && get_settings('global_settings','moderator_can_create_post','No')=='Yes')
	    		return TRUE;
	    	else if(is_generaluser() && get_settings('global_settings','generaluser_can_create_post','No')=='Yes' && $videos->author==$CI->session->userdata('user_id'))
	    	{
	    		return TRUE;
	    	}
	    	else
	    		return FALSE;    		
    	}
    }
}
//end
if ( ! function_exists('get_channel_id_from_url'))
{
    function get_channel_id_from_url($url='')
    {
    	if(stripos($url,'//'))
    	{
    		$seg = explode('/', $url);
    		return $seg[count($seg)-1];
    	}
    	else
    		return $url;
    }
}
if ( ! function_exists('get_channel_id_from_user_url'))
{
    function get_channel_id_from_user_url($url='')
    {
    	if(stripos($url,'//'))
    	{
    		$seg = explode('/', $url);
    		$user_name = $seg[count($seg)-1];
    	}
    	else
    		$user_name = $url;
    
    	$CI = get_instance();
    	$CI->load->model('grab/grab_model');
    	$channel_id = $CI->grab_model->get_channel_id_from_user($user_name);

		return $channel_id;
    }
}

if ( ! function_exists('get_playlist_id_from_url'))
{
    function get_playlist_id_from_url($url='')
    {
    	if(stripos($url,'//'))
    	{
	    	$urlInfo = parse_url($url);
			$urlVars = array();
			parse_str($urlInfo['query'], $urlVars); 
			if(isset($urlVars['list']))
				return $urlVars['list'];
			else
				return $url;
		}
		else
			return $url;
    }
}

if ( ! function_exists('get_youtube_video_id_from_url'))
{
    function get_youtube_video_id_from_url($url='')
    {
    	if(stripos($url,'//'))
    	{
	    	$urlInfo = parse_url($url);
			$urlVars = array();
			parse_str($urlInfo['query'], $urlVars); 
			if(isset($urlVars['v']))
				return $urlVars['v'];
			else
				return $url;
		}
		else
			return $url;
    }
}

if ( ! function_exists('check_youtube_url_validity'))

{

    function check_youtube_url_validity($url='')

    {

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36"); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 0); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$response = curl_exec($ch); 
		if (curl_errno($ch)) {
		    $error_msg = curl_error($ch);
		}

		curl_close($ch);

		if (isset($error_msg)) 
		{
		    return array('result'=>FALSE,'msg'=>$error_msg);
		}
		else
		{
			return array('result'=>TRUE,'msg'=>'');
		}

    }

}

if ( ! function_exists('get_max_thumb_url'))
{
	function get_max_thumb_url($thumbnails)
	{
		if(isset($thumbnails->standard))
			return $thumbnails->standard->url;
		else if(isset($thumbnails->high))
			return $thumbnails->high->url;
		else if(isset($thumbnails->medium))
			return $thumbnails->medium->url;		
		else
			return $thumbnails->default->url;		
	}
}

if ( ! function_exists('checkRemoteFile'))
{
	function checkRemoteFile($url)
	{
		$url = str_replace('https://', 'http://', $url);

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    // don't download content
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    if(curl_exec($ch)!==FALSE)
	    {
	        return true;
	    }
	    else
	    {
	    	echo 'Curl-Fehler: ' . curl_error($ch);
	    	die;
	        return false;
	    }

	}
}

if ( ! function_exists('get_media_url'))
{
	function get_media_url($url,$youtube_id)
	{
	
		$large_thumb = $url;

		if($large_thumb!='')
		{
			$is_media_exists = checkRemoteFile($large_thumb);
			if($is_media_exists)
			{
				if(get_settings('global_settings','save_images_locally','No')=='Yes')
				{
					$url = image_from_url($large_thumb,$youtube_id.'.jpg');
					$image_url = $url;
				}
				else
					$image_url = $large_thumb;
			}
			else
			{
				$image_url = base_url('uploads/images/no-image.png');
			}
		}
		else
		{
			$image_url = base_url('uploads/images/no-image.png');
		}

		return $image_url;
	}
}

if ( ! function_exists('get_url_content'))
{
	function get_url_content($url='')
	{
		  $ch 	= curl_init(); 
		  curl_setopt($ch, CURLOPT_URL, $url); 
		  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36"); 
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		  curl_setopt($ch, CURLOPT_TIMEOUT, 0); 
		  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		  $response = curl_exec($ch); 
		  curl_close($ch); 

		  if(!empty($response))
		  {
		  	return $response;
		  }
		  else
		  	return '';	  	
	}
}
/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */
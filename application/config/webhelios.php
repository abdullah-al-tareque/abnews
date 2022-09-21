<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['blog_post_types']	= array('blog'=>'blog_post','article'=>'article','news'=>'news');

$config['source_types']	= array('youtube_channel','youtube_user','youtube_playlist','youtube_search');


$config['decimal_point'] = '.';
$config['thousand_separator'] = ',';


#setting this config value to non empty will override the packge price currency.
#so if you have paypal enabled then remeber to use a currency which is supported by paypal. Otherwise your paypal payment will not work
#use this settings only if you want to enable bank payment and disable paypal payment
$config['package_currency'] = '';

#example
#$config['package_currency'] = 'USD';


#active languages 
$config['active_languages'] = array('en'=>'English','es'=>'Spanish','ru'=>'Russian','ar'=>'Arabic','de'=>'German','fr'=>'French','it'=>'Italian','pt'=>'Portuguese','tr'=>'Turkish','hi'=>'Hindi','bn'=>'Bangla','bg'=>'Bulgarian','ur'=>'Urdu','th'=>'Thai','ta'=>'Tamil');
#$config['active_languages'] = array('en'=>'English','ru'=>'Russian');

#use ssl
$config['use_ssl'] = 'no';


#if you use google map as banner then loading all posts can slowdown your site
#so define how many recent posts you want to show there
$config['banner_map_post_limit'] = 200;

#if set to 1 then related video link will be shown within youtube player
$config['show_related_video_on_player'] = 0;

#Any news with these blocked words wont be grabbed
#example $config['blocked_words'] = "fword,nword";
#it will not grab any news which contains "fword" or "nword" within it's title or description 
#by default it is set to none
$config['blocked_words'] = "";

#News only with any of these words will be grabbed
#example $config['blocked_words'] = "football,tennis";
#it will grab only those news which contains "football" or "tennis" within it's title or description 
#by default it is set to none
$config['match_words'] = "";

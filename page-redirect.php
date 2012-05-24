<?php  
/* 
Template Name: Redirect 
*/  
  
$redirect_url = get_post_meta($post->ID, 'redirect_url', true);  
if ($redirect_url) {  
Header( 'HTTP/1.1 301 Moved Permanently' );  
Header( 'Location: '.$redirect_url.'' );  
}  
?>
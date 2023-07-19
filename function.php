<?php
function meta_tags($pageName = '') {  
	$tags = require 'meta_tag.php';  
	$pageTags = $tags[$pageName];  
	$html = '';  
	foreach ($pageTags as $key => $tag) {    
		$html .= '<meta name="'.$tag['name'].'" content="'.$tag['content'].'">';
		$html .= "\n";
	}
  	return $html;
}
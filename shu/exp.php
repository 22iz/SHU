<?php 
	$str='/*.(jpg|gif|pjpeg|png)/';
	$test='/fuck.jpg';
	$matches = array();
	if(preg_match($str,$test,$matches)){
		var_dump($matches);
	}
 ?>
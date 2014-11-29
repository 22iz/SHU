<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid );//根据ID获取用户等基本信息


$token_new = $_SESSION['token']['access_token'];
$expires_in = $_SESSION['token']['expires_in'];

print_r($_SESSION);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新浪微博V2发布接口</title>
</head>

<body>

<?php 
	
	// connect database uicer
	// $con = mysql_connect("localhost", "94449588.host", "uicer&yunduan");
	$con = mysql_connect("localhost", "uicer", "1+1=uicer");
	if (!$con){ die('Could not connect: ' . mysql_error()); }
	
	$db_selected = mysql_select_db("uicer", $con);
	mysql_query("set names 'utf8'");
	
	echo $user_message['screen_name'] . $uid . ' 正在准备更新token' . '<br/><br/><hr/>';
	
	// check if uid exist & get old token
	$sql_uid = "select token from dd_shudong_v2 WHERE uid='$uid'";
	$result_uid = mysql_query($sql_uid, $con);
	while($row_uid = mysql_fetch_array($result_uid))
	{
		$token_old = $row_uid['token'];
	}
	
	if (!isset($token_old)){
		die('invalid weibo account！');
	}
	
	// compare the old token & the new token
	if ($token_old != $token_new){ // refresh the token 
		
		$datetime = date('Y-m-d H:i:s');
		
		$sql_refresh = "update dd_shudong_v2 SET token = '$token_new', expires_in = '$expires_in', created = '$datetime' WHERE uid='$uid'";
		$result_update = mysql_query($sql_refresh, $con);
	
		if ($result_update) echo '更新token完毕';
		
	} else{
		echo '检查token未过期，无需更新';
	}

?>

</body>
</html>

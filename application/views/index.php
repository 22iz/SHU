<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

// connect database uicer
$con = mysql_connect("localhost", "uicer", "1+1=uicer");
if (!$con){ die('Could not connect: ' . mysql_error()); }

$db_selected = mysql_select_db("uicer", $con);
mysql_query("set names 'utf8'");

// get token_old to send weibo
$sql_uid = "select token from dd_shudong_v2 WHERE id = 1";
$result_uid = mysql_query($sql_uid, $con);
while($row_uid = mysql_fetch_array($result_uid))
{
	$token_old = $row_uid['token'];
}

if (!isset($token_old)){
	die('weibo token is missing！');
}

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $token_old );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style.css" type="text/css" rel="stylesheet" charset="utf-8" />
<title>UIC树洞机器人V2</title>
</head>

<body>

<div class="W_Banner">
	<a href="">UIC树洞机器人V2 零食版</a>
</div>

<div class="W_Box" onmousemove="if(document.getElementById('W_Panel_upload_input').value != '') document.getElementById('W_Panel_notice').innerHTML=document.getElementById('W_Panel_upload_input').value">
	<form id="W_Post" enctype="multipart/form-data"method="post" action="" >
	
	<p class="W_Post_word_count">还可输入<span id="W_Post_word_left">140</span>个字</p>
	
	<textarea type="text" name="text" onkeyup="document.getElementById('W_Post_word_left').innerHTML = eval(140-this.value.length)" onfocus="if(this.value=='点此输入要发送的微博内容') {this.value='';}this.style.color='#333';" onblur="if(this.value=='') {this.value='点此输入要发送的微博内容';this.style.color='#333';}">点此输入要发送的微博内容</textarea>
	
	<div class="W_Panel">

		<div class="W_Panel_upload"><input size="1" id="W_Panel_upload_input" class="W_Panel_upload_input" type="file" name="pic" value="上传图片" /></div>
		
		<span>上传图片</span>
		<input class="W_Panel_submit" type="submit" value="发送"/>
		<span onclick="document.getElementById('W_Post').submit()">发布微博</span>
		
		<p id="W_Panel_notice"></p>
	</div>
	</form>
</div>

<div class="W_Notification">
	
	*由于新浪V2接口实现树洞功能较为令人抓狂和蛋疼，因此在令牌自动更新期间可能会短时间无法发布，属正常现象。<br/>
	*此版本树洞为零食过渡版，正式版尚未完工，为缓解大家对树洞君滴思念之情，顺便排查V2功能上的BUG之用。<br/>
	为了树洞的发展，欢迎反馈各种bug（最好有图有真相哦^-^）给 <a href="http://weibo.com/imdiadian">@外星人放點點粥回来了</a>
	
	<p>树洞微博发布须知 :</p>

	不得利用本微博危害国家安全、泄露国家秘密，不得侵犯国家社会集体的和公民的合法权益，不得利用本微博制作、复制和传播下列信息：<br/>

	捏造或者歪曲事实，散布谣言，扰乱社会秩序的；<br/>
	宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、教唆犯罪的；<br/>
	公然侮辱他人或者捏造事实诽谤他人的，或者进行其他恶意攻击的；<br/>
	进行商业广告行为的。
</div>

<?php 
	
	if ($_POST){
		
		if ($_FILES['pic']['tmp_name']== ''){ //木有图片
			$rr = $c->update( $_POST['text'] );
		} else{
			$rr = $c->upload( $_POST['text'] , $_FILES['pic']['tmp_name'] );
		}

		//$rr = $c->upload( $weibo_content , 'http://www.lovingjob.com/weibo/' . $pic . '.jpg' ); // 『这里修改了图片地址』
		
		if ( isset($rr['error_code']) && $rr['error_code'] > 0 ) {
			$notice = "发送失败，错误：#" . $rr['error_code'] . ":" . $rr['error'];
		} else {
			$notice = "发送成功";
		}
		
		echo "<script>document.getElementById('W_Panel_notice').innerHTML='$notice'</script>";
		
	}

?>

<?php
//iconv转化字符编码遇到'-'会出现illegal character; mb_convert_encoding不会 但是效率慢
/**
 * 截取utf8字符串
 */
function utf8Substr($str, $from, $len){
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
                '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
            '$1',$str);
}
/**
 * 计算utf8字符串长度
 */
function utf8Strlen($string = null) {
    // 将字符串分解为单元
    preg_match_all('/./us', $string, $match);
    // 返回单元个数
    return count($match[0]);
}
?>


</body>
</html>

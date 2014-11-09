<?php
session_start();
include_once( APPPATH.'libraries/weibooauth.php' );
class ajax extends CI_controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('th_usr_model','usr');
	}
	//使用树洞的token
	function tclient(){
		$th_token=new SaeTClientV2($this->config->item('WB_AKEY'),$this->config->item('WB_SKEY'),
								$this->usr->load_token());
		return $th_token;
		}
	//发送树洞微博
	function post($text='分享图片',$mid=null,$url=null){
		$th_token=$this->tclient();
		//微博发送
		if(isset($_POST['img_url'])){
			$url=$_POST['img_url'];
		}
		if(isset($_POST['text'])){
			$text=$_POST['text'];
		}
		($url==null)?$th_token->update($text):$th_token->upload($text,$url);
		// $data=array('th_post_text'=>$text,'th_post_time'=>$date,'th_post_img'=>$url);
		// $token=$this->usr->post_insert($data);
	}
	
	//图片上传
	function upload(){
		if(isset($_FILES['pic'])){

			if(($_FILES['pic']['type'] == 'image/gif')|| ($_FILES['pic']['type'] == 'image/jpeg')|| ($_FILES['pic']['type'] == 'image/pjpeg')|| ($_FILES['pic']['type']=='image/png') && ($_FILES['pic']['size'] < 500000)){
				
				if ($_FILES['pic']['error'] > 0){
					echo 'failed';
				}else{	
					if($_FILES['pic']['type'] == 'image/gif'){
						$type='.gif';
					}elseif ($_FILES['pic']['type'] == 'image/jpeg') {
						$type='.jpg';
					}elseif ($_FILES['pic']['type'] == 'image/pjpeg') {
						$type='.jpg';
					}elseif ($_FILES['pic']['type']=='image/png'){
						$type='.png';
					}
					$filename=urldecode($_FILES['pic']['name']);
					$name='./upload_image/'.date('Y-m-d-H-i-s').'-'.rand(0,200).$type;
					$file='./upload_image/'.$filename;
					move_uploaded_file($_FILES['pic']['tmp_name'], iconv("UTF-8","gb2312//ignore",$file));	
					if(file_exists(iconv("UTF-8","gb2312",$file))){
						if(rename(iconv("UTF-8","gb2312",$file),$name)){
							$url=$name;
						}
					}
					echo json_encode($url);
				}
				//<?php echo $code_url;//
			}else{			
				echo 'format';
			}
		}
	}


	//加载微博以及输出到主页面上
	//获取$page 页，前5条微博
		
	function load($count=8,$length=4){
		$th_token=$this->tclient();
		$weibo=array();
		if(isset($_POST['count'])){
			$count=$_POST['count'];
		}
		$page=ceil($count/100);
		$weiboIndex=0;
		for($j=1;$j<=$page;$j++){
			$length=($count>100)?100:$count;
			if($count>100 && $j==($page-1)){
					$count=$count-$j*100;
			}
			$timeline=$th_token->user_timeline_by_name('uictreehole',$j,100);
			$length--;
			for($i=0;$i<=$length;$i++){ 
				$ms=array('text'=>null,'mid'=>null,'cCount'=>null,'rCount'=>null,'img'=>null,'original_pic'=>null,'repost'=>null,'repost_img'=>null,'repost_original_pic'=>null);
				//微博内容
				$ms['text']=$timeline['statuses'][$i]['text'];
				//微博mid
				$ms['mid']=$timeline['statuses'][$i]['mid'];			
				//微博转发统计
				$ms['rCount']=$timeline['statuses'][$i]['reposts_count']; 
				//微博评论统计                    
				$ms['cCount']=$timeline['statuses'][$i]['comments_count']; 
				//微博图片缩略图地址(预览图地址：bmiddle_pic,全图地址:original_pic)
				if(isset($timeline['statuses'][$i]['thumbnail_pic'])){
					$ms['img']=$timeline['statuses'][$i]['thumbnail_pic'];
					$ms['original_pic']=$timeline['statuses'][$i]['original_pic'];
				}
				//微博转发原微博内容
				if(isset($timeline['statuses'][$i]['retweeted_status']['text'])){
					$ms['repost']=$timeline['statuses'][$i]['retweeted_status']['text'];
					if(isset($timeline['statuses'][$i]['retweeted_status']['thumbnail_pic'])){
						$ms['repost_img']=$timeline['statuses'][$i]['retweeted_status']['thumbnail_pic'];
						$ms['repost_original_pic']=$timeline['statuses'][$i]['retweeted_status']['original_pic'];
					}
				}
				$weibo[$weiboIndex]=$ms;
				$weiboIndex++;
			}
		}
			// 将$weibo数组转换成JSON格式传回
			// print_r($weibo);
			echo json_encode($weibo);
	}

	//加载微博评论
	function loadComment($page=1,$mid=null){
		$th_token=$this->tclient();
		if (isset($_POST['mid']) && $_POST['mid']!=null){
			$mid=$_POST['mid'];
			if(isset($_POST['page'])){
				$page=$_POST['page'];
			}
			echo $this->dataResponse($mid,$th_token,'loadComment',$page);
		}
	}

	//发表评论
	function sendComment($text=null,$mid=null,$is_repost=0,$response = array('comment' =>null ,'rt'=>null,'error'=>null )){
		$th_token=$this->tclient();
		if(isset($_POST['text'])){
			$text=$_POST['text'];
		}
		if(isset($_POST['mid'])){
			$mid=$_POST['mid'];
		}
		$data=$th_token->send_comment($mid,$text);
		if(isset($_POST['is_repost'])){
			$is_repost=$_POST['is_repost'];	
		}
		if($is_repost){
			$this->repost($text,$mid);
		}else{
			$response['comment']=$data['status']['comments_count'];
			$response['rt']=$data['status']['reposts_count'];
			echo json_encode($response);
		}
	}
		//转发树洞微博
	function repost($text=null,$mid=null,$is_comment=0,$response=array('comment'=>null, 'rt'=>null,'error'=>null)){
		$th_token=$this->tclient();
		$text="转发微博";
		// 用户转发微博到树洞
		if(isset($_POST['text'])){
			$text=$_POST['text'];
		}
		if(isset($_POST['mid'])){
				$mid=$_POST['mid'];
		}	
		if(isset($_POST['is_comment'])){
			$is_comment=$_POST['is_comment'];
		}
		$data=$th_token->repost($mid,$text,$is_comment);
		if(isset($data['error_code'])){
			$response['error']='error';
		}else{
			$response['comment']=$data['comments_count'];
			$response['rt']=$data['reposts_count'];
			echo json_encode($response);
		}
	}
	//前端数据返回函数
	protected function dataResponse($mid=null,$th_token=null,$control=null,$page=1){
		switch ($control) {
			case 'repost':
					$response=array('comment'=>null,'rt'=>null);
				break;
			case 'comment':
					$response=array('comment'=>null,'rt'=>null);
				break;
			case 'loadComment':
				$response=array('text'=>array(),'comment'=>null,'rt'=>null);
				$listComment=array('user'=>null,'text'=>null,'cid'=>null);
				$comment=$th_token->get_comments_by_sid($mid,$page,5);
				foreach($comment['comments'] as $key => $comment){
					$listComment['user']=$comment['user']['name'];
					$listComment['text']=$comment['text'];
					$listComment['mid']=$comment['id'];
					$response['text'][$key]=$listComment;
					}
				break;
			case 'error':
			$response=array('error'=>null);
			$response['error']='error';
			break;
		}
		if($mid!=null){
			$count=$th_token->show_status($mid);
			$response['comment']=$count['comments_count'];
			$response['rt']=$count['reposts_count'];	
		}
		return json_encode($response);
	}	
	//加载表情
	function emotion($category=null,$emo=null){
			if(isset($_POST['emo'])){
				$emo=$_POST['emo'];
				$emotion=$this->emo_data(null,$emo,null);
			}elseif(isset($_POST['category'])){
				$category=$_POST['category'];
				$emotion=$this->emo_data($category,null,null);
			}
			echo json_encode($emotion);		
	}
	//表情数据处理函数
	function emo_data($category=null,$emo=null,$data=null){
		$th_token=$this->tclient();
		$emotion=$th_token->emotions();
		$data=array(array());
		$i=0;
		if($category!=null){
				foreach ($emotion as $key => $emotion) {
				if($emotion['category']==$category){
					$data[$i]['phrase']=$emotion['phrase'];
					$data[$i]['url']=$emotion['url'];
					$i++;
				}
			}
		}else{
			$emo=json_decode($emo);
			foreach ($emotion as $key => $emotion) {
				for($i=0;$i<count($emo)-1;$i++){
					if($emotion['phrase']==$emo[$i]){
						$data[$i]['phrase']=$emotion['phrase'];
						$data[$i]['url']=$emotion['url'];
						$i++;
					}
				}
			}
		}
		return $data;
	}	
	//记录用户未登陆时输入的内容。
	function record(){
		if(isset($_POST['record'])){
			$_SESSION['record']=$_POST['record'];
		}
		elseif(isset($_SESSION['record'])){
			echo $_SESSION['record'];
		}
	}
	function query(){
		$th_token=$this->tclient();
		$amount=$th_token->show_user_by_name('uictreehole');
		if(isset($amount)){
			if(isset($amount['error_code'])){
				echo ' X ';
			}else{
				echo $amount['statuses_count'];	
			}
		}
	}
	function test(){
		$th_token=$this->tclient();
		$data=$th_token->user_timeline_by_name('uictreehole');
		print_r($data);

	}
}


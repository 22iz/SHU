<?php
session_start();
// session_destroy();
// unset($_SESSION);
include_once( APPPATH.'libraries/weibooauth.php' );
class treehole extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('user_agent');
	}
	//主页
	public function index(){
		if (isset($_SESSION['logined'])){
			if($_SESSION['logined'] == 1){
				$this->load->model('th_usr_model');
				$data['imgUrl']=base_url().'image/crown_bg/';
				$callback_url='shu.uicer.com/treehole/callback';
				$o = new SaeTOAuthV2($this->config->item('WB_AKEY') , $this->config->item('WB_SKEY') );
				$data['code_url'] = $o->getAuthorizeURL( $callback_url );
				if($this->agent->browser()=='Internet Explorer'){
					if ($this->agent->version()=='6.0' || $this->agent->version()=='7.0') {
						$this->load->view('th_forbid_view');
					}else{
						$this->load->view('th_view',$data);
					}
				}else{
					$this->load->view('th_view',$data);			
				}
			}
		}
		else
			$this->load->view('th_login');
	}	

	//用户授权后callback页面
	function callback(){
		$o = new SaeTOAuthV2($this->config->item('WB_AKEY') , $this->config->item('WB_SKEY') );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = site_url().'/treehole/callback';
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
			}
		}
		if ($token) {
			$_SESSION['token'] = $token;
			setcookie( 'shu_user_id'.$o->client_id, http_build_query($token) );
		}
		$url='shu.uicer.com';
		header("Location:$url");
	}

}
?>
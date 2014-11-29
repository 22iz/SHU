<?php
class Login extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('user_agent');
    }

    public function in(){
        header("Content-Type: text/html;charset=utf-8");
        session_start();

        //注销登录
        if(!empty($_GET['action'])){
            if($_GET['action'] == "logout"){
                unset($_SESSION['userid']);
                unset($_SESSION['username']);
                echo '注销登录成功！点击此处 <a href="login.html">登录</a>';
                exit;
            }
        }

        //登录
        if(!isset($_POST['submit'])){
            exit('非法访问!');
        }
        $username = htmlspecialchars($_POST['username']);
        // $password = MD5($_POST['password']);
        $password = $_POST['password'];

        //包含数据库连接文件
        $conn = @mysql_connect("localhost","uicer","1+1=uicer");
        if (!$conn){
            die("连接数据库失败：" . mysql_error());
        }
        mysql_select_db("uicer", $conn);
        //字符转换，读库
        mysql_query("set character set 'gbk'");
        //写库
        mysql_query("set names 'gbk'");
        //检测用户名及密码是否正确
        $check_query = mysql_query("select id from users where username='$username' and password='$password' 
        limit 1");
        // echo 'I am check_query: ' . $check_query;
        if($result = mysql_fetch_array($check_query)){
            //登录成功
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $result['id'];
            $_SESSION['logined'] = 1;
            echo "<script>alert('Welcome'); window.location.href = '/shu';</script>";
            // header("Location: /shu");
            // echo $username,' 欢迎你！进入 <a href="/shu">用户中心</a><br />';
            // echo '点击此处 <a href="/shu/index.php/logout">注销</a> 登录！<br />';
            exit;
        } else {
            exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
        }
        // echo 'aaaaa';
    }

    public function out(){
        session_start();
        session_destroy();
        unset($_SESSION);
        header("Location: /shu"); 
    }

    public function toReg(){
        $this->load->view('th_register.html');
    }

    public function reg(){
        header("Content-Type: text/html;charset=utf-8");
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];
        $repeat_pwd = $_POST['repeat_pwd'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        if (!empty($username)) {        // 用户填写了数据才执行数据库操作
            // 调用mysqli的构造函数建立连接，同时选择使用数据库'test'
            $conn = @mysql_connect("localhost","uicer","1+1=uicer");
            if (!$conn){
                die("连接数据库失败：" . mysql_error());
            }
            mysql_select_db("uicer", $conn);
            //字符转换，读库
            mysql_query("set character set 'gbk'");
            //写库
            mysql_query("set names 'gbk'");

            mysql_query("INSERT INTO users (username, password, name, email) 
                VALUES ('$username', '$pwd', '$name', '$email')");

            mysql_close($conn);

            echo "<script>alert('Register Successfully! Please login and post.'); window.location.href = '/shu';</script>";
        }
    }
}
?>
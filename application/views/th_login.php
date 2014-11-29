<?php
$o = new SaeTOAuthV2( '1393274451' , 'c7d01aee1011287ffd96a86d707fedfd' );
$code_url = $o->getAuthorizeURL( 'http://uicer.com/shudong/callback.php', 'code');
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>有树 | 可能是最美的树洞</title>
  <link rel="stylesheet" type="text/css" href="style.css" media="all" />
  <link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
  <style type="text/css">
    html{font-size:12px;}
    fieldset{width:250px; margin: 0 auto;}
    legend{font-weight:bold; font-size:14px;}
    label{float:left; width:70px; margin-left:10px;}
    .left{margin-left:80px;}
    .input{width:150px;}
    span{color: #666666;}
  </style>
 </head>
<body>
  <div class="show_img" id="show_img">
    <img src="" alt="" class="show_img" id="show_img">
  </div>
  <div class="th_bg" id="th_bg"></div>
  <div class="th_crown" id="th_crown">
      <div class="th_crown_wrapper" id="th_crown_wrapper">
        <img src="image/logo.png" alt="Developed by Uicer." />
        <div class="th_sendbox" id="th_sendbox">
          <div>
            <fieldset>
            <legend>用户登录</legend>
              <form name="LoginForm" method="post" action="index.php/login" onSubmit="return InputCheck(this)">
                <p>
                  <label for="username" class="label">用户名:</label>
                  <input id="username" name="username" type="text" class="input" />
                <p/>
                <p>
                  <label for="password" class="label">密 码:</label>
                  <input id="password" name="password" type="password" class="input" />
                <p/>
                <p>
                  <input type="submit" name="submit" value=" 确 定 " />
                  <!-- 授权按钮 -->
                  <a href="<?=$code_url?>" style="text-decoration: none;">
                    <img src="weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" />
                  </a>
                </p>
              </form>
                  <!-- <button onclick="window.location.href = '/shu/toRegister';">Register</button> -->
            </fieldset>
          </div>
        </div>
      </div>
  </div>
  </div>
<script type="text/javascript">

function InputCheck(LoginForm)
{
  if (LoginForm.username.value == "")
  {
    alert("请输入用户名!");
    LoginForm.username.focus();
    return (false);
  }
  if (LoginForm.password.value == "")
  {
    alert("请输入密码!");
    LoginForm.password.focus();
    return (false);
  }
}

</script>
</body>
</html>
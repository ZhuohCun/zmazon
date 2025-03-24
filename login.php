<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>登录--zmazon</title>
    <link rel="stylesheet" href="assets/login/login.css">
</head>
<script>
    function onlogin() {
        var check = document.getElementById("accept");
        var username=document.getElementById("username");
        var password=document.getElementById("password");
        if(username.value===''){
            alert("请输入用户名");
            return false;
        }
        if(password.value===''){
            alert("请输入密码");
            return false;
        }else {
            if (check.checked) {
                return true;
            } else {
                alert("请同意使用协议");
                return false;
            }
        }
    }
    function showpw(){
        var checkbox=document.getElementById("showpwd");
        var pwdbox=document.getElementById("password");
        if(checkbox.checked){
            pwdbox.type="text";
        }else {
            pwdbox.type="password";
        }
    }
</script>
<body>
<?PHP
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
?>
<div class="container">
    <div class="header"><img src="assets/login/title.jpg"> </div>
    <div class="main">
        <div class="part1">登录</div>
        <div class="part2">忘记密码</div>
        <div class="part3">
            <form action="loginorreg.php?opt=log" id="form1" method="post" onsubmit="return onlogin();">
                <input class="text" type="text" id="username" name="username" placeholder="用户名"/>
                <input class="text" type="password" id="password" name="password" placeholder="密码"/>
                <div class="showpw">
                    <input type="checkbox" id="showpwd" onclick="showpw();">
                    <label for="showpw" class="label">显示密码</label>
                </div>
                <div class="check">
                    <input type="checkbox" id="accept">
                    <label for="accept" class="label">我已阅读并同意<h1>使用条件</h1>及<h1>隐私声明</h1>，并同意我的部分个人信息将根据隐私声明在境外处理。</label>
                </div>
                <div class="loginbutton">
                    <input type="submit" name="login" id="login" class="button" value="登录" />
                </div>
            </form>
        </div>
        <div class="part4">更多登录方式</div>
        <div class="part5">
            <button><div class="text"><img src="assets/login/wechat.jpg">微信账号登录</div></button>
        </div>
        <div class="part6">Z马逊的新客户？</div>
        <div class="part7">
            <button onclick="location.href='register.php'">创建新的Z马逊账户</button>
        </div>
        <div class="part8"></div>
        <div class="part9">©2025 ゼマゾン株式会社</div>
    </div>
</div>
</body>
</html>
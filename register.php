<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>注册--zmazon</title>
    <link rel="stylesheet" href="assets/register/register.css">
</head>
<script>
    function onreg() {
        var check1 = document.getElementById("accept1");
        var check2 = document.getElementById("accept2");
        var username = document.getElementById("username");
        var password1 = document.getElementById("password1");
        var password2 = document.getElementById("password2");
        var email = document.getElementById("email");
        var phone = document.getElementById("phone");
        if(username.value===''){
            alert("请输入用户名");
            return false;
        }else if(phone.value===''){
            alert("请输入电话号码");
            return false;
        }else if(email.value===''){
            alert("请输入电子邮箱");
            return false;
        }else if(password1.value===''){
            alert("请输入密码");
            return false;
        }else if(password1.value!==password2.value){
            alert("两次输入的密码不匹配");
            return false;
        }else {
            if (check1.checked&&check2.checked){
                return true;
            }else {
                alert("请同意使用协议");
                    return false;
            }
        }
    }
    function showpw(){
        var checkbox=document.getElementById("showpwd");
        var pwdbox1=document.getElementById("password1");
        var pwdbox2=document.getElementById("password2");
        if(checkbox.checked){
            pwdbox1.type="text";
            pwdbox2.type="text";
        }else {
            pwdbox1.type="password";
            pwdbox2.type="password";
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
        <div class="part1">创建账户</div>
        <div class="part2">
            <form action="loginorreg.php?opt=reg" id="form1" method="POST" onsubmit="return onreg();">
                <input class="text" type="text" id="username" name="username" placeholder="用户名"/>
                <input class="text" type="text" id="phone" name="phone" placeholder="电话号码"/>
                <input class="text" type="text" id="email" name="email" placeholder="电子邮箱"/>
                <input class="text" type="password" id="password1" name="password" placeholder="密码"/>
                <input class="text" type="password" id="password2" placeholder="确认密码"/>
                <div class="showpw">
                    <input type="checkbox" id="showpwd" onclick="showpw();">
                    <label for="showpw" class="label">显示密码</label>
                </div>
                <div class="check">
                    <input type="checkbox" id="accept1">
                    <label for="accept1" class="label">我已阅读并同意网站的<h1>使用条件</h1>及<h1>隐私声明</h1>。</label>
                </div>
                <div class="check">
                    <input type="checkbox" id="accept2">
                    <label for="accept2" class="label">我同意我的部分个人信息将根据<h1>隐私声明</h1>在境外处理。</label>
                </div>
                <div class="loginbutton">
                    <input type="submit" name="login" id="login" class="button" value="继续" />
                </div>
            </form>
        </div>
        <div class="part3">其他注册方式</div>
        <div class="part4">
            <button><div class="text"><img src="assets/login/wechat.jpg">微信账号注册</div></button>
        </div>
        <div class="part5"><div class="text" onclick="location.href='login.php'">已拥有账户？</div></div>
        <div class="part6"></div>
        <div class="part7">©2025 ZMAZON</div>
    </div>
</div>
</body>
</html>
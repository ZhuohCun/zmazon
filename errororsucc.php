<!doctype html>
<html lang="en">
<?PHP
if(isset($_GET['reason'])){
    $rea=$_GET['reason'];
}else{
    $rea=-1;
}
if(isset($_GET['back'])){
    $back=$_GET['back'];
}else{
    $back='index.php';
}
if(isset($_GET['usid'])){
    $usid=$_GET['usid'];
}else{
    $usid=-1;
}
if(isset($_GET['usr'])){
    $usr=$_GET['usr'];
}else{
    $usr='null';
}
if(isset($_GET['veri'])){
    $veri=$_GET['veri'];
}else{
    $veri='null';
}
if(isset($_GET['succ'])){
    $succ=$_GET['succ'];
}else{
    $succ=0;
}
if(isset($_GET['text'])){
    $text=$_GET['text'];
}else{
    $text=0;
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?PHP
        if($succ==1){
            echo "成功了--zmazon";
        }else{
            echo "出错了--zmazon";
        }
        ?></title>
    <link rel="stylesheet" href="assets/errororsucc/errororsucc.css">
</head>
<body>
<div class="container">
    <div class="header">
        <?PHP
            if($succ==1){
                echo "成功了";
            }else{
                echo "出错了";
            }
        ?>
    </div>
    <div class="main">
        <div class="result">
            <div class="mark">
                <?PHP
                if($succ==1){
                    echo "<svg class=\"check\" xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 1024 1024\"><path fill=\"currentColor\" d=\"M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z\"/></svg>";
                }else{
                    echo "<svg class=\"xmark\" xmlns=\"http://www.w3.org/2000/svg\" width=\"1em\" height=\"1em\" viewBox=\"0 0 24 24\"><path fill=\"currentColor\" fill-rule=\"evenodd\" d=\"M12 1.25C6.063 1.25 1.25 6.063 1.25 12S6.063 22.75 12 22.75S22.75 17.937 22.75 12S17.937 1.25 12 1.25M9.702 8.641a.75.75 0 0 0-1.061 1.06L10.939 12l-2.298 2.298a.75.75 0 0 0 1.06 1.06L12 13.062l2.298 2.298a.75.75 0 0 0 1.06-1.06L13.06 12l2.298-2.298a.75.75 0 1 0-1.06-1.06L12 10.938z\" clip-rule=\"evenodd\"/></svg>";
                }
                ?>
            </div>
            <div class="text">
                <?PHP
                    if($rea=='userpass'){
                        echo "用户名或密码出错";
                    }elseif ($rea=='paraloss'){
                        echo "参数出错";
                    }elseif ($rea=='incorrectuser'){
                        echo "登录信息错误或登录失效";
                    }elseif ($rea=='404'){
                        echo "404找不到请求的内容";
                    }elseif ($rea=='input'){
                        echo "您的输入有误";
                    }elseif ($rea=='name') {
                        echo "用户名已被注册";
                    }elseif ($rea=='phone'){
                        echo "手机号已被注册";
                    }elseif ($rea=='email'){
                        echo "E-mail已被注册";
                    }elseif ($rea=='hasuser'){
                        echo "用户不存在";
                    }elseif ($rea=='addcart'){
                        echo "加入购物车成功";
                    }elseif ($rea=='regsuccess'){
                        echo "注册成功";
                    }elseif ($rea=='noaddress'){
                        echo "未添加收货地址";
                    } elseif ($rea=='balance'){
                        echo "余额不足";
                    }elseif ($rea=='uservalid'){
                        echo "用户状态不正常";
                    }
                    elseif ($rea!=-1){
                        echo $rea;
                    }else{
                        echo "未知错误";
                    }
                ?>
            </div>
        </div>
        <?PHP
            echo "<div class=\"backbutton\" onclick=\"location.href='".$back."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\">";
            if($text==0){
                if($back=='index.php'){
                    echo "<div class='button'>回首页</button></div>";
                }else{
                    echo "<div class='button'>返回</div></div>";
                }
            }else{
                echo "<div class='button'>$text</button></div>";
            }
        ?>
    </div>
</body>
</html>

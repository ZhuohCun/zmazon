<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/payment/payment.css">
    <title>商家管理系统</title>
</head>
<script>

</script>
<body>
<?PHP
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
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
if(isset($_GET['chosen'])){
    $chosen=$_GET['chosen'];
}else{
    $chosen=1;
}
$current="payment.php";
$hasitem=0;
$usrv=mysqli_query($conn,'set names utf8');
$usrv=mysqli_query($conn,"select username,verify,role from users where id = $usid and valid=1");
$usrqry=0;
while($usrvr=mysqli_fetch_row($usrv)){
    $realname=$usrvr[0];
    $realver=$usrvr[1];
    $role=$usrvr[2];
    $usrqry=1;
}
if($usrqry==1&&$usr==$realname && $veri==$realver && $role==2){

}elseif($usid!=-1){
    header("Location:"."errororsucc.php?reason=用户权限不足");
    die;
}else{
    header("Location:"."login.php");
    die;
}
?>
<div class="container">
    <div class="left">
        <div class="title">欢迎您，Z马逊自营商家</div>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">商品管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&eri=$veri&chosen=1'\">商品管理</div>";} ?>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">分类管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&eri=$veri&chosen=1'\">分类管理</div>";} ?>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">推荐管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&eri=$veri&chosen=1'\">推荐管理</div>";} ?>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">订单管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&eri=$veri&chosen=1'\">订单管理</div>";} ?>
    </div>
</div>
</body>
</html>
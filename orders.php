<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>订单详情--zmazon</title>
    <link rel="stylesheet" href="assets/orders/orders.css">
</head>
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
if(isset($_GET['status'])){
    $status=$_GET['status'];
}else{
    $status=0;
}
$usrv=mysqli_query($conn,'set names utf8');
$usrv=mysqli_query($conn,'select username,verify from users where id = '.$usid);
$usrqry=0;
while($usrvr=mysqli_fetch_row($usrv)){
    $realname=$usrvr[0];
    $realver=$usrvr[1];
    $usrqry=1;
}
if($usrqry==1&&$usr==$realname && $veri==$realver){

}elseif($usid!=-1){
    header("Location:"."errororsucc.php?reason=incorrectuser");
    die;
}?>
<div class="container">
    <div class="header">
        <div>
            <div class="item">全部订单</div>
        </div>
    </div>
    <div class="header2">
        <div <?php if($status==0){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href'orders.php?usid=$usid&usr=$usr&veri=$veri&typeid=0'\""?>>全部订单</div>
        <div <?php if($status==1){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";}?>>待支付</div>
        <div <?php if($status==2){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";}?>>待发货</div>
        <div <?php if($status==3){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";}?>>待收货</div>
        <div <?php if($status==4){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";}?>>待评价</div>
        <div <?php if($status==5){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";}?>>已取消</div>
    </div>
    <div class="main">

    </div>
</div>
</body>
</html>

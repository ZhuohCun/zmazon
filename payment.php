<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/payment/payment.css">
    <title>在线支付</title>
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
if(isset($_GET['orderid'])){
    $orderid=$_GET['orderid'];
}else{
    $orderid=0;
}
$current="payment.php";
$hasitem=0;
$usrv=mysqli_query($conn,'set names utf8');
$usrv=mysqli_query($conn,"select username,verify from users where id = $usid and valid=1");
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
}else{
    header("Location:"."login.php");
    die;
}?>
<div class="container">
    <div class="header">
        <div class="item">在线支付</div>
    </div>
    <div class="main">
        <div class="title">订单号：<?php echo $orderid ?></div>
        <?PHP
        $orderquery=mysqli_query($conn,"select orders.price from orders where orders.uid=$usid and id=$orderid and valid=1");
        while($orderrow=mysqli_fetch_row($orderquery)){
            $price=$orderrow[0];
        }
        echo "<div class='price'>共计需支付:<h1>&#165 $price</h1></div>";
        $methodquery=mysqli_query($conn,"select no,name,pic from paymethod where valid=1");
        ?>
    </div>
</div>
</body>
</html>

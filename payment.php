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
if(isset($_GET['chosen'])){
    $chosen=$_GET['chosen'];
}else{
    $chosen=0;
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
        <div class="back" <?php echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=1'\"";?>></div>
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
        $methodquery=mysqli_query($conn,"select no,pic from paymethod where valid=1");
        echo "<div class='paymethod'>";
        while ($methodrow=mysqli_fetch_row($methodquery)){
            $pmid=$methodrow[0];
            $pmpic=$methodrow[1];
            echo "<div class='item'>";
            echo "<div class='pic'><img src='$pmpic' /></div>";
            if($pmid==$chosen){
                echo "<div class='checkboxred'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 1024 1024\"><path fill=\"currentColor\" d=\"M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896\"/><path fill=\"currentColor\" d=\"M745.344 361.344a32 32 0 0 1 45.312 45.312l-288 288a32 32 0 0 1-45.312 0l-160-160a32 32 0 1 1 45.312-45.312L480 626.752z\"/></svg></div>";
            }else{
                echo "<div class='checkbox'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 1024 1024\"><path fill=\"currentColor\" d=\"M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896\"/><path fill=\"currentColor\" d=\"M745.344 361.344a32 32 0 0 1 45.312 45.312l-288 288a32 32 0 0 1-45.312 0l-160-160a32 32 0 1 1 45.312-45.312L480 626.752z\"/></svg></div>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "<div class='sbbox'><div class='sb'>确认支付</div></div>"
        ?>
    </div>
</div>
</body>
</html>

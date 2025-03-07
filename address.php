<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>地址管理--zmazon</title>
    <link rel="stylesheet" href="assets/address/address.css">
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
if(isset($_GET['chosen'])){
    $chosen=$_GET['chosen'];
}else{
    $chosen=-1;
}
if(isset($_GET['back'])){
    $back=$_GET['back'];
}else{
    $back=-1;
}
if(isset($_GET['cartmanage'])){
    $cartmanage=$_GET['cartmanage'];
}else{
    $cartmanage=-1;
}
if(isset($_GET['opt'])){
    $opt=$_GET['opt'];
}else{
    $opt=-1;
}
if(isset($_GET['optid'])){
    $optid=$_GET['optid'];
}else{
    $optid=-1;
}
$current="address.php";
$hasitem=0;
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
}else{
    header("Location:"."login.php");
    die;
}?>
<div class="container">
    <div class="header">
        <div class="back" <?php echo "onclick=\"location.href='me.php?usid=$usid&usr=$usr&veri=$veri'\""; ?>></div>
        <div class="item">地址管理</div>
    </div>
    <div class="main">
        <div class="itembox">
        <?php
        $hasaddr=0;
        $addquery=mysqli_query($conn,"select id,address1,address2,receiver,phoneofreceiver,isdefault from usertoaddress where uid=$usid");
        while($addr=mysqli_fetch_row($addquery)){
            $hasaddr=1;
            $addrid=$addr[0];
            $addrname1=$addr[1];
            $addrname2=$addr[2];
            $recerver=$addr[3];
            $por=$addr[4];
            $isdefault=$addr[5];
            echo "<div class='item'>";
            echo "<div class='p1'>$addrname1</div>";
            echo "<div class='p2'>";if($isdefault==1){echo "<div class='ifdefault'>默认</div>";} echo "<div class='addr'>$addrname2</div><div class='edit'></div></div>";
            echo "<div class='p3'>$recerver  $por</div>";
            echo "</div>";
        }
        if($hasaddr==0){
            echo "<div class='noitembox'><div class='noitem'><img src='assets/address/empty.png'><div class='noitemtitle'>暂无订单信息</div></div></div>";
        }
        ?>
        </div>
    </div>
    <div class="footer">
        <div class="button">添加收货地址</div>
    </div>
</div>
</body>
</html>

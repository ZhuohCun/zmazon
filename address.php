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
    $chosen=0;
}
if(isset($_GET['back'])){
    $back=$_GET['back'];
}else{
    $back=0;
}
if(isset($_GET['cartmanage'])){
    $cartmanage=$_GET['cartmanage'];
}else{
    $cartmanage=0;
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
    <div class="header2">
        <div <?php if($status==0){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=0'\""?>>全部订单</div>
        <div <?php if($status==1){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=1'\""?>>待支付</div>
        <div <?php if($status==2){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=2'\""?>>待发货</div>
        <div <?php if($status==3){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=3'\""?>>待收货</div>
        <div <?php if($status==4){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=4'\""?>>已完成</div>
        <div <?php if($status==5){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=5'\""?>>已取消</div>
    </div>
    <div class="main">
        <?php
        if($status==0){
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.status from orders where orders.uid=$usid");
        }else{
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.status from orders where orders.uid=$usid and orders.status=$status");
        }
        while($orderrow=mysqli_fetch_row($orderquery)){
            if($hasitem==0){
                echo "<div class=\"itembox\">";
            }
            $hasitem=1;
            $id=$orderrow[0];
            $orderprice=$orderrow[1];
            $status=$orderrow[2];
            if($status==1){
                $realststus="待支付";
            }elseif ($status==2) {
                $realststus="待发货";
            }elseif ($status==3) {
                $realststus="待收货";
            }elseif ($status==4) {
                $realststus="已完成";
            }elseif ($status==5) {
                $realststus="已取消";
            }
            echo "<div class='item'>";
            echo "<div class='itemhead'><div class='itemid'>订单号: $id</div><div class='status'>$realststus</div></div>";
            $siquery=mysqli_query($conn,"select ordertosubitem.quantity,ordertosubitem.siprice,subitems.sitext,vendors.vname,subitems.id from subitems,ordertosubitem,items,vendors where ordertosubitem.oid=$id and subitems.id=ordertosubitem.siid and vendors.id=items.vid and subitems.iid=items.id");
            while ($siqueryrow=mysqli_fetch_row($siquery)){
                $quantity=$siqueryrow[0];
                $siprice=$siqueryrow[1];
                $sitext=$siqueryrow[2];
                $vname=$siqueryrow[3];
                $siid=$siqueryrow[4];
                $picquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$siid limit 1");
                while ($picrow=mysqli_fetch_row($picquery)) {
                    $pic=$picrow[0];
                }
                echo "<div class='itembody'>";
                echo "<div class='p2'>";
                echo "<div class='left' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$siid."&back=".$current."&status=$status'\"><img src='$pic'></div>";
                echo "<div class='middle' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$siid."&back=".$current."&status=$status'\"><div class='itemtitle'>$sitext</div><div class='vendor'>$vname</div></div>";
                echo "<div class='right'><div class='price'>&#165 $siprice</div><div class='quantity'>$quantity 个</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "<div class='paybox'><div class='itemprice'>订单总额：&#165 $orderprice</div>";
            if ($status==1) {
                echo "<div class='pay' onclick=\"location.href='payment.php?usid=$usid&usr=$usr&veri=$veri&orderid=$id'\">去支付</div>";
            }
            echo "</div>";
            echo "</div>";
            if($hasitem==0){
                echo "</div>";
                $hasitem=1;
            }
        }
        if($hasitem==0){
            echo "<div class='noitembox'><div class='noitem'><img src='assets/orders/empty.png'><div class='noitemtitle'>暂无订单信息</div></div></div>";
        }
        ?>

    </div>
</div>
</div>
</body>
</html>
<?php

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
$current="orders.php";
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
            <div class="item">订单详情</div>
        </div>
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
        <div class="itembox">
        <?php
        if($status==0){
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.quantity,subitems.sitext,vendors.vname,orders.status,subitems.id from orders,subitems,items,vendors where orders.uid=$usid and orders.siid=subitems.id and subitems.iid=items.id and items.vid=vendors.id");
        }else{
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.quantity,subitems.sitext,vendors.vname,orders.status,subitems.id from orders,subitems,items,vendors where orders.uid=$usid and orders.status=$status and orders.siid=subitems.id and subitems.iid=items.id and items.vid=vendors.id");
        }
        while($orderrow=mysqli_fetch_row($orderquery)){
            $siid=$orderrow[6];
            $picquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$siid limit 1");
            while ($picrow=mysqli_fetch_row($picquery)) {
                $pic=$picrow[0];
            }
            $id=$orderrow[0];
            $price=$orderrow[1];
            $quantity=$orderrow[2];
            $sitext=$orderrow[3];
            $vname=$orderrow[4];
            $status=$orderrow[5];
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
            echo "<div class='itemhead'>订单号: $id</div>";
            echo "<div class='itembody'>";
            echo "<div class='p1'>$realststus</div>";
            echo "<div class='p2' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$siid."&back=".$current."&status=$status'\">";
            echo "<div class='left'><img src='$pic'></div>";
            echo "<div class='middle'><div class='itemtitle'>$sitext</div><div class='vendor'>$vname</div></div>";
            echo "<div class='right'><div class='price'>&#165 $price</div><div class='quantity'>$quantity 个</div></div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
        </div>
    </div>
</div>
</body>
</html>

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
    $status=$_GET['orderid'];
}else{
    $status=0;
}
$current="orders.php";
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
<div class="wrapper">
    <header>
        <p>在线支付</p>
    </header>
    <h3>订单信息：</h3>
    <div class="order-info">
        <?PHP
        global $vname;
        global $vfee;
        $info=mysqli_query($conn,'select vname,vfee from vendor where vno = '.$vendor);
        while($inforow=mysqli_fetch_row($info)){
            $vname=$inforow[0];
            $vfee=$inforow[1];
        }
        ?>
        <p>
            <?PHP echo $vname; ?>
            <i class="fa fa-caret-down" id="showBtn"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10l5 5l5-5"/></svg></i>
        </p>
        <?PHP
        global $total;
        $totalseek=mysqli_query($conn,"select sum(food.fprice * orders.num) from orders,vendor,food where orders.fno=food.fno and food.vno=vendor.vno and vendor.vno=".$vendor." and orders.userno = ".$usid." and orders.checked=0 and orders.paid=0");
        while($totalrow=mysqli_fetch_row($totalseek)){
            $total=$totalrow[0];
        }
        ?>
        <p>&#165;<?PHP echo $total+$vfee; ?></p>
    </div>
    <ul class="order-detailet" id="detailetBox">
        <?PHP
        $order=mysqli_query($conn,"select orders.num,food.fname,food.fpic,food.fprice from orders,vendor,food where orders.fno=food.fno and food.vno=vendor.vno and vendor.vno=".$vendor." and orders.userno = ".$usid." and orders.checked=0 and orders.paid=0 and orders.num>0");
        while($orderrow=mysqli_fetch_row($order)) {
            $fnum = $orderrow[0];
            $fname = $orderrow[1];
            $fpic = $orderrow[2];
            $fprice = $orderrow[3];
            echo "<li>\n";
            echo "<p>$fname x$fnum</p>\n";
            echo "<p>&#165;$fprice</p>\n<li>\n";
        }
        ?>
        <li>
            <p>配送费</p>
            <p>&#165;<?PHP echo $vfee; ?></p>
        </li>
    </ul>
    <ul class="payment-type">
        <?PHP
        $payment=mysqli_query($conn,'select no,pic from paymethod');
        while($paymentrow=mysqli_fetch_row($payment)){
            $payno=$paymentrow[0];
            $paypic=$paymentrow[1];
            echo "<li>\n";
            echo "<img src=\"$paypic\">\n";
            if($payno==$chosen){
                echo "<i class=\"fa fa-check-circle\"></i>\n";
            }else{
                echo "<i onclick=\"location.href='payment.php?id=$usid&usr=$usr&ver=$veri&vno=$vendor&chosen=$payno&sub=0'\" class=\"fa fa-check-grey\"></i>\n";
            }
            echo "</li>\n";
        }
        echo "<div class=\"payment-button\" onclick=\"location.href='payment.php?id=$usid&usr=$usr&ver=$veri&vno=$vendor&chosen=$chosen&sub=1'\">\n";
        ?>
        <button>确认支付</button>
</div>
</ul>
<footer class="footer">
    <?PHP echo "<div onclick=\"location.href='index.php?id=".$usid."&usr=".$usr."&ver=".$veri."'\">";?>
    <i class="i material-symbols:house-outline"></i>
    <span>首页</span>
    </div>
    <?PHP echo "<div onclick=\"location.href='discover.php?id=".$usid."&usr=".$usr."&ver=".$veri."'\">";?>
    <i class="i material-symbols:assistant-navigation-outline"></i>
    <span>发现</span>
    </div>
    <?PHP echo "<div onclick=\"location.href='orderlist.php?id=".$usid."&usr=".$usr."&ver=".$veri."'\">";?>
    <i class="i material-symbols:apk-document-outline"></i>
    <span>订单</span>
    </div>
    <div>
        <i class="i material-symbols:person-4-outline-rounded"></i>
        <span>我的</span>
    </div>
</footer>
</div>
</body></html>

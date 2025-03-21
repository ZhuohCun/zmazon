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
$current="orders.php";
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
}
if($opt!=-1 && $optid!=-1){
    $optvalid=0;
    $optvalidquery=mysqli_query($conn,"select * from orders where uid=$usid and id=$optid and valid=1");
    while ($optvalidrow=mysqli_fetch_row($optvalidquery)){
        $optvalid=1;
    }
    if($optvalid==0){
        header("Location:"."errororsucc.php?reason=paraloss");
        die;
    }elseif($opt=="ccr"){  //确认收货
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select status,status_name from orders where uid=$usid and id=$optid and valid=1 for update");
        $ispr=0;
        $isprquery=mysqli_query($conn,"select * from orders where uid=$usid and id=$optid and valid=1 and status=3");  //是否待收货
        while ($isprrow=mysqli_fetch_row($isprquery)){
            $ispr=1;
        }
        if($ispr==1){
            mysqli_query($conn,"update orders set status=4,status_name='已完成' where uid=$usid and id=$optid and valid=1");
            mysqli_query($conn,"commit");
            header("Location:"."errororsucc.php?reason=确认收货成功&succ=1&usid=$usid&usr=$usr&veri=$veri&back=index.php&text=回首页");
            die;
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
    }elseif ($opt=="cco"){  //确认取消
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select status,status_name from orders where uid=$usid and id=$optid and valid=1 for update");
        $ispp=0;
        $isppquery=mysqli_query($conn,"select * from orders where uid=$usid and id=$optid and valid=1 and status=3");  //是否待支付
        while ($ispprow=mysqli_fetch_row($isppquery)){
            $ispp=1;
        }
        if($ispp==1){
            mysqli_query($conn,"update orders set status=5,status_name='已取消' where uid=$usid and id=$optid and valid=1");
            mysqli_query($conn,"commit");
            header("Location:"."orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status");
            die;
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
    }
}
?>
<div class="container">
    <div class="header">
            <div class="back" <?php if($opt==-1){echo "onclick=\"location.href='me.php?usid=$usid&usr=$usr&veri=$veri'\"";} ?>></div>
            <div class="item">订单详情</div>
    </div>
    <div class="header2">
        <div <?php if($status==0){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=0'\"";}?>>全部订单</div>
        <div <?php if($status==1){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=1'\"";}?>>待支付</div>
        <div <?php if($status==2){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=2'\"";}?>>待发货</div>
        <div <?php if($status==3){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=3'\"";}?>>待收货</div>
        <div <?php if($status==4){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=4'\"";}?>>已完成</div>
        <div <?php if($status==5){echo "class=\"itemchosen\"";}else{echo "class=\"item\"";} if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=5'\"";}?>>已取消</div>
    </div>
    <div class="main">
        <?php
        if($status==0){  //全部订单
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.status,orders.expfirm,orders.expno,orders.status_name from orders where orders.uid=$usid and valid=1 order by orders.id desc");
        }else{  //仅某个状态的订单
            $orderquery=mysqli_query($conn,"select orders.id,orders.price,orders.status,orders.expfirm,orders.expno,orders.status_name from orders where orders.uid=$usid and orders.status=$status and valid=1 order by orders.id desc");
        }
        while($orderrow=mysqli_fetch_row($orderquery)){
            if($hasitem==0){
                echo "<div class=\"itembox\">";
            }
            $hasitem=1;
            $id=$orderrow[0];
            $orderprice=$orderrow[1];
            $itemstatus=$orderrow[2];
            $expfirm=$orderrow[3];
            $expno=$orderrow[4];
            $realststus=$orderrow[5];
            echo "<div class='item'>";
            echo "<div class='itemhead'><div class='itemid'>订单号: $id</div><div class='status'>$realststus</div></div>";
            $siquery=mysqli_query($conn,"select ordertosubitem.quantity,ordertosubitem.siprice,subitems.sitext,vendors.vname,subitems.id from subitems,ordertosubitem,items,vendors where ordertosubitem.oid=$id and subitems.id=ordertosubitem.siid and vendors.id=items.vid and subitems.iid=items.id and ordertosubitem.valid=1");
            while ($siqueryrow=mysqli_fetch_row($siquery)){
                $quantity=$siqueryrow[0];
                $siprice=$siqueryrow[1];
                $sitext=$siqueryrow[2];
                $vname=$siqueryrow[3];
                $siid=$siqueryrow[4];
                $picquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$siid and subitemtopic.valid=1 limit 1");
                while ($picrow=mysqli_fetch_row($picquery)) {
                    $pic=$picrow[0];
                }
                echo "<div class='itembody'>";
                echo "<div class='p2'>";
                echo "<div class='left'";if($opt==-1){echo " onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$siid."&back=".$current."&status=$status'\"";}echo "><img src='$pic'></div>";
                echo "<div class='middle'";if($opt==-1){echo "onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$siid."&back=".$current."&status=$status'\"";}echo "><div class='itemtitle'>$sitext</div><div class='vendor'>$vname</div></div>";
                echo "<div class='right'><div class='price'>&#165 $siprice</div><div class='quantity'>$quantity 个</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
                if($itemstatus==3 or $itemstatus==4){
                    echo "<div class='exp'>";
                    echo "<div class='expf'>快递业者：$expfirm</div>";
                    echo "<div class='expn'>快递单号：$expno</div>";
                    echo "</div>";
                }
                echo "<div class='paybox'><div class='itemprice'>订单总额：&#165 $orderprice</div>";
            if ($itemstatus==1) {
                echo "<div class='pay'"; if($opt==-1){echo "onclick=\"location.href='payment.php?usid=$usid&usr=$usr&veri=$veri&orderid=$id&status=$status'\"";}echo ">去支付</div>";
                echo "<div class='pay'" ; if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&optid=$id&opt=co&status=$status'\"";}echo ">取消订单</div>";
            }elseif ($itemstatus==3) {
                echo "<div class='pay'"; if($opt==-1){echo "onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&optid=$id&opt=cr&status=$status'\"";}echo ">确认收货</div>";
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
        if($opt=="co" && $optid!=-1){
            echo "<div class='dltpanel'>";
            echo "<div class='x' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status'\"></div>";
            echo "<div class='title'>是否确认取消该订单？</div>";
            echo "<div class='buttons'><div class='confirm' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status&opt=cco&optid=$optid'\">确认</div><div class='cancel' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status'\">取消</div></div>";
            echo "</div>";
        }elseif ($opt=="cr" && $optid!=-1){
            echo "<div class='dltpanel'>";
            echo "<div class='x' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status'\"></div>";
            echo "<div class='title'>是否确认收货该订单？</div>";
            echo "<div class='buttons'><div class='confirm' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status&opt=ccr&optid=$optid'\">确认</div><div class='cancel' onclick=\"location.href='orders.php?usid=$usid&usr=$usr&veri=$veri&status=$status'\">取消</div></div>";
            echo "</div>";
        }
        ?>

        </div>
    </div>
</div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>我的--zmazon</title>
    <link rel="stylesheet" href="assets/me/me.css">
    <link rel="stylesheet" href="assets/icons/footer.css">
    <script>
        function logout(){
            var c=confirm("是否退出登录");
            if (c===true){
                location.replace("me.php");
            }
        }
    </script>
</head>
<body>
<?PHP
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
$dotnum=0;
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
if(isset($_GET['act'])){
    $act=$_GET['act'];
}else{
    $act='null';
}
if(isset($_GET['actid'])){
    $actid=$_GET['actid'];
}else{
    $actid=-1;
}
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
}
$footerchosen=4;
$iscart=0;
if($act=="add"){
    if($usid==-1){
        header("location:login.php");
        die;
    }else{
        $cartquery=mysqli_query($conn,"select * from cart where uid=$usid and siid=$actid and checked=0 and quantity>0 and valid=1");
        while($cartrow=mysqli_fetch_assoc($cartquery)){
            $iscart=1;
        }
        if($iscart==0){
            mysqli_query($conn,"insert into cart (siid,uid,quantity,valid) values ($actid,$usid,1,1)");
            header("location:me.php?usid=$usid&veri=$veri&usr=$usr");
            die;
        }elseif($iscart==1){
            mysqli_query($conn,"start transaction");
            $quantityquery=mysqli_query($conn,"select quantity from cart where uid=$usid and siid=$actid and checked=0 and quantity>0 and valid=1 for update");
            while ($quantityrow=mysqli_fetch_row($quantityquery)){
                $quantity=$quantityrow[0];
            }
            $quantity=$quantity+1;
            mysqli_query($conn,"update cart set quantity=$quantity where uid=$usid and siid=$actid and checked=0 and quantity>0 and valid=1");
            mysqli_query($conn,"commit");
            header("location:me.php?usid=$usid&veri=$veri&usr=$usr");
            die;
        }
    }
}
?>
<div class="container">
    <div class="main">
        <div class="part1">
            <div class="left">
                <i class="ico"></i>
                <div class="detail">
                <div class="user">
                    <?PHP
                    if($usid==-1){
                        echo "欢迎您";
                    }else{
                        echo $usr;
                    }
                    ?>
                </div>
                <div class="logorreg" <?PHP
                    if($usid==-1){
                        echo "onclick=location.href='login.php'";
                    }else{
                        echo "onclick='logout()'";
                    }
                ?>>
                    <h1>
                            <?PHP
                            if($usid==-1){
                                echo "登录/注册";
                            }else{
                                $tocommentquery=mysqli_query($conn,"select count(*) from orders where orders.uid=$usid and status=4 and valid=1");
                                while ($tocommentrow=mysqli_fetch_row($tocommentquery)){
                                    $tonum=$tocommentrow[0];
                                }
                                $hascommentquery=mysqli_query($conn,"select count(*) from orders where orders.uid=$usid and status=5 and valid=1");
                                while ($hascommentrow=mysqli_fetch_row($hascommentquery)){
                                    $hasnum=$hascommentrow[0];
                                }
                                if($hasnum==0){
                                    if($tonum==0){
                                        echo "已评价|去评价";
                                    }else{
                                        echo "已评价|去评价$tonum";
                                    }
                                }else{
                                    if($tonum!=0){
                                        echo "已评价$hasnum|去评价$tonum";
                                    }else{
                                        echo "已评价$hasnum|去评价";
                                    }
                                }
                            }
                            ?>
                        <i class="ico"></i>
                        </h1>

                </div>
                </div>
            </div>
            <div class="right">
                <i class="settingico"></i>
                <i class="alarmico"></i>
            </div>
        </div>
        <div class="part2"></div>
        <div class="part3">
            <div <?PHP echo "class='head' onclick=\"location.href='orders.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&status=0'\">";?>我的全部订单>
            </div>
            <div class="body">
                <?PHP
                $statusquery=mysqli_query($conn,"select * from status where id!=7 and valid=1");  //取所有状态名称
                while($statusrow=mysqli_fetch_row($statusquery)){
                    $statusid=$statusrow[0];
                    $statusname=$statusrow[1];
                    if($usid!=-1){
                        $dotquery=mysqli_query($conn,"select count(*) from orders where orders.uid=$usid and orders.status=$statusid and valid=1");  //取不同状态订单数量
                        while($dotrow=mysqli_fetch_row($dotquery)){
                            $dotnum=$dotrow[0];
                        }
                        if($dotnum!=0 && ($statusid==1 || $statusid==2 || $statusid==3)){
                            echo "<div class='item' onclick=\"location.href='orders.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&status=".$statusid."'\"><img src='assets/me/part3/".$statusid.".jpg'><h2>$statusname</h2><div class='dot'>$dotnum</div></div>";
                        }else{
                            echo "<div class='item' onclick=\"location.href='orders.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&status=".$statusid."'\"><img src='assets/me/part3/".$statusid.".jpg'><h2>$statusname</h2></div>";
                        }
                    }else{
                        echo "<div class='item' onclick=\"location.href='orders.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&status=".$statusid."'\"><img src='assets/me/part3/".$statusid.".jpg'><h2>$statusname</h2></div>";
                    }
                }
                ?>
            </div>
        </div>
        <div class="part4">
            <div class="item">
                <img src="assets/me/part4/1.jpg">
                <h3>优惠券</h3>
            </div>
            <div class="item">
                <img src="assets/me/part4/2.jpg">
                <h3>今日特惠</h3>
            </div>
            <div class="item">
                <img src="assets/me/part4/3.jpg">
                <h3>畅销推荐</h3>
            </div>
        </div>
        <div class="part5">
            <div class="item" <?php echo "onclick=\"location.href='address.php?usid=$usid&usr=$usr&veri=$veri&back=me.php'\"";?>>
                <img src="assets/me/part5/1.jpg">
                <h4>收货地址</h4>
            </div>
            <div class="item">
                <img src="assets/me/part5/2.jpg">
                <h4>清关信息</h4>
            </div>
            <div class="item">
                <img src="assets/me/part5/3.jpg">
                <h4>联系客服</h4>
            </div>
            <div class="item">
                <img src="assets/me/part5/4.jpg">
                <h4>证照信息</h4>
            </div>
        </div>
        <div class="part6">
            <div class="head">畅销单品推荐</div>
            <div class="body">
            <?PHP
            $itemquery=mysqli_query($conn,"select distinct subitems.id from subcategories,thirdcategories,items,subitems where subcategories.id=thirdcategories.scid and thirdcategories.id=items.thcid and subitems.rcid!=0 and subitems.valid=1 and subitems.rcverify=1 order by subitems.id");
            while ($itemrow=mysqli_fetch_row($itemquery)) {
                $subid=$itemrow[0];
                $detailquery=mysqli_query($conn,"select subitems.siprice,subitems.sitext,vendors.vname from subitems,items,vendors where subitems.iid=items.id and items.vid=vendors.id and subitems.id=$subid and subitems.valid=1");
                while ($detailrow=mysqli_fetch_row($detailquery)) {
                    $price=$detailrow[0];
                    $name=$detailrow[1];
                    $vendor=$detailrow[2];
                }
                $pic="assets/items/itempic/nopic.jpg";
                $picquery=mysqli_query($conn,"select pic from subitemtopic where siid=$subid and valid=1 limit 1");
                while ($picrow=mysqli_fetch_row($picquery)) {
                    $pic=$picrow[0];
                }
                echo "<div class='item'><div class='tag' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$subid."&back=me.php'\"><img src='$pic'><h5>$name</h5><div class='price'>&#165 $price</div><div class='detail'><div class='detailleft'>$vendor</div><div class='detailright'>满300元免运费</div></div></div><div class='last' onclick=\"location.href='me.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&actid=".$subid."&act=add'\"><svg class='ico' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg></div></div>";
            }
            ?>
            </div>
        </div>
    </div>
    <div class="footer">
        <?PHP
        $cartitem=0;
        $footerquery=mysqli_query($conn,"select id,text,href,icon from footer where valid=1");
        $cartitemquery=mysqli_query($conn,"select sum(quantity) from cart where uid=$usid and checked=0 and quantity>0 and valid=1");
        while ($cartitemrow=mysqli_fetch_row($cartitemquery)) {
            $cartitem=$cartitemrow[0];
        }
        if($usid==-1){
            $cartitem=0;
        }
        while($footerrow=mysqli_fetch_row($footerquery)){
            $fid=$footerrow[0];
            $ftext=$footerrow[1];
            $fhref=$footerrow[2];
            $ficon=$footerrow[3];
            if($fid==$footerchosen&&$fid!=3) {
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
            }elseif ($fid==3) {
                if($fid==$footerchosen){
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }else{
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }
            }else {
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
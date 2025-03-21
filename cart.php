<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>购物车--zmazon</title>
    <link rel="stylesheet" href="assets/cart/cart.css">
    <link rel="stylesheet" href="assets/icons/footer.css">
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
if(isset($_GET['manage'])){
    $manage=$_GET['manage'];
}else{
    $manage=0;
}
if(isset($_GET['act'])){
    $act=$_GET['act'];
}else{
    $act='none';
}
if(isset($_GET['actid'])){
    $actid=$_GET['actid'];
}else{
    $actid=-1;
}
if(isset($_GET['aid'])){
    $address=$_GET['aid'];
}else{
    $address=-1;
}
$current="cart.php";
$addcount=0;
if($address!=-1){
    $addveri=mysqli_query($conn,"select count(*) from usertoaddress where uid=$usid and id='$address' and valid=1");
    while($addverirow=mysqli_fetch_row($addveri)){
        $addcount=$addverirow[0];
    }
    if($addcount==0){
        header("Location:"."errororsucc.php?reason=paraloss&back=$current&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
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
}else{
    header("Location:"."login.php");
    die;
}
$footerchosen=3;
$cartitem=0;
$cartitemquery=mysqli_query($conn,"select sum(quantity) from cart where uid=$usid and checked=0 and quantity>0 and valid=1");
while ($cartitemrow=mysqli_fetch_row($cartitemquery)) {
    $cartitem=$cartitemrow[0];
}
if($usid==-1){
    $cartitem=0;
}
$haslocation=0;
if($address==-1){
    $dlocationquery=mysqli_query($conn,"select address1,address2 from usertoaddress where uid=$usid and isdefault = 1 and valid=1 limit 1");
    while ($dlocationrow=mysqli_fetch_row($dlocationquery)) {
        $location=$dlocationrow[0].$dlocationrow[1];
        $haslocation=1;
    }
}else{
    $dlocationquery=mysqli_query($conn,"select address1,address2 from usertoaddress where uid=$usid and id=$address and valid=1 limit 1");
    while ($dlocationrow=mysqli_fetch_row($dlocationquery)) {
        $location=$dlocationrow[0].$dlocationrow[1];
        $haslocation=1;
    }
}
if($haslocation==0){
    $location="还未添加默认地址";
}
$totalprice=0;
$totalquantity=0;
$totalquery=mysqli_query($conn,"select sum(cart.quantity*subitems.siprice),sum(cart.quantity) from subitems,cart where uid=$usid and cart.siid=subitems.id and cart.checked=0 and cart.quantity>0 and cart.chosen=1 and cart.valid=1");
while ($totalrow=mysqli_fetch_row($totalquery)) {
    $totalprice=number_format($totalrow[0],2);
    $totalquantity=number_format($totalrow[1],0);
}
$allcheck=1;
$hasallcheck=0;
$allcheckquery=mysqli_query($conn,"select chosen from cart where uid=$usid and quantity>0 and checked=0 and valid=1");
while ($allcheckrow=mysqli_fetch_row($allcheckquery)){
    $hasallcheck=1;
    if($allcheckrow[0]<=0){
        $allcheck=0;
    }
}
if($hasallcheck==0){
    $allcheck=0;
}
if($actid>=0){
    $verify=0;
    if($actid!=0){
        $verifyquery=mysqli_query($conn,"select count(*) from cart where id=$actid and uid=$usid and quantity>0 and checked=0 and valid=1");
        while ($verifyrow=mysqli_fetch_row($verifyquery)){
            if($verifyrow[0]>0){
                $verify=1;
            }
        }
    }else{
        $verify=1;
    }
    if($verify!=1){
        header("Location:"."errororsucc.php?reason=incorrectuser");
        die;
    }
    if($act=='check'){
        if($actid!=0){
            mysqli_query($conn,"start transaction");
            $checkquery=mysqli_query($conn,"select chosen from cart where id=$actid for update");
            while ($checkrow=mysqli_fetch_row($checkquery)){
                $check=$checkrow[0];
            }
            if($check==0){
                $check=1;
            }else{
                $check=0;
            }
            mysqli_query($conn,"update cart set chosen=$check where id=$actid");
            mysqli_query($conn,"commit");
            header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=$manage");
            die;
        }else{
            if($allcheck==0){
                mysqli_query($conn,"update cart set chosen=1 where uid=$usid and quantity>0 and checked=0 and valid=1");
                header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=$manage");
                die;
            }else{
                mysqli_query($conn,"update cart set chosen=0 where uid=$usid  and quantity>0 and checked=0 and valid=1");
                header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=$manage");
            }
        }
    }elseif ($act=='minus'){
        mysqli_query($conn,"start transaction");
        $minusquery=mysqli_query($conn,"select quantity from cart where id=$actid for update");
        while ($minusrow=mysqli_fetch_row($minusquery)){
            $minusquantity=$minusrow[0];
        }
        if($minusquantity<=1){
            header("Location:"."errororsucc.php?reason=incorrectuser");
            die;
        }else{
            $minusquantity=$minusquantity-1;
        }
        mysqli_query($conn,"update cart set quantity=$minusquantity where id=$actid");
        mysqli_query($conn,"commit");
        header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=$manage");
    }elseif ($act=='plus'){
        mysqli_query($conn,"start transaction");
        $plusquery=mysqli_query($conn,"select quantity from cart where id=$actid for update");
        while ($plusrow=mysqli_fetch_row($plusquery)){
            $plusquantity=$plusrow[0];
        }
        $plusquantity=$plusquantity+1;
        mysqli_query($conn,"update cart set quantity=$plusquantity where id=$actid");
        mysqli_query($conn,"commit");
        header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=$manage");
    }else{
        header("Location:"."errororsucc.php?reason=paraloss?usid=$usid&usr=$usr&veri=$veri");
        die;
    }
}
if($act=='del'){
    mysqli_query($conn,"update cart set valid=0 where checked=0 and quantity>0 and chosen=1 and uid=$usid");
    header("location:cart.php?usid=$usid&usr=$usr&veri=$veri&manage=1");
}elseif ($act=='buy'){
    $buyaddress=-1;
    $buyaddressquery=mysqli_query($conn,"select id from usertoaddress where uid=$usid and isdefault=1 and valid=1 limit 1");
    while ($buyaddressrow=mysqli_fetch_row($buyaddressquery)) {
        $buyaddress=$buyaddressrow[0];
    }
    if($buyaddressrow==-1){
        $buyaddressquery=mysqli_query($conn,"select id from usertoaddress where uid=$usid and valid=1 limit 1");
        while ($buyaddressrow=mysqli_fetch_row($buyaddressquery)) {
            $buyaddress=$buyaddressrow[0];
        }
    }
    if($buyaddress==-1){
        header("location:errororsucc.php?reason=noaddress&usid=$usid&usr=$usr&veri=$veri&back=cart.php");
        die;
    }
    mysqli_query($conn,"start transaction");
    $buytotalquery=mysqli_query($conn,"select sum(cart.quantity*subitems.siprice),sum(cart.quantity),sum(subitems.siimportfee*cart.quantity),sum(subitems.transportfee*cart.quantity) from subitems,cart where uid=$usid and cart.siid=subitems.id and cart.checked=0 and cart.quantity>0 and cart.chosen=1 and cart.valid=1 for update");
    while ($buytotalrow=mysqli_fetch_row($buytotalquery)) {
        $buytotalprice = $buytotalrow[0];
        $buytotalquantity = $buytotalrow[1];
        $buytotalimportfee = $buytotalrow[2];
        $buytotaltransportfee = $buytotalrow[3];
        if ($buytotalprice >= 300) {
            $buytotaltransportfee = 0;
        }
        $buytotal=$buytotalprice+$buytotalimportfee+$buytotaltransportfee;
    }
    mysqli_query($conn,"insert into orders (uid,status,status_name,price,aid,pid,valid) values ($usid,1,'待支付',$buytotal,$buyaddress,0,1)");
    $orderidquery=mysqli_query($conn,"select id from orders where uid=$usid");
    while ($orderrow=mysqli_fetch_row($orderidquery)) {
        $orderid=$orderrow[0];
    }
    $buysubitemquery=mysqli_query($conn,"select cart.siid,cart.quantity,subitems.siprice,subitems.siimportfee,subitems.transportfee from cart,subitems where uid=$usid and cart.siid=subitems.id and cart.quantity>0 and cart.chosen=1 and cart.checked=0 and cart.valid=1");
    while ($buysubitemrow=mysqli_fetch_row($buysubitemquery)) {
        $buysubitemid=$buysubitemrow[0];
        $buyitemvalidquery=mysqli_query($conn,"select valid from subitems where id=$buysubitemid");
        while ($buyitemvalidrow=mysqli_fetch_row($buyitemvalidquery)) {
            $buysubitemvalid=$buyitemvalidrow[0];
            if($buysubitemvalid==0){
                mysqli_query($conn,"rollback");
                header("location:errororsucc.php?reason=含有已下架的商品&text=返回购物车&usid=$usid&usr=$usr&veri=$veri&back=$current");
                die;
            }
        }
        $buysubitemquantity=$buysubitemrow[1];
        $siprice=$buysubitemrow[2];
        $siimportfee=$buysubitemrow[3];
        $transportfee=$buysubitemrow[4];
        mysqli_query($conn,"insert into ordertosubitem (oid,siid,quantity,siprice,siimportfee,transportfee,valid) values ($orderid,$buysubitemid,$buysubitemquantity,$siprice,$siimportfee,$transportfee,1)");  //下单固定价格
    }
    mysqli_query($conn,"update cart set checked=1 where checked=0 and quantity>0 and chosen=1 and valid=1 and uid=$usid");
    mysqli_query($conn,"commit");
    header("location:payment.php?usid=$usid&usr=$usr&veri=$veri&orderid=$orderid");
    die;
}
?>
<div class="container">
    <div class="header">
        <div class="left">
            <h1>购物车(<?php echo $cartitem;?>)</h1>
            <div class="location" <?php echo "onclick=\"location.href='address.php?usid=$usid&usr=$usr&veri=$veri&back=cart.php&cartmanage=$manage'\"" ?>>
                <i class="lico"></i>
                <?php echo $location;?>
                <i class="rico"></i>
            </div>
        </div>
        <div class="right" onclick="location.href='<?php
        if($manage==0){
            echo "cart.php?usid=$usid&usr=$usr&veri=$veri&manage=1&aid=$address";
        }else{
            echo "cart.php?usid=$usid&usr=$usr&veri=$veri&manage=0&aid=$address";
        }
        ?>'"><?php
            if($manage==0){
                echo "管理";
            }else{
                echo "关闭";
            }
            ?></div>
    </div>
    <div class="main">
        <?php
        $isempty=1;
        $subitemquery=mysqli_query($conn,"select subitems.id,subitems.sitext,subitems.subname,subitems.siprice,subitems.siimportfee,subitems.transportfee,cart.chosen,cart.id from cart,subitems where subitems.id=cart.siid and cart.uid=$usid and cart.quantity>0 and cart.valid=1 and cart.checked=0");
        while ($subitemrow=mysqli_fetch_row($subitemquery)) {
            $subid=$subitemrow[0];
            $subtext=$subitemrow[1];
            $subname=$subitemrow[2];
            $subprice=$subitemrow[3];
            $subimportfee=$subitemrow[4];
            $transportfee=$subitemrow[5];
            $subchosen=$subitemrow[6];
            $cartid=$subitemrow[7];
            $isempty=0;
            $toitem=mysqli_query($conn,"select items.id from items,subitems where items.id=subitems.iid and subitems.id=$subid");
            while ($toitemrow=mysqli_fetch_row($toitem)){
                $item=$toitemrow[0];
            }
            $vendorquery=mysqli_query($conn,"select vendors.vname from vendors,items where items.vid=vendors.id and items.id=$item");
            while ($vendorrow=mysqli_fetch_row($vendorquery)) {
                $vname=$vendorrow[0];
            }
            $subnumquery=mysqli_query($conn,"select count(*) from items,subitems where items.id=subitems.iid and items.id=$item");
            $subnum=0;
            while ($subnumrow=mysqli_fetch_row($subnumquery)){
                $subnum=$subnumrow[0];
            }
            $quantityquery=mysqli_query($conn,"select quantity from cart where siid=$subid and checked=0 and valid=1 and quantity>0 and uid=$usid");
            while ($quantityrow=mysqli_fetch_row($quantityquery)){
                $subquantity=$quantityrow[0];
            }
            $pic="assets/items/itempic/nopic.jpg";
            $picquery=mysqli_query($conn,"select pic from subitemtopic where siid=$subid limit 1");
            while ($picrow=mysqli_fetch_row($picquery)){
                $pic=$picrow[0];
            }
            if($subnum>1){
                $subdisplay="<div class='subinfo'><h1>已选</h1><h2>$subname</h2><i class='ico'></i></div>";
            }else{
                $subdisplay="";
            }
            echo "<div class='item'>";
            echo "<div class='checkbox'>";
            $checklink="cart.php?usr=$usr&usid=$usid&veri=$veri&act=check&actid=$cartid&manage=$manage";
            if($subchosen==0){
                echo "<div class='checkgrey' onclick=\"location.href='".$checklink."'\">";
            }else{
                echo "<div class='checkred' onclick=\"location.href='".$checklink."'\">";
            }
            $checkico="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 1024 1024\"><path fill=\"currentColor\" d=\"M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896\"/><path fill=\"currentColor\" d=\"M745.344 361.344a32 32 0 0 1 45.312 45.312l-288 288a32 32 0 0 1-45.312 0l-160-160a32 32 0 1 1 45.312-45.312L480 626.752z\"/></svg>";
            $minusico="<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\" viewBox=\"0 0 1024 1024\"><path fill=\"currentColor\" d=\"M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64\"/><path fill=\"currentColor\" d=\"M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896\"/></svg>";
            $plusico="<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg>";
            echo $checkico;
            echo "</div></div>";
            $detaillink="details.php?usid=$usid&usr=$usr&veri=$veri&subid=$subid&manage=$manage&back=cart.php";
            echo "<div class='body' ><div class='left' onclick=\"location.href='".$detaillink."'\"><img class='img' src='$pic'>";
            echo "</div>";
            if($subquantity>1){
                $greyorblue="minusblue";
                $minuslink="location.href='cart.php?usr=".$usr."&usid=".$usid."&veri=".$veri."&act=minus&actid=".$cartid."&manage=".$manage."'";
            }else{
                $greyorblue="minusgrey";
                $minuslink="";
            }
            $pluslink="cart.php?usr=$usr&usid=$usid&veri=$veri&act=plus&actid=$cartid&manage=$manage";
            echo "<div class='right'><div class='p1'>$subtext</div><div class='p2'><div class='lft'><div class='vendor'>$vname</div>$subdisplay<div class='price'>&#165;$subprice</div></div><div class='rit'><div class='$greyorblue' onclick=$minuslink>$minusico</div><div class='number'>$subquantity</div><div class='plus' onclick=\"location.href='".$pluslink."'\">$plusico</div></div></div> </div>";
            echo "</div></div>";
        }
        if($isempty==1){
            echo "<div class='empty'><img src='assets/cart/cartico.jpg'>购物车为空，快来添加宝贝吧！</div>";
        }
        ?>
    <?php
    if($isempty==0){
        echo "<div class='subfooter'>";
        echo "  <div class='left'>";
        $allchecklink="cart.php?usr=$usr&usid=$usid&veri=$veri&act=check&actid=0&manage=$manage";
        if($manage==0){
            $buylink="cart.php?usr=$usr&usid=$usid&veri=$veri&act=buy";
        } else{
            $buylink="cart.php?usr=$usr&usid=$usid&veri=$veri&act=del";
        }
        if($allcheck==1){
            echo " <div class='checkboxred' onclick=\"location.href='".$allchecklink."'\">$checkico</div>";
        }else{
            echo " <div class='checkboxgrey' onclick=\"location.href='".$allchecklink."'\">$checkico</div>";
        }
        echo "     <h1>全选</h1>";
        echo "  </div>";
        echo "  <div class='middle'>商品合计(不含运费及进口费用)<h1>&#165;$totalprice</h1></div>";
        echo "  <div class='right' onclick=\"location.href='".$buylink."'\">";
        if ($manage==0){
            echo "去结算";
        }else{
            echo "删除";
        }
        echo "(".$totalquantity.")</div>";
        echo "</div>";
    }
    ?>
    </div>
    <div class="footer">
        <?PHP
        $footerquery=mysqli_query($conn,"select id,text,href,icon from footer where valid=1");
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

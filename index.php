<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>欢迎光临zmazon</title>
    <link rel="stylesheet" href="assets/index/index.css">
    <link rel="stylesheet" href="assets/icons/footer.css">
</head>
<?php
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connvisit.php";
mysqli_set_charset($record, "utf8");
include "$rootlocation/ip2city/ip2city.php";
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$datetime = date('Y-m-d H:i:s');
if(isset($_SERVER['HTTP_REFERER'])){
    $referrer = $_SERVER['HTTP_REFERER'];
}else{
    $referrer = "newly opened";
}
$url = $_SERVER['REQUEST_URI'];
$city = ip2city($ip);
$city = mb_convert_encoding($city, 'utf8', 'gb2312');
$page="zmazon";  //current page
mysqli_query($record,"insert into visit (ip,useragent,datetime,address,page,back,city) values (\"$ip\",\"$userAgent\",\"$datetime\",\"$url\",\"$page\",\"$referrer\",\"$city\")");
?>
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
if(isset($_GET['rcchosen'])){
    $rcchosen=$_GET['rcchosen'];
}else{
    $rcchosen=1;
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
$usrv=mysqli_query($conn,"select username,verify from users where id =$usid and valid=1");
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
$footerchosen=1;
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
            header("location:index.php?usid=$usid&veri=$veri&usr=$usr&rcchosen=$rcchosen");
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
            header("location:index.php?usid=$usid&veri=$veri&usr=$usr&rcchosen=$rcchosen");
            die;
        }
    }
}
$role=-1;
if($usid!=-1){
    $rolequery=mysqli_query($conn,"select role from users where id=$usid and valid=1");
    while($rolerow=mysqli_fetch_row($rolequery)){
        $role=$rolerow[0];
    }
    if($role==-1){
        header("errororsucc.php?reason=uservalid&usid=$usid&usr=$usr&veri=$veri");
        die;
    }elseif($role==2){
        header("location:vendormanage.php?usid=$usid&usr=$usr&veri=$veri");
        die;
    }elseif($role==1){
        header("location:rootmanage.php?usid=$usid&usr=$usr&veri=$veri");
        die;
    }
}
?>
<div class="container">
    <div class="header">
        <div class="left">
            <img src="assets/index/searchbox.png">
        </div>
        <div class="right">
            <div class="searchbox">
                <div class="searchico">
                    <i class="ico"></i>
                </div>
                <div class="input">
                    <input type="text" class="text" placeholder="搜索"/>
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="part1">
            <div class="picbar">
                <img src="assets/index/p1.png">
                <img src="assets/index/p2.png">
            </div>
        </div>
        <div class="part2">
            <?PHP
            $indexcategory=mysqli_query($conn,"select icpic,icname,id from indexcategories where valid=1 and id!=0");
            while($indexcategoryrow=mysqli_fetch_row($indexcategory)){
                $icpic=$indexcategoryrow[0];
                $icname=$indexcategoryrow[1];
                $icid=$indexcategoryrow[2];
                echo "<div class='item' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$icid."&type=index'\"><img src='$icpic'><h3>$icname</h3></div>";
            }
            ?>
        </div>
        <div class="part3">
            <?PHP
            $rcquery=mysqli_query($conn,"select id,rcname,bgcolor from recccategories where id!=0 and valid=1");
            while($rcqueryrow=mysqli_fetch_row($rcquery)){
                $rcid=$rcqueryrow[0];
                $rcname=$rcqueryrow[1];
                $rcbgcolor=$rcqueryrow[2];
                if($rcid==$rcchosen) {
                    echo "<div class='item' style='background-color: $rcbgcolor'><h3>$rcname</h3></div>";
                }else{
                    echo "<div class='item' onclick=\"location.href='index.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcid."'\"><h3>$rcname</h3></div>";
                }
            }
            ?>
        </div>
        <div class="part4">
            <div class="body">
                <?PHP
                $itemquery=mysqli_query($conn,"select distinct subitems.id from subcategories,thirdcategories,items,subitems where subcategories.id=thirdcategories.scid and thirdcategories.id=items.thcid and subitems.rcid=$rcchosen and subitems.valid=1 and subitems.rcverify=1 order by subitems.id");
                while ($itemrow=mysqli_fetch_row($itemquery)) {
                    $subid=$itemrow[0];
                    $detailquery=mysqli_query($conn,"select subitems.siprice,subitems.sitext,vendors.vname from subitems,items,vendors where subitems.iid=items.id and items.vid=vendors.id and subitems.id=$subid and subitems.valid=1 and vendors.valid=1");
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
                    echo "<div class='item'><div class='tag' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$subid."&rcchosen=".$rcchosen."&back=index.php'\"><img src='$pic'><h5>$name</h5><div class='price'>&#165 $price</div><div class='detail'><div class='detailleft'>$vendor</div><div class='detailright'>满300元免运费</div></div></div><div class='last' onclick=\"location.href='index.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&actid=".$subid."&act=add&rcchosen=".$rcchosen."'\"><svg class='ico' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg></div></div>";
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
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
            }elseif ($fid==3) {
                if($fid==$footerchosen){
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }else{
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }
            }else {
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&rcchosen=".$rcchosen."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>

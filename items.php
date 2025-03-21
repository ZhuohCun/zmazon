<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>zmazon商品</title>
    <link rel="stylesheet" href="assets/items/items.css">
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
if(isset($_GET['type'])){
    $type=$_GET['type'];
}else{
    header("Location:"."errororsucc.php?reason=paraloss&usid=".$usid."&veri=".$veri."&usr=".$usr);
    die;
}
if(isset($_GET['id'])){
    $id=$_GET['id'];
}else{
    header("Location:"."errororsucc.php?reason=paraloss&usid=".$usid."&veri=".$veri."&usr=".$usr);
    die;
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
if($type=='sub'){
    $titlequery=mysqli_query($conn,"select subcategories.scname,categories.id from categories,subcategories where categories.id=subcategories.cid and subcategories.id=$id and subcategories.valid=1");
    while ($titlerow=mysqli_fetch_row($titlequery)) {
        $title=$titlerow[0];
        $categorychosen=$titlerow[1];
    }
    $back="category.php";
}elseif($type=='trd') {
    $titlequery = mysqli_query($conn, "select thirdcategories.thcname,categories.id from thirdcategories,categories,subcategories where categories.id=subcategories.cid and thirdcategories.scid=subcategories.id and thirdcategories.id=$id and thirdcategories.valid=1");
    while ($titlerow = mysqli_fetch_row($titlequery)) {
        $title = $titlerow[0];
        $categorychosen=$titlerow[1];
    }
    $back="category.php";
}elseif ($type=='index'){
    $titlequery = mysqli_query($conn, "select icname from indexcategories where id=$id and valid=1");
    while ($titlerow = mysqli_fetch_row($titlequery)) {
        $title = $titlerow[0];
        $categorychosen=0;
    }
    $back="index.php";
}else{
    header("Location:errororsucc.php?reason=paraloss?usid=".$usid."&veri=".$veri."&usr=".$usr);
    die;
}
$current="items.php&type=$type&id=$id";
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
            header("location:items.php?usid=$usid&veri=$veri&usr=$usr&type=$type&id=$id");
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
            header("location:items.php?usid=$usid&veri=$veri&usr=$usr&type=$type&id=$id");
            die;
        }
    }
}
?>
<div class="container">
    <div class="header">
        <div class="back" onclick="location.href='<?php echo $back;?>?usid=<?PHP echo $usid;?>&usr=<?PHP echo $usr;?>&veri=<?PHP echo $veri;?>&categorychosen=<?PHP echo $categorychosen;?>'"><i class="ico"></i> </div>
        <?PHP echo $title; ?>
    </div>
    <div class="main">
        <?PHP
        if($type=='sub'){
            $itemquery=mysqli_query($conn,"select distinct subitems.id from thirdcategories,subitems,items where thirdcategories.scid=$id and thirdcategories.id=items.thcid and items.id=subitems.iid and subitems.valid=1 order by subitems.id");
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
                echo "<div class='item'><div class='tag' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$subid."&back=".$current."'\"><img src='$pic'><h1>$name</h1><div class='price'>&#165 $price</div><div class='detail'><div class='detailleft'>$vendor</div><div class='detailright'>满300元免运费</div></div></div><div class='last' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$id."&actid=".$subid."&act=add&type=sub'\"><svg class='ico' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg></div></div>";
            }
        }elseif($type=='trd'){
            $itemquery=mysqli_query($conn,"select distinct subitems.id from items,subitems where items.id=subitems.iid and items.thcid=$id and subitems.valid=1 order by subitems.id");
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
                echo "<div class='item'><div class='tag' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$subid."&back=".$current."'\"><img src='$pic'><h1>$name</h1><div class='price'>&#165 $price</div><div class='detail'><div class='detailleft'>$vendor</div><div class='detailright'>满300元免运费</div></div></div><div class='last' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$id."&actid=".$subid."&act=add&type=trd'\"><svg class='ico' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg></div></div>";
            }
        }elseif ($type=='index'){
            echo "<div class='ichead'><img src='assets/indexcategory/".$id.".jpg'/> </div>";
            $itemquery=mysqli_query($conn,"select distinct subitems.id from subitems where icid=$id and valid=1 and subitems.icverify=1 order by subitems.id");
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
                echo "<div class='item'><div class='tag' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$subid."&back=".$current."'\"><img src='$pic'><h1>$name</h1><div class='price'>&#165 $price</div><div class='detail'><div class='detailleft'>$vendor</div><div class='detailright'>满300元免运费</div></div></div><div class='last' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$id."&actid=".$subid."&act=add&type=trd'\"><svg class='ico' xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 1024 1024'><path fill='currentColor' d='M352 480h320a32 32 0 1 1 0 64H352a32 32 0 0 1 0-64'/><path fill='currentColor' d='M480 672V352a32 32 0 1 1 64 0v320a32 32 0 0 1-64 0'/><path fill='currentColor' d='M512 896a384 384 0 1 0 0-768a384 384 0 0 0 0 768m0 64a448 448 0 1 1 0-896a448 448 0 0 1 0 896'/></svg></div></div>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>

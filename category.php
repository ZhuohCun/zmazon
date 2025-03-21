<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>商品分类--zmazon</title>
    <link rel="stylesheet" href="assets/category/category.css">
    <link rel="stylesheet" href="assets/icons/footer.css">
</head>
<body>
<?PHP
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
$subarr=array();
$subidarr=array();
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
if(isset($_GET['categorychosen'])){
    $categorychosen=$_GET['categorychosen'];
}else{
    $categorychosen=1;
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
$footerchosen=2;
?>
<div class="container">
    <div class="header">商品分类</div>
    <div class="main">
        <div class="left">
            <?PHP
            $categoryquery=mysqli_query($conn,'select id,ctext from categories where valid=1');
            while($categoryrow=mysqli_fetch_row($categoryquery)){
                $cid=$categoryrow[0];
                $ctext=$categoryrow[1];
                if($categorychosen==$cid){
                    echo "<div class='itemchosen'><h2>$ctext</h2></div>";
                }else{
                    echo "<div class='item' onclick=\"location.href='category.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$cid."'\"><h2>$ctext</h2></div>";
                }
            }
            ?>
        </div>
        <div class="right">
            <?PHP
            $subquery=mysqli_query($conn,"select id,scname from subcategories where cid=$categorychosen and valid=1");
            while($subrow=mysqli_fetch_row($subquery)){
                $subid=$subrow[0];
                $subtext=$subrow[1];
                array_push($subarr,$subtext);
                array_push($subidarr,$subid);
            }
            if(count($subarr)==0){

            }
            elseif($subarr[0]!='/'){
                echo "<div class='head'><div class='hleft'>";
                for ($i = 0; $i < count($subarr); $i++) {
                    echo "<div class='item'>$subarr[$i]</div>";
                }
                echo "</div><div class='hright'><i class='ico'></i></div></div>";
                for ($i = 0; $i < count($subarr); $i++) {
                    echo "<div class='itemhead' ><div class='ileft'>$subarr[$i]</div>";
                    echo "<div class='iright' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$subidarr[$i]."&type=sub'\">全部<i class='ico'></i></div></div>";
                    $trdquery = mysqli_query($conn, "select thirdcategories.thcname,thirdcategories.thcpic,thirdcategories.id from categories,subcategories,thirdcategories where categories.id=subcategories.cid and subcategories.id=thirdcategories.scid and categories.id=$categorychosen and subcategories.id=$subidarr[$i] and thirdcategories.valid=1");
                    while ($trdrow = mysqli_fetch_row($trdquery)) {
                        $trdname = $trdrow[0];
                        $trdpic = $trdrow[1];
                        $trdid=$trdrow[2];
                        echo "<div class='item' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$trdid."&type=trd'\"><img src='$trdpic'>";
                        echo "<h3>$trdname</h3></div>";
                    }
                }
            }else{
                $trdquery=mysqli_query($conn,"select thirdcategories.thcname,thirdcategories.thcpic,thirdcategories.id from categories,subcategories,thirdcategories where categories.id=subcategories.cid and subcategories.id=thirdcategories.scid and categories.id=$categorychosen and thirdcategories.valid=1");
                while($trdrow=mysqli_fetch_row($trdquery)){
                    $trdname=$trdrow[0];
                    $trdpic=$trdrow[1];
                    $trdid=$trdrow[2];
                    echo "<div class='item' onclick=\"location.href='items.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&id=".$trdid."&type=trd'\"><img src='$trdpic'>";
                    echo "<h3>$trdname</h3></div>";
                }
            }
            ?>

        </div>
    </div>
    <div class="footer">
        <?PHP
        $cartitem=0;
        $footerquery=mysqli_query($conn,"select id,text,href,icon from footer");
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
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
            }elseif ($fid==3) {
                if($fid==$footerchosen){
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i style='background-color: cornflowerblue' class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }else{
                    if($cartitem>0){
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i class='$ficon'></i><div class='carticon'><p>$cartitem</p></div><h3>$ftext</h3></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
                    }
                }
            }else {
                echo "<div class='item' onclick=\"location.href='".$fhref."?usid=".$usid."&usr=".$usr."&veri=".$veri."&categorychosen=".$categorychosen."'\"><i class='$ficon'></i><h3>$ftext</h3></div>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>商品详情--zmazon</title>
    <link rel="stylesheet" href="assets/details/details.css">
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
if(isset($_GET['type'])){
    $backtype=$_GET['type'];
}else{

}
if(isset($_GET['id'])){
    $backid=$_GET['id'];
}else{

}
if(isset($_GET['manage'])){
    $backmanage=$_GET['manage'];
}else{

}
if(isset($_GET['rcchosen'])){
    $backrcchosen=$_GET['rcchosen'];
}else{
    $backrcchosen=1;
}
if(isset($_GET['status'])){
    $backstatus=$_GET['status'];
}else{

}
if(isset($_GET['subid'])){
    $subid=$_GET['subid'];
}else{
    header("Location:"."errororsucc.php?reason=paraloss&back=index.php&usid=$usid&veri=$veri&usr=$usr");
    die;
}
if(isset($_GET['aid'])){
    $aid=$_GET['aid'];
}else{
    $aid=-1;
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
$subidvalidquery=mysqli_query($conn,"select valid from subitems where id=$subid");
while($subidvalid=mysqli_fetch_row($subidvalidquery)){
    $subvalid=$subidvalid[0];
}
if($subvalid==0){
    header("location:errororsucc.php?reason=该商品已下架&usid=$usid&usr=$usr&veri=$veri&back=index.php");
    die;
}
$current="details.php";
if($aid!=-1){
    $aidv=0;
    $addveriquery=mysqli_query($conn,"select * from usertoaddress where id=$aid and uid=$usid and valid=1");
    while($addveri=mysqli_fetch_row($addveriquery)){
        $aidv=1;
    }
    if($aidv==0){
        header("Location:"."errororsucc.php?reason=paraloss&back=$current&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
}
if(isset($_GET['back'])){
    $back=$_GET['back'];
    if($back=="items.php"){
        $back1="type=$backtype&id=$backid";
    }elseif($back=="me.php"){
        $back1="";
    }elseif ($back=="index.php"){
        $back1="rcchosen=$backrcchosen";
    }elseif ($back=="cart.php"){
        $back1="manage=$backmanage";
    }elseif ($back=="orders.php"){
        $back1="status=$backstatus";
    }
}else{
    $back="index.php?usid=$usid&usr=$usr&veri=$veri";
    $back1="";
}
$iscart=0;
if($act=="add"){
    if($usid==-1){
        header("location:login.php");
        die;
    }else{
        $cartquery=mysqli_query($conn,"select * from cart where uid=$usid and siid=$subid and checked=0 and quantity>0 and valid=1");
        while($cartrow=mysqli_fetch_assoc($cartquery)){
            $iscart=1;
        }
        if($iscart==0){
            mysqli_query($conn,"insert into cart (siid,uid,quantity,valid) values ($subid,$usid,1,1)");
            header("location:errororsucc.php?reason=addcart&succ=1&text=去购物车&back=cart.php&usid=$usid&veri=$veri&usr=$usr");
            die;
        }elseif($iscart==1){
            mysqli_query($conn,"start transaction");
            $quantityquery=mysqli_query($conn,"select quantity from cart where uid=$usid and siid=$subid and valid=1 and checked=0 and quantity>0 for update");
            while ($quantityrow=mysqli_fetch_row($quantityquery)){
                $quantity=$quantityrow[0];
            }
            $quantity=$quantity+1;
            mysqli_query($conn,"update cart set quantity=$quantity where uid=$usid and siid=$subid and valid=1 and checked=0 and quantity>0");
            mysqli_query($conn,"commit");
            header("location:errororsucc.php?reason=addcart&succ=1&text=去购物车&back=cart.php&usid=$usid&veri=$veri&usr=$usr");
            die;
        }
    }
}elseif ($act=='buy'){
    if($aid==-1){
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
    }else{
        $buyaddress=$aid;
    }
    $buydetailquery=mysqli_query($conn,"select siprice,siimportfee,transportfee from subitems where id=$subid");
    while($buydetailrow=mysqli_fetch_assoc($buydetailquery)){
        $buysiprice=$buydetailrow['siprice'];
        $buysiimportfee=$buydetailrow['siimportfee'];
        $buytransportfee=$buydetailrow['transportfee'];
        if($buysiprice>=300){
            $buytransportfee=0;
        }
        $buytotal=$buysiprice+$buytransportfee+$buysiimportfee;
    }
    mysqli_query($conn,"insert into orders (uid,status,status_name,price,aid,pid,valid) values ($usid,1,'待支付',$buytotal,$buyaddress,0,1)");
    $orderidquery=mysqli_query($conn,"select id from orders where uid=$usid");
    while ($orderrow=mysqli_fetch_row($orderidquery)) {
        $orderid=$orderrow[0];
    }
    mysqli_query($conn,"insert into ordertosubitem (oid,siid,quantity,siprice,siimportfee,transportfee,valid) values ($orderid,$subid,1,$buysiprice,$buytransportfee,$buytransportfee,1)");
    header("location:payment.php?usid=$usid&usr=$usr&veri=$veri&orderid=$orderid");
    die;
}
?>
<div class="container">
    <div class="header">
        <div class="left" onclick="location.href='<?PHP echo "$back?usid=$usid&usr=$usr&veri=$veri&$back1"; ?>'">
            <i class="ico"></i>
        </div>
        <div class="middle">
            <div class="searchbox">
                <div class="searchico">
                    <i class="ico"></i>
                </div>
                <div class="input">
                    <input type="text" class="text" placeholder="搜索千万种商品"/>
                </div>
            </div>
        </div>
        <div class="right">
            <i class="ico"></i>
        </div>
    </div>
    <div class="header2">
        <div class="item">商品</div>
        <div class="item">评价</div>
        <div class="item">详情</div>
        <div class="item">推荐</div>
    </div>
    <div class="main">
        <div class="part1">
            <div class="picbar">
                <?php
                $picquery1=mysqli_query($conn,"select subitemtopic.pic from subitems,subitemtopic where subitemtopic.siid=subitems.id and subitems.id=$subid and subitemtopic.valid=1");
                while($picrow1=mysqli_fetch_row($picquery1)){
                    $pic=$picrow1[0];
                    echo "<img src='$pic'/>";
                }
                ?>
            </div>
            <?PHP
            $toitem=mysqli_query($conn,"select items.id from items,subitems where items.id=subitems.iid and subitems.id=$subid and subitems.valid=1");
            while ($toitemrow=mysqli_fetch_row($toitem)){
                $item=$toitemrow[0];
            }
            $subnumquery=mysqli_query($conn,"select count(*) from items,subitems where items.id=subitems.iid and items.id=$item and subitems.valid=1");
            $subnum=0;
            while ($subnumrow=mysqli_fetch_row($subnumquery)){
                $subnum=$subnumrow[0];
            }
            if($subnum!=1){
                echo "<div class='subitem'>";
                $subquery=mysqli_query($conn,"select subitems.id from subitems,items where subitems.iid=items.id and items.id=$item and subitems.valid=1");
                while ($subrow=mysqli_fetch_row($subquery)){
                    $allsubitemid=$subrow[0];
                    $allpicquery=mysqli_query($conn,"select pic from subitemtopic where siid=$allsubitemid and valid=1 limit 1");
                    while ($picrow=mysqli_fetch_row($allpicquery)){
                        $allpic=$picrow[0];
                    }
                    if($subid==$allsubitemid){
                        echo "<div class='itemchosen' onclick=''><img src='$allpic'/></div>";
                    }else{
                        echo "<div class='item' onclick=\"location.href='details.php?usid=".$usid."&usr=".$usr."&veri=".$veri."&subid=".$allsubitemid."&back=".$back."&".$back1."'\"><img src='$allpic'/></div>";
                    }
                }
                echo "<div class='last'>共 $subnum 种</div></div>";
            }
            ?>
            <div class="price">&#165 <?php
                $subitemquery=mysqli_query($conn,"select siprice,siimportfee,transportfee,sitext,subname from subitems where id=$subid");
                while($subitemrow=mysqli_fetch_row($subitemquery)){
                    $price=$subitemrow[0];
                    $siimportfee=$subitemrow[1];
                    $transportfee=$subitemrow[2];
                    $sitext=$subitemrow[3];
                    $subname=$subitemrow[4];
                }
                $vendorquery=mysqli_query($conn,"select vendors.vname from vendors,items,subitems where vendors.id=items.vid and items.id=subitems.iid and subitems.id=$subid");
                while($vendorrow=mysqli_fetch_row($vendorquery)){
                    $vname=$vendorrow[0];
                }
                $addressfetched=0;
                if($aid==-1){
                    $daddressquery=mysqli_query($conn,"select usertoaddress.address1,usertoaddress.address2 from users,usertoaddress where users.id=usertoaddress.uid and usertoaddress.isdefault=1 and users.id=$usid and usertoaddress.valid=1 limit 1");
                    while($daddressrow=mysqli_fetch_row($daddressquery)){
                        $address=$daddressrow[0].$daddressrow[1];
                        $addressfetched=1;
                    }
                    if($addressfetched==0){
                        $address="请添加收货地址";
                    }
                }else{
                    $daddressquery=mysqli_query($conn,"select usertoaddress.address1,usertoaddress.address2 from users,usertoaddress where users.id=usertoaddress.uid and usertoaddress.id=$aid and users.id=$usid and usertoaddress.valid=1 limit 1");
                    while($daddressrow=mysqli_fetch_row($daddressquery)){
                        $address=$daddressrow[0].$daddressrow[1];
                        $addressfetched=1;
                    }
                    if($addressfetched==0){
                        header("location:errororsucc.php?reason=paraloss&back=details.php&usid=$usid&veri=$veri&usr=$usr");
                        die;
                    }
                }
                echo $price;
                ?>
            </div>
            <div class="text">
                <?php
                echo $sitext;
                ?>
            </div>
        </div>
        <div class="line"></div>
        <div class="part2">
            <div class="item">
                <div class="left"><h1>已选</h1></div>
                <div class="middle"><h2><?php echo $subname."，"; ?>1件</h2></div>
                <i class="right"></i>
            </div>
            <div class="item">
                <div class="left"><h1>发货</h1></div>
                <div class="middle"><h2><?php echo $vname;?>销售发货</h2></div>
                <i class="right"></i>
            </div>
            <div class="item">
                <div class="left"></div>
                <div class="middle">
                    <div class="lft"><h1>快递</h1></div>
                    <div class="rit"><h2>&#165 <?php echo $transportfee; ?></h2></div>
                </div>
                <i class="right"></i>
            </div>
            <div class="item">
                <div class="left"></div>
                <div class="middle" <?php echo "onclick=\"location.href='address.php?usid=$usid&usr=$usr&veri=$veri&back=details.php&backsubid=$subid'\""; ?>>
                    <div class="lft"><h1>送至</h1></div>
                    <div class="rit"><h1><?php echo $address; ?></h1></div>
                </div>
                <i class="right"></i>
            </div>
            <div class="item">
                <div class="left"></div>
                <div class="middle">
                    <div class="lft" style="width: 25vw;"><h1>进口费用</h1></div>
                    <div class="rit"><h2>预计&#165 <?php echo $siimportfee; ?></h2></div>
                </div>
                <i class="right"></i>
            </div>
            <div class="insure">
                <div class="item"><?php echo $vname;?>销售发货</div>
                <div class="item">正品保证</div>
                <div class="item">满300免运费</div>
                <div class="item">上门取退</div>
            </div>
        </div>
        <div class="line"></div>
        <?php
            $commentnumquery=mysqli_query($conn,"select count(*) from comments,items,subitems where items.id=subitems.iid and subitems.id=comments.siid and comments.valid=1 and subitems.valid=1 and items.id=$item");
            while ($commentnumrow=mysqli_fetch_row($commentnumquery)){
                $commentnum=$commentnumrow[0];
            }
            if($commentnum==0){
                echo "<div class='commentnone'>暂无买家评价(0)</div>";
            }else{
                echo "<div class='comment'>";
                echo "<div class='head'><div class='left'>买家评价(".$commentnum.")</div><div class='right'>查看全部<i class='ico'></i></div></div>";
                $commentquery=mysqli_query($conn,"select subitems.subname,users.username,comments.text,comments.year,comments.month,comments.day from comments,users,subitems,items where comments.uid=users.id and comments.siid=subitems.id and comments.valid=1 and subitems.valid=1 and subitems.iid=items.id and items.id=$item limit 2");
                while($commentrow=mysqli_fetch_row($commentquery)){
                    $sub=$commentrow[0];
                    $user=$commentrow[1];
                    $text=$commentrow[2];
                    $year=$commentrow[3];
                    $month=$commentrow[4];
                    $day=$commentrow[5];
                    echo "<div class='item'><div class='detail'><div class='left'><i class='ico'></i><div class='wrap'><div class='text'>$user</div><div class='text'>购入 $sub</div></div></div><div class='right'>".$year."年".$month."月".$day."日</div></div><div class='text'>$text</div></div>";
                }
                echo "</div>";
            }
        ?>
        <div class="line"></div>
        <div class="itemdetail">
            <div class="head">商品详情</div>
            <?php
            $picquery2=mysqli_query($conn,"select pic from subitemtopic where subitemtopic.siid=$subid and valid=1");
            while($picrow2=mysqli_fetch_row($picquery2)){
                $pic=$picrow2[0];
                echo "<img src='$pic'>";
            }
            ?>
        </div>
        <div class="line"></div>
        <div class="iteminfo">
            <div class="head">商品特点&基本信息</div>
            <div class="body">
                <ul>
                    <?php
                    $infoquery=mysqli_query($conn,"select text from subitemtotext where siid=$subid and valid=1");
                    while($inforow=mysqli_fetch_row($infoquery)){
                        $infotext=$inforow[0];
                        echo "<li>$infotext</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="line"></div>
        <div class="tips">
            <div class="head">Z马逊海外购小贴士</div>
            <?php
            $tipquery=mysqli_query($conn,"select id,text from tips where valid=1");
            while ($tiprow=mysqli_fetch_row($tipquery)){
                $tipid=$tiprow[0];
                $tiptext=$tiprow[1];
                echo "<div class='body'><h1>$tiptext</h1>";
                echo "<ul>";
                $subtipquery=mysqli_query($conn,"select text from subtips where tid=$tipid and valid=1");
                while($subtiprow=mysqli_fetch_row($subtipquery)){
                    $subtiptext=$subtiprow[0];
                    echo "<li>$subtiptext</li>";
                }
                echo "</ul></div>";
            }
            ?>
        </div>
        <div class="line"></div>
    </div>
    <div class="footer">
        <div class="left">
            <div class="item" onclick="location.href='<?php echo "index.php?usid=$usid&usr=$usr&veri=$veri"; ?>'">
                <i class="homeico"></i>
                <h3>首页</h3>
            </div>
            <div class="item">
                <i class="cartico" onclick="location.href='<?php echo "cart.php?usid=$usid&usr=$usr&veri=$veri"; ?>'"></i>
                <h3>购物车</h3>
            </div>
        </div>
        <div class="right">
            <div class="cartbutton" onclick="location.href='<?php echo "details.php?usid=$usid&usr=$usr&veri=$veri&act=add&subid=$subid";?>'">加入购物车</div>
            <div class="buybutton" onclick="location.href='<?php echo "details.php?usid=$usid&usr=$usr&veri=$veri&act=buy&subid=$subid";?>'">
                <div class="h1" >立即购买</div>
                <div class="h2">&#165;<?php echo $price;?></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

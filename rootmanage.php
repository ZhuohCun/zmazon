<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/rootmanage/rootmanage.css">
    <title>Z马逊管理员操作系统</title>
</head>
<script>
    function logout(){
        var c=confirm("是否退出登录");
        if (c===true){
            location.replace("me.php");
        }
    }
    function ondeliver() {
        var expf = document.getElementById("expf");
        var expn=document.getElementById("expn");
        if(expf.value===''){
            alert("请输入快递业者名称");
            return false;
        }else if(expn.value===''){
            alert("请输入快递单号");
            return false;
        }else {
            return true;
        }
    }
</script>
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
    $chosen=1;
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
$current="rootmanage.php";
$hasitem=0;
$usrv=mysqli_query($conn,'set names utf8');
$usrv=mysqli_query($conn,"select username,verify,role from users where id = $usid and valid=1");
$usrqry=0;
while($usrvr=mysqli_fetch_row($usrv)){
    $realname=$usrvr[0];
    $realver=$usrvr[1];
    $role=$usrvr[2];
    $usrqry=1;
}
if($usrqry==1 && $usr==$realname && $veri==$realver && $role=='1'){   //有效管理员登录

}elseif($usid!=-1){   //登陆信息效验失败
    header("Location:"."errororsucc.php?reason=用户权限不足");
    die;  //防止继续执行
}else{   //未登录用户
    header("Location:"."login.php");
    die;  //防止继续执行
}
if($opt=="changegoods"){
    if($optid==-1){
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }else{
        if(isset($_POST['subsitext'])){
            $goodssubsitext=$_POST['subsitext'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['subname'])){
            $goodssubname=$_POST['subname'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['price'])){
            $goodsprice=$_POST['price'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['importfee'])){
            $goodsimportfee=$_POST['importfee'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['transportfee'])){
            $goodstransportfee=$_POST['transportfee'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['rcrecommend'])){
            $goodsrcrecommend=$_POST['rcrecommend'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['icrecommend'])){
            $goodsicrecommend=$_POST['icrecommend'];
        }else{
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
        if(isset($_POST['goodsvalid'])){
            $goodsgoodsvalid=$_POST['goodsvalid'];
        }else{
            $goodsgoodsvalid="off";
        }
    }
    $ifgoodsexists=0;
    $ifgoodsexistsquery=mysqli_query($conn,"select * from subitems where id=$optid limit 1");  //未上架的商品也可以修改，不强求valid=1
    while($ifgoodsexistsrow=mysqli_fetch_row($ifgoodsexistsquery)){
        $ifgoodsexists=1;
    }
    if($ifgoodsexists==1){
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select * from subitems where id=$optid for update");
        $goodsrcquery=mysqli_query($conn,"select rcid,rcverify from subitems where id=$optid limit 1");
        while($goodsrcrow=mysqli_fetch_row($goodsrcquery)){
            $goodsrcid=$goodsrcrow[0];
            $goodsrcverify=$goodsrcrow[1];
        }
        $goodsicquery=mysqli_query($conn,"select icid,icverify from subitems where id=$optid limit 1");
        while($goodsicrow=mysqli_fetch_row($goodsicquery)){
            $goodsicid=$goodsicrow[0];
            $goodsicverify=$goodsicrow[1];
        }
        if($goodsrcverify!=0 && $goodsrcid!=$goodsrcrecommend && $goodsrcrecommend!=0){
            mysqli_query($conn,"update subitems set rcverify=0,rcid=$goodsrcrecommend where id=$optid");
        }elseif ($goodsrcrecommend==0){
            mysqli_query($conn,"update subitems set rcverify=0,rcid=0 where id=$optid");
        }elseif ($goodsrcverify==0 && $goodsrcid!=$goodsrcrecommend){
            mysqli_query($conn,"update subitems set rcid=$goodsrcrecommend where id=$optid");
        }
        if($goodsicverify!=0 && $goodsicid!=$goodsicrecommend && $goodsicrecommend!=0){
            mysqli_query($conn,"update subitems set icverify=0,icid=$goodsicrecommend where id=$optid");
        }elseif ($goodsicrecommend==0){
            mysqli_query($conn,"update subitems set icverify=0,icid=0 where id=$optid");
        }elseif ($goodsicverify==0 && $goodsicid!=$goodsicrecommend){
            mysqli_query($conn,"update subitems set icid=$goodsicrecommend where id=$optid");
        }
        if($goodsgoodsvalid=="on"){
            $goodsgoodsvalidnum=1;
        }else{
            $goodsgoodsvalidnum=0;
        }
        $goodsvalidquery=mysqli_query($conn,"select valid from subitems where id=$optid limit 1");
        while ($goodsvalidrow=mysqli_fetch_row($goodsvalidquery)){
            $selectedgoodsvalid=$goodsvalidrow[0];
        }
        if($selectedgoodsvalid==1 && $goodsgoodsvalidnum==0){
            mysqli_query($conn,"update subitems set valid=0,icverify=0,rcverify=0 where id=$optid");
        }elseif ($selectedgoodsvalid==0 && $goodsgoodsvalidnum==1){
            mysqli_query($conn,"update subitems set valid=1 where id=$optid");
        }
        mysqli_query($conn,"update subitems set sitext='$goodssubsitext',subname='$goodssubname',siprice='$goodsprice',siimportfee='$goodsimportfee',transportfee='$goodstransportfee' where id=$optid");
        mysqli_query($conn,"commit");
        header("Location:"."rootmanage.php?&usid=$usid&usr=$usr&veri=$veri&chosen=1");
    }
}
if($opt=="ccancel"){
    if($optid==-1){
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    mysqli_query($conn,"start transaction");
    mysqli_query($conn,"select status,status_name from orders where  id=$optid and valid=1 for update");
    mysqli_query($conn,"update orders set status=5,status_name='已取消' where id=$optid and valid=1");
    mysqli_query($conn,"commit");
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");
    die;
}
if($opt=="cdeliver"){
    if($optid==-1){
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["expf"])){
        $expf=$_POST["expf"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["expn"])){
        $expn=$_POST["expn"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    $statusquery=mysqli_query($conn,"select status from orders where id=$optid and valid=1 limit 1");
    while ($statusrow=mysqli_fetch_row($statusquery)){
        $selectedstatus=$statusrow[0];
    }
    if($selectedstatus!=2){
        header("Location:"."errororsucc$optid.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    mysqli_query($conn,"start transaction");
    mysqli_query($conn,"select * from orders where id=$optid and valid=1 for update");
    mysqli_query($conn,"update orders set status='3',status_name='待收货',expfirm='$expf',expno='$expn' where id=$optid and valid=1");
    mysqli_query($conn,"commit");
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");
    die;
}
if($opt=="crcpass"){  //确认通过RC推荐
    $crcvalidquery=mysqli_query($conn,"select * from subitems where id=$optid and rcverify=0 and valid=1 limit 1");
    $crcvalid=0;
    while ($crcvalidrow=mysqli_fetch_row($crcvalidquery)){
        $crcvalid=1;
    }
    mysqli_query($conn,"start transaction");
    mysqli_query($conn,"select * from subitems where id=$optid and valid=1 for update");  //数据上锁
    mysqli_query($conn,"update subitems set rcverify=1 where id=$optid");  //修改为已生效
    mysqli_query($conn,"commit");
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");
    die;
}
if($opt=="cicpass"){  //确认通过IC推荐
    $cicvalidquery=mysqli_query($conn,"select * from subitems where id=$optid and icverify=0 and valid=1 limit 1");
    $cicvalid=0;
    while ($cicvalidrow=mysqli_fetch_row($cicvalidquery)){
        $cicvalid=1;
    }
    mysqli_query($conn,"start transaction");
    mysqli_query($conn,"select * from subitems where id=$optid and valid=1 for update");  //数据上锁
    mysqli_query($conn,"update subitems set icverify=1 where id=$optid");  //修改为已生效
    mysqli_query($conn,"commit");
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");
    die;
}
if($opt=="clock"){  //确认封号
    if($optid==-1){  //该操作必须有optid参数
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["lockreason"])){
        $lockreason=$_POST["lockreason"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    $islockedquery=mysqli_query($conn,"select valid from users where id=$optid limit 1");
    while ($islockedrow=mysqli_fetch_row($islockedquery)) {
        $isvalid = $islockedrow[0];
    }
    if($isvalid!=1){
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }else{
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select valid,comment from users where id=$optid for update");
        mysqli_query($conn,"update users set valid='0',comment='$lockreason' where id=$optid");  //修改数据库
        mysqli_query($conn,"commit");
    }
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");  //封号操作完成
    die;
}
if($opt=="cunlock"){  //确认解封账号
    if($optid==-1){  //该操作必须有optid参数
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    $islockedquery=mysqli_query($conn,"select valid from users where id=$optid limit 1");
    while ($islockedrow=mysqli_fetch_row($islockedquery)) {
        $isvalid = $islockedrow[0];
    }
    if($isvalid!=0){
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }else{
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select valid,comment from users where id=$optid for update");
        mysqli_query($conn,"update users set valid='1',comment='' where id=$optid");  //修改数据库
        mysqli_query($conn,"commit");
    }
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");
    die;
}
if($opt=="changeuser"){  //修改用户信息
    if($optid==-1){  //该操作必须有optid参数
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["username"])){
        $cuusername=$_POST["username"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["phone"])){
        $cuphone=$_POST["phone"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    if(isset($_POST["email"])){
        $cuemail=$_POST["email"];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
    $isuserexist=0;
    $isuserexistquery=mysqli_query($conn,"select * from users where id=$optid limit 1");
    while ($isuserexistrow=mysqli_fetch_row($isuserexistquery)) {
        $isuserexist=1;
    }
    if($isuserexist==0){  //要操作的用户不存在
        header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
        die;
    }else{
        mysqli_query($conn,"start transaction");
        mysqli_query($conn,"select username,phone,email from users where id=$optid for update");  //数据上锁
        mysqli_query($conn,"update users set username='$cuusername',phone='$cuphone',email='$cuemail' where id=$optid");  //修改数据库
        mysqli_query($conn,"commit");
    }
    header("Location:"."rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen");  //修改成功
    die;
}
?>
<div class="container">
    <div class="left">
        <div class="title">欢迎您，Z马逊系统管理员</div>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">商品管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=1'\">商品管理</div>";} ?>
        <?php if($chosen==2){echo "<div class=\"itemwhite\">订单管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=2'\">订单管理</div>";} ?>
        <?php if($chosen==3){echo "<div class=\"itemwhite\">用户管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=3'\">用户管理</div>";} ?>
        <?php if($chosen==4){echo "<div class=\"itemwhite\">退出登录</div>";}else{echo "<div class=\"item\" onclick=\"logout()\">退出登录</div>";} ?>
        <div class="copyright">版权所有© ZMAZON</div>
    </div>
    <?php
    if($chosen==1){
        echo "<div class=\"right\">";
        $subitemquery=mysqli_query($conn,"select id,iid,sitext,subname,siprice,siimportfee,transportfee,rcid,icid,valid,rcid,rcverify,icid,icverify from subitems");
        while ($subitemrow=mysqli_fetch_array($subitemquery)){
            $subid=$subitemrow[0];
            $subiid=$subitemrow[1];
            $subsitext=$subitemrow[2];
            $subname=$subitemrow[3];
            $subsiprice=$subitemrow[4];
            $subsiimportfee=$subitemrow[5];
            $subtransportfee=$subitemrow[6];
            $subrcid=$subitemrow[7];
            $subicid=$subitemrow[8];
            $subvalid=$subitemrow[9];
            $rcid=$subitemrow[10];
            $rcverify=$subitemrow[11];
            $icid=$subitemrow[12];
            $icverify=$subitemrow[13];
            if($subvalid==0){
                $realrcverify="商品未上架";
            }elseif ($rcid==0){
                $realrcverify="未选择推荐";
            }elseif($rcverify==0){
                $realrcverify="待审核";
            }elseif($rcverify==1){
                $realrcverify="生效中";
            }elseif($rcverify==2){
                $realrcverify="审核不通过";
            }elseif ($rcverify==3){
                $realrcverify="已过期";
            }elseif ($rcverify==4 && $rcid==0){
                $realrcverify="用户未选择推荐";
            }else{
                $realrcverify="系统出错";
            }
            if($subvalid==0){
                $realicverify="商品未上架";
            }elseif ($icid==0){
                $realicverify="未选择推荐";
            }elseif($icverify==0){
                $realicverify="待审核";
            }elseif($icverify==1){
                $realicverify="生效中";
            }elseif($icverify==2){
                $realicverify="审核不通过";
            }elseif ($icverify==3){
                $realicverify="已过期";
            }elseif ($icverify==4 && $icid==0){
                $realicverify="用户未选择推荐";
            }else{
                $realicverify="系统出错";
            }
            $picquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$subid and subitemtopic.valid=1 limit 1");
            while ($picrow=mysqli_fetch_row($picquery)) {
                $pic=$picrow[0];
            }
            echo "<div class=\"goodsitem\">";
            echo "<form action=\"rootmanage.php?usid=$usid&usr=$usr&veri=$veri&opt=changegoods&optid=$subid&chosen=$chosen\" id=\"form1\" method=\"post\">";
            echo "<div class='upper'>";
            echo "<div class='p1'><img src='$pic'></div>";
            echo "<div class='p2'><input id='subsitext' name='subsitext' value='$subsitext' class='subtext'/><input id='subname' name='subname' value='$subname' class='subtext'/></div>";
            echo "<div class='p3'><div class='p3item'><h1>价格：</h1><input id='price' name='price' value='$subsiprice' class='iptbox'/></div><div class='p3item'><h1>进口关税：</h1><input id='importfee' name='importfee' value='$subsiimportfee' class='iptbox'/></div><div class='p3item'><h1>运费：</h1><input id='transportfee' name='transportfee' value='$subtransportfee' class='iptbox'/></div></div>";
            echo "<div class='p4'><div class='p4item'><h1>rc推荐条目</h1><select id='rcrecommend' name='rcrecommend' class='slctbox'>";
            $rcquery=mysqli_query($conn,"select id,rcname from recccategories where valid=1 order by id asc");
            while ($rcrow=mysqli_fetch_row($rcquery)) {
                $rcqueryrcid=$rcrow[0];
                $rcqueryrcname=$rcrow[1];
                echo "<option " ;
                if($rcqueryrcid==$rcid){
                    echo "selected style=\"color:red;\"";
                }
                echo " value='$rcqueryrcid'>$rcqueryrcname</option>";
            }
            echo "</select><h1>状态：$realrcverify</h1>"; if($realrcverify=="待审核"){echo "<div class='psbutton' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=crcpass&optid=$subid'\">通过审核</div>";} echo "</div>";
            echo "<div class='p4item'><h1>ic推荐条目</h1><select id='icrecommend' name='icrecommend' class='slctbox'>";
            $icquery=mysqli_query($conn,"select id,icname from indexcategories where valid=1 order by id asc");
            while ($icrow=mysqli_fetch_row($icquery)) {
                $icqueryicid=$icrow[0];
                $icqueryicname=$icrow[1];
                echo "<option ";
                if($icqueryicid==$icid){
                    echo "selected style=\"color:red;\"";
                }
                echo " value='$icqueryicid'>$icqueryicname</option>";
            }
            echo "</select><h1>状态：$realicverify</h1>"; if($realicverify=="待审核"){echo "<div class='psbutton' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=cicpass&optid=$subid'\">通过审核</div>";} echo "</div>";
            echo "<div class='p4item'><h2>更改推荐栏目及下架商品会使目前推荐资格失效，且无法恢复，需重新审核后方可生效</h2></div>";
            echo "<div class='p4item'><h1>是否上架</h1><input type='checkbox' id='goodsvalid' name='goodsvalid' class='slectbox' ";if($subvalid==1){echo "checked";}echo "></div>";
            echo "</div>";
            echo "</div>";
            echo "<div class='lower'>";
            echo "<div class='submitbutton'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"sbmtbtn\" value=\"整体商品修改\" /></div>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
        }
    }elseif ($chosen==2){
        echo "<div class=\"right1\">";
        $orderquery=mysqli_query($conn,"select orders.id,orders.status,orders.price,orders.pid,usertoaddress.address1,usertoaddress.address2,usertoaddress.receiver,usertoaddress.phoneofreceiver,orders.valid,orders.expfirm,orders.expno,orders.status_name from orders,usertoaddress where orders.aid=usertoaddress.id order by orders.id asc");
        while ($orderrow=mysqli_fetch_row($orderquery)) {
            $orderid=$orderrow[0];
            $orderstatus=$orderrow[1];
            $orderprice=$orderrow[2];
            $orderpid=$orderrow[3];
            $orderaddress=$orderrow[4].$orderrow[5];
            $orderreceiver=$orderrow[6]." ".$orderrow[7];
            $ordervalid=$orderrow[8];
            $orderexpfirm=$orderrow[9];
            $orderexpno=$orderrow[10];
            $realorderstatus=$orderrow[11];
            echo "<div class='orderitem'>";
            echo "<div class='title'><div class='p1'>订单号：$orderid</div><div class='p2'>$realorderstatus</div><div class='p3'>总价：&#165 $orderprice</div></div>";
            $ordertosubquery=mysqli_query($conn,"select ordertosubitem.siid,ordertosubitem.quantity,ordertosubitem.siprice,ordertosubitem.siimportfee,ordertosubitem.transportfee,ordertosubitem.valid,vendors.vname,subitems.sitext,subitems.subname from ordertosubitem,subitems,items,vendors where ordertosubitem.oid=$orderid and ordertosubitem.siid=subitems.id and subitems.iid=items.id and items.vid=vendors.id");
            while ($ordertosubrow=mysqli_fetch_row($ordertosubquery)) {
                $subordersiid=$ordertosubrow[0];
                $suborderquantity=$ordertosubrow[1];
                $suborderprice=$ordertosubrow[2];
                $suborderimportfee=$ordertosubrow[3];
                $subordertransportfee=$ordertosubrow[4];
                $subordervalid=$ordertosubrow[5];
                $subordervname=$ordertosubrow[6];
                $subordersubtext=$ordertosubrow[7];
                $subordersubname=$ordertosubrow[8];
                $suborderpicquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$subordersiid and subitemtopic.valid=1 limit 1");
                while ($suborderpicrow=mysqli_fetch_row($suborderpicquery)) {
                    $suborderpic=$suborderpicrow[0];
                }
                echo "<div class='subitem'>";
                echo "<div class='p1'><img src='$suborderpic'></div>";
                echo "<div class='p2'><div class='text'>$subordersubtext</div><div class='name'>款式：$subordersubname</div> </div>";
                echo "<div class='p3'>供应商：$subordervname</div>";
                echo "<div class='p4'><div class='price'>商品价格：$suborderprice</div><div class='importfee'>进口关税：$suborderimportfee</div><div class='transportfee'>运费：$subordertransportfee</div></div>";
                echo "<div class='p5'>x$suborderquantity</div>";
                echo "</div>";  //subitem
            }
            echo "<div class='lower'>";
            echo "<div class='lefter'><div class='address'>收货地址：$orderaddress</div><div class='receiver'>收件人：$orderreceiver</div></div>";
            echo "<div class='righter'>";
            if($orderstatus==3 || $orderstatus==4) {
                echo "<div class='p1'><div class='expfirm'>快递业者：$orderexpfirm</div><div class='expno'>快递单号：$orderexpno</div></div>";
            }else{
                echo "<div class='p1'></div>";
            }
            echo "<div class='p2'>";
            if($orderstatus==1 || $orderstatus==2) {
                echo "<div class='cancelbutton'";if($opt==-1){echo " onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=cancel&optid=$orderid'\"";}echo ">强制取消订单</div>";
            }
            if($orderstatus==2) {
                echo "<div class='deliverbutton'";if($opt==-1){echo " onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=deliver&optid=$orderid'\"";}echo ">发货</div>";
            }
            echo "</div>";  //p2
            echo "</div>";  //righter
            echo "</div>";  //lower
            echo "</div>";  //orderitem
        }
    }elseif ($chosen==3){
        echo "<div class=\"right2\">";
        $userquery=mysqli_query($conn,"select id,username,phone,email,role,valid,comment from users where role!=1");
        while ($userrow=mysqli_fetch_row($userquery)) {
            $userid=$userrow[0];
            $username=$userrow[1];
            $phone=$userrow[2];
            $email=$userrow[3];
            $role=$userrow[4];
            $valid=$userrow[5];
            $invalidreason=$userrow[6];
            if($role==1){
                $realrole="管理员";
            }elseif($role==2){
                $realrole="商家";
            }elseif($role==3){
                $realrole="用户";
            }else{
                $realrole="数据库被非法修改";
            }
            if($valid==1){
                $realvalid="正常";
            }elseif($valid==0){
                $realvalid="封禁";
            }else{
                $realrole="数据库被非法修改";
            }
            echo "<div class='useritem'>";
            echo "<form action=\"rootmanage.php?usid=$usid&usr=$usr&veri=$veri&opt=changeuser&optid=$userid&chosen=$chosen\" id=\"form2\" method=\"post\">";
            echo "<div class='upper'>";
            echo "<div class='p1'>";
            echo "<div class='p1item'><div class='lefter'>用户ID:</div><div class='righter'>$userid</div></div>";
            echo "<div class='p1item'><div class='lefter'>用户名:</div><div class='righter'><input id='username' name='username' value='$username' class='iptbox'/></div></div>";
            echo "<div class='p1item'><div class='lefter'>电话号码:</div><div class='righter'><input id='phone' name='phone' value='$phone' class='iptbox'/></div></div>";
            echo "</div>"; //p1
            echo "<div class='p2'>";
            echo "<div class='p2item'><div class='lefter'>电子信箱:</div><div class='righter'><input id='email' name='email' value='$email' class='iptbox'/></div></div>";
            echo "<div class='p2item'><div class='lefter'>角色:</div><div class='righter'>$realrole</div></div>";
            echo "<div class='p2item'><div class='lefter'>状态:</div><div class='righter'><div class='l'>$realvalid</div>";
            if($valid==0){
                echo "<div class='r'>封号原因：$invalidreason</div>";
            }
            echo "</div></div>";
            echo "</div>"; //p2
            echo "<div class='p3'>";
            if($valid==0){
                echo "<div class='ubtnbox'><div class='ubtn' ";if($opt==-1){echo "onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=cunlock&optid=$userid'\"";}echo ">解封</div></div>";
            }elseif($valid==1){
                echo "<div class='lbtnbox'><div class='lbtn' ";if($opt==-1){echo "onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=lock&optid=$userid'\"";}echo ">封号</div></div>";
            }
            echo "</div>";  //p3
            echo "</div>";  //upper
            echo "<div class='lower'>";
            echo "<div class='sbmtbtnbox'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"sbmtbtn\" value=\"整体用户修改\" /></div>";
            echo "</div>";  //lower
            echo "</form>";
            echo "</div>"; //useritem
        }
        echo "</div>";  //right2
    }
    ?>
<?php
if($opt=="deliver") {
    echo "<div class='panel'>";
    echo "<div class='title'>订单发货</div>";
    echo "<div class='x' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen'\"></div>";
    echo "<form action=\"rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=cdeliver&optid=$optid\" id=\"form1\" method=\"post\" onsubmit=\"return ondeliver();\" accept-charset='UTF-8'>";
    echo "<div class='p'>快递业者：<input class=\"i\" type=\"text\" id=\"expf\" name=\"expf\" value=\"\"/></div>";
    echo "<div class='p'>快递单号：<input class=\"i\" type=\"text\" id=\"expn\" name=\"expn\" value=\"\"/></div>";
    echo "<div class='pb'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button\" value=\"确认发货\" /></div>";
    echo "</div>";  //panel
}
if($opt=="cancel") {
    echo "<div class='panel'>";
    echo "<div class='title'>强制取消</div>";
    echo "<div class='x' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen'\"></div>";
    echo "<form action=\"rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=ccancel&optid=$optid\" id=\"form1\" method=\"post\" onsubmit=\"return ondeliver();\" accept-charset='UTF-8'>";
    echo "<div class='pcancel'>订单号：$optid</div>";
    echo "<div class='pcancel'>确认强制取消该订单？</div>";
    echo "<div class='buttons'><div class='confirm' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&opt=ccancel&optid=$optid&chosen=$chosen'\">确认</div><div class='cancel' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen'\">取消</div></div>";
    echo "</div>";  //panel
}
if($opt=="lock") {
    echo "<div class='panel'>";
    echo "<div class='title'>用户封号</div>";
    echo "<div class='x' onclick=\"location.href='rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen'\"></div>";
    echo "<form action=\"rootmanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=$chosen&opt=clock&optid=$optid\" id=\"form1\" method=\"post\" onsubmit=\"return ondeliver();\" accept-charset='UTF-8'>";
    $locknamequery=mysqli_query($conn,"select username from users where id=$optid");
    while ($lockrow=mysqli_fetch_row($locknamequery)) {
        $lockusername=$lockrow[0];
    }
    echo "<div class='p'><div class='pl'>封号用户：$lockusername</div><div class='pr'>ID号：$optid</div></div>";
    echo "<div class='p'>封号原因：<input class=\"i\" type=\"text\" id=\"lockreason\" name=\"lockreason\" value=\"\"/></div>";
    echo "<div class='pb'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button\" value=\"确认封号\" /></div>";
    echo "</div>";  //panel
}
?>
</div>
</body>
</html>
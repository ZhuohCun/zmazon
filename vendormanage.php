<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/vendormanage/vendormanage.css">
    <title>Z马逊商家管理系统</title>
</head>
<script>
    function logout(){
        var c=confirm("是否退出登录");
        if (c===true){
            location.replace("me.php");
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
$current="payment.php";
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
if($usrqry==1 && $usr==$realname && $veri==$realver && $role==2){

}elseif($usid!=-1){
    header("Location:"."errororsucc.php?reason=用户权限不足");
    die;
}else{
    header("Location:"."login.php");
    die;
}
?>
<div class="container">
    <div class="left">
        <div class="title">欢迎您，Z马逊自营商家</div>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">商品管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=1'\">商品管理</div>";} ?>
        <?php if($chosen==2){echo "<div class=\"itemwhite\">分类管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=2'\">分类管理</div>";} ?>
        <?php if($chosen==3){echo "<div class=\"itemwhite\">推荐管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=3'\">推荐管理</div>";} ?>
        <?php if($chosen==4){echo "<div class=\"itemwhite\">订单管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=4'\">订单管理</div>";} ?>
        <?php if($chosen==5){echo "<div class=\"itemwhite\">退出登陆</div>";}else{echo "<div class=\"item\" onclick=\"logout()\">退出登陆</div>";} ?>
        <div class="copyright">版权所有© ゼマゾン株式会社</div>
    </div>
    <div class="right">
        <?php if($chosen==1){
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
                if($rcverify==0){
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
                if($icverify==0){
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
                $picquery=mysqli_query($conn,"select subitemtopic.pic from subitemtopic,subitems where subitemtopic.siid=subitems.id and subitems.id=$siid and subitemtopic.valid=1 limit 1");
                while ($picrow=mysqli_fetch_row($picquery)) {
                    $pic=$picrow[0];
                }
                echo "<div class=\"item\">";
                echo "<form>";
                echo "<div class='upper'>";
                echo "<div class='p1'><img scr='$pic'></div>";
                echo "<div class='p2'><input id='subsitext' value='$subsitext'/><input id='subname' value='$subname'/></div>";
                echo "<div class='p3'><input id='price' value='$subsiprice'/><input id='importfee' value='$subsiimportfee'/><input id='transportfee' value='$subtransportfee'/></div>";
                echo "<div class='p4'><div class='p4item'><h1>rc推荐条目</h1><select id='rcrecommend' name='rcrecommend'>";
                $rcquery=mysqli_query($conn,"select id,rcname from recccategories where valid=1 and id!=0");
                while ($rcrow=mysqli_fetch_row($rcquery)) {
                    $rcqueryrcid=$rcrow[0];
                    $rcqueryrcname=$rcrow[1];
                    echo "<option value='$rcqueryrcid'>$rcqueryrcname</option>";
                }
                echo "</select></div>";
                echo "<div class='p4item'><h1>ic推荐条目</h1><select id='icrecommend' name='icrecommend'>";
                $icquery=mysqli_query($conn,"select id,icname from indexcategores where valid=1");
                while ($icrow=mysqli_fetch_row($icquery)) {
                    $icqueryrcid=$icrow[0];
                    $icqueryrcname=$icrow[1];
                    echo "<option value='$icqueryrcid'>$icqueryrcname</option>";
                }
                echo "</select></div>";
                echo "<div class='p4item'><h1>是否上架</h1><input type='radio' id='goodsvalid'/></div>";
                echo "";
                echo "</div>";
                echo "</div>";
                echo "<div class='lower'></div>";
                echo "</form>";
                echo "</div>";
            }
        }?>
    </div>
</div>
</body>
</html>
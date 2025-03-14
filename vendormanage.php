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
if(isset($_GET['opt'])){
    $opt=$_GET['opt'];
}else{
    $opt=1;
}
if(isset($_GET['optid'])){
    $optid=$_GET['optid'];
}else{
    $optid=1;
}
$current="vendormanage.php";
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
            header("Location:"."errororsucc.php?reason=paraloss&usid=$usid&usr=$usr&veri=$veri");
            die;
        }
    }
}
?>
<div class="container">
    <div class="left">
        <div class="title">欢迎您，Z马逊自营商家</div>
        <?php if($chosen==1){echo "<div class=\"itemwhite\">商品管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=1'\">商品管理</div>";} ?>
        <?php if($chosen==2){echo "<div class=\"itemwhite\">订单管理</div>";}else{echo "<div class=\"item\" onclick=\"location.href='vendormanage.php?usid=$usid&usr=$usr&veri=$veri&chosen=2'\">订单管理</div>";} ?>
        <?php if($chosen==3){echo "<div class=\"itemwhite\">退出登陆</div>";}else{echo "<div class=\"item\" onclick=\"logout()\">退出登陆</div>";} ?>
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
                echo "<form action=\"vendormanage.php?opt=changegoods&optid=$subid\" id=\"form1\" method=\"post\" onsubmit=\"return onlogin();\">";
                echo "<div class='upper'>";
                echo "<div class='p1'><img src='$pic'></div>";
                echo "<div class='p2'><input id='subsitext' value='$subsitext' class='subtext'/><input id='subname' value='$subname' class='subtext'/></div>";
                echo "<div class='p3'><div class='p3item'><h1>价格：</h1><input id='price' value='$subsiprice' class='iptbox'/></div><div class='p3item'><h1>进口关税：</h1><input id='importfee' value='$subsiimportfee' class='iptbox'/></div><div class='p3item'><h1>运费：</h1><input id='transportfee' value='$subtransportfee' class='iptbox'/></div></div>";
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
                echo "</select><h1>状态：$realrcverify</h1></div>";
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
                echo "</select><h1>状态：$realicverify</h1></div>";
                echo "<div class='p4item'><h2>更改推荐栏目及下架商品会使目前推荐资格失效，且无法恢复，需重新审核后方可生效</h2></div>";
                echo "<div class='p4item'><h1>是否上架</h1><input type='checkbox' id='goodsvalid' class='slectbox' ";if($subvalid==1){echo "checked";}echo "></div>";
                echo "</div>";
                echo "</div>";
                echo "<div class='lower'>";
                echo "<div class='submitbutton'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"sbmtbtn\" value=\"整体商品修改\" /></div>";
                echo "</div>";
                echo "</form>";
                echo "</div>";
            }
        }?>
    </div>
</div>
</body>
</html>
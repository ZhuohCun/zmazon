<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>地址管理--zmazon</title>
    <link rel="stylesheet" href="assets/address/address.css">
</head>
<script>
    function onedit() {
        var address1 = document.getElementById("address1");
        var address2=document.getElementById("address2");
        var receiver=document.getElementById("receiver");
        var por=document.getElementById("por");
        if(address1.value===''){
            alert("请输入地区");
            return false;
        }else if(address2.value===''){
            alert("请输入地址");
            return false;
        }else if(receiver.value===''){
            alert("请输入收件人");
            return false;
        }else if(por.value===''){
            alert("请输入联系电话");
            return false;
        }else {
            return true;
        }
    }
</script>
<body>
<?PHP
ini_set('default_charset', 'UTF-8');
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
    $chosen=-1;
}
if(isset($_GET['back'])){
    $back=$_GET['back'];
}else{
    $back=-1;
}
if(isset($_GET['cartmanage'])){
    $cartmanage=$_GET['cartmanage'];
}else{
    $cartmanage=-1;
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
if(isset($_POST['address1'])){
    $postaddress1= mb_convert_encoding($_POST['address1'],"UTF-8");
}else{
    $postaddress1=-1;
}
if(isset($_POST['address2'])){
    $postaddress2=mb_convert_encoding($_POST['address2'],"UTF-8");
}else{
    $postaddress2=-1;
}
if(isset($_POST['receiver'])){
    $postreceiver=mb_convert_encoding($_POST['receiver'],"UTF-8");
}else{
    $postreceiver=-1;
}
if(isset($_POST['por'])){
    $postpor=mb_convert_encoding($_POST['por'],"UTF-8");
}else{
    $postpor=-1;
}
$current="address.php";
$hasitem=0;
$usrv=mysqli_query($conn,'set names utf8');
$usrv=mysqli_query($conn,'select username,verify from users where id = '.$usid);
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
    $optv=0;
    $addveriquery=mysqli_query($conn,"select * from usertoaddress where id=$optid and uid='$usid and valid=1'");
    while($addveri=mysqli_fetch_row($addveriquery)){
        $optv=1;
    }
    if($optv==0){
        header("Location:"."errororsucc.php?reason=paraloss&back=$current&usid=$usid&usr=$usr&veri=$veri");
        die;
    }
}
if($opt=="cedit" && $optid!=-1 && $postaddress1!=-1 && $postaddress2!=-1 && $postreceiver!=-1 && $postpor!=-1){
    $ceditquery=mysqli_query($conn,"set names utf8");
    $ceditquery=mysqli_query($conn,"start transaction");
    $ceditquery=mysqli_query($conn,"select address1,address2,receiver,phoneofreceiver from usertoaddress where id=$optid for update");
    $ceditquery=mysqli_query($conn,"update usertoaddress set address1='$postaddress1', address2='$postaddress2', receiver='$postreceiver', phoneofreceiver='$postpor' where id=$optid");
    $ceditquery=mysqli_query($conn,"commit");
    header("Location:"."address.php?usid=$usid&usr=$usr&veri=$veri");
}elseif($opt=="cedit"){
    header("Location:"."errororsucc.php?reason=paraloss&back=$current&usid=$usid&usr=$usr&veri=$veri");
    die;
}
?>
<div class="container">
    <div class="header">
        <div class="back" <?php echo "onclick=\"location.href='me.php?usid=$usid&usr=$usr&veri=$veri'\""; ?>></div>
        <div class="item">地址管理</div>
    </div>
    <div class="main">
        <div class="itembox">
        <?php
        $hasaddr=0;
        $addquery=mysqli_query($conn,"select id,address1,address2,receiver,phoneofreceiver,isdefault from usertoaddress where uid=$usid and valid=1");
        while($addr=mysqli_fetch_row($addquery)){
            $hasaddr=1;
            $addrid=$addr[0];
            $addrname1=$addr[1];
            $addrname2=$addr[2];
            $recerver=$addr[3];
            $por=$addr[4];
            $isdefault=$addr[5];
            echo "<div class='item'>";
            echo "<div class='p1'>$addrname1</div>";
            echo "<div class='p2'>";if($isdefault==1){echo "<div class='ifdefault'>默认</div>";} echo "<div class='addr'>$addrname2</div>";if($isdefault==0){ echo "<div class='ifdefault2'></div>";}echo "<div class='delete'></div><div class='setdefault'><img src='assets/address/default.png'></div><div class='edit'";if($opt==-1){echo "onclick=\"location.href='address.php?usid=$usid&usr=$usr&veri=$veri&opt=edit&optid=$addrid'\"";} echo "></div></div>";
            echo "<div class='p3'>$recerver  $por</div>";
            echo "</div>";
        }
        if($hasaddr==0){
            echo "<div class='noitembox'><div class='noitem'><img src='assets/address/empty.png'><div class='noitemtitle'>暂无订单信息</div></div></div>";
        }
        ?>
        </div>
        <?php
        if($opt=="edit"&&$optid!=-1){
            echo "<div class='panel'>";
            $editquery=mysqli_query($conn,"select id,uid,address1,address2,receiver,phoneofreceiver,isdefault from usertoaddress where id=$optid and valid=1");
            while($editrow=mysqli_fetch_row($editquery)){
                $editaddrid=$editrow[0];
                $editadduid=$editrow[1];
                $editaddress1=$editrow[2];
                $editaddress2=$editrow[3];
                $editreceiver=$editrow[4];
                $editpor=$editrow[5];
                $editisdefault=$editrow[6];
                echo "<div class='title'>修改地址</div>";
                echo "<div class='x' onclick=\"location.href='address.php?usid=$usid&usr=$usr&veri=$veri'\"></div>";
                echo "<form action=\"address.php?usid=$usid&usr=$usr&veri=$veri&opt=cedit&optid=$optid\" id=\"form1\" method=\"post\" onsubmit=\"return onedit();\" accept-charset='UTF-8'>";
                echo "<div class='p'>地区：<input class=\"i\" type=\"text\" id=\"address1\" name=\"address1\" value=\"$editaddress1\"/></div>";
                echo "<div class='p'>地址：<input class=\"i\" type=\"text\" id=\"address2\" name=\"address2\" value=\"$editaddress2\"/></div>";
                echo "<div class='p'>收件人姓名：<input class=\"i\" type=\"text\" id=\"receiver\" name=\"receiver\" value=\"$editreceiver\"/></div>";
                echo "<div class='p'>联系电话：<input class=\"i\" type=\"text\" id=\"por\" name=\"por\" value=\"$editpor\"/></div>";
                echo "<div class='pb'><input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button\" value=\"保存修改\" /></div>";
            }
            echo "</div>";
        }
        ?>
    </div>
    <div class="footer">
        <div class="button">添加收货地址</div>
    </div>
</div>
</body>
</html>

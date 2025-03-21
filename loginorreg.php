<?php
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
if(isset($_GET['opt'])){
    $opt = $_GET['opt'];
}else{
    header("Location:"."errororsucc.php?reason=paraloss&back=login.php");
    die;
}
if($opt=='log'){
    if(isset($_POST['username'])){
        $loginname = $_POST['username'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=login.php");
        die;
    }
    if(isset($_POST['password'])){
        $loginpass = $_POST['password'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=login.php");
        die;
    }
    if($loginname==' '||$loginpass==''){
        header("Location:"."errororsucc.php?reason=paraloss&back=login.php");
        die;
    }
    $loginquery=mysqli_query($conn,"select id,username,password,verify,valid,role from users where username = '$loginname'");
    $hasuser=0;
    while ($loginrow = mysqli_fetch_row($loginquery)) {
        $usid = $loginrow[0];
        $realname = $loginrow[1];
        $realpass = $loginrow[2];
        $verify = $loginrow[3];
        $valid = $loginrow[4];
        $role = $loginrow[5];
        $hasuser=1;
    }
    if ($hasuser == 0) {
        header("Location:"."errororsucc.php?reason=hasuser&back=login.php");
        die;
    }elseif ($valid!=1){
        header("Location:"."errororsucc.php?reason=uservalid&back=login.php");

    }elseif ($realname == $loginname && $realpass == $loginpass && $role==3) {
        header("location:index.php?usid=$usid&usr=$loginname&veri=$verify");
        die;
    }elseif ($realname == $loginname && $realpass == $loginpass && $role==2){
        header("location:vendormanage.php?usid=$usid&usr=$loginname&veri=$verify");
        die;
    }elseif ($realname == $loginname && $realpass == $loginpass && $role==1){
        header("location:rootmanage.php?usid=$usid&usr=$loginname&veri=$verify");
        die;
    }else {
        header("Location:"."errororsucc.php?reason=userpass&back=login.php");
        die;
    }
}elseif($opt=="reg"){
    if(isset($_POST['username'])){
        $regname = $_POST['username'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
        die;
    }
    if(isset($_POST['password'])){
        $regpass = $_POST['password'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
        die;
    }
    if(isset($_POST['phone'])){
        $regphone = $_POST['phone'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
        die;
    }
    if(isset($_POST['email'])){
        $regemail = $_POST['email'];
    }else{
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
        die;
    }
    if($regname==' '|| $regpass==''|| $regemail==''|| $regphone==''){
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
        die;
    }
    $namequery=mysqli_query($conn,"select username from users where username = '$regname'");
    while ($namerow = mysqli_fetch_row($namequery)) {
        header("Location:"."errororsucc.php?reason=name&back=register.php");
        die;
    }
    $phonequery=mysqli_query($conn,"select phone from users where phone = '$regphone'");
    while ($phonerow = mysqli_fetch_row($phonequery)) {
        header("Location:"."errororsucc.php?reason=phone&back=register.php");
        die;
    }
    $emailquery=mysqli_query($conn,"select email from users where email = '$regemail'");
    while ($emailrow = mysqli_fetch_row($emailquery)) {
        header("Location:"."errororsucc.php?reason=email&back=register.php");
        die;
    }
    $regquery=mysqli_query($conn,"insert into users (username,password,phone,email,role,verify,valid) values ('$regname','$regpass','$regphone','$regemail','3',10000000000000*RAND(),'1')");
    header("Location:"."errororsucc.php?reason=regsuccess&back=login.php&succ=1&text=去登录");
    die;
}
?>
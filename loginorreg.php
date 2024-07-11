<?php
$rootlocation=$_SERVER['DOCUMENT_ROOT'];
include "$rootlocation/connzmazon.php";
$head=0; //1.paraloss 2.uservalid 3.userpass 4.other
if(isset($_GET['opt'])){
    $opt = $_GET['opt'];
}else{
    $head=1;
}
if($opt=='log'){
    if(isset($_POST['username'])){
        $loginname = $_POST['username'];
    }else{
        $head=1;
    }
    if(isset($_POST['password'])){
        $loginpass = $_POST['password'];
    }else{
        $head=1;
    }
    if($loginname==' '||$loginpass==''){
        $head=1;
    }
    if($head==1){
        header("Location:"."errororsucc.php?reason=paraloss&back=login.php");
    }
    if($head==0) {
        $loginquery=mysqli_query($conn,"select id,username,password,verify from users where username = '$loginname'");
        $valid=0;
        while ($loginrow = mysqli_fetch_row($loginquery)) {
            $usid = $loginrow[0];
            $realname = $loginrow[1];
            $realpass = $loginrow[2];
            $verify = $loginrow[3];
            $valid = 1;
        }
        if ($valid == 0) {
            $head=2;
        } elseif ($realname == $loginname && $realpass == $loginpass) {
            header("location:index.php?usid=$usid&usr=$loginname&veri=$verify");
        } else {
            $head=3;
        }
        if($head==2){
            header("Location:"."errororsucc.php?reason=uservalid&back=login.php");
        }elseif ($head==3) {
            header("Location:"."errororsucc.php?reason=userpass&back=login.php");
        }
    }
}elseif($opt=="reg"){
    if(isset($_POST['username'])){
        $regname = $_POST['username'];
    }else{
        $head=1;
    }
    if(isset($_POST['password'])){
        $regpass = $_POST['password'];
    }else{
        $head=1;
    }
    if(isset($_POST['phone'])){
        $regphone = $_POST['phone'];
    }else{
        $head=1;
    }
    if(isset($_POST['email'])){
        $regemail = $_POST['email'];
    }else{
        $head=1;
    }
    if($regname==' '|| $regpass==''|| $regemail==''|| $regphone==''){
        $head=1;
    }
    if($head==1){
        header("Location:"."errororsucc.php?reason=paraloss&back=register.php");
    }
    $namequery=mysqli_query($conn,"select username from users where username = '$regname'");
    while ($namerow = mysqli_fetch_row($namequery)) {
        $head=4;
        header("Location:"."errororsucc.php?reason=name&back=register.php");
    }
    $phonequery=mysqli_query($conn,"select phone from users where phone = '$regphone'");
    while ($namerow = mysqli_fetch_row($namequery)) {
        $head=4;
        header("Location:"."errororsucc.php?reason=phone&back=register.php");
    }
    $emailquery=mysqli_query($conn,"select email from users where email = '$regemail'");
    while ($namerow = mysqli_fetch_row($namequery)) {
        $head=4;
        header("Location:"."errororsucc.php?reason=phone&back=register.php");
    }
    if($head==0){
        $regquery=mysqli_query($conn,"insert into users (username,password,phone,email,role,verify) values ('$regname','$regpass','$regphone','$regemail','3',10000000000000*RAND())");
        header("Location:"."errororsucc.php?reason=regsuccess&back=login.php&succ=1&text=去登录");
    }
}
?>
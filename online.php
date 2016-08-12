<?php

include_once("lib/webconfig.php");
include_once "func/database.class.php";

$mydb = new Database();

session_start();

header("Content-type:text/html; charset=UTF-8");     
header("Cache-Control: no-store, no-cache, must-revalidate");    
header("Cache-Control: post-check=0, pre-check=0", false);    

$spanMember = "";
$sql = "SELECT * FROM online";
$query = $mydb->runQuery($sql);
$num = mysqli_num_rows($query);
while($result = mysqli_fetch_assoc($query)){
	$mem = "SELECT * FROM member WHERE mid = '".$result['mid']."'";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);
	
	$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
	$rank_result = $mydb->runQuery($rank);
	$rank_row = mysqli_fetch_assoc($rank_result);
	
	$spanMember.= " <a href='". DOMAIN ."/profile/".$mem_row['username'].".html'><span class='".$rank_row['rank_css']."'>" .$mem_row['username']. "</span></a> ,";
	
}
echo "<h3>ผู้ใช้งานขณะนี้</h3><div>สมาชิกออนไลน์ - " .$num . " ออนไลน์ </div>";
echo $spanMember;

if(isset($_SESSION['user'])){

	$mem = "SELECT * FROM member WHERE username = '".$_SESSION['user']."'";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);

	$sql = "SELECT * FROM online WHERE mid = '".$mem_row['mid']."'";
	$query = $mydb->runQuery($sql);
	$row = mysqli_fetch_assoc($query);
	
	if(mysqli_num_rows($query) <= 0){
		$insert = "INSERT INTO online (mid,username,onlinetime) VALUES('".$mem_row['mid']."','".$mem_row['username']."','".time()."')";
		$query = $mydb->runQuery($insert);
	}else{
		$delete = "DELETE FROM online WHERE unix_timestamp() - onlinetime > 60";
		$query = $mydb->runQuery($delete);
	}
}
?>  

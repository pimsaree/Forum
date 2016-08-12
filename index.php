<?php
date_default_timezone_set('Asia/Bangkok');
include_once("lib/webconfig.php");
include_once "func/database.class.php";
include_once "func/function.class.php";

$func = new Func();
$mydb = new Database();

@$topic = $mydb->clearText($_GET['topic']);
@$cate = $mydb->clearText($_GET['cate']);

$myip = $_SERVER['REMOTE_ADDR'];
$mpgv = "INSERT INTO logip (ipaddress,time_view) VALUES ('$myip',NOW())";
$mydb->runQuery($mpgv);

$_info = "SELECT * FROM info";
$_result = $mydb->runQuery($_info);
$_row = mysqli_fetch_assoc($_result);

session_start();

?>
<!DOCTYPE html>
<html>
<head>
<?php
	if($topic){
	$sql = "SELECT * FROM data WHERE did = '". $topic ."' limit 0,1";
	$result = $mydb->runQuery($sql);
	if(isset($result))
	{
		$row = mysqli_fetch_assoc($result);
		if(!$row)
		{
			$title = "ไม่พบหัวข้อที่คุณกำลังค้นหาอยู่";
		} else {
			$title = $row['subject'] . " - " . $_row["wsname"];
		}
?>
<title><?php echo $title?></title>
<?php } } else if($cate){
	$_cate = "SELECT * FROM category WHERE title = '".$cate."'";
	$result = $mydb->runQuery($_cate);
	$row = mysqli_fetch_assoc($result);
?>
<title><?php echo $row["title"]?></title>
<?php } else if(@$_GET['sec'] == "search"){ ?>
<title>ค้นหา - <?php echo $_row['wsname']?></title>
<?php } else if(@$_GET['sec'] == "profile") {
	$user = $_GET['user'];
	$mem = "SELECT * FROM member WHERE username = '".$user."'";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);
?>
<title>รายละเอียดของ <?php echo $mem_row['username'];?></title>
<?php } else {?>
<title><?php echo $_row["wsname"]?></title>
<?php } ?>

<meta charset="utf-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<?php echo $_row['meta'] . "\n"; ?>
<link rel="shortcut icon" href="<?php echo DOMAIN?>/favicon.ico">
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
<link href='<?php echo DOMAIN?>/assets/css/semantic.css' rel='stylesheet' />
<link href='<?php echo DOMAIN?>/assets/css/main.css' rel='stylesheet' />
<!-- Load jQuery  -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/jquery.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/jquery.address.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/jquery-ui.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/semantic.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo DOMAIN?>/assets/js/function.js"></script>

<!-- Load WysiBB JS and Theme -->
<script src="http://cdn.wysibb.com/js/jquery.wysibb.min.js"></script>
<link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />

<?php if($topic){
	$sql = "SELECT * FROM data WHERE did = '". $topic ."' limit 0,1";
	$result = $mydb->runQuery($sql);
	if(isset($result)){
		$row = mysqli_fetch_assoc($result);
?>
<meta name="og:type" content="website" />
<meta name="og:image" content="<?php echo DOMAIN?>/images/<?php echo $_row['image']?>"/>
<meta name="og:title" content="<?php echo $row['subject']; ?>" />
<meta name="og:url" content="<?php $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; echo $actual_link;?>"/>

<meta name="keywords" content="<?php echo $_row['keyword'];?>" />
<meta name="description" content="<?php echo $row['subject'];?>" />
<?php 
	} 
	} else if($cate){
	$_cate = "SELECT * FROM category WHERE title = '".$cate."' limit 0,1";
	$_cate_result = $mydb->runQuery($_cate);
	$_cate_row = mysqli_fetch_assoc($_cate_result);
?>
<meta name="og:type" content="website" />
<meta name="og:image" content="<?php echo DOMAIN?>/images/<?php echo $_row['image']?>"/>
<meta name="og:title" content="<?php echo $_cate_row['title']; ?>" />
<meta name="og:url" content="<?php $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; echo $actual_link;?>"/>
<meta name="og:description" content="<?php echo $_cate_row['description'];?>" />

<meta name="keywords" content="<?php echo $_row['keyword'];?>" />
<meta name="description" content="<?php echo $_cate_row['description'];?>" />
<?php
	} else {
	$_info = "SELECT * FROM info";
	$_result = $mydb->runQuery($_info);
	$_row = mysqli_fetch_assoc($_result);
?>
<meta name="og:type" content="website" />
<meta name="og:image" content="<?php echo DOMAIN?>/images/<?php echo $_row['image']?>"/>
<meta name="og:title" content="<?php echo $_row['wsname'] ?>" />
<meta name="og:description" content="<?php echo $_row['description'];?>" />
<meta name="og:url" content="<?php $actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; echo $actual_link;?>"/>

<meta name="keywords" content="<?php echo $_row['keyword'];?>" />
<meta name="description" content="<?php echo $_row['description'];?>" />
<?php } ?>
</head>
<body>
<div class="div-body">
<div class="div-inner">
<div class="logo">
<div class="left"><img src="<?php echo DOMAIN?>/images/logo.png"/></div>
<div class="left div-loginbox">
  	<?php if(@$_SESSION['Login']){

		$user = $_SESSION['user'];
		$pass = $_SESSION['pass'];

		$login = "SELECT * FROM member WHERE username = '".$user."' and password = '".$pass."'";
		$login_result = $mydb->runQuery($login);
		$login_row = mysqli_fetch_assoc($login_result);
		if(!$login_row){
			$islog = $mysqli->query("UPDATE member SET islogin = '0' WHERE mid = '".$login_result['mid']."'");
			session_destroy();
		}
	} else { 
	?>
	<div class="left item">
		<input id="user" placeholder="Username" type="text">
	</div>
	<div class="left item">
		<input id="pass" placeholder="Password" type="password">
	</div>
	<div class="left item">
		<div class="ui button small" onclick="Login(); return false">
			Login
		</div>
		<div class="register ui button small" onclick="ShowReg(); return false">
			Register
		</div>
	</div>
	<?php } ?>
</div>
</div>
<div style="clear: both;"></div>
<div class="ui red inverted menu">
	<a href="<?php echo DOMAIN?>/index.php" class="item">หน้าแรก</a>
	<a href="<?php echo DOMAIN?>/search" class="item">ค้นหา</a>
	<?php
	$sql = "SELECT * FROM menu";
	$result = $mydb->runQuery($sql);
	if(isset($result))
	{
		while($row = mysqli_fetch_assoc($result))
		{
	?>
			<a href="<?php echo $row['link']?>" class="item"><?php echo $row['text']?></a>
	<?php
		}
	}
	if(@$_SESSION['Login']){
	$allpm = $mydb->totalCount("pmid","pm","WHERE to_id = '".$login_row['mid']."' and to_read = '0' or form_read = '0'");
	?>
	<div class="ui dropdown item right">
		<?php echo $login_row['username']?><i class="dropdown icon"></i>
		<div class="menu">
			<a class="item" href="<?php echo DOMAIN?>/setting"><i class="setting icon"></i> Setting</a>		
			<a class="item" onclick="Logout(); return false">Logout </a>
		</div>
	</div>
	<a class="item right" href="<?php echo DOMAIN?>/pm"><i class="mail icon"></i>Inbox [<?php echo $allpm?>]</a>
	<?php } ?>
</div>
<div class="div-content">
<div class="div-data">
<?php
	@$sec = $_GET['sec'];
	
	switch($sec)
	{
		case "setting":
		if(@$_SESSION['Login']){
?>
<div class="div-setting">
<div class="sideNav">
<h3><a href="<?php echo DOMAIN?>/setting">Edit Profile</a></h3>
<h3><a href="<?php echo DOMAIN?>/setting/password/">Edit Password</a></h3>
</div>
<div class="Content">
	<?php 
		@$act = $_GET['act'];
		switch($act){
		case "password":
	?>
	<div class="ui fluid form ">
		<div class="field">
			<label><h2>Old Password</h2></label>
			<input placeholder="" type="password" id="oldpass">
		</div>
		<div class="field">
			<label><h2>New Password</h2></label>
			<input placeholder="" type="password" id="newpass">
		</div>
		<div class="field">
			<label><h2>Re New Password</h2></label>
			<input placeholder="" type="password" id="renewpass">
		</div>
		<div class="small orange ui labeled icon button" onclick="ChangePass(); return false">
		  <i class="edit sign icon"></i>Change
		</div>
	</div>
	<?php
			break;
		default:
	?>
	<div class="ui fluid form ">
		<div class="field">
			<label><h2>Profile Avatar</h2></label>
			<input placeholder="" type="text" id="image" value="<?php echo $login_row['avatar']?>">
		</div>
		<div class="field">
			<label><h2>Website</h2></label>
			<input placeholder="" type="text" id="website" value="<?php echo $login_row['website']?>">
		</div>
		<div class="field">
			<label><h2>Skype</h2></label>
			<input placeholder="" type="text" id="skype" value="<?php echo $login_row['skype']?>">
		</div>
		<div class="field">
			<label><h2>Facebook</h2></label>
			<input placeholder="" type="text" id="facebook" value="<?php echo $login_row['facebook']?>">
		</div>
		<div class="field">
			<label><h2>Line</h2></label>
			<input placeholder="" type="text" id="line" value="<?php echo $login_row['line']?>">
		</div>
		<div class="field">
			<label><h2>Location</h2></label>
			<input placeholder="" type="text" id="location" value="<?php echo $login_row['location']?>">
		</div>
		<div class="field">
			<label><h2>Signature</h2></label>
			<textarea id="body" placeholder="ลองรับการใช้งาน BBCODE"><?php echo $login_row['signature']?></textarea>
		</div>
		<div class="small green ui labeled icon button" onclick="ProEdit(); return false">
		  <i class="edit sign icon"></i>Edit
		</div>
	</div>
	<?php } ?>
</div>
<div style="clear:both;"></div>
</div>
<?php
			} else {
?>
<div class="_box">
	<div class="ui error message">
	  <div class="header">
		ข้อความจากระบบ
	  </div>
	  <ul class="list">
		<li>คุณไม่ได้รับสิทธิ์ในการเข้าหน้าเพ็จนี้</li>
	  </ul>
	</div>
</div>
<?php
			}
			break;
		case "profile":
?>
<div class="div-profile">
<?php
			@$user = $_GET['user'];
			if($user){
			
			$mem = "SELECT * FROM member WHERE username = '".$user."'";
			$mem_result = $mydb->runQuery($mem);
			$mem_row = mysqli_fetch_assoc($mem_result);
			if($mem_row){
					$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
					$rank_result = $mydb->runQuery($rank);
					$rank_row = mysqli_fetch_assoc($rank_result);
?>
<div class="sideNav">
<h3><?php echo $mem_row['username']?></h3>
<img src="<?php echo $mem_row['avatar']?>" width="160" height="160"/>
</div>
<div class="Content">
	<div class="ui fluid form ">
		<div class="field">
			<label><h2>Profile Infomation</h2></label>
			<div><strong>Rank</strong> : <span class="<?php echo $rank_row['rank_css']?>"><?php echo $rank_row['rank_name']?></span></div>
			<div><strong>สมัครเมือวันที่</strong> : <?php echo $mem_row['reg_time']?></div>
			<div><strong>Location</strong> : <strong><?php echo $mem_row['location']?></strong></div>
			<div><strong>Website</strong> : <a href="http://<?php echo $func->protect($mem_row['website'])?>"><?php echo $func->protect($mem_row['website'])?></a></div>
			<div><strong>Skype</strong> : <?php echo $func->protect($mem_row['skype'])?></div>
			<div><strong>Facebook</strong> : <a href="http://<?php echo $func->protect($mem_row['facebook'])?>"><?php echo $func->protect($mem_row['facebook'])?></a></div>
			<div><strong>Line</strong> : <?php echo $func->protect($mem_row['line'])?></div>
			<div>
				<strong>ลายเซ็น</strong>
				<div><?php echo $func->parseText($mem_row['signature'])?></div>
			</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<a href="<?php echo DOMAIN?>/pm/send/<?php echo $mem_row['username']?>" class="tiny ui labeled icon button red"><i class="mail icon"></i>ส่งข้อความ</a>
<?php
			} else {
?>
<div class="ui error message">
  <div class="header">
    ข้อความจากระบบ
  </div>
  <ul class="list">
    <li>ไม่พบผู้ใช้งานที่คุณกำลังค้นหาอยู่</li>
    <li>โปรดติดต่อผู้ดูแลระบบในภายหลัง</li>
  </ul>
</div>
<?php
			}
			} else {
?>
<div class="ui error message">
  <div class="header">
    ข้อความจากระบบ
  </div>
  <ul class="list">
    <li>ไม่พบผู้ใช้งานที่คุณกำลังค้นหาอยู่</li>
    <li>โปรดติดต่อผู้ดูแลระบบในภายหลัง</li>
  </ul>
</div>
<?php
			}
?>
</div>
<?php
		break;
		case "pm":
		if(@$_SESSION['Login']){
		@$act = $_GET['act'];
		switch($act){
			case "read":
			@$pmid = $_GET['pmid'];
?>
<div class="div-privatemessage">
	<div class="sideNav">
	<a href="<?php echo DOMAIN?>/pm"><h3>ข้อความเข้า</h3></a>
	<a href="<?php echo DOMAIN?>/pm/send/"><h3>ส่งข้อความ</h3></a>
	</div>
	<div class="Content">
		<div class="ui fluid form ">
		<div class="field">
			<?php 
				$pm = "SELECT * FROM pm WHERE pmid = '".$pmid."'";
				$pm_result = $mydb->runQuery($pm);
				$pm_row = mysqli_fetch_assoc($pm_result);
				
				$form_sql = "SELECT * FROM member WHERE mid = '".$pm_row['form_id']."'";
				$form_result = $mydb->runQuery($form_sql);
				$form_row = mysqli_fetch_assoc($form_result);
				
				$rank = "SELECT * FROM rank WHERE rid = '".$form_row['rank']."'";
				$rank_result = $mydb->runQuery($rank);
				$rank_row = mysqli_fetch_assoc($rank_result);
				
				if($login_row['mid'] == $pm_row['to_id'] || $login_row['mid'] == $pm_row['form_id']){
				if($pm_row['to_id'] == $login_row['mid']){
					$read = "UPDATE pm SET to_read = '1' WHERE pmid = '". $pmid ."'";
					$read_result = $mydb->runQuery($read);
				}
				if($login_row['mid'] == $pm_row['form_id']){
					$read = "UPDATE pm SET form_read = '1' WHERE pmid = '". $pmid ."'";
					$read_result = $mydb->runQuery($read);
				}
			?>
			<div class="_box div-pmbox">
			<div class="topbar">ผู้ส่ง <span class="<?php echo $rank_row['rank_css']?>"><?php echo $form_row['username']?></span></div>
			<div><h3>หัวข้อ <?php echo $pm_row['title']?><h3></div>
			<div><?php echo $func->parseText($pm_row['message'])?></div>
			<div class="botbar">เมื่อ <?php echo $pm_row['timecreate'];?></div>
			</div>
			<div class="_box">
			<?php
				$repm = "SELECT * FROM repm WHERE pmid ='".$pmid."'";
				$repm_result = $mydb->runQuery($repm);
				while($repm_row = mysqli_fetch_assoc($repm_result)){

				$form_sql = "SELECT * FROM member WHERE mid = '".$repm_row['form_id']."'";
				$form_result = $mydb->runQuery($form_sql);
				$form_row = mysqli_fetch_assoc($form_result);
				
				$rank = "SELECT * FROM rank WHERE rid = '".$form_row['rank']."'";
				$rank_result = $mydb->runQuery($rank);
				$rank_row = mysqli_fetch_assoc($rank_result);	
			?>
			<div class="div-repmbox">
			<div class="topbar">ข้อความจาก <span class="<?php echo $rank_row['rank_css']?>"><?php echo $form_row['username']?></span></div>
			<div><?php echo $func->parseText($repm_row['message'])?></div>
			<div class="botbar">เมื่อ <?php echo $repm_row['timesend'];?></div>
			</div>
			<?php 
				} 
				if($pm_row['form_id'] == $login_row['mid']){
					@$sendto.= $pm_row['to_id'];
				} else if($pm_row['form_id'] != $login_row['mid']){
					@$sendto.= $pm_row['form_id'];
				}
			?>
			</div>
			<div><textarea placeholder="ลองรับการใช้งาน BBCODE" id="body"></textarea></div>
			<div style="padding:5px;">
			<div class="small green ui labeled icon button" onclick="SendRepm(<?php echo $pmid?>,<?php echo $sendto; ?>); return false">
			  <i class="add sign Box icon"></i>
				Send
			</div>
			</div>
		</div>
		<?php } else { ?>
			<div>คุณไม่ได้รับสิทธิ์ในการอ่านข้อความนี้</div>
		<?php } ?>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php
				break;
			case "send":
			@$user = $_GET['u'];
?>
<div class="div-privatemessage">
	<div class="sideNav">
	<a href="<?php echo DOMAIN?>/pm"><h3>ข้อความเข้า</h3></a>
	<a href="<?php echo DOMAIN?>/pm/send/"><h3>ส่งข้อความ</h3></a>
	</div>
	<div class="Content">
		<div class="ui fluid form ">
		<div class="field">
			<div class="field">
				<input id="category" value="3" type="hidden">
				<label><h2>หัวข้อ</h2></label>
				<input id="title" type="text">
			</div>
		</div>
		<div class="field">
			<div class="field">
				<label><h2>ข้อความ</h2></label>
				<textarea id="body"></textarea>
			</div>
		</div>
		<div class="field">
			<input id="category" value="3" type="hidden">
				<label><h2>ส่งถึง</h2></label>
				<input id="user" type="text" value="<?php echo $user?>">
		</div>
		<div class="small green ui labeled icon button" onclick="SendPm(); return false">
		  <i class="edit sign icon"></i>ส่งข้อความ
		</div>
		</div>
	</div>
</div>
<div style="clear:both;"></div>
<?php
				break;
			default:
?>
<div class="div-privatemessage">
	<div class="sideNav">
	<a href="<?php echo DOMAIN?>/pm"><h3>ข้อความเข้า</h3></a>
	<a href="<?php echo DOMAIN?>/pm/send/"><h3>ส่งข้อความ</h3></a>
	</div>
	<div class="Content">
		<div class="ui fluid form ">
		<div class="field">
			<?php 
				$pm = "SELECT * FROM pm WHERE to_id = '".$login_row['mid']."' or form_id = '".$login_row['mid']."' ORDER BY timeupdate DESC";
				$pm_result = $mydb->runQuery($pm);
				while($pm_row = mysqli_fetch_assoc($pm_result)){
				
				$form_sql = "SELECT * FROM member WHERE mid = '".$pm_row['form_id']."'";
				$form_result = $mydb->runQuery($form_sql);
				$form_row = mysqli_fetch_assoc($form_result);
				
				$to_sql = "SELECT * FROM member WHERE mid = '".$pm_row['to_id']."'";
				$to_result = $mydb->runQuery($to_sql);
				$to_row = mysqli_fetch_assoc($to_result);
				
				$rank = "SELECT * FROM rank WHERE rid = '".$form_row['rank']."'";
				$rank_result = $mydb->runQuery($rank);
				$rank_row = mysqli_fetch_assoc($rank_result);
				
				$_rank = "SELECT * FROM rank WHERE rid = '".$to_row['rank']."'";
				$_rank_result = $mydb->runQuery($_rank);
				$_rank_row = mysqli_fetch_assoc($_rank_result);
			?>
			<div class="_box" style="margin-top:5px; <?php if($pm_row['form_id'] == $login_row['mid']) { if($pm_row['form_read']) { echo "background-color:#EEE;"; } } else if($pm_row['to_id'] == $login_row['mid']){ if($pm_row['to_read']) { echo "background-color:#EEE;"; } }?>">
			<div class="topbar"><a href="pm/read-<?php echo $pm_row['pmid']?>.html"><h3><?php echo $pm_row['title']?></h3></a></div>
			<div><?php if($pm_row['form_id'] == $login_row['mid']){ echo "ส่งไปหา <span class='".$_rank_row['rank_css']."'>" . $to_row['username'] . "</span>"; } else { echo "ข้อความจาก <span class='".$rank_row['rank_css']."'>" . $form_row['username'] . "</span>"; }?></div>
			<div class="botbar"><?php echo $func->count_time($pm_row['timeupdate']);?></div>
			</div>
			<?php } ?>
		</div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
<?php
			}
			} else {
?>
			<div class="_box">
			<div class="ui error message">
			  <div class="header">
				ข้อความจากระบบ
			  </div>
			  <ul class="list">
				<li>คุณไม่ได้รับสิทธิ์ในการเข้าหน้าเพ็จนี้</li>
			  </ul>
			</div>
			</div>
<?php
			}
			break;
			case "search":
?>
			<div class="_box">
				<div class="ui fluid icon input">
				  <input id="search" placeholder="ค้นหาสิ่งที้คุณต้องการหา" type="text">
				  <i class="search icon"></i>
				</div>
			</div>
<?php
			@$text = $mydb->clearText($_GET['text']);

			$sql = "SELECT * FROM data WHERE subject like '%$text%' ORDER BY time_update DESC";
			$result = $mydb->runQuery($sql);
			while($row = mysqli_fetch_assoc($result)){
			
			$cate = "SELECT * FROM category WHERE cid = '".$row['category']."'";
			$cate_result = $mydb->runQuery($cate);
			$cate_row = mysqli_fetch_assoc($cate_result);

			$comcou = $mydb->totalCount("cid","comment","WHERE did = '".$row['did']."'");
				
			$com = "SELECT * FROM comment WHERE did = '".$row['did']."' ORDER by cid DESC";
			$com_result = $mydb->runQuery($com);
			$com_row = mysqli_fetch_assoc($com_result);
				
			$mem = "SELECT * FROM member WHERE mid = '".$row['mid']."'";
			$mem_result = $mydb->runQuery($mem);
			$mem_row = mysqli_fetch_assoc($mem_result);
			
			$lastp = "SELECT * FROM member WHERE mid = '".$row['upmid']."'";
			$lastp_result = $mydb->runQuery($lastp);
			$lastp_row = mysqli_fetch_assoc($lastp_result);
			
			$lastrk = "SELECT * FROM rank WHERE rid = '".$lastp_row['rank']."'";
			$lastrk_result = $mydb->runQuery($lastrk);
			$lastrk_row = mysqli_fetch_assoc($lastrk_result);
			
			$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
			$rank_result = $mydb->runQuery($rank);
			$rank_row = mysqli_fetch_assoc($rank_result);
?>
<div class="box">
<div><i class="huge chat basic icon"></i></div>
<div class="title_"><a class="href" href="<?php echo DOMAIN?>/category/<?php echo $cate_row['title']?>/topic-<?php echo $row['did']?>.html"><?php echo $row['subject']?></a>
<div class="div-comlast">
<div>โดย <a href="<?php echo DOMAIN?>/profile/<?php echo $lastp_row['username']?>.html"><span class="<?php echo $lastrk_row['rank_css']?>"><?php echo $lastp_row['username']?></span></a></div>
<div>เมื่อ <?php echo $func->count_time($row['time_update'])?></div>
</div>
<div class="div-comcou">
<div>เข้าชม : <?php echo $row['view']?></div>
<div>ตอบ : <?php echo $comcou;?></div>
</div>
<div class="description">Start By <a href="<?php echo DOMAIN?>/profile/<?php echo $mem_row['username']?>.html"><span class="<?php echo $rank_row['rank_css']?>"><?php echo $mem_row['username']?></span></a> , <i class="calendar icon"></i> <?php echo $func->count_time($row['time_create'])?></div>
</div>
</div>
<?php
			}
			break;
		default:
if($topic)
{
	$sql = "SELECT * FROM data WHERE did = '". $topic ."' limit 0,1";
	$result = $mydb->runQuery($sql);
	if(isset($result))
	{
		$row = mysqli_fetch_assoc($result);
		
		$cate = "SELECT * FROM category WHERE cid = '".$row['category']."'";
		$cate_result = $mydb->runQuery($cate);
		$cate_row = mysqli_fetch_assoc($cate_result);
		
		$pgv = "UPDATE data SET view = view+1 WHERE did = '".$topic."'";
		$mydb->runQuery($pgv);
		
		$com = $mydb->totalCount("cid","comment","WHERE did = '".$row['did']."'");
		
		$mem = "SELECT * FROM member WHERE mid = '".$row['mid']."'";
		$mem_result = $mydb->runQuery($mem);
		$mem_row = mysqli_fetch_assoc($mem_result);
		
		$mem_com = $mydb->totalCount("cid","comment","WHERE mid = '".$mem_row['mid']."'");
		
		$mem_post = $mydb->totalCount("did","data","WHERE mid = '".$mem_row['mid']."'");
		
		$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
		$rank_result = $mydb->runQuery($rank);
		$rank_row = mysqli_fetch_assoc($rank_result);
		
		$all = $mem_com + $mem_post;
?>

<div class="_box">
<?php if($row){?>
<div class="ui large breadcrumb">
  <a class="section" href="<?php echo DOMAIN?>">Home</a>
  <div class="divider"> / </div>
  <a class="section" href="<?php echo DOMAIN . "/category/" . $cate_row['title']?>/"><?php echo $cate_row['title']?></a>
  <div class="divider"> / </div>
  <div class="active section"><?php echo $row['subject']?></div>
</div>
<div><strong>Thread: <?php echo $row['subject']?></strong></div>
<div class="div-thread-name">
<div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1500335676852677&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="<?php echo DOMAIN?>/category/<?php echo $cate_row['title']?>/topic-<?php echo $row['did']?>.html" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
</div>
<div style="padding: 5px;background-color: #EFEFEF;"><i class="calendar icon"></i> <?php echo $func->count_time($row['time_create'])?> </div>
<div style="border-bottom:1px dashed #EBEBEB; margin-bottom: 5px;"></div>
<div class="box-inner">
<div class="member_info">
<div class="name"><a href="<?php echo DOMAIN?>/profile/<?php echo $mem_row['username']?>.html"><span class="<?php echo $rank_row['rank_css']?>"><?php echo $mem_row['username']?></span></a></div>
<img src="<?php echo $mem_row['avatar']?>" width="120" height="120"/>
<div class="row"><strong>Rank:</strong> <strong><span class="<?php echo $rank_row['rank_css']?>"><?php echo $rank_row['rank_name']?></span></strong></div>
<div class="row"><strong>Join Date:</strong> <?php echo $mem_row['reg_time']?></div>
<div class="row"><strong>Location:</strong> <?php echo $mem_row['location']?></div>
<div class="row"><strong>Posts:</strong> <?php echo $all?></div>
</div>
</div>
<div class="_box-body">
<div style="border-bottom:1px solid #EBEBEB;margin-bottom:10px;">
<h3><?php echo $row['subject']?></h3>
<div class="div-static"><?php if($row['mid'] == @$login_row['mid']){ echo "<a href='#' onclick='EditTxt(); return false'>แก้ไข</a>";}?></div>
</div>
<div class="txtbody"><?php echo $func->parseText(stripcslashes($row['body']))?></div>
<div><?php if($mem_row['signature']){?>
<div class="div-signature"><?php echo $func->parseText(stripcslashes($mem_row['signature']));?></div>
<?php } ?>
</div>
<?php 
if($row['mid'] == @$login_row['mid']){
?>
<div class="txtedit">
<div class="div-comment">
	  <form class="ui reply form">
		  <div class="field">
			<span>แก้ไขกระทู้: <?php echo $row['subject']?></span>
		  </div>
		<div class="field">
			<input value="<?php echo $row['did']?>" id="did" type="hidden">
			<textarea id="txt_body"><?php echo $row['body']?></textarea>
		</div>
		<div class="ui tiny button teal submit labeled icon" onclick="EditPost(); return false">
		  <i class="icon edit"></i> แก้ไข
		</div>
	  </form>
</div>
</div>
<?php } ?>
</div>
<div style="clear:both; border-bottom:1px dashed #EBEBEB; margin-bottom:10px; margin-top:10px;"></div>
<?php } else {?>
<div class="ui error message">
  <div class="header">
    ข้อความจากระบบ
  </div>
  <ul class="list">
    <li>หัวข้อนี้อาจจะโดนลบหรือเสียหาย</li>
    <li>กรุณาติดต่อผู้ดูแลระบบเพื่อทำการแก้ไขในภายหลัง</li>
  </ul>
</div>
<?php }?>
</div>

<div style="height:20px;"></div>

<?php 
	$sql = "SELECT * FROM comment WHERE did = '". $topic ."'";
	$result = $mydb->runQuery($sql);
	if(isset($result)){
	while($com_result = mysqli_fetch_assoc($result)){
	
	$mem = "SELECT * FROM member WHERE mid = '".$com_result['mid']."'";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);
	
	$mem_com = $mydb->totalCount("cid","comment","WHERE mid = '".$mem_row['mid']."'");
	$mem_post = $mydb->totalCount("did","data","WHERE mid = '".$mem_row['mid']."'");
	$all = $mem_com + $mem_post;
	
	$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
	$rank_result = $mydb->runQuery($rank);
	$rank_row = mysqli_fetch_assoc($rank_result);
	if($row){
?>
<div class="_box">
<div class="div-comment-header">
<div><h4>Re: <?php echo $row['subject']?></h4></div>
</div>
<div style="padding: 5px;background-color: #EFEFEF;"><i class="calendar icon"></i> <?php echo $func->count_time($com_result['time_comment'])?> 
<?php if(@$_SESSION['Admin']){?>
	<a id="<?php echo $com_result['cid']?>" href="" onclick="Delete(this.id); return false">ลบความคิดเห็นนี้</a>
<?php } ?></div>
<div style="border-bottom:1px dashed #EBEBEB; margin-bottom: 5px;"></div>
<div class="box-inner">
<div class="member_info">
<div class="name"><a href="<?php echo DOMAIN?>/profile/<?php echo $mem_row['username']?>.html"><strong><span class="<?php echo $rank_row['rank_css']?>"><?php echo $mem_row['username']?></span></strong></a></div>
<img src="<?php echo $mem_row['avatar']?>" width="120" height="120"/>
<div class="row"><strong>Rank:</strong> <strong><span class="<?php echo $rank_row['rank_css']?>"><?php echo $rank_row['rank_name']?></span></strong></div>
<div class="row"><strong>Join Date:</strong> <?php echo $mem_row['reg_time']?></div>
<div class="row"><strong>Location:</strong> <?php echo $mem_row['location']?></div>
<div class="row"><strong>Posts:</strong> <?php echo $all?></div>
</div>
</div>
<div class="_box-body">
<div style="margin-bottom:10px;">
<div class="div-static">
	<!-- eqwewqe -->
</div>
</div>
<div class="txtbody"><?php echo $func->parseText(stripcslashes($com_result['body']));?></div>
<div class="div-signature"><?php echo $func->parseText(stripcslashes($mem_row['signature']));?></div>
</div>
<div style="clear:both; border-bottom:1px dashed #EBEBEB; margin-bottom:10px; margin-top:10px;"></div>
</div>
<?php } } }
if(@$_SESSION['Login'] && $row){
?>
<div class="div-comment">
	<div class="ui horizontal icon divider">
	  <i class="circular comment icon"></i>
	</div>
	  <form class="ui reply form">
		  <div class="field">
			<span>Quick Reply</span>
		  </div>
		<div class="field">
			<input type="hidden" value="<?php echo $topic?>" id="did">
			<textarea id="body" placeholder="ลองรับการใช้งาน BBCODE"></textarea>
		</div>
		<div class="ui tiny button teal submit labeled icon" onclick="Comment(); return false">
		  <i class="icon edit"></i> Post Quick Reply
		</div>
	  </form>
</div>
<?php
	}
	} 
} else {
if($cate)
{	
	$cate = "SELECT * FROM category WHERE title = '".$cate."'";
	$cate_result = $mydb->runQuery($cate);
	$cate_row = mysqli_fetch_assoc($cate_result);
	
	$sql = "SELECT * FROM data WHERE category = '".$cate_row['cid']."' ORDER BY time_update DESC;";
	
	if(!$cate_row)
	{
		echo "<meta http-equiv='refresh' content='0;url=404.html'> ";
	}
	$result = $mydb->runQuery($sql);
	?>
<div class="div-showthread">
<div class="div-pagetitle">
<div><h3>Forum : <?php echo $cate_row['title']?></h3></div>
<div><?php echo $cate_row['description']?></div>
</div>
<div class="div-showthread-title">Forum : <?php echo $cate_row['title']?></div>
<div class="div-showHeader">
<div style="margin-left:70px; float:left; width:700px;"><strong>Title</strong></div>
<div style="float:left; width:150px;"><strong>Last Post</strong></div>
<div style="clear:both;"></div>
</div>
<?php
	if(isset($result))
	{
		while($row = mysqli_fetch_assoc($result)){
		$cate = "SELECT * FROM category WHERE cid = '".$row['category']."'";
		$cate_result = $mydb->runQuery($cate);
		$cate_row = mysqli_fetch_assoc($cate_result);
		
		$comcou = $mydb->totalCount("cid","comment","WHERE did = '".$row['did']."'");
		
		$com = "SELECT * FROM comment WHERE did = '".$row['did']."' ORDER by cid DESC";
		$com_result = $mydb->runQuery($com);
		$com_row = mysqli_fetch_assoc($com_result);
		
		$mem = "SELECT * FROM member WHERE mid = '".$row['mid']."'";
		$mem_result = $mydb->runQuery($mem);
		$mem_row = mysqli_fetch_assoc($mem_result);
		
		$lastp = "SELECT * FROM member WHERE mid = '".$row['upmid']."'";
		$lastp_result = $mydb->runQuery($lastp);
		$lastp_row = mysqli_fetch_assoc($lastp_result);
		
		$lastrk = "SELECT * FROM rank WHERE rid = '".$lastp_row['rank']."'";
		$lastrk_result = $mydb->runQuery($lastrk);
		$lastrk_row = mysqli_fetch_assoc($lastrk_result);
		
		$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
		$rank_result = $mydb->runQuery($rank);
		$rank_row = mysqli_fetch_assoc($rank_result);
?>
<div class="box">
<div><i class="huge chat basic icon"></i></div>
<div class="title_"><a class="href" href="topic-<?php echo $row['did']?>.html"><?php echo $row['subject']?></a>
<div class="div-comlast">
<div>โดย <a href="<?php echo DOMAIN?>/profile/<?php echo $lastp_row['username']?>.html"><span class="<?php echo $lastrk_row['rank_css']?>"><?php echo $lastp_row['username']?></span></a></div>
<div>เมื่อ <?php echo $func->count_time($row['time_update'])?></div>
</div>
<div class="div-comcou">
<div>เข้าชม : <?php echo $row['view']?></div>
<div>ตอบ : <?php echo $comcou;?></div>
</div>
<div class="description">Start By <a href="<?php echo DOMAIN?>/profile/<?php echo $mem_row['username']?>.html"><span class="<?php echo $rank_row['rank_css']?>"><?php echo $mem_row['username']?></span></a> , <i class="calendar icon"></i> <?php echo $func->count_time($row['time_create'])?></div>
</div>
</div>
<?php
}
?>
</div>
<div class="above-data">
	<div class="small ui labeled icon button" onclick="showNewTh(); return false">
    <i class="add sign icon"></i>
		New Thread
	</div>
<div class="div-post">
<?php if(@$_SESSION['Login']){?>
<div class="ui fluid form ">
	<div class="field">
		<div class="field">
			<input id="category" type="hidden" value="<?php echo $cate_row['cid'];?>"/>
			<label><h2>หัวข้อกระทู้</h2></label>
			<input placeholder="เช่น ประกาศขาย สินค้ามากมาย" id="title" type="text">
		</div>
	</div>
	<div class="field">
		<div class="field">
			<label><h2>รายละเอียด</h2></label>
			<textarea placeholder="ลองรับการใช้งาน BBCODE" id="body"></textarea>
		</div>
	</div>
  	<div class="small green ui labeled icon button" onclick="Post(); return false">
      <i class="edit sign icon"></i>ตั้งกระทู้
    </div>
</div>
<?php } else { ?>
<div class="ui error message">
  <div class="header">
    ข้อความจากระบบ
  </div>
  <ul class="list">
    <li>คุณยังไม่ได้ล็อกอินจึงไม่สามารถตั้งกระทู้ใหม่ได้</li>
    <li>กรุณาล็อกอินเพื่อที่จะตั้งกระทู้ใหม่</li>
  </ul>
</div>
<?php } ?>
</div>
</div>
<?php
}
} else {
?>
<div class="div-banner-top">
<div class="postop">
<?php 
	$banner = "SELECT * FROM banner WHERE position = '0' and enable = '1'";
	$banner_result = $mydb->runQuery($banner);
	while($banner_row = mysqli_fetch_assoc($banner_result)){
?>
<a href="<?php echo $banner_row['link']?>"><img src="<?php echo $banner_row['image']?>" width="120" height="120"/></a>
<?php } ?>
</div>
</div>
<div class="div-recent">
<div><i class="pin icon"></i> Recent Post on Topic</div>
<?php 
	$data = "SELECT * FROM data ORDER BY time_update DESC limit 0,20";
	$data_result = $mydb->runQuery($data);
	while($data_row = mysqli_fetch_assoc($data_result)){
	
	$lastp = "SELECT * FROM member WHERE mid = '".$data_row['upmid']."'";
	$lastp_result = $mydb->runQuery($lastp);
	$lastp_row = mysqli_fetch_assoc($lastp_result);
	
	$_cate = "SELECT * FROM category WHERE cid = '".$data_row['category']."'";
	$_cate_result = $mydb->runQuery($_cate);
	$_cate_row = mysqli_fetch_assoc($_cate_result);
	
	$rank = "SELECT * FROM rank WHERE rid = '".$lastp_row['rank']."'";
	$rank_result = $mydb->runQuery($rank);
	$rank_row = mysqli_fetch_assoc($rank_result);
?>
<div class="item"> <a href="category/<?php echo $_cate_row['title']?>/topic-<?php echo $data_row['did']?>.html"><?php echo $data_row['subject']?></a> โดย <a href="profile/<?php echo $lastp_row['username']?>.html"><span class="<?php echo $rank_row['rank_css']?>"><?php echo $lastp_row['username']?></span></a> <div class="right">[ <a href="category/<?php echo $_cate_row['title']?>/"><?php echo $_cate_row['title']?></a> ] เมื่อเวลา <?php echo $func->count_time($data_row['time_update'])?></div></div> 
<?php } ?>
</div>

<?php 
	$hcate = "SELECT * FROM headercate ORDER BY noid DESC";
	$hcate_result = $mydb->runQuery($hcate);
	while($hcate_row = mysqli_fetch_assoc($hcate_result)){
?>
<div class="div-headercate">
<div class="div-headercate-title"> <?php echo $hcate_row['title']?></div>
<div class="div-showHeader">
<div style="margin-left:100px; float:left; width:610px;"><strong>Title</strong></div>
<div style="float:left; width:150px;"><strong>Last Post</strong></div>
<div style="clear:both;"></div>
</div>
<div class="div-showc">
<?php
	$sql = "SELECT * FROM category WHERE hcid = '".$hcate_row['hcid']."' ORDER BY noid DESC";
	$result = $mydb->runQuery($sql);
	if(isset($result))
	{
	while($row = mysqli_fetch_assoc($result)){
	
	$lastd = "SELECT * FROM data WHERE category = '".$row['cid']."' ORDER BY time_update DESC";
	$lastd_result = $mydb->runQuery($lastd);
	$lastd_row = mysqli_fetch_assoc($lastd_result);
	
	$mem = "SELECT * FROM member WHERE mid = '".$lastd_row['upmid']."'";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);
	
	$rank = "SELECT * FROM rank WHERE rid = '".$mem_row['rank']."'";
	$rank_result = $mydb->runQuery($rank);
	$rank_row = mysqli_fetch_assoc($rank_result);
	
	$threads = $mydb->totalCount("did","data","WHERE category = '".$row['cid']."'");
?>
<div class="box">
<div><i class="huge comment icon"></i></div>
<div class="title"><a href="category/<?php echo $row['title']?>/"><?php echo $row['title']?></a>
<div class="description"><?php echo $func->CutStr($row['description'],"300","..."); ?>
</div>
</div>
<div class="div-counter">
<div><?php echo $threads?> กระทู้</div>
</div>
<div class="div-last">
<div>กระทู้ล่าสุด <strong><a href="category/<?php echo $row['title']?>/topic-<?php echo $lastd_row['did']?>.html"><?php echo $func->cutStr($lastd_row['subject'],10,"...")?></a></strong></div>
<div>โดย <a href="profile/<?php echo $mem_row['username']?>.html"><span class="<?php echo $rank_row['rank_css']?>"><?php echo $mem_row['username']?></span></a></div>
<div>เมื่อ <?php echo $func->count_time($lastd_row['time_update'])?></div>
</div>
</div>
<?php
	}
	}
?>
</div>
</div>
<?php
}
?>
<div class="div-banner">
<?php 
	$banner = "SELECT * FROM banner WHERE position = '1' and enable = '1'";
	$banner_result = $mydb->runQuery($banner);
	while($banner_row = mysqli_fetch_assoc($banner_result)){
?>
<div class="boxbanner">
<div class="left item"><a href="http://<?php echo $banner_row['link']?>" target="blank" title="<?php echo $banner_row['title']?>" rel="dofollow"><img src="<?php echo $banner_row['image']?>" width="88" height="31"/></a></div>
<div class="left item">
<div><a href="http://<?php echo $banner_row['link']?>" target="blank" title="<?php echo $banner_row['title']?>" rel="dofollow"><?php echo $banner_row['title']?></a></div>
<div><?php echo $banner_row['description']?></div>
</div>
</div>
<?php } ?>
</div>
<div class="div-stats">
<?php 
	$threads = $mydb->totalCount("did","data","");
	$com = $mydb->totalCount("cid","comment","");
	$_mem = $mydb->totalCount("mid","member","");
	
	$mem = "SELECT * FROM member ORDER BY mid DESC limit 0,1";
	$mem_result = $mydb->runQuery($mem);
	$mem_row = mysqli_fetch_assoc($mem_result);
?>
<div><i class="bar chart basic icon"></i>
<b><?php echo $_row['wsname']?> Statistics</b> 
<div>Thread: <strong><?php echo $threads?></strong> Post: <strong><?php echo $com?></strong> Member: <strong><?php echo $_mem?></strong> ยินดีต้อนรับสมาชิกใหม่ <a href="<?php echo DOMAIN?>/profile/<?php echo $mem_row['username']?>.html"><?php echo $mem_row['username']?></a></div>
</div>
</div>
<div class="div-online"></div>
<div class="div-rankclass">
<?php 
$rank = "SELECT * FROM rank ORDER BY rid ASC";
$rank_result = $mydb->runQuery($rank);
while($rank_row = mysqli_fetch_assoc($rank_result)){
?>
[<span class="<?php echo $rank_row['rank_css']?>"><?php echo $rank_row['rank_name']?></span>]
<?php } ?>
</div>
<div class="footer"><?php if($_row['footer']){ echo $_row['footer']; }?></div>
<?php
}
}
}
?>

</div>
</div>
</div>
<div class="div-footer">

<div><strong>Power By <a href="https://www.facebook.com/profile.php?id=100008460758422">Jimmy Lowrax</a> Copyright © 2013.</strong></div>
</div>
</div>
<div class="ui dimmer page"><div class="ui reg modal transition" style="margin-top: -85px;">
    <i class="close icon"></i>
    <div class="header">
      Register Member
    </div>
    <div class="content">
<div class="ui fluid form ">
	<div class="two fields">
		<div class="field">
			<label><h2>Username</h2></label>
			<input placeholder="" type="text" id="user_reg">
		</div>
		<div class="field">
			<label><h2>Email</h2></label>
			<input placeholder="" type="text" id="email_reg">
		</div>
	</div>
	<div class="two fields">
		<div class="field">
			<label><h2>Password</h2></label>
			<input placeholder="" type="password" id="pass_reg">
		</div>
		<div class="field">
			<label><h2>Re Password</h2></label>
			<input placeholder="" type="password" id="repass_reg">
		</div>
	</div>
  	<div class="small green ui labeled icon button" onclick="Register(); return false">
      <i class="edit sign icon"></i>Register
    </div>
</div>
</div>
</div>
</div>
</body>
</html>
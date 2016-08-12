<!DOCTYPE html>
<?php 
	require("lib/webconfig.php");
	require("lib/function.php");
	session_start();
	date_default_timezone_set('Asia/Bangkok'); 
?>
<html>
<head>
<title>Administrator Control Panel</title>
<meta charset="utf-8" />
<link href='css/semantic.css' rel='stylesheet' />
<link href='css/main.css' rel='stylesheet' />
<link href="http://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="javascript/semantic.min.js"></script>
<script src="javascript/main.js"></script>


<!-- Load WysiBB JS and Theme -->
<script src="http://cdn.wysibb.com/js/jquery.wysibb.min.js"></script>
<link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />
</head>
<body>
<?php if(@$_SESSION['Admin']){?>
<div class="navheader">
<div class="ui inverted red menu">
  		  <div class="right menu">
		<div class="ui dropdown item">
		  Menu<i class="dropdown icon"></i>
		  	<div class="menu ui transition hidden">
				<a class="item" href="index.php">Index</a>
				<a class="item" href="?sec=post-add">Post Add</a>
				<a class="item" href="?sec=post-edit">Post Edit</a>
				<a class="item" href="?sec=menu-add">Menu Add</a>
				<a class="item" href="?sec=menu-edit">Menu Edit</a>
				<a class="item" href="?sec=cate-add">Category Add</a>
				<a class="item" href="?sec=cate-edit">Category Edit</a>
				<a class="item" href="?sec=hcate-add">HeaderCategory Add</a>
				<a class="item" href="?sec=hcate-edit">HeaderCategory Edit</a>
				<a class="item" href="?sec=member-add">Member Add</a>
				<a class="item" href="?sec=member-edit">Member Edit</a>
				<a class="item" href="?sec=banner-add">Banner Add</a>
				<a class="item" href="?sec=banner-edit">Banner Edit</a>
				<a class="item" href="?sec=note">Note</a>
				<a class="item" href="?sec=logout">Logout</a>
			</div>
		</div>
		
	  </div>
</div>
</div>
<div class="data-contain-div">
<div class="data-div left">
<?php 
	@$sec = $_GET['sec'];
	switch($sec)
	{
		case "note":
		$note = $mysqli->query("SELECT * FROM note");
		$note_result = $note->fetch_assoc();
?>
<div class="">
<div class="ui form segment">
	<div class="field">
    	<label><h2><i class="book icon"></i>Note</h2></label>
		<textarea style="height:500px;" placeholder="Text Text Text" id="text"><?php echo $note_result['text'];?></textarea>
	</div>
    <div class="small green ui labeled icon button" onclick="DoSave(); return false">
      <i class="add sign Box icon"></i>
		Save
    </div>
</div>
</div>
<?php
			break;
		case "logout":
			echo "<meta http-equiv='refresh' content='0; url=index.php' />";
			session_destroy();
			break;
		case "post-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>หัวข้อกระทู้</h2></label>
		<input placeholder="bla bla ~~~" type="text" id="title">
	</div>
	<div class="field">
    	<label><h2>รายละเอียด</h2></label>
		<textarea style="height:50px;" placeholder="ลองรับการใช้งาน BBCODE" id="body"></textarea>
	</div>
	<div class="field">
		<label><h2>ประเภท</h2></label>
		<select id="category">
			<?php 
				$category = $mysqli->query("SELECT * FROM category");
				while($cate_result = $category->fetch_assoc()){
			?>
			<option  value="<?php echo $cate_result['cid']?>" selected="selected"><?php echo $cate_result['title']?></option>
			<?php } ?>
		</select>
	</div>
  	<div class="small green ui labeled icon button" onclick="DoPost(); return false">
      <i class="add sign Box icon"></i>
		POST
    </div>
</div>
<?php
			break;
		case "post-edit":
			@$editid = $_GET['edit-id'];
			if($editid)
			{
			$data = $mysqli->query("SELECT * FROM data WHERE did = '$editid'");
			$data_result = $data->fetch_assoc();
?>
<div class="ui form segment">
	<input type="hidden" value="<?php echo $data_result['did'];?>" id="editid" />
	<a href="?sec=post-edit"><span>แก้ไข</span></a> / <?php echo $data_result['subject'];?>
	<div class="field">
		<label><h2>หัวข้อกระทู้</h2></label>
		<input type="text" id="title" value="<?php echo $data_result['subject'];?>">
	</div>
	<div class="field">
    	<label><h2>รายละเอียด</h2></label>
		<textarea id="body"><?php echo $data_result['body'];?></textarea>
	</div>	
	<div class="field">
		<label><h2>ประเภท</h2></label>
		<select id="category">
			<?php 
				$category = $mysqli->query("SELECT * FROM category");
				while($cate_result = $category->fetch_assoc()){
			?>
			<option  value="<?php echo $cate_result['cid']?>" <?php if($data_result['category'] == $cate_result['cid']) echo"selected"; ?>><?php echo $cate_result['title']?></option>
			<?php } ?>
		</select>
	</div>
  	<div class="small black ui labeled icon button" onclick="DoEdit(); return false">
      <i class="edit sign icon"></i>
		แก้ไขกระทู้
    </div>
	<div class="small red ui labeled icon button" onclick="DoDelete(); return false">
      <i class="trash icon"></i>
		ลบกระทู้
    </div>
</div>
<?php
			} else {
			$data = $mysqli->query("SELECT * FROM data ORDER By time_create DESC");
			
?>
<div class="ui segment">
<?php
			while($data_result = $data->fetch_assoc()){
			$_cate = $mysqli->query("SELECT * FROM category WHERE cid = '".$data_result['category']."'");
			$_cate_result = $_cate->fetch_assoc();
?>
<div class="title-div">[</span><a href="?sec=post-edit&edit-id=<?php echo $data_result['did'];?>"><span> แก้ไข</span></a>] <?php echo $data_result['subject'];?> (<?php echo $_cate_result['title']?>)</div>
<?php
			}
			}
?>
</div>
<?php
			break;
		case "menu-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>หัวข้อเมนู</h2></label>
		<input placeholder="bla bla ~~~" type="text" id="title">
	</div>
	<div class="field">
		<label><h2>ลิงค์</h2></label>
		<input placeholder="http://www.google.co.th" type="text" id="link">
	</div>
  	<div class="small green ui labeled icon button" onclick="DoMenuAdd(); return false">
      <i class="add sign Box icon"></i>
		เพิ่มเมนูใหม่
    </div>
</div>
<?php
			break;
		case "menu-edit":
		@$menuid = $_GET['menu-id'];
		if($menuid)
		{
			$menu = $mysqli->query("SELECT * FROM menu WHERE mid='$menuid'");
			$menu_result = $menu->fetch_assoc();
?>
<div class="ui form segment">
	<input type="hidden" value="<?php echo $menu_result['mid'];?>" id="menuid" />
	<div class="field">
		<label><h2>หัวข้อเมนู</h2></label>
		<input type="text" id="title" value="<?php echo $menu_result['text']?>">
	</div>
	<div class="field">
		<label><h2>ลิงค์</h2></label>
		<input type="text" id="link" value="<?php echo $menu_result['link']?>">
	</div>
    <div class="small black ui labeled icon button" onclick="DoMenuEdit(); return false">
      <i class="edit sign icon"></i>
		แก้ไข
    </div>
	<div class="small red ui labeled icon button" onclick="DoMenuDelete(); return false">
      <i class="trash icon"></i>
		ลบ
    </div>
</div>
<?php
		} else {
		$menu = $mysqli->query("SELECT * FROM menu");
?>
<div class="ui segment">
<?php
		while($menu_result = $menu->fetch_assoc()){
?>
<div class="menu-title-div">
<span>[</span><a href="?sec=menu-edit&menu-id=<?php echo $menu_result['mid'];?>"><span> แก้ไข</span></a>] <?php echo protect_hack($menu_result['text']);?> - <?php echo protect_hack($menu_result['link']);?></span>
</div>
<?php
		}
		}
?>
</div>
<?php
			break;
		case "cate-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>หัวข้อประเภท</h2></label>
		<input type="text" id="title">
	</div>
	<div class="field">
		<label><h2>รายละเอียดประเภท</h2></label>
		<input type="text" id="desc">
	</div>
	<div class="field">
		<label><h2>HeaderCategory</h2></label>
		<select id="headercate">
			<?php 
				$hcate = $mysqli->query("SELECT * FROM headercate");
				while($hcate_result = $hcate->fetch_assoc()){
			?>
			<option  value="<?php echo $hcate_result['hcid']?>"><?php echo $hcate_result['title']?></option>
			<?php } ?>
		</select>
	</div>
  	<div class="small green ui labeled icon button" onclick="DoCateAdd(); return false">
      <i class="add sign Box icon"></i>
		เพิ่มหัวข้อใหม่
    </div>
</div>
<?php
			break;
		case "cate-edit":
		@$cid = $_GET['cate-id'];
		if($cid)
		{
			$cate = $mysqli->query("SELECT * FROM category WHERE cid = '$cid'");
			$cate_result = $cate->fetch_assoc();
?>
<div class="ui form segment">
	<div class="field">
		<input id="cid" type="hidden" value="<?php echo $cate_result['cid']?>"></input>
		<label><h2>หัวข้อประเภท</h2></label>
		<input placeholder="VB.NET" type="text" id="title" value="<?php echo $cate_result['title']?>">
	</div>
	<div class="field">
		<label><h2>รายละเอียดประเภท</h2></label>
		<input placeholder="Programing" type="text" id="desc" value="<?php echo $cate_result['description']?>">
	</div>
	<div class="field">
		<label><h2>HeaderCategory</h2></label>
		<select id="headercate">
		<?php 
			$hcate = $mysqli->query("SELECT * FROM headercate ORDER BY hcid DESC");
			while($hcate_result = $hcate->fetch_assoc()){
		?>
		<option value="<?php echo $hcate_result['hcid']?>" <?php if($cate_result['hcid'] == $hcate_result['hcid']){ echo "selected='selected'"; }?>><?php echo $hcate_result['title']?></option>
		<?php } ?>
		</select>
	</div>
	
  	<div class="small black ui labeled icon button" onclick="DoCateEdit(); return false">
      <i class="edit sign icon"></i>
		แก้ไข
    </div>
	<div class="small red ui labeled icon button" onclick="DoCateDelete(); return false">
      <i class="trash icon"></i>
		ลบ
    </div>
</div>
<?php
		} else {
		$cate = $mysqli->query("SELECT * FROM category");
?>
<div class="ui segment">
<?php
		while($cate_result = $cate->fetch_assoc()){
?>
<div class="menu-title-div">
<span>[</span><a href="?sec=cate-edit&cate-id=<?php echo $cate_result['cid'];?>"><span> แก้ไข</span></a>] <?php echo protect_hack($cate_result['title']);?> - <?php echo protect_hack($cate_result['description']);?></span>
</div>
<?php
		}
		}
?>
</div>
<?php
			break;
			case "hcate-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>หัวข้อประเภท</h2></label>
		<input type="text" id="title">
	</div>
  	<div class="small green ui labeled icon button" onclick="DoHCateAdd(); return false">
      <i class="add sign Box icon"></i>
		เพิ่มหัวข้อใหม่
    </div>
</div>
<?php
			break;
			case "hcate-edit":
			@$hcid = $_GET['hcid'];
			if($hcid){
				$hcate = $mysqli->query("SELECT * FROM headercate WHERE hcid = '".$hcid."'");
				$hcate_result = $hcate->fetch_assoc();
?>
			<div class="ui form segment">
				<div class="field">
					<input id="hcid" type="hidden" value="<?php echo $hcate_result['hcid']?>"></input>
					<label><h2>หัวข้อประเภท</h2></label>
					<input type="text" id="title" value="<?php echo $hcate_result['title']?>">
				</div>
				  	<div class="small black ui labeled icon button" onclick="DoHCateEdit(); return false">
					  <i class="edit sign icon"></i>
						แก้ไข
					</div>
					<div class="small red ui labeled icon button" onclick="DoHCateDelete(); return false">
					  <i class="trash icon"></i>
						ลบ
					</div>
			</div>
<?php
			} else {
			$hcate = $mysqli->query("SELECT * FROM headercate");
?>
<div class="ui segment">
<?php
			while($hcate_result = $hcate->fetch_assoc()){
?>
			<div class="title-div"><span>[</span><a href="?sec=hcate-edit&hcid=<?php echo $hcate_result['hcid'];?>"><span> แก้ไข</span></a>] <?php echo protect_hack($hcate_result['title'])?></span></div>
<?php
			} 
			}
?>
</div>
<?php
			break;
			case "member-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>Username</h2></label>
		<input placeholder="" type="text" id="user_reg">
	</div>
	<div class="field">
		<label><h2>Email</h2></label>
		<input placeholder="" type="text" id="email_reg">
	</div>
	<div class="field">
		<label><h2>Password</h2></label>
		<input placeholder="" type="password" id="pass_reg">
	</div>
	<div class="field">
		<label><h2>Re Password</h2></label>
		<input placeholder="" type="password" id="repass_reg">
	</div>
  	<div class="small green ui labeled icon button" onclick="DoMemRegister(); return false">
      <i class="edit sign icon"></i>Register
    </div>
</div>
<?php
			break;
			case "member-edit":
			@$mid = $_GET['mid'];
			if($mid){
			$mem = $mysqli->query("SELECT * FROM member WHERE mid = '".$mid."'");
			$mem_result = $mem->fetch_assoc();
?>
<div class="ui form segment">
	<div class="field">
		<input id="mid" type="hidden" value="<?php echo $mem_result['mid']?>"></input>
		<label><h2>Username</h2></label>
		<input type="text" id="user" value="<?php echo $mem_result['username']?>">
	</div>
	<div class="field">
		<label><h2>Email</h2></label>
		<input type="text" id="email" value="<?php echo $mem_result['email']?>">
	</div>
	<div class="field">
		<label><h2>Rank</h2></label>
		<select id="rid">
		<?php 
			$rank = $mysqli->query("SELECT * FROM rank ORDER BY rid DESC");
			while($rank_result = $rank->fetch_assoc()){
		?>
		<option value="<?php echo $rank_result['rid']?>" <?php if($mem_result['rank'] == $rank_result['rid']){ echo "selected='selected'"; }?>><?php echo $rank_result['rank_name']?></option>
		<?php } ?>
		</select>
	</div>
	<div class="field">
		<label><h2>Password</h2></label>
		<input type="password" id="pass">
	</div>
	<div class="field">
		<label><h2>Re Password</h2></label>
		<input type="password" id="repass">
	</div>
	<div class="field">
		<label><h2>Signature</h2></label>
		<textarea id="body" placeholder="ลองรับการใช้งาน BBCODE"><?php echo $mem_result['signature']?></textarea>
	</div>
	<div class="small black ui labeled icon button" onclick="DoMemEdit(); return false">
	<i class="edit sign icon"></i>
		แก้ไข
	</div>
	<div class="small red ui labeled icon button" onclick="DoMemDelete(); return false">
	<i class="trash icon"></i>
		ลบ
	</div>
</div>
<?php
			} else {
			$mem = $mysqli->query("SELECT * FROM member ORDER BY mid DESC");
?>
<div class="ui segment">
<?php
			while($mem_result = $mem->fetch_assoc()){
?>
			<div class="title-div"><span>[</span><a href="?sec=member-edit&mid=<?php echo $mem_result['mid'];?>"><span> แก้ไข</span></a>] [<?php echo $mem_result['mid']?>] <?php echo protect_hack($mem_result['username'])?></span></div>
<?php
			} 
			}
?>
</div>
<?php
			break;
			case "banner-add":
?>
<div class="ui form segment">
	<div class="field">
		<label><h2>Title</h2></label>
		<input placeholder="" type="text" id="title">
	</div>
	<div class="field">
		<label><h2>Url Link</h2></label>
		<input placeholder="" type="text" id="link">
	</div>
	<div class="field">
		<label><h2>Image</h2></label>
		<input placeholder="" type="text" id="image">
	</div>
	<div class="field">
		<label><h2>Description</h2></label>
		<input placeholder="" type="text" id="desc">
	</div>
	<div class="field">
		<label><h2>Position</h2></label>
		<select id="pos">
			<option value="0">ด้านบน</option>
			<option value="1">ด้านล่าง</option>
		</select>
	</div>
  	<div class="small green ui labeled icon button" onclick="DoBanAdd(); return false">
      <i class="edit sign icon"></i>เพิ่ม
    </div>
</div>
<?php
			break;
			case "banner-edit":
				@$bid = $_GET['bid'];
				if($bid){
				$banner = $mysqli->query("SELECT * FROM banner WHERE bid = '".$bid."'");
				$banner_result = $banner->fetch_assoc();
?>
<div class="ui form segment">
	<div class="field">
		<input id="bid" type="hidden" value="<?php echo $banner_result['bid']?>"></input>
		<label><h2>Title</h2></label>
		<input placeholder="" type="text" id="title" value="<?php echo $banner_result['title']?>">
	</div>
	<div class="field">
		<label><h2>Url Link</h2></label>
		<input placeholder="" type="text" id="link" value="<?php echo $banner_result['link']?>">
	</div>
	<div class="field">
		<label><h2>Image</h2></label>
		<input placeholder="" type="text" id="image" value="<?php echo $banner_result['image']?>">
	</div>
	<div class="field">
		<label><h2>Description</h2></label>
		<input placeholder="" type="text" id="desc" value="<?php echo $banner_result['description']?>">
	</div>
	<div class="field">
		<label><h2>Position</h2></label>
		<select id="pos">
			<option value="0" <?php if($banner_result['position'] == 0){ echo "selected='selected'";}?>>ด้านบน</option>
			<option value="1" <?php if($banner_result['position'] == 1){ echo "selected='selected'";}?>>ด้านล่าง</option>
		</select>
	</div>
  	<div class="small black ui labeled icon button" onclick="DoBanEdit(); return false">
	<i class="edit sign icon"></i>
		แก้ไข
	</div>
	<div class="small red ui labeled icon button" onclick="DoBanDelete(); return false">
	<i class="trash icon"></i>
		ลบ
	</div>
</div>
<?php
			} else {
			$banner = $mysqli->query("SELECT * FROM banner ORDER BY bid DESC");
?>
<div class="ui segment">
<?php
			while($banner_result = $banner->fetch_assoc()){
?>
			<div class="title-div"><span>[</span><a href="?sec=banner-edit&bid=<?php echo $banner_result['bid'];?>"><span> แก้ไข </span></a>] [<?php echo $banner_result['bid']?>] <?php echo $banner_result['title']?> <?php if($banner_result['position'] == 0){ echo "ด้านบน"; } else {  echo "ด้านล่าง"; }?></span></div>
<?php
			} 
			}
?>
</div>
<?php
			break;
			default:
?>
<?php 
	$info = $mysqli->query("SELECT * FROM info");
	$info_result = $info->fetch_assoc();
?>
<div class="status-div">
<div class="ui form segment">
	<div class="field">
		<label><h2><i class="info basic icon"></i>ข้อมูลเว็บไซต์</h2></label>
<div class="ui form">
  <div class="field">
    <label>Website Name</label>
    <input type="text" id="website" value="<?php echo $info_result['wsname']?>">
  </div>
</div>
<div class="ui form">
  <div class="field">
    <label>Image</label>
    <input type="text" id="image" value="<?php echo $info_result['image']?>">
  </div>
</div>
<div class="ui form">
  <div class="field">
    <label>Keyword</label>
    <input type="text" id="keyword" value="<?php echo $info_result['keyword']?>">
  </div>
</div>
<div class="ui form">
  <div class="field">
    <label>Meta</label>
    <textarea style="height:50px;" id="meta"><?php echo $info_result['meta']?></textarea>
  </div>
</div>
<div class="ui form">
  <div class="field">
    <label>Description</label>
    <textarea style="height:50px;" id="description"><?php echo $info_result['description']?></textarea>
  </div>
</div>
<div class="ui form">
  <div class="field">
    <label>Footer</label>
    <textarea style="height:50px;" id="footer"><?php echo $info_result['footer']?></textarea>
  </div>
</div>
	<div class="small green ui labeled icon button" onclick="InfoUp(); return false">
    <i class="ok sign icon"></i>
	บันทึก
</div>
	</div>
</div>
</div>
<div class="status-div">
<div class="ui form segment">
	<div class="field">
		<label><h2><i class="tasks icon"></i>Last Post</h2></label>
		<div>
		<?php 
			$lst = $mysqli->query("SELECT * FROM data ORDER BY time_create DESC limit 0,5");
			while($lst_result = $lst->fetch_assoc()){
		?>
			<div><span><?php echo $lst_result['subject'];?> - <?php echo count_time($lst_result['time_create']);?></span></div>
			<?php } ?>
		</div>
	</div>
	<div class="field">
		<?php 
			$daynow = date("Y-m-d"); 
			$num_row = $mysqli->query("SELECT DISTINCT * FROM logip WHERE time_view = '$daynow'");
			$num_result = $num_row->num_rows;
		?>
		<label><h2><i class="signal icon"></i>WebPage View Today(<?php echo $num_result?>)</h2></label>
		<div>
		<?php 
			$log = $mysqli->query("SELECT DISTINCT * FROM logip WHERE time_view = '$daynow'");
			while($log_result = $log->fetch_assoc()){
		?>
			<span><?php echo $log_result['ipaddress']?></span></br>
		<?php } ?>
		</div>
	</div>
</div>
</div>
<?php
			break;
	}
?>
</div>
</div>
<?php } else { ?>
<div class="div-login">
<div class="login-div">
<div class="ui form">
	<div class="field">
		<center><i class="circular lock massive icon"></i></center>
	</div>
	<div class="field">
		<input placeholder="Username" type="text" id="user">
	</div>
	<div class="field">
		<input placeholder="Password" type="password" id="pass">
	</div>
    <div class="small green ui labeled icon button" onclick="DoLogin(); return false">
    <i class="lock icon"></i>
    Login
    </div>
</div>
</div>
</div>
<?php } ?>
</body>
</html>

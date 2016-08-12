<?php
	require("lib/webconfig.php");
	session_start();
	date_default_timezone_set('Asia/Bangkok');
	
	$now = date("Y-m-d H:i:s");
	
	$member = $mysqli->query("SELECT * FROM member WHERE username = '".@$_SESSION['user']."' and password = '".@$_SESSION['pass']."'");
	$member_result = $member->fetch_assoc();
	
	@$at = $_POST['action'];
	if($at == "memlog"){
		$user = $mysqli->real_escape_string($_POST['user']);
		$pass = $mysqli->real_escape_string($_POST['pass']);
		
		$login = $mysqli->query("SELECT * FROM member WHERE username = '".$user."' and password = md5('".$pass."')");
		$login_result = $login->fetch_assoc();
		
		if($login_result)
		{
			$_SESSION['Login'] = true;
			$_SESSION['user'] = $login_result['username'];
			$_SESSION['pass'] = $login_result['password'];
			echo "Login Sucessed!";
			$islog = $mysqli->query("UPDATE member SET islogin = '1' WHERE mid = '".$login_result['mid']."'");
		} else {
			echo "Username or Password Incorrect. " . $mysqli->error;
		}
	}
	if($at == "memlogout"){
		session_destroy();
		$islog = $mysqli->query("UPDATE member SET islogin = '0' WHERE mid = '".$member_result['mid']."'");
	}
	if($at == "login")
	{
		$user = $mysqli->real_escape_string($_POST['user']);
		$pass = $mysqli->real_escape_string($_POST['pass']);
			
		if($user == "admin00" && $pass == "admin")
		{
			$_SESSION['Admin'] = true;
		}
	}
	if($at == "register")
	{
		$user = $mysqli->real_escape_string($_POST['user']);
		$pass = $mysqli->real_escape_string($_POST['pass']);
		$repass = $mysqli->real_escape_string($_POST['repass']);
		$email = $mysqli->real_escape_string($_POST['email']);
		
		$ucount = strlen($user);
		$pcount = strlen($pass);
		
		$chkmem = $mysqli->query("SELECT * FROM member WHERE username = '".$user."'");
		$chkmem_result = $chkmem->fetch_assoc();
		if($user == "" && $pass == "" && $repass == "" && $email == "")
		{
			return false;
		}
		if($ucount <= 6)
		{
			echo "กรุณากรอง Username ให้มากกว่า 6 ตัว";
			return false;
		}
		if($pcount <= 6)
		{
			echo "กรุณากรอง Password ให้มากกว่า 6 ตัว";
			return false;
		}
		if($repass == $pass)
		{
			if($chkmem_result){
				echo "ข้อมูลซ้ำกับในระบบกรุณาลองใหม่";
			} else {	
				$reg = $mysqli->query("INSERT INTO member (username,password,email,avatar,rank) VALUES ('".$user."',md5('".$pass."'),'".$email."','http://www.allcongress.com/wp-content/themes/twentyten/images/default_avatar.jpg','3')");
				if($reg)
				{
					echo "Register Sucessed.";
				}
			}	
		} else {
			echo "Password ไม่ตรงกัน";
		}
		
	}
	if(@$_SESSION['Login']){
		if($at == "repm"){
			$msg = $_POST['msg'];
			$toid = $_POST['toid'];
			$pmid = $_POST['pmid'];
			$insert = $mysqli->query("INSERT INTO repm (pmid,to_id,form_id,message) VALUES ('".$pmid."','".$toid."','".$member_result['mid']."','".$msg."')");
			$update = $mysqli->query("UPDATE pm SET timeupdate = '".$now."' , to_read = '0' , form_read = '0' WHERE pmid = '".$pmid."'");
			if($insert){
				echo "ส่งข้อความสำเร็จ";
			} else {
				echo "ส่งข้อความไม่สำเร็จ" . $mysqli->error;
			}
		}
		if($at == "pm"){
		
			$title = $_POST['title'];
			$msg = $_POST['msg'];
			$user = $_POST['user'];
			$to = $mysqli->query("SELECT * FROM member WHERE username ='".$user."'");
			$to_result = $to->fetch_assoc();
			
			$insert = $mysqli->query("INSERT INTO pm (title,to_id,form_id,message,timeupdate) VALUES ('".$title."','".$to_result['mid']."','".$member_result['mid']."','".$msg."','".$now."')");
			if($insert){
				echo "ส่งข้อความสำเร็จ";
			} else {
				echo "ส่งข้อความไม่สำเร็จ" . $mysqli->error;
			}
		}
		if($at == "com")
		{
			$body = $_POST['body'];
			$did = $_POST['did'];

			if($body == "")
			{
					
			} else {
				$insert = $mysqli->query("INSERT INTO comment (body,did,mid) VALUES ('".$body."','".$did."','".$member_result['mid']."')");
				$update = $mysqli->query("UPDATE data SET time_update = '".$now."' , upmid = '".$member_result['mid']."' WHERE did = '".$did."'");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "mempost")
		{
			$title = $_POST['title'];
			$body = $_POST['body'];
			$category = $_POST['category'];
			
			$ip = $_SERVER['REMOTE_ADDR'];
			if($title == "" || $body == "")
			{
					
			} else {
				$insert = $mysqli->query("INSERT INTO data (subject,body,category,time_update,mid,upmid) VALUES ('".$title."','".$body."','".$category."','".$now."','".$member_result['mid']."','".$member_result['mid']."')");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "memedit")
		{
			$image = $_POST['image'];
			$website = $_POST['website'];
			$skype = $_POST['skype'];
			$facebook = $_POST['facebook'];
			$line = $_POST['line'];
			$signature = $_POST['signature'];
			$location = $_POST['location'];
			
			if($image == "")
			{
				return false;
			} else {
				$update = $mysqli->query("UPDATE member SET avatar = '".$image."' , website = '".$website."' , skype = '".$skype."' , facebook = '".$facebook."' , line = '".$line."' , signature = '".$signature."' , location = '".$location."' WHERE mid = '".$member_result['mid']."'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "memeditpost")
		{
			$body = $_POST['body'];
			$did = $_POST['did'];
			
			$data = $mysqli->query("SELECT * FROM data WHERE did = '".$did."'");
			$data_result = $data->fetch_assoc();
			
			if($data_result['mid'] == $member_result['mid']){
				$update = $mysqli->query("UPDATE data SET body = '".$body."' WHERE did = '".$did."'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}	
			}
		}
		if($at == "changepass")
		{
			$oldpass = $_POST['oldpass'];
			$newpass = $_POST['newpass'];
			$renewpass = $_POST['renewpass'];
			
			$oldpassc = strlen($oldpass);
			$newpassc = strlen($newpass);
			$renewpassc = strlen($renewpass);
			
			if($oldpassc < 6){
				echo "กรุณากรองรหัสผ่านเก่ามากว่า 6 ตัว";
				return false;
			}
			if($newpassc < 6){
				echo "กรุณากรองรหัสผ่านใหม่มากว่า 6 ตัว";
				return false;
			}
			if($renewpassc < 6){
				echo "กรุณากรองยืนยันรหัสผ่านใหม่มากว่า 6 ตัว";
				return false;
			}
			
			if(md5($oldpass) == $member_result['password'])
			{
				if($newpass == $renewpass)
				{
					$update = $mysqli->query("UPDATE member SET password = md5('".$newpass."') WHERE mid = '".$member_result['mid']."'");
					if($update){
						echo "เปลี่ยนรหัสผ่านสำเร็จ. \nกรุณาทำการล็อกอินใหม่.";
						session_destroy();
					} else {
						echo "เปลี่ยนรหัสผ่านไม่สำเร็จ " . $mysqli->error;
					}
				}
			} else {
				echo "รหัสผ่านไม่ตรงกับของเก่า";
			}
		}
	}
	if(@$_SESSION['Admin'])
	{
		if($at == "menuadd")
		{
			$title = $_POST['title'];
			$link = $_POST['link'];
			if($title == "" || $link == "")
			{
				
			} else {
				$insert = $mysqli->query("INSERT INTO menu (text,link) VALUES ('$title','$link')");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "menuedit")
		{
			$title = $_POST['title'];
			$link = $_POST['link'];
			$menuid = $_POST['menuid'];
			if($title == "" || $link == "")
			{
				
			} else {
				$update = $mysqli->query("UPDATE menu set text='$title', link='$link' WHERE mid='$menuid'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "menudelete")
		{
			$id = $_POST['id'];
			$delete = $mysqli->query("DELETE FROM menu WHERE mid='$id'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "edit")
		{
			$title = $_POST['title'];
			$body = $_POST['body'];
			$editid = $_POST['editid'];
			$category = $_POST['category'];
			
			if($title == "" || $body == "")
			{
				
			} else {
				$update = $mysqli->query("UPDATE data SET subject='".$title."' , body='".$body."' , category = '".$category."' WHERE did='".$editid."'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error.";
				}
			}
		}
		if($at == "delete")
		{
			$id = $_POST['id'];
			$delete = $mysqli->query("DELETE FROM data WHERE did='$id'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "post")
		{
			$title = $_POST['title'];
			$body = $_POST['body'];
			$category = $_POST['category'];
			
			$ip = $_SERVER['REMOTE_ADDR'];
			if($title == "" || $body == "")
			{
				
			} else {
				$insert = $mysqli->query("INSERT INTO data (subject,body,category,time_update,mid,upmid) VALUES ('".$title."','".$body."','".$category."','".$now."','1','1')");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error";
				}
			}
		}
		if($at == "cateadd")
		{
			$title = $_POST['title'];
			$desc = $_POST['desc'];
			$hcid = $_POST['hcid'];
			if($title == "" || $desc == "")
			{
			
			} else {
				$insert = $mysqli->query("INSERT INTO category (title,description,hcid) VALUES ('".$title."','".$desc."','".$hcid."')");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error";
				}
			}
		}
		if($at == "cateedit")
		{
			$title = $_POST['title'];
			$desc = $_POST['desc'];
			$cid = $_POST['cid'];
			$hcid = $_POST['hcid'];
			
			if($title == "" || $desc == "")
			{
			
			} else {
				$update = $mysqli->query("UPDATE category SET title='".$title."' , description='".$desc."' , hcid='".$hcid."'  WHERE cid = '$cid'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error";
				}
			}
		}
		if($at == "catedelete")
		{
			$id = $_POST['id'];
			$delete = $mysqli->query("DELETE FROM category WHERE cid='$id'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "hcateadd")
		{
			$title = $_POST['title'];
			
			if($title == "")
			{
			
			} else {
				$insert = $mysqli->query("INSERT INTO headercate (title) VALUES ('".$title."')");
				if($insert)
				{
					echo "Sucessed.";
				} else {
					echo "Error";
				}
			}
		}
		if($at == "hcateedit")
		{
			$title = $_POST['title'];
			$hcid = $_POST['hcid'];
			
			if($title == "")
			{
			
			} else {
				$update = $mysqli->query("UPDATE headercate SET title='".$title."' WHERE hcid='".$hcid."'");
				if($update)
				{
					echo "Sucessed.";
				} else {
					echo "Error" . $mysqli->error;
				}
			}
		}
		if($at == "hcatedelete")
		{
			$id = $_POST['hcid'];
			$delete = $mysqli->query("DELETE FROM headercate WHERE hcid='".$id."'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "save")
		{
			$text = $_POST['text'];
			$note = $mysqli->query("SELECT * FROM note");
			$note_result = $note->fetch_assoc();
			if($note_result['text'])
			{
				$update = $mysqli->query("UPDATE note SET text = '$text'");
			} else {
				$insert = $mysqli->query("INSERT INTO note (text) VALUES ('$text')");
			}
			
		}
		if($at == "delcom")
		{
			$cid = $_POST['cid'];
			$delete = $mysqli->query("DELETE FROM comment WHERE cid = '$cid'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "admemedit"){
			$user = $mysqli->real_escape_string($_POST['user']);
			$pass = $mysqli->real_escape_string($_POST['pass']);
			$repass = $mysqli->real_escape_string($_POST['repass']);
			$email = $mysqli->real_escape_string($_POST['email']);
			$rid = $mysqli->real_escape_string($_POST['rid']);
			$mid = $mysqli->real_escape_string($_POST['mid']);
			$signature = $mysqli->real_escape_string($_POST['signature']);
			
			$ucount = strlen($user);
			$pcount = strlen($pass);
			
			if($ucount <= 6)
			{
				echo "กรุณากรอง Username ให้มากกว่า 6 ตัว";
				return false;
			}
			
			if($pass){
				if($pcount <= 6)
				{
					echo "กรุณากรอง Password ให้มากกว่า 6 ตัว";
					return false;
				}
				if($repass == $pass)
				{
					$update = $mysqli->query("UPDATE member SET username = '".$user."' , password = md5('".$pass."') , email = '".$email."' , rank = '".$rid."' , signature = '".$signature."' WHERE mid = '".$mid."'");
					if($update){
							echo "แก้ไขสมาชิกสำเร็จ";
					} else {
							echo "Error" . $mysqli->error;
					}
				} else {
					echo "Password ไม่ตรงกัน";
				}
			} else {
				$update = $mysqli->query("UPDATE member SET username = '".$user."' , email = '".$email."' , rank = '".$rid."' , signature = '".$signature."' WHERE mid = '".$mid."'");
				if($update){
						echo "แก้ไขสมาชิกสำเร็จ";
				} else {
						echo "Error" . $mysqli->error;
				}
			}
		}
		if($at == "banadd"){
			$title = $_POST['title'];
			$link = $_POST['link'];
			$image = $_POST['image'];
			$pos = $_POST['pos'];
			$desc = $_POST['desc'];
			
			$insert = $mysqli->query("INSERT INTO banner (title,link,image,position,enable,description) VALUES ('".$title."','".$link."','".$image."','".$pos."','1','".$desc."')");
			if($insert){
				echo "เพิ่มแบนเนอร์ใหม่สำเร็จ";
			} else {
				echo "Error" . $mysqli->error;
			}
		}
		if($at == "banedit"){
			$title = $_POST['title'];
			$link = $_POST['link'];
			$image = $_POST['image'];
			$pos = $_POST['pos'];
			$bid = $_POST['bid'];
			$desc = $_POST['desc'];
			
			$update = $mysqli->query("UPDATE banner SET title = '".$title."' , link = '".$link."' , image = '".$image."' , position = '".$pos."' , description = '".$desc."' WHERE bid = '".$bid."'");
			if($update){
				echo "แก้ไขแบนเนอร์สำเร็จ";
			} else {
				echo "Error" . $mysqli->error;
			}
		}
		if($at == "bandelete")
		{
			$bid = $_POST['bid'];
			$delete = $mysqli->query("DELETE FROM banner WHERE bid = '".$bid."'");
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error" . $mysqli->error;
			}
		}
		if($at == "admemdelete")
		{
			$mid = $_POST['mid'];
			$delete = $mysqli->query("DELETE FROM member WHERE mid = '".$mid."'");
			$mem_delete = $mysqli->query("DELETE FROM data WHERE mid = '".$mid."'");
			
			if($delete)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
		if($at == "infoup")
		{
			$title = $_POST['title'];
			$img = $_POST['img'];
			$keyword = $_POST['keyword'];
			$desc = $_POST['desc'];
			$meta = $_POST['meta'];
			$footer = $_POST['footer'];
			$contact = "support@includ.org";
			
			$update = $mysqli->query("UPDATE info SET wsname = '".$title."' , image = '".$img."' , keyword = '".$keyword."' , meta = '".$meta."' , description = '".$desc."' , contact = '".$contact."' , footer = '".$footer."'");
			if($update)
			{
				echo "Sucessed.";
			} else {
				echo "Error.";
			}
		}
	}
?>

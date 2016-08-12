$(document).ready(function(){
	$("#body").wysibb();
	
	$('.ui.dropdown')
	  .dropdown()
	;
});
function DoPost()
{
	var title = $("#title").val();
	var body = $("#body").bbcode();
	
	var ampc = body.split("&").length - 1;
	
	for(i = 0;i<=ampc;i++){
		body = body.replace("&","%26");
	}
	
	var form = $("#form").val();
	var tags = $("#tags").val();
	var category = $("#category").val();
	var desc = $("#desc").val();
	var image = $("#image").val();
	var category = $("#category").val();
	
	if(title == "")
	{
		alert("กรุณากรองหัวข้อกระทู้");
		return false
	}
	if(body == "")
	{
		alert("กรุณากรองรายละเอียด");
		return false
	}
	var datastring = "action=post&title="+title+"&body="+body+"&tags="+tags+"&desc="+desc+"&category="+category+"&image="+image;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoEdit()
{
	var title = $("#title").val();
	var body = $("#body").bbcode();
	
	var ampc = body.split("&").length - 1;
	
	for(i = 0;i<=ampc;i++){
		body = body.replace("&","%26");
	}
	
	var form = $("#form").val();
	var tags = $("#tags").val();
	var category = $("#category").val();
	var editid = $("#editid").val();
	var desc = $("#desc").val();
	var category = $("#category").val();
	var image = $("#image").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อกระทู้");
		return false
	}
	if(body == "")
	{
		alert("กรุณากรองรายละเอียด");
		return false
	}
	var datastring = "action=edit&title="+title+"&body="+body+"&tags="+tags+"&desc="+desc+"&category="+category+"&image="+image+"&editid="+editid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoDelete()
{
	var id = $("#editid").val();
	var datastring = "action=delete&id="+id;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.href = "index.php?sec=post-edit";
		}
	});
}
function DoMenuAdd()
{
	var title = $("#title").val();
	var link = $("#link").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อเมนู");
		return false
	}
	if(link == "")
	{
		alert("กรุณากรองลิงค์");
		return false
	}
	var datastring = "action=menuadd&title="+title+"&link="+link;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoMenuEdit()
{
	var title = $("#title").val();
	var link = $("#link").val();
	var menuid = $("#menuid").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อเมนู");
		return false
	}
	if(link == "")
	{
		alert("กรุณากรองลิงค์");
		return false
	}
	var datastring = "action=menuedit&title="+title+"&link="+link+"&menuid="+menuid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoMenuDelete()
{
	var id = $("#menuid").val();
	var datastring = "action=menudelete&id="+id;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.href = "index.php?sec=menu-edit";
		}
	});
}
function DoCateAdd()
{
	var title = $("#title").val();
	var desc = $("#desc").val();
	var hcid = $("#headercate").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อประเภท");
		return false
	}
	if(desc == "")
	{
		alert("กรุณากรองรายละเอียด");
		return false
	}
	var datastring = "action=cateadd&title="+title+"&desc="+desc+"&hcid="+hcid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoCateEdit()
{
	var title = $("#title").val();
	var desc = $("#desc").val();
	var cid = $("#cid").val();
	var hcid = $("#headercate").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อประเภท");
		return false
	}
	if(desc == "")
	{
		alert("กรุณากรองรายละเอียด");
		return false
	}
	var datastring = "action=cateedit&title="+title+"&desc="+desc+"&cid="+cid+"&hcid="+hcid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoCateDelete()
{
	var cid = $("#cid").val();
	var datastring = "action=catedelete&id="+cid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.href = "index.php?sec=cate-edit";
		}
	});
}
function DoHCateAdd()
{
	var title = $("#title").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อประเภท");
		return false
	}
	var datastring = "action=hcateadd&title="+title;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoHCateEdit()
{
	var title = $("#title").val();
	var hcid = $("#hcid").val();
	if(title == "")
	{
		alert("กรุณากรองหัวข้อประเภท");
		return false
	}
	var datastring = "action=hcateedit&title="+title+"&hcid="+hcid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoHCateDelete()
{
	var hcid = $("#hcid").val();
	var datastring = "action=hcatedelete&hcid="+hcid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoMemRegister()
{
	var user = $("#user_reg").val();
	var pass = $("#pass_reg").val();
	var repass = $("#repass_reg").val();
	var email = $("#email_reg").val();
	
	if(user == "")
	{
		return false
	}
	if(pass == "")
	{
		return false
	}
	if(repass == "")
	{
		return false
	}
	if(email == "")
	{
		return false
	}
	
	var datastring = "action=register&user="+user+"&pass="+pass+"&repass="+repass+"&email="+email;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});	
}
function DoMemEdit()
{
	var user = $("#user").val();
	var pass = $("#pass").val();
	var repass = $("#repass").val();
	var email = $("#email").val();
	var rid = $("#rid").val();
	var mid = $("#mid").val();
	var body = $("#body").bbcode();
	
	if(user == "")
	{
		return false
	}
	if(email == "")
	{
		return false
	}
	
	var datastring = "action=admemedit&user="+user+"&pass="+pass+"&repass="+repass+"&email="+email+"&signature="+body+"&rid="+rid+"&mid="+mid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});	
}
function DoMemDelete()
{
	var mid = $("#mid").val();
	var datastring = "action=admemdelete&mid="+mid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoBanAdd()
{
	var title = $("#title").val();
	var link = $("#link").val();
	var image = $("#image").val();
	var pos = $("#pos").val();
	var desc = $("#desc").val();
	
	var datastring = "action=banadd&title="+title+"&link="+link+"&image="+image+"&pos="+pos+"&desc="+desc;

	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoBanEdit()
{
	var title = $("#title").val();
	var link = $("#link").val();
	var image = $("#image").val();
	var pos = $("#pos").val();
	var bid = $("#bid").val();
	var desc = $("#desc").val();
	var datastring = "action=banedit&title="+title+"&link="+link+"&image="+image+"&pos="+pos+"&desc="+desc+"&bid="+bid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoBanDelete()
{
	var bid = $("#bid").val();
	var datastring = "action=bandelete&bid="+bid;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}
function DoLogin()
{
	var user = $("#user").val();
	var pass = $("#pass").val();
	if(user== "")
	{
		alert("Username");
		return false
	}
	if(pass == "")
	{
		alert("Password");
		return false
	}
	var datastring = "action=login&user="+user+"&pass="+pass;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			location.reload();
		}
	});
}
function DoSave()
{
	var text = $("#text").val();
	var datastring = "action=save&text="+text;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			location.reload();
		}
	});
}
function InfoUp()
{
	var title = $("#website").val();
	var img = $("#image").val();
	var keyword = $("#keyword").val();
	var meta = $("#meta").val();
	var description = $("#description").val();
	var footer = $("#footer").val();
	var datastring = "action=infoup&img="+img+"&title="+title+"&keyword="+keyword+"&meta="+meta+"&desc="+description+"&footer="+footer;
	$.ajax({
		type: "POST",
		url:"process.php",
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			location.reload();
		}
	});
}

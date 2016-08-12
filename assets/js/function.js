$(document).ready(function(){
	
	var _Prf = "/forum";
	Prf = _Prf + "/cp/process.php";
	Of = _Prf + "/online.php";
	
	$('.ui.dropdown')
	  .dropdown()
	;
	
	$(".txtedit").hide();
	
	$('pre').find('br').remove();
	
	$(".div-post").hide();
	
	$('.reg.modal')
	  .modal('attach events', '.register.button', 'show')
	;
	
	var wbbOpt = {buttons: "bold,italic,underline,|,img,link,|,fontcolor,"}

	$("#body").wysibb(wbbOpt);
	$("#txt_body").wysibb(wbbOpt);
	$("#search").keypress(function( event ) {
		var text = $("#search").val();
		if ( event.which == 13 ) {
		window.location.href = _Prf + "/search/" + text + "/";
		}
	});
	callMemberOnline();
	/*var intV=setInterval("callMemberOnline()",5000);*/
});

function callMemberOnline(){
	var html=$.ajax({
		url:Of,
		data:"",
		async: false,
		success:function(html){
			$(".div-online").html(html);
		},
		error:function(){
			/*clearInterval(intV);*/
			location.reload();
		}
	}).responseText;		
}

function EditTxt()
{
	$(".txtbody").hide();
	$(".txtedit").fadeIn();
}
function ShowReg(){
	
}
function EditPost()
{
	var txtbody = $("#txt_body").bbcode();	
	var ampc = txtbody.split("&").length - 1;
	
	for(i = 0;i<=ampc;i++){
		txtbody = txtbody.replace("&","%26");
	}
	
	var did = $("#did").val();
	if(txtbody == "")
	{
		return false
	}
	var datastring = "action=memeditpost&body="+txtbody+"&did="+did;
	$.ajax({
		type: "POST",
		url:Prf,
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
function Post()
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
	var datastring = "action=mempost&title="+title+"&body="+body+"&tags="+tags+"&desc="+desc+"&category="+category+"&image="+image;
	$.ajax({
		type: "POST",
		url:Prf,
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

function showNewTh()
{
	$(".div-post").slideDown();
}

function Login()
{
	var user = $("#user").val();
	var pass = $("#pass").val();
	if(user == "")
	{
		return false
	}
	if(pass == "")
	{
		return false
	}
	var datastring = "action=memlog&user="+user+"&pass="+pass;
	$.ajax({
		type: "POST",
		url:Prf,
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

function Register()
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
		url:Prf,
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
function ProEdit()
{
	var image = $("#image").val();
	var website = $("#website").val();
	var skype = $("#skype").val();
	var facebook = $("#facebook").val();
	var line = $("#line").val();
	var body = $("#body").bbcode();
	var location = $("#location").val();
	
	if(image == "")
	{
		return false
	}
	var datastring = "action=memedit&image="+image+"&website="+website+"&skype="+skype+"&facebook="+facebook+"&location="+location+"&line="+line+"&signature="+body;
	$.ajax({
		type: "POST",
		url:Prf,
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
function ChangePass()
{
	var oldpass = $("#oldpass").val();
	var newpass = $("#newpass").val();
	var renewpass = $("#renewpass").val();

	if(oldpass == "")
	{
		return false;
	}
	if(newpass == "")
	{
		return false;
	}
	if(renewpass == "")
	{
		return false;
	}
	
	var datastring = "action=changepass&oldpass="+oldpass+"&newpass="+newpass+"&renewpass="+renewpass;
	$.ajax({
		type: "POST",
		url:Prf,
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
function Logout()
{
	var datastring = "action=memlogout";
	$.ajax({
		type: "POST",
		url:Prf,
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			location.reload();
		}
	});	
}
function Comment()
{
	var body = $("#body").bbcode();
	var did = $("#did").val();
	if(body == "")
	{
		alert("กรุณากรองข้อความด้วยค่ะ");
		return false
	}
	var datastring = "action=com&body="+body+"&did="+did;
	$.ajax({
		type: "POST",
		url:Prf,
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			mess = $("#mess").val("");
			email = $("#email").val("");
			location.reload();
		}
	});
}
function Delete(cid)
{
	var datastring = "action=delcom&cid="+cid;
	$.ajax({
		type: "POST",
		url:Prf,
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			mess = $("#mess").val("");
			location.reload();
		}
	});	
}
function SendRepm(pmid,toid)
{
	var msg = $("#body").bbcode();
	
	var datastring = "action=repm&pmid="+pmid+"&toid="+toid+"&msg="+msg;
	$.ajax({
		type: "POST",
		url:Prf,
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			mess = $("#mess").val("");
			location.reload();
		}
	});	
}
function SendPm()
{
	var user = $("#user").val();
	var title = $("#title").val();
	var msg = $("#body").bbcode();
	
	var datastring = "action=pm&title="+title+"&user="+user+"&msg="+msg;
	$.ajax({
		type: "POST",
		url:Prf,
		cache: false,
		data:datastring,
		contentType: "application/x-www-form-urlencoded",
		success: function(response)
		{
			alert(response);
			mess = $("#mess").val("");
			location.reload();
		}
	});	
}
<?php
//MAIL FUNCTION STARTS


function email_code_messagee($code){
	return
	<<< EOF
<html>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
					<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>		
					<style>
						.j-j-text-shadow{j-text-shadow: 7px 3px 5px;}
						.j-text-color5{color:#757575!important}
						.j-text-color7{color:#3a3a3a!important}
						</style>
				</head>
				<body id='body' class='j-color6' style='font-family:sans-serif'>
					<div style='padding: 20px;text-align: justify'>
						<center>
							<a href='https://www.turtapp.com' class='j-xxlarge j-j-text-shadow' style='padding: 15px 10px;color: teal;text-decoration: none;font-size: 35px;cursor: pointer;'>
								<b><span class=''>J</span><i>ob</i>S<i>er</i>V<i></i>ice</i>S</b>
							</a><br><br><br>
						</center>
						<div class='j-text-color7'>
							<p>Hi,</p>
							<p>Your Passcode is <b>{$code}</b></p>
							<p> Please note that it expires in 5 minutes</p><br>
							
							<p>Thanks for using <a href='https://www.turtapp.com' style='text-decoration:none;color:teal'>JobServices</a>.</p>
							<p>Best Regards.</p>
							<p>Turtapp Team.</p><br>
							
							<p>Please do not reply to this email.</p>
							<p>You receive this email, because you are currently using Turtapp. If you are not responsible for this email, please ignore and don't share the code
							with anyone.</p>
							<hr>
							<div class='j-text-color5' style='font-family: Open Sans'>
								<p>Copyright <?= date('Y');?> Jobs.ent All rights reserved.</p>
								<p>Please do not share your account info with anyone, JobServices team will never ask for your Social account password or login details.</p>
							</div>
							<hr>
						</div>
					</div>
				</body>
			</html>
EOF;
}




//email code message starts
function email_code_message($code,$type='member/user'){
 $media_url = file_location('media_url','home/admin_logo.png');
 $home_url = file_location('home_url','');
 $company_name = ucwords(get_xml_data('company_name'));
	return
	<<< EOF
<html>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
					<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
     <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Roboto">
					<style>
						.j-j-text-shadow{j-text-shadow: 7px 3px 5px;}
						.j-text-color5{color:#757575!important}
						.j-text-color7{color:#3a3a3a!important}
						</style>
				</head>
    <body id='body'class=''style='font-family:Roboto,sans-serif;font-size:20px;'>
					<div style='padding: 20px;text-align: justify'>
						<center>
							<a href="{$home_url}" class='j-xxlarge j-j-text-shadow' style='padding: 15px 10px;color: teal;text-decoration: none;font-size: 35px;cursor: pointer;'>
        <img src="{$media_url}"class=''alt="{$company_name} LOGO IMAGE"style="width:98%;max-width:500px;height:70px;">
							</a><br><br><br>
						</center>
						<div class='j-text-color7'>
							<p>Hi,</p>
							<p>Your Passcode is <b>{$code}</b></p>
							<p> Please note that it expires in 5 minutes. We appreciate your effort in shopping with us.</p><br>
							
							<p>Thanks for supporting us.</p>
							<p>Best Regards.</p>
							<p>{$company_name} Team.</p><br>
							
       <p>Please do not reply to this email.</p>
							<p>You are receiving this email, because you are a registered {$type} of <a href="{$home_url}" class=''style='color: red;text-decoration: none;cursor: pointer;'>
       {$company_name}</a>. If you are not responsible for this
       email, please ignore and don't share the code with anyone.</p>
							<hr>
							<div class='j-text-color5' style='font-family: Open Sans'>
								<p>Copyright <?= date('Y');?> {$company_name} All rights reserved.</p>
							</div>
							<hr>
						</div>
					</div>
				</body>
			</html>
EOF;
}
//email code message ends

//welcome message email starts
function user_welcome_message($name){
 $name = ucwords($name);
 $media_url = file_location('media_url','home/admin_logo.png');
 $home_url = file_location('home_url','');
 $company_name = ucwords(get_xml_data('company_name'));
	return
	<<< EOF
<html>
				<head>
					<meta charset='UTF-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'>
					<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
					<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
     <link rel="stylesheet"href="https://fonts.googleapis.com/css?family=Roboto">
					<style>
						.j-j-text-shadow{j-text-shadow: 7px 3px 5px;}
						.j-text-color5{color:#757575!important}
						.j-text-color7{color:#3a3a3a!important}
						</style>
				</head>
    <body id='body'class=''style='font-family:Roboto,sans-serif;font-size:20px;'>
					<div style='padding: 20px;text-align: justify'>
						<center>
							<a href="{$home_url}" class='j-xxlarge j-j-text-shadow' style='padding: 15px 10px;color: teal;text-decoration: none;font-size: 35px;cursor: pointer;'>
        <img src="{$media_url}"class=''alt="{$company_name} LOGO IMAGE"style="width:98%;max-width:500px;height:70px;">
							</a><br><br><br>
						</center>
						<div class='j-text-color7'>
							<p>Hi {$name},</p>
							<p>We (The team at {$company_name}) welcome you to {$company_name}.</p>
							<p>We hope that you have a quality and memorable moment while shopping with us. We appreciate your effort in shopping with us.</p><br>
							
							<p>Thanks for supporting us.</p>
							<p>Best Regards.</p>
							<p>{$company_name} Team.</p><br>
							
       <p>Please do not reply to this email.</p>
							<p>You are receiving this email, because you are a registered member/user of <a href="{$home_url}" class=''style='color: red;text-decoration: none;cursor: pointer;'>
       {$company_name}</a>. If you are not responsible for this
       email, please ignore and don't share with anyone.</p>
							<hr>
							<div class='j-text-color5' style='font-family: Open Sans'>
								<p>Copyright <?= date('Y');?> {$company_name} All rights reserved.</p>
							</div>
							<hr>
						</div>
					</div>
				</body>
			</html>
EOF;
}
//welcome message email ends
//MAIL FUNCTION ENDS
?>
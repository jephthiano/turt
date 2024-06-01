<?php require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/addons/all_actions.inc.php'); ?>
<!DOCTYPE html>
<html>
<head><?php require_once($_SERVER['DOCUMENT_ROOT'].'/addons/meta.inc.php'); ?><title>FEEDBACK</title></head>
<body id="body"class="j-color4"style="font-family: Roboto,sans-serif;width: 100%;"onload="alertoff();">
<div class="j-text-color1 j-container">
		<div class="j-text-color1 j-card-4 j-round-large j-panel" style="width:98%; max-width:400px; height: auto;">
			<div class="j-center"><h5 title="Jobsblog333 privacy policy"><b>SEND FEEDBACK</b></h5><hr></div>
				<form method="post" action="<?php echo test_input('');?>">
					<label class="j-text-color1 ">Email:<span class='j-text-color2'> *</span>
					</label><br>
					<input type="text" class="j-input j-medium j-border j-border-color1 j-round-large" minlength="5" maxlength="70" placeholder="Enter email"
						   name="email" id="email" value="<?php echo @$email; ?>" style="width:100%; max-width: 400px" /><br>
					<label class="j-text-color1 ">Fullname:<span class='j-text-color2'> *</span>
					</label><br>
					<input type="text" class="j-input j-medium j-border j-border-color1 j-round-large" minlength="5" maxlength="70" placeholder="Enter fullname"
						   name="fullname" id="fullname" value="<?php echo @$fullname; ?>" style="width:100%; max-width: 400px" /><br>
					<label class="j-text-color1 ">Message:<span class='j-text-color2'> *</span>
					</label><br>
					<textarea class="j-input j-medium j-border j-border-color1 j-round-large" minlength="5" placeholder="Enter the feedback"
							  name="message" id="message" style="width:100%; max-width: 400px"></textarea><br>
					<div>
						<input type="submit" class="j-button j-round-large j-color1 j-hover-color3 j-hover-text-color1"
							   name="send_feedback"id="send_feedback"value="Send"style="width:100%">
					</div>
					<br>
				</form>
			</div>
		</div>
</div>
</body>
</html>
<?php
//TRANSACTION FUNCTION STARTS
// transaction reuslt starts
function transaction_result($form,$type='confirm',$page="payment"){
 $follow_type = 'no follow';
 $image_link = file_location('media_url','home/logo_white.png');
 $page_name = strtoupper($form)." | ".strtoupper(get_xml_data('company_name'));
 require_once(file_location('inc_path','session_check_nologout.inc.php'));
 ?>
 <!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head><head>
<body id="body"class="j-color4"style="font-family:Roboto,sans-serif;width:100%;">
	<center>
		<div class="j-card-4 j-color6 j-round"style="width:96%;max-width:400px;height:auto;margin-top:50px">
			<div class="j-display-container">
				<div class="j-container">
					<br><br>
					<?php
					if($form === 'error'){
						?>
						<div style="width:150px;height: 150px;"class="j-border-color1 j-border j-circle j-display-container">
							<span class="j-display-middle j-text-color1"><i class="<?=icon('times')?> j-xxlarge"></i></span>
						</div>
						<div>
							<br>
							<p class="j-text-color1 j-large"><b>You Reach this Page by Error</b></p>
							<p>Click home to redirect to homepage</p>
							<a href="<?=file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style='width: 90px'>Home</span></a>
							<br><br>
						</div>
						<?php
					}elseif($form === 'unsuccessful payment'){
						?>
						<div style="width:150px;height: 150px;"class="j-border-color1 j-border j-circle j-display-container">
							<span class="j-display-middle j-text-color1"><i class="<?=icon('times')?> j-xxlarge"></i></span>
						</div>
						<div>
							<br>
							<p class="j-text-color1 j-large"><b>Transaction not Successful</b></p>
							<p>If you have been charged,wait for your bank to credit you or contact customer support. Click home to redirect to homepage</p>
							<a href="<?= file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style=''>Home</span></a>
							<br><br>
						</div>
						<?php
					}elseif($form === 'error connecting'){
						?>
      <div style="width:150px;height: 150px;"class="j-border-color1 j-border j-circle j-display-container">
       <span class="j-display-middle j-text-color1"><i class="<?=icon('times')?> j-xxlarge"></i></span>
      </div>
      <div>
       <br>
       <p class="j-text-color1 j-large"><b>Error Connecting to <?=$page?> Gateway</p>
       <p class='j-text-color5'>Error occur while initiating <?=$page?> gateway. Click home to redirect to homepage or reload the page</p>
       <a href="<?= file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style='width: 120px'>Home</span></a>
       <br><br>
      </div>
						<?php
					}elseif($form === 'fail'){
						?>
						<div style="width:150px;height: 150px;"class="j-border-color1 j-border j-circle j-display-container">
       <span class="j-display-middle j-text-color1"><i class="<?=icon('times')?> j-xxlarge"></i></span>
      </div>
      <div>
       <br>
       <?php
       if($type === 'confirm'){
        ?>
        <p class="j-text-color1 j-large"><b>Order Failed</b></p>
       <p>Error occur while processing your order. Click Home to redirect to homepage</p>
       <a href="<?=file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style='width: 90px'>Home</span></a>
        <?php
       }else{
        ?>
        <p class="j-text-color1 j-large"><b>Error Authenticating Transaction</b></p>
        <p>
         Error occur while authenticating your transaction. If you had been charged kindly contact your bank or contact our customer service.
         Click Home to redirect to homepage
        </p>
        <a href="<?=file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style='width: 120px'>Home</span></a>
        <?php
       }
       ?>
       <br><br>
      </div>
						<?php
					}elseif($form === 'success'){
						?>
						<div style="width:150px;height: 150px;"class="j-border-color1 j-border j-circle j-display-container">
						<span class="j-display-middle j-text-color1"><i class="fa fa-check j-xxlarge"></i></span>
					</div>
					<div>
						<br>
      <?php
      if($type === 'confirm'){
       $loc = 'order/';
       ?>
       <p class="j-text-color1 j-large"><b>Order Received</b></p>
       <p>
        Your Order has been received.<br>You will receive email containing your order status and details,
        Once your order has been confirmed, we will let you know.<br>Check your email for order details.
       </p>
        <?php
      }else{
       ?>
       <p class="j-text-color1 j-large"><b>Transaction Successful</b></p>
       <p>
        Payment successful.<br>Your Order has been received, you will receive email containing your order status and details.
        Once your order has been confirmed, we will let you know.<br>Check your email for order details.
       </p>
       <?php
      }
      ?>
      <p>Click Home to redirect to homepage or click orders to see order details</p>
      <a href="<?=file_location('home_url','order/order placed/');?>"><span class="j-color1 j-round j-btn"style='width:90px;margin-right:20px;'>Orders</span></a>
      <a href="<?=file_location('home_url','');?>"><span class="j-color1 j-round j-btn" style='width: 90px'>Home</span></a>
      <br><br>
     </div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</center>
 <?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>
 <?php
}
//transaction result ends

//check_transaction starts
function check_transaction($type,$c_id,$trans_id){
 if(isset($_SESSION['user_id'])){$uid = test_input(ssl_decrypt_input($_SESSION['user_id']));}
 // creating connection
 require_once(file_location('inc_path','connection.inc.php'));
 @$conn = dbconnect('userselect','PDO');
 //$sql = "SELECT t_id FROM transaction_table WHERE t_trans_id = :trans_id, c_type = :type, c_id = :c_id, u_id = :u_id LIMIT 1";
 $sql = "SELECT t_id FROM transaction_table WHERE t_trans_id = :trans_id AND c_type = :type AND c_id = :c_id AND u_id = :u_id LIMIT 1";
 $stmt =  $conn->prepare($sql); 
 $stmt->bindParam(':trans_id',$trans_id,PDO::PARAM_STR);
 $stmt->bindParam(':type',$type,PDO::PARAM_STR);
 $stmt->bindParam(':c_id',$c_id,PDO::PARAM_STR);
 $stmt->bindParam(':u_id',$uid,PDO::PARAM_INT);
 $stmt->execute();
 $numRow = $stmt->rowCount();
 if($numRow === 1){
  return true;
 }else{
  return false;
 }
closeconnect("stmt",$stmt);
closeconnect("db",$conn);
}

//get payment method starts
function get_payment_method($type,$post_var){
	if($type === 'full'){
		?>
		<option value="" <?php if($post_var === "" || !isset($_POST)){ echo "selected";} ?>>Select Payment Method</option>
		<?php
	}
	?>
 <option value="paystack" <?php if($post_var === "paystack"){ echo "selected";} ?>>Paystack</option>
<?php
}
//get payment method ends
//TRANSACTION FUNCTION ENDS
?>
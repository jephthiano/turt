<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));// session check
if($_GET['reference']){
 $reference = ($_GET['reference']);
 if(!empty($reference)){
  //CONNECT TO PAYSTACK
  $paystack = new paystack();
  $paystack->reference = $reference;
  $result = $paystack->verify_payment();
  if($result === false){die(transaction_result('Error connecting','',''));}
  //FURTHER PROCESSES IF NO ERROR
    $info = json_decode($result);
    //IF THE STATUS IS FALSE, SHOW ERROR
    if(!$info->status){
     die(transaction_result('Unsuccessful payment','',''));
    }else{
     //DECALARING ALL THE VARIABLE
     $transaction = new transaction('admincreateandalluser');
     $transaction->amount = $info->data->amount/100;
     $transaction->currency = $info->data->currency;
     $transaction->ref_id = $info->data->reference;
     $transaction->payment_method = $info->data->channel;
     if($info->data->authorization->account_name == null){$transaction->account_name = "Unknown";}else{$transaction->account_name = $info->data->authorization->account_name;}
     if(isset($info->data->plan->account_number)){$transaction->account_number = $info->data->authorization->account_number;}else{$transaction->account_number = "**********";}
     $transaction->bank = $info->data->authorization->bank;
     $transaction->brand = $info->data->authorization->brand;
     $transaction->ipaddress = $info->data->ip_address;
     $transaction->type = $info->data->metadata->ty;
     $transaction->c_id = removenum($info->data->metadata->c_id);
     $transaction->u_id = removenum($info->data->metadata->u_id);
     $transaction->trans_id = $info->data->metadata->trans_id;
     if($u_id !== $uid){ die(transaction_result('Error','',''));}//VALIDATE CURRENT USER AGAINST PAYER
     if($ref_id === transaction_data('t_ref_id',$trans_id,"t_trans_id")){die(transaction_result('Error','',''));}//CHECK IF THE REFERENCE HAS BEEN USED
     
     if($info->data->status == "success"){ // IF THE TRANSACTION WAS SUCCESSFUL
      //USE TRY AND CATCH
      //UPDATE TRANSACTION
      $transaction->status = 'success';
      $update = $transaction->insert_update_transation();
      if($update === true){
       //UPDATE SPONSORED
       $sponsor = new sponsor('userupdate');
       $sponsor->new_status = "active";
       $sponsor->type = $info->data->metadata->ty;
       $sponsor->c_id = removenum($info->data->metadata->c_id);
       $sponsor->trans_id = $info->data->metadata->trans_id;
       $sponsor->update_status();
       
       //UPDATE FEED,SKILL,JOB
       if($type === 'feed'){
        $change = new feed('userupdate');
       }elseif($type === 'skill'){
        $change = new skill('userupdate');
       }elseif($type === 'job'){
        $change = new job('userupdate');
       }
       $change->id = removenum($info->data->metadata->c_id);
       $change->type = 'promote';
       $change->update_type_status();
       die(transaction_result('Success',$transaction->type,$transaction->c_id));
      }else{
       die(transaction_result('Fail'));
      }
     }else{// if  $info->data->status is not "success"
      $transaction->status = 'fail';
      $update = $transaction->insert_update_transation();
	     die(transaction_result('Unsuccessful payment'));
	    }
    }// END OF IF $info->status is true 
 }else{
    die(transaction_result('Error','',''));
 }// end of if not empty($reference)
}else{
    die(transaction_result('Error','',''));
} // end of if isset($_GET[])
?>
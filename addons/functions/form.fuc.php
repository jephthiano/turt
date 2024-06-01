<?php
//FORM FUNCTION STARTS
//form hidden starts
function get_form_hidden($id,$value){
  ?> <input type="hidden"name="<?=$id?>"id="<?=$id?>"value="<?=$value?>"> <?php
}
//form hidden ends

//form button starts
function get_form_button($id,$value,$disable=''){
  ?> <button type='submit'id='<?=$id?>'name='<?=$id?>'class="j-btn j-medium j-color1 j-round-large j-bolder"style='width:100%;max-width:400px;'<?=$disable?>><?=$value?></button> <?php
}
//form button ends


//form password starts
function get_form_password($btn_id,$id='pss',$placeholder='Password',$disable='',$label='',$eye=''){
  if(empty($label)){
   ?> <span class='mg j-text-color2 j-left'id='<?=$id?>e'></span><br class='j-clearfix'><?php
  }else{
   ?> <label class="j-left"><b><?=$label?>: </b><span class='mg j-text-color2 'id='<?=$id?>e'></span></label><br> <?php
  }
  ?>
  <div style="width:100%;max-width:400px;position:relative;">
   <input type="password"class="pss j-input j-medium j-border-2 j-border-color5 j-round j-color4 j-text-color3"minlength="7"maxlength="30"placeholder="<?=$placeholder?>"required
    name="<?=$id?>"id="<?=$id?>"value=""style="width:inherit;max-width:inherit;outline:none;"onkeyup="daebtn(this,$('#<?=$btn_id?>'))"/>
    <?php
    if($eye !== 'hide'){
     ?><div class="j-eye"style="width:30px;"><span id="eye<?=$id?>"class="j-clickable"onclick="cpit('<?=$id?>');"><i class="<?=icon('eye')?>"></i></span></div><?php
    }
    ?>
  </div>
  <br>
  <?php
}
//form password ends

//form checkbox starts
function get_form_checkbox($id,$value,$checked='',$onclick=''){
  ?><input type="checkbox"name="<?=$id?>"id="<?=$id?>"value="<?=$value?>"class="j-check"<?=$checked?>onclick="<?=$onclick?>"/><?php
}
//form checkbox ends

//form radio starts
function get_form_radio($id,$value,$checked='',$onclick=''){
  ?><input type="radio"name="<?=$id?>"id="<?=$id?>"value="<?=$value?>"class="j-check"<?=$checked?>onclick="<?=$onclick?>"/><?php
}
//form radio ends

//form select starts
function get_form_select($id,$data,$value,$action){
 $value = strtolower($value);
 ?>
 <select id='<?=$id?>'name="<?=$id?>">
  <option value="">Select</option>
  <?php
  foreach($data AS $datum){
   $low_datum = strtolower($datum);
   ?><option value="<?=$low_datum?>"<?=($value === $low_datum)?"checked":"";?>><?=$datum?></option><?php
  }
  ?>
 </select>
 <?php
}
//form select ends

//form textarea starts
function get_form_textarea($id,$btn_id,$placeholder,$value='',$row='',$min_len,$max_len,$label='',$disable='',$required='required'){
 if(empty($label)){
   ?> <span class='mg j-text-color2 j-left'id='<?=$id?>e'></span><br class='j-clearfix'><?php
  }else{
   ?> <label class="j-left"><b><?=$label?>: </b><span class='mg j-text-color2'id='<?=$id?>e'></span></label><br> <?php
  }
  ?>
  <textarea class="j-medium j-border-2 j-border-color5 j-round j-color4 j-text-color3"name="<?=$id?>"id="<?=$id?>"minlength="<?=$min_len?>"maxlength="<?=$max_len?>"placeholder="<?=$placeholder?>"rows="<?=$row?>"
    <?=$required?> <?=$disable?> style="width:100%;max-width:400px;outline:none;"onkeyup="daebtn(this,$('#<?=$btn_id?>'));"><?=$value?></textarea><br><br>
  <?php
}
//form textarea ends

//form type starts
function get_form_type($type,$id,$btn_id,$placeholder,$value='',$min_len='',$max_len='',$label='',$disable='',$required='required',$onkeyup=""){
  if(empty($label)){
   ?> <span class='mg j-text-color2 j-left'style=""id='<?=$id?>e'></span><br class='j-clearfix'><?php
  }else{
   ?> <label class="j-left"><b><?=$label?>: </b><span class='mg j-text-color2'id='<?=$id?>e'></span></label><br> <?php
  }
  ?>
		<input type="<?=$type?>"class="j-input j-medium j-border-2 j-border-color5 j-round j-color4 j-text-color3"minlength="<?=$min_len?>"maxlength="<?=$max_len?>"placeholder="<?=$placeholder?>"
				<?=$required?> <?=$disable?> name="<?=$id?>"id="<?=$id?>"value="<?=$value?>"style="width:100%;max-width:400px;outline:none;"
    onkeyup="daebtn(this,$('#<?=$btn_id?>'));<?=$onkeyup?>"/><br>
  <?php
}
//form type ends
//FORM FUNCTION ENDS
?>
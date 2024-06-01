<?php //SEARCH JS STARTS ?>
<?php if($_SERVER['PHP_SELF'] === "/explore/index.php"){?>
$(document).ready(function(){$('#sIp').val('');});<?php //set the input value to '' onload?>
<?php }?>
<?php if($_SERVER['PHP_SELF'] === "/explore/search.enc.php"){?>
$(document).ready(function(){$('#sIp').val('<?=$searchtext?>');});<?php //set the input value to '' onload?>
<?php }?>
<?php if(isset($explore_search_js) && $explore_search_js === true){ // [explore index and search page]?>
function getr(){drpdwn();$.ajax({type:'POST',url:dar+'get/getr/',data:{"s":$('#sIp').val()}}).fail(function(e,f,g){fail_action('');}).done(function(s){$('.nmcr').html(s);});}<?php //get explore typing result?>
function gtsp(){var qry = $('#sIp').val();if(qry.length > 0){window.location = hu+'explore/search?qry='+encodeURIComponent(qry)}}<?php //onsearch, send to search page?>
function drpdwn(){document.getElementById('drpdwnid').style.display = 'block';$('#explore_modal').show()}
<?php }?>
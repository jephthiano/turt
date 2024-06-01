<script>
<?php
$js = ['general','message','notification','search','settings_and_misc','ads','text_input','turt','user','media'];
foreach($js AS $section){
 require_once(file_location('inc_path',"js/$section.js.php"));
}
?>
</script>
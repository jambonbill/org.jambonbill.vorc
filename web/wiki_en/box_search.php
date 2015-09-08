<?php
// box search //

// build list of categories //

$sql="SELECT DISTINCT flag_category FROM wiki_en WHERE 1;";
$q=$VORC->db()->query($sql) or die("Error");
while($r=$q->fethc()){

}


$box=new LTE\Box;
$box->title("Search wiki");
$box->icon("fa fa-search");
$box->body("text search, category, platform, date, ");
echo $box;
?>
<script>
$(function(){
	
});
</script>
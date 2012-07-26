<?php
if(!$_POST["data"]){
	echo "Invalid data";
	exit;
}
include('./config.php');
$data=json_decode($_POST["data"]);
foreach($data->items as $item)
{
	$col_id=preg_replace('/[^\d\s]/', '', $item->column);
	$widget_id=preg_replace('/[^\d\s]/', '', $item->id);
	$sql="UPDATE widgets SET column_id='$col_id', sort_no='".$item->order."', collapsed='".$item->collapsed."' WHERE id='".$widget_id."'";
	mysql_query($sql) or die('Error updating widget DB');
}
echo "success";

?>
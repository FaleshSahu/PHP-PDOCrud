<?php
include 'dbConnect_new.php';
$db = new DB();
$tblName = 'employee';
	$condition = array('eid' => $_REQUEST['id']);
    $delete = $db->delete($tblName,$condition);
header('location:index.php');
?>
    
       	

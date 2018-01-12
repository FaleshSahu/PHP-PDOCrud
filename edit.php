<?php
include 'dbConnect_new.php';
$db = new DB();
$tblName = 'employee';
if(isset($_REQUEST['submit']))
{
	$Data = array(
            'ename' => $_REQUEST['name']
        );
        $condition = array('eid' => $_REQUEST['hidden']);
       	$update = $db->update($tblName,$Data,$condition);//$update stores no of rows updated
       	header('location:index.php');
}
else
{
$userData = array(
	'where'=>array('eid'=>$_REQUEST['id']),
	'return_type'=>'single'
	
);
$value =  $db->select($tblName,$userData);
echo'
<!DOCTYPE html>
<html>
<head>
	<title>Add</title>
</head>
<body>
<form>
	<input type="hidden" name="hidden" value="'.$value['eid'].'">
	name <input type="text" name="name" value="'.$value['ename'].'"><br>
	<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>';

}
?>
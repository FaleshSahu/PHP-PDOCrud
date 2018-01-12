<?php
if(isset($_REQUEST['submit']))
{
	session_start();
	include 'dbConnect_new.php';
	$db = new DB();
	$tblName = 'employee';
	$userData = array(
		'ename'=>$_REQUEST['name']
	);
	$insert = $db->insert($tblName,$userData);
	header("location:index.php");
}
else
{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add</title>
</head>
<body>
<form>
	name <input type="text" name="name"><br>
	<input type="submit" name="submit" value="Submit">
</form>
</body>
</html>
<?php
}
?>
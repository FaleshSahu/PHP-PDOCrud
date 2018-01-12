<?php
include 'dbConnect_new.php';
$db = new DB();
$tblName = 'employee';
echo'<a href="add.php">Add</a>';
echo'<table border="1">
    <thead>
        <tr>
            <td>Empid</td>
            <td>Emp Name</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
    ';

$condition = array(
    'extra'=>'order by eid desc' 
);

$employies =  $db->select($tblName,$condition);
foreach ($employies as  $employee) {
    echo'<tr>
            <td>'.$employee['eid'].'</td>
            <td>'.$employee['ename'].'</td>
            <td><a href="edit.php?id='.$employee['eid'].'">Edit</a></td>
            <td><a href="delete.php?id='.$employee['eid'].'">Delete</a></td>
        </tr>';
}
    
    echo'<tbody>
</table>';
?>
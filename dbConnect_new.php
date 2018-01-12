<?php
/*
 * DB Class to reduce the complexity of PDO
 * This class is used for database related (connect, insert, update, and delete) operations
 * with PHP Data Objects (PDO) using dynamic binding
 * @author    Falesh kumar Sahu
 * @url       http://www.webtechsolutionsdurg.com
 * Date 12-01-2018
 */
class DB{

    private $dbHost     = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName     = "cruid";
    private $option = [
        PDO::ATTR_ERRMODE            =>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   =>false,
    ];

    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUser, $this->dbPass, $this->option);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with Database: " . $e->getMessage());
            }
        }
    }
    
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function select($table,$conditions = array()){
        $dataToBind = array();
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = :".$key;
                $dataToBind[':'.$key] = $value;
                $i++;
            }
        }
        
        /*If required any specific query then you can use extra  condition and put your query inside it */  
        if(array_key_exists("extra",$conditions)){
            $sql .= " ".$conditions['extra']; 
         }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
        $query = $this->db->prepare($sql);
        if(!empty($dataToBind))
        {
            foreach($dataToBind as $key=>&$value)// binding Data
                    {
                        $query->bindParam($key, $value);
                    }
        }
        $query->execute();
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }
        return !empty($data)?$data:false;
    }
    
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>&$val){
                 $query->bindParam(':'.$key, $val);
            }
            $insert = $query->execute();
            return $insert?$this->db->lastInsertId():false;
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
        $dataToBind = array();
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            if(!array_key_exists('operation_date',$data)){
                $data['operation_date'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$value){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key." = :".$key;
                $dataToBind[':'.$key] = $value;
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = :".$key;
                    $dataToBind[':'.$key] = $value;
                    $i++;
                }
            }
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            
            $query = $this->db->prepare($sql);
            
            if(!empty($dataToBind))
            {
                foreach($dataToBind as $key=>&$value)// binding Data
                {
                    $query->bindParam($key, $value);
                }
            }
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        $dataToBind = array();
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = :".$key;
                $dataToBind[':'.$key] = $value;
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
        $query = $this->db->prepare($sql);
        if(!empty($dataToBind))
            {
                foreach($dataToBind as $key=>&$value)// binding Data
                {
                    $query->bindParam($key, $value);
                }
            }
        $delete = $query->execute();
        return $delete?$delete:false;
    }
}


/* How to use

Select
    include 'dbConnect_new.php';
    $db = new DB();
    $tblName = 'employee'; 

Normal Use (All column without any condition)  
$employies =  $db->select($tblName);
foreach ($employies as  $employee) {}

//To perform order by 
// $condition = array(
//     'order_by'=>'col1'   
// );
// 
//If required any specific query then you can use extra  condition and put your query inside it    
// $condition = array(
//     'extra'=>('where ename like "%fa%"')   
// );
// $condition = array(
//     'extra'=>'order by eid desc' 
// );
// 
//To return only single row
// $condition = array(
//     'return_type'=>'single'   
// );
// $employies =  $db->select($tblName,$condition);
// echo $employies['eid'].$employies['ename'];
// 
// To get row count
// $condition = array(
//     'return_type'=>'count'   
// );
// $employies =  $db->select($tblName,$condition);
// echo $employies;


Insert
if(isset($_REQUEST['submit']))
{
    session_start();
    include 'dbConnect_new.php';
    $db = new DB();
    $tblName = 'employee';
    $userData = array(
        'ename'=>$_REQUEST['name']
    );
    $insert = $db->einsrt($tblName,$userData);
    header("location:index.php");
}

Update
session_start();
include 'dbConnect_new.php';
$db = new DB();
$tblName = 'employee';
if(isset($_REQUEST['submit']))
{
    $Data = array(
            'ename' => $_REQUEST['name'],
            'operation' => 'Update',
            'operation_userid' => '202139'
        );
        $condition = array('eid' => $_REQUEST['hidden']);
        $update = $db->update($tblName,$Data,$condition);//$update stores no of rows updated
        header('location:index.php');
}

Delete
session_start();
include 'dbConnect_new.php';
$db = new DB();
$tblName = 'employee';
    $condition = array('eid' => $_REQUEST['id']);
    $delete = $db->delete($tblName,$condition);
header('location:index.php');
*/
?>
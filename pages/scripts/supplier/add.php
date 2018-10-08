<?php
session_start();
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
$employee_id = $_SESSION['employee_id'];

if(isset($_POST['add_supplier'])){
    $supplier_name = $_POST['supplier_name'];
    $supplier_address = $_POST['supplier_address'];
    $supplier_email = $_POST['supplier_email'];
    $supplier_contact = $_POST['supplier_contact'];
    $gst_no = $_POST['gst_no'];
    
    
    
    
    $query = "SELECT * FROM supplier WHERE supplier_contact = $supplier_contact";
    $result = mysqli_query($connection,$query);
    checkQueryResult($result);
    
    if(mysqli_num_rows($result)>0){
        $_SESSION["status"] = SUPPLIER_ALREADY_EXISTS;
        echo mysqli_num_rows($result);
    }
    
    else{    
    $tableName = "supplier";
    $columns = "supplier_name, supplier_address,supplier_email,supplier_contact,gst_no";
    $values = "'$supplier_name','$supplier_address','$supplier_email','$supplier_contact','$gst_no'";
    insert($tableName,$columns,$values);
        $_SESSION["status"]=SUPPLIER_ADDED;
            
            
    header("Location: http://".BASE_SERVER."/erp/pages/add-supplier.php");
    exit;
    }
    
        
    
    
}
?>
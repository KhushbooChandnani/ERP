<?php
session_start();
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
$employee_id = $_SESSION['employee_id'];

if(isset($_POST['add_customer'])){
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $customer_email = $_POST['customer_email'];
    $customer_contact = $_POST['customer_contact'];
    $gst_no = $_POST['gst_no'];
    
    
    
    
    $query = "SELECT * FROM customer WHERE customer_contact = $customer_contact";
    $result = mysqli_query($connection,$query);
    checkQueryResult($result);
    
    if(mysqli_num_rows($result)>0){
        $_SESSION["status"] = CUSTOMER_ALREADY_EXISTS;
        echo mysqli_num_rows($result);
    }
    
    else{    
    $tableName = "customer";
    $columns = "customer_name, customer_address,customer_email,customer_contact,gst_no";
    $values = "'$customer_name','$customer_address','$customer_email','$customer_contact','$gst_no'";
    insert($tableName,$columns,$values);
        $_SESSION["status"]=CUSTOMER_ADDED;
            
            
    header("Location: http://".BASE_SERVER."/erp/pages/add-customer.php");
    exit;
    }
    
        
    
    
}
?>
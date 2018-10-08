<?php
session_start();
require_once("../../includes/functions.php");
$employee_id = $_SESSION['employee_id'];
/***************************************************************************
                Procedure to upload an image
****************************************************************************/
//$image_name=$_FILES['product_image']['name'];
//$image_size = $_FILES['product_image']['size'];
//$temp_name = $_FILES['product_image']['tmp_name'];
//$file_type = $_FILES['product_image']['type'];
//
//$file_extension = strtolower(end(explode(".",$image_name)));
//echo "Image Name : ".$image_name;
//echo "<br> Image Size : $image_size";
//echo "<br> Temp Name : $temp_name";
//echo "<br> File Type : $file_type";
//echo "<br> File Extension : $file_extension";
//
//$valid_extensions = array("jpeg","jpg","png");
//
//if(in_array($file_extension,$valid_extensions) == false){
//    $error_msg[] = "Image is not valid ! Please choose a jpg or png image type";
//}
//if($image_size>2097152){
//    $error_msg[] = "Image size is too large ! Please select an image within 2MB size";
//}
//if(empty($error_msg)){
//    move_uploaded_file($temp_name,"../../../assets/products/images/.$image_name");
//    echo "File successfully uploaded";
//}
//else{
//    print_r($error_msg);
//}
/***************************************************************************
                Procedure to upload an image
****************************************************************************/
if(isset($_POST['add_product'])){
    //checking whether file was uploaded or not !
    if(isset($_FILES['product_image']))
    {
        $image_name=$_FILES['product_image']['name'];
        $image_size = $_FILES['product_image']['size'];
        $temp_name = $_FILES['product_image']['tmp_name'];
        $file_type = $_FILES['product_image']['type'];
        $file_extension = strtolower(end(explode(".",$image_name)));
    }
    $product_name = $_POST['product_name'];
    $rate_of_sale = $_POST['rate_of_sale'];
    $additional_specification = $_POST['additional_specification'];
    $category_id= $_POST['category_id'];
    $eoq = $_POST['eoq'];
    $suppliers = $_POST['supplier_id'];
    
    $tablename = "product";
    $columns = "product_name,eoq,additional_specification,category_id,image_extension,created_by";
    $values = "'$product_name',$eoq,'$additional_specification','$category_id','$file_extension',$employee_id";
    
    $result = insert($tablename,$columns,$values);
    $product_id = mysqli_insert_id($connection);
    
    $tablename = "product_sale_rate";
    $columns = "product_id,rate_of_sale,wef,created_by";
    $values = "$product_id,$rate_of_sale,now(),$employee_id";
    $result = insert($tablename,$columns,$values);
    //product has been added
    
    
    //getting the last product_id which was automtically added in DBMS
    $tablename = "product_supplier";
    $columns = "product_id,supplier_id";
    foreach($suppliers as $supplier_id){
         $values = "$product_id,$supplier_id";
        $result = insert($tablename,$columns,$values);
    }
    
    /* CODE to upload the file*/
    if(isset($_FILES['product_image'])){
        move_uploaded_file($temp_name,"../../../assets/products/images/".$product_id.".".$file_extension);
    }
    
    $_SESSION['status']=CUSTOMER_ADD_SUCCESS;
    
    
    
}


?>
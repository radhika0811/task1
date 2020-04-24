<?php

$firstname = $_REQUEST['fname'];
$email = $_REQUEST['email'];
$address1 = $_REQUEST['address1'];
$address2 = $_REQUEST['address2'];
$address3 = $_REQUEST['address3'];
$name_file = basename($_FILES['file']['name']);
$type_file = substr($name_file,strrpos($name_file,'.')+1);
$size_file =  $_FILES["file"]["size"]/1024;
$max_allowed_file_size = 100; // size in KB
$allowed_extensions = "pdf";

//Validations
if($size_file > $max_allowed_file_size )
{
    $errors .= "\n Size of file should be less than $max_allowed_file_size";
}

//------ Validate the file extension -----
$allowed_ext = false;
    if(strcasecmp($allowed_extensions,$type_file) == 0)
    {
        $allowed_ext = true;
    }

if(!$allowed_ext)
{
    $errors .= "\n The uploaded file is not supported file type. ".
        " Only the following file types are supported: ".implode(',',$allowed_extensions);
}
$path_of_uploaded_file = $upload_folder.$name_file;
$tmp_path = $_FILES["uploaded_file"]["tmp_name"];

if(is_uploaded_file($tmp_path))
{
    if(!copy($tmp_path,$path_of_uploaded_file))
    {
        $errors .= '\n error while copying the uploaded file';
    }
}
//$amount = $_REQUEST['amount'];
$pincode = $_REQUEST['zip'];
$mobno = $_REQUEST['phone'];
//echo json_encode($_GET);
if (empty($firstname) || empty($email)  || empty($address1) || empty($address2) || empty($address3) || empty($pincode) || empty($mobno) ) {
    echo "Please enter values in fields";
} /*if (empty($theData)) {
    echo "Please enter values in fields";
}*/ else {
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("sendmail_from", "radhikaa245@gmail.com");
    ini_set("sendmail_path", "C:/xampp/sendmail/sendmail.exe");
    //mail("radhikaa245@gmail.com", "Form Submission Details", "From: $theData\n");
    if (mail("Jatin.ibs@gmail.com", "New Order Recieved!!!!\n", "From: \n$firstname\n $address1\n $address2\n $address3\n
     $pincode\n $mobno\n $email\n $name_file", "Yes")) echo "mail sent";
else echo "error sending mail";
}
//fclose($fm);
?>


<?php

$firstname = $_REQUEST['fname'];
$email = $_REQUEST['email'];
$address1 = $_REQUEST['address1'];
$address2 = $_REQUEST['address2'];
$address3 = $_REQUEST['address3'];
//$amount = $_REQUEST['amount'];
$uploadStatus = '';
if(!empty($_FILES["file"]["name"])){
    $targetDir = "/uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
// Allow certain file formats
    $allowTypes = array('pdf', 'doc', 'jpg', 'png', 'jpeg');
}
if(in_array($fileType, $allowTypes)){
// Upload file to the server
    if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){
        $uploadedFile = $targetFilePath;
    }else{
        $uploadStatus = 0;
        $statusMsg = "Sorry, there was an error uploading your file.";
    }
}else{
    $uploadStatus = 0;
    $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
}
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
     $pincode\n $mobno\n $email\n", "Yes")) echo "mail sent";
else echo "error sending mail";
}
//fclose($fm);
?>


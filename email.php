<?php
$postData = $uploadedFile = $statusMsg = '';
$msgClass = 'errordiv';
$firstname = $_REQUEST['fname'];
$email = $_REQUEST['email'];
$address1 = $_REQUEST['address1'];
$address2 = $_REQUEST['address2'];
$address3 = $_REQUEST['address3'];
//$amount = $_REQUEST['amount'];
$uploadStatus = '';
if(!empty($_FILES["file"]["name"])){
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
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
    $toEmail = "Jatin.ibs@gmail.com" ;
    $from = $email;
    $emailSubject = 'Contact Request Submitted by '.$firstname;
    $htmlContent = '


//Contact Request Submitted
Name: '.$firstname.'
Email: '.$email.'
Address1: '.$address1.'
Address2: '.$address2.'
Address3: '.$address3.'
Mobile Number: '.$mobno.'
Pincode: '.$pincode.'
';
    $headers = "From: $firstname"." <".$from.">";
    if(!empty($uploadedFile) && file_exists($uploadedFile)){
// Boundary
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
// Headers for attachment
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
// Multipart boundary
        $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
// Preparing attachment
        if(is_file($uploadedFile)){
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($uploadedFile,"rb");
            $data = @fread($fp,filesize($uploadedFile));
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile)."\"\n" .
                "Content-Description: ".basename($uploadedFile)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile)."\"; size=".filesize($uploadedFile).";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
        $message .= "--{$mime_boundary}--";
        $returnpath = "-f" . $email;
// Send email
        $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);
// Delete attachment file from the server
        @unlink($uploadedFile);
    }
    else{
// Set content-type header for sending HTML email
        $headers .= "\r\n". "MIME-Version: 1.0";
        $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
// Send email
        $mail = mail($toEmail, $emailSubject, $htmlContent, $headers);
    }
// If mail sent
    if($mail){
        $statusMsg = 'Your contact request has been submitted successfully !';
        $msgClass = 'succdiv';
        $postData = '';
    }else{
        $statusMsg = 'Your contact request submission failed, please try again.';
    }
}
//fclose($fm);
?>


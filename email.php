<?php
$postData = $uploadedFile = $statusMsg = '';
$msgClass = 'errordiv';
$firstname = $_REQUEST['fname'];
$email = $_REQUEST['email'];
$address1 = $_REQUEST['address1'] ;
$address2 = $_REQUEST['address2'] ;
$address3 = $_REQUEST['address3'];
$pincode = $_REQUEST['zip'];
$mobno = $_REQUEST['phone'];
//$amount = $_REQUEST['amount'];
function sms_integration(){
    $username = "jatin";
    $apikey = "32f27136-3898-48e4-8c9a-3e6bf3e20175";
    $message = "Thanks for successfully registering at GOABRIGO!! Your request will be processed shortly.";
    $sendername = "JATINJ";
    $smstype = "TRANS";
    $numbers = $_POST['phone'];

    $data = "username=".$username."&message=".$message."&sendername=".$sendername."&smstype=".$smstype."&numbers=".$numbers."&apikey=".$apikey;

    $ch = curl_init('http://sms.hspsms.com/sendSMS?');

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    echo $result;
    curl_close($ch);
}
function database(){
     $host = "localhost";
    $db_name = "goabrigo";
    $username = "radhika";
    $password = "Test!123";
    try{
    $conn = new PDO("mysql:host=$host; dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmnt = $conn -> prepare("INSERT INTO register (firstname,email,mobno,address1,address2,address3,pincode) VALUES(:firstname, :email, :mobno, :address1,:address2,:address3,:pincode)");
    $stmnt->bindParam(':firstname', $firstname);
    $stmnt->bindParam(':email', $email);
    $stmnt->bindParam(':mobno', $mobno);
    $stmnt->bindParam(':address1', $address1);
    $stmnt->bindParam(':address2', $address2);
    $stmnt->bindParam(':address3', $address3);
    $stmnt->bindParam(':pincode', $pincode);
        $stmnt -> execute();
        echo "done..";}
        catch (PDOException $e){
            echo "Error: " . $e->getMessage();
        }
       // $stmnt -> close();
        $conn = null;

}
$uploadStatus = '';
if(!empty($_FILES["file"]["name"])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('pdf', 'doc', 'jpg', 'png', 'jpeg');
}
if(in_array($fileType, $allowTypes)){
// Upload file to the server
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
        $uploadedFile = $targetFilePath;
    }else{
        // $uploadStatus = 0;
        $statusMsg = "Sorry, there was an error uploading your file.";
    }
}else{
    // $uploadStatus = 0;
    $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
}
//echo json_encode($_GET);
if (empty($firstname) || empty($email)  || empty($address1) || empty($address2) || empty($address3) || empty($pincode) || empty($mobno) ) {
    echo "Please enter values in fields";
} /*if (empty($theData)) {
    echo "Please enter values in fields";
}*/ else {
    database();
    sms_integration();
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("sendmail_from", "radhikaa245@gmail.com");
    ini_set("sendmail_path", "C:/xampp/sendmail/sendmail.exe");
    $toEmail = "Jatin.ibs@gmail.com" ;
    $from = $email;
    $emailSubject = 'A  new order by '.$firstname;
    $emailSubject1 = 'Thanks for placing an order with GoAbrigo';
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
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

// Headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

// Multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

// Preparing attachment
    if(!empty($file) > 0){
        if(is_file($fileName)){
            $message .= "--{$mime_boundary}\n";
            $fp =    @fopen($fileName,"rb");
            $data =  @fread($fp,filesize($fileName));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($fileName)."\"\n" .
                "Content-Description: ".basename($fileName)."\n" .
                "Content-Disposition: attachment;\n" . " filename=\"".basename($fileName)."\"; size=".filesize($fileName).";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;
//echo $fileName;
//echo json_encode($_POST);
// Send email
    $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);
    //$mail1 = mail($email, )
// Email sending status
   // echo $mail?"<h1>Email Sent Successfully!</h1>":"<h1>Email sending failed.</h1>";
}
if($mail){
    Windows.history.log(-1);
   echo '<script> alert("Thanks for submitting your details. Our team will contact you soon")</script>';
}
else
{
    echo '<script> alert("Try again later")</script>';
}
//fclose($fm);
?>

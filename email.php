<?php
$firstname = $_REQUEST['fname'];
$lastname = $_REQUEST['lname'];
$age = $_REQUEST['age'];
$email = $_REQUEST['mail'];
$address = $_REQUEST['address'];
$password = $_REQUEST['password'];

if (empty($firstname) || empty($lastname) || empty($email) || empty($address) || empty($password)) {
    echo "Please enter values in fields";
} /*if (empty($theData)) {
    echo "Please enter values in fields";
}*/ else {
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("sendmail_from", "radhikaa245@gmail.com");
    ini_set("sendmail_path", "C:/xampp/sendmail/sendmail.exe");

    //mail("radhikaa245@gmail.com", "Form Submission Details", "From: $theData\n");
    if (mail("radhikaa245@gmail.com", "Form Submission Details", "From: $firstname $lastname $email $age $address\n", "Yes")) echo "mail sent";
    else echo "error sending mail";
}
//fclose($fm);
?>
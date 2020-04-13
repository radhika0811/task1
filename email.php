<?php
$myFile = "index.html";
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
echo $theData;

if (empty($theData)) {
    echo "Please enter values in fields";
} else {
    ini_set("SMTP", "localhost");
    ini_set("smtp_port", "25");
    ini_set("sendmail_from", "radhikaa245@gmail.com");
    ini_set("sendmail_path", "C:/xampp/sendmail/sendmail.exe");

    mail("radhikaa245@gmail.com", "Form Submission Details", "From: $theData\n");
}
fclose($fh);
?>
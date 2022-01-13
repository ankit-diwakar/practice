<?php
 
if(isset($_POST['send']))
{
extract($_POST); 
$to=$_POST['email']; //change to ur mail address
$strSubject="Tutorialswebsite | Email | $firstname";
$message = file_get_contents('templete.php'); 
$message=str_replace('{{firstname}}', $firstname, $message);
 
$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
// $headers .= "Bcc: pradeepku041@gmail.com\r\n";
$headers .= "From: ankit.999571@gmail.com";
 
$mail_sent=mail($to, $strSubject, $message, $headers); 
if($mail_sent)
echo "<script>alert('Thank you. we will get back to you'); window.location='index.php';exit();</script>";
else
echo "<script>alert('Sorry.Request not send'); window.location='index.php';exit();</script>";
}
?>
<?php 
//echo'mail sent'; 
require_once __DIR__."/../vendor/autoload.php";
use Tarikh\PhpMeta\MetaTraderClient;
use Tarikh\PhpMeta\Entities\User;
use Tarikh\PhpMeta\src\Lib\MTEnDealAction;
include('../src/config/conn.php');
 $msg = $_POST['msg'];
if($msg =="success"){
	$address = $_POST['address'];
	$country = $_POST['country'];
	$email   = $_POST['email'];
	$fname   = $_POST['fname'];
	$lev     = $_POST['lev'];
	$lname   = $_POST['lname'];
	$phone   = $_POST['phone'];
	$plan    = $_POST['plan'];
	$type    = $_POST['type'];
	$name = $fname.' '.$lname;
	$namecut = substr($name, 0, 5);
	$n = 4;
	 function generateNumericOTP($n) { 
	 $generator = "1357902468";   
	 $result = "";    
	 for ($i = 1; $i <= $n; $i++) {  
	 $result .= substr($generator, (rand()%(strlen($generator))), 1);   
	 }
	 return $result;
	 } 
	$otp = generateNumericOTP($n);
	$trd_roompwd = $namecut.$otp;
	$pass1=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 11);
	$pass2=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 11);
	$pass3=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 11);
	//echo'its working';
	 $api = new MetaTraderClient($server, $port, $login, $password);
	//Create Account
	$user = new User();
	$user->setGroup($type);
	$user->setName($name);
	$user->setEmail($email);
	$user->setAddress($address);
	$user->setCity("chd");
	$user->setState("ut");
	$user->setCountry($country);
	$user->setMainPassword($pass1);
	$user->setPhone($phone);
	$user->setPhonePassword($pass2);
	$user->setInvestorPassword($pass3);
	$user->setLeverage($lev);
	$user->setZipCode(160036);
	$result = $api->createUser($user);
	
		//echo'<pre>';
	$loginid = $result->getLogin();
	$mtname  = $result->getName();
	$mtgroup = $result->getGroup();
	$mtlev   = $result->getLeverage();
	$mtmpassword = $result->getMainPassword();
	$mtppass = $result->getPhonePassword();
	$mtinvetpass = $result->getInvestorPassword();
//print_r($result);
//echo'</pre>';
	
	//$txtmsg = "Your Trader Room Login details : Email" . $email." And Password". $trd_roompwd.". <br>Your MT5 Main Login ID:".$loginid." And Password: ".$mtmpassword.". <br>Your MT5 Phone Password: ".$mtppass."<br>Your MT5 Investor Password: ".$mtinvetpass."<br>. Your Account type:".$mtgroup.". <br>Your Leverage: ".$mtlev;
	$nemail = "no-reply@tradebull.io";
	$nname = "tradebull.io";
	 $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From: '.$nemail."\r\n".
    'Reply-To: '.$nemail."\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	$txtmsg = "<html><body> <table><h5>MT5 Credentials</h5><br>    <p> Login ID:- $loginid</p> <br>    <p> Login Password:- $mtmpassword</p> <br><h5>Tradebull.io Trader Room Credentials</h5><br>    <p> Email:- $email</p><br>    <p> Password:- $trd_roompwd</p><br><h5>MT5 Phone Password</h5><br>    <p> Password:- $mtppass</p><br><h5>MT5 Investor Password</h5><br>    <p>Investor Password:- $mtinvetpass</p><br><h5>MT5 Details</h5><br>    <p> Account type:- $mtgroup</p><br>    <p> Leverage:- $mtlev</p><br></table>    </html></body>";	
	 
	
	$subject = "Login Credentials for Trader Room And MT5 Account";
	$headers .= "From: " . $nname . "<". $nemail .">\r\n";
	if(mail($email, $subject, $txtmsg, $headers)) {
		
		echo'<pre>';
//echo $result->getMainPassword();
print_r($result);
echo'</pre>';

	/* define('HOST', 'localhost'); // Database host name ex. localhost
	define('USER', 'mastetnr_tradebull'); // Database user. ex. root ( if your on local server)
	define('PASSWORD', 'TradeBull.Io@#2021'); // user password  (if password is not set for user then keep it empty )
	define('DATABASE', 'mastetnr_tradebullio'); // Database Database name

	function DB()
	{
		try {
			$db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD);
			return $db;
		} catch (PDOException $e) {
			return "Error!: " . $e->getMessage();
			die();
		}
	}
		$conn = DB(); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     $sql = "INSERT INTO credentials (name,email,password,phone) VALUES ('$name','$email','$trd_roompwd','$phone')";
	$conn->prepare($sql)->execute(); */
	} 
}
	?>
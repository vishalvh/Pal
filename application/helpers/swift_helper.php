<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/swift_mailer/swift_required.php';
if ( ! function_exists('send_mail'))
{
    function send_mail($to,$subject,$msg)
    {
try{
	
// Create the Transport the call setUsername() and setPassword()
//$transport = Swift_SmtpTransport::newInstance('localhost', 25);

$transport = Swift_SmtpTransport::newInstance('c16820.sgvps.net',465,'ssl')
  ->setUsername('noreply@squadli.com')
  ->setPassword('noreply#000#');
  
$mailer = Swift_Mailer::newInstance($transport);
// Create the Mailer using your created Transport
$message = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance($subject)
  ->setFrom(array('support@shrihari.com' => 'Shri Hari'))
  ->setTo($to);
  $footer='';
$msg.= $footer;
 $message->setBody($msg);
//$message->addBcc('vishal@virtualheight.com');
  
$message->setContentType("text/html");
// Send the message

$result = $mailer->send($message);


}catch(Exception $e){
echo $e->getMessage();
}    
    return $result;
    }  
}
?>

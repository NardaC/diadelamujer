<?php
function send_email($from, $to, $subject, $message_html, $message_txt = '') {
        
    $email = $to;
    				
    //create a boundary for the email. This 
    $boundary = uniqid('np');
    				
    //headers - specify your from email address and name here
    //and specify the boundary for the email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: $from \r\n";
    $headers .= "To: $email\r\n";
    //'Reply-To: ' . $from,
    //'Return-Path: ' . $from,
    $headers .= 'Date: ' . date('r', $_SERVER['REQUEST_TIME'])."\r\n";
    $headers .= 'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME'].$subject) . '@' . $_SERVER['SERVER_NAME'] . '>'."\r\n";
    $headers .= 'X-Mailer: PHP v' . phpversion()."\r\n";
    $headers .= 'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']."\r\n";
    
    $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";
    
    //here is the content body
    $message = "This is a MIME encoded message.";
    
    //Plain text body
    $message .= "\r\n\r\n--" . $boundary . "\r\n";
    $message .= "Content-type: text/plain;charset=iso-8859-1\r\n\r\n";
    
    if ( $message_txt == '' ) {
    	$message_txt = nl2br( $message_html );
    	$message_txt = strip_tags( $message_txt );
    }
    $message .= $message_txt;
    //Html body
    $message .= "\r\n\r\n--" . $boundary . "\r\n";
    $message .= "Content-type: text/html;charset=uiso-8859-1\r\n\r\n";
    $message .= $message_html;
    
    $message .= "\r\n\r\n--" . $boundary . "--";
    
    //invoke the PHP mail function
    mail('', $subject, $message, $headers);

}

if ( ! isset($_POST['email']) ) {
	exit;
}

// Construimos el mensaje
$to= 'narda@henribarrett.com';
$reply = 'judith@henribarrett.com';
$user_email = $_POST['email'];
$subject = 'Mensaje automático: '.$_POST['subject'];

$message = '<table>';
$message = '¡Gracias por tu comentario!';
$message .= '<tr><td>Nombre</td><td>'.$_POST['name']."</td></tr>\n";
$message .= '<tr><td>Apellidos</td><td>'.$_POST['lastname']."</td></tr>\n";
$message .= '<tr><td>Email</td><td>'.$_POST['phone']."</td></tr>\n";
$message .= '<tr><td>Asunto</td><td>'.$_POST['email']."</td></tr>\n";
$message .= '<tr><td>Mensaje</td><td>'.$_POST['message']."</td></tr>\n";
$message .= '</table>';

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agradecimiento</title>
</head>
<body>
    <div style="position:absolute; left:50%;top:50%; transform:translate(-50%,-50%); background-color:#fff; padding: 1.5rem; text-align: center; width: 70%">
        <img src="" style="width: 4rem"alt="">
        <h1 style="font-family: BarbarianRegular; font-size: 1rem">¡Gracias por tu comentario</h1>
        <a href="http://127.0.0.1:5501/index.html "style="background-color:black; color:#fff; font-family: suplementBarbarian; padding: .5rem; font-size:.7rem; text-decoration:none;">REGRESAR AL INICIO</a>
    </div>
    
</body>
</html>';

send_email($user_email, $to, $subject, $message);
send_email($reply, $user_email, $subject, $message);

?>


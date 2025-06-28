<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoMantenimiento($codigo_dispositivo, $fecha_ultimo, $fecha_proximo, $descripcion) {

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require_once dirname(__DIR__) . '/libs/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {

//  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'katamaria2006@gmail.com';                     //SMTP username
    $mail->Password   = 'idkzwqxmxbrbvipk';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mariatalavera301207@gmail.com', 'Mailer');
    $mail->addAddress('katamaria2006@gmail.com', 'Karla');     //Add a recipient
 
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Mantenimiento Ascardio';
    $mail->Body    = '
    <div style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px;">
        <div style="max-width: 500px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #e0e0e0; padding: 24px;">
            <h2 style="color:rgb(163, 52, 52); border-bottom: 1px solid #eee; padding-bottom: 10px;">Nuevo Mantenimiento Programado</h2>
            <table style="width:100%; border-collapse:collapse; font-size:16px;">
                <tr>
                    <td style="padding:8px 0; color:#555;"><b>Dispositivo:</b></td>
                    <td style="padding:8px 0;">'.htmlspecialchars($codigo_dispositivo).'</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#555;"><b>Fecha último mantenimiento:</b></td>
                    <td style="padding:8px 0;">'.htmlspecialchars($fecha_ultimo).'</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#555;"><b>Fecha próximo mantenimiento:</b></td>
                    <td style="padding:8px 0;">'.htmlspecialchars($fecha_proximo).'</td>
                </tr>
                <tr>
                    <td style="padding:8px 0; color:#555;"><b>Descripción:</b></td>
                    <td style="padding:8px 0;">'.htmlspecialchars($descripcion).'</td>
                </tr>
            </table>
            <div style="margin-top:24px; color:#888; font-size:13px; text-align:center;">
                Ascardio - Sistema de Gestión de Mantenimientos
            </div>
        </div>
    </div>
';
   
    $mail->send();
 
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
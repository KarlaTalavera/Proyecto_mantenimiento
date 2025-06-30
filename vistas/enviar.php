<?php
// importa las clases de phpmailer para poder enviar correos
// esto debe ir arriba del todo

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoMantenimiento($codigo_dispositivo, $fecha_ultimo, $fecha_proximo, $descripcion) {

    // carga el autoloader de composer para phpmailer
    require_once dirname(__DIR__) . '/libs/vendor/autoload.php';

    // crea una instancia de phpmailer, true para activar excepciones
    $mail = new PHPMailer(true);

    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // para ver mensajes de debug si hace falta
        $mail->isSMTP(); // usa smtp para enviar el correo
        $mail->Host       = 'smtp.gmail.com'; // servidor smtp de gmail
        $mail->SMTPAuth   = true; // activa autenticacion smtp
        $mail->Username   = 'katamaria2006@gmail.com'; // usuario smtp
        $mail->Password   = 'idkzwqxmxbrbvipk'; // clave smtp
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // usa tls implicito
        $mail->Port       = 465; // puerto para smtp seguro

        // pone el remitente y el destinatario
        $mail->setFrom('mariatalavera301207@gmail.com', 'Sistemas');
        $mail->addAddress('katamaria2006@gmail.com', 'Karla');

        // arma el contenido del correo
        $mail->isHTML(true); // el correo es html
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
                        <td style="padding:8px 0; color:#555;"><b>Fecha ultimo mantenimiento:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($fecha_ultimo).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Fecha proximo mantenimiento:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($fecha_proximo).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Descripcion:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($descripcion).'</td>
                    </tr>
                </table>
                <div style="margin-top:24px; color:#888; font-size:13px; text-align:center;">
                    Ascardio - Sistema de Gestion de Mantenimientos
                </div>
            </div>
        </div>
        ';

        $mail->send();

    } catch (Exception $e) {
        echo "El mensaje correo no pudo ser enviado, mailer error: {$mail->ErrorInfo}";
    }
}

function enviarCorreoFalloReportado($codigo_dispositivo, $ubicacion, $tipo, $nivel_urgencia, $descripcion, $usuario) {
    require_once dirname(__DIR__) . '/libs/vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'katamaria2006@gmail.com';
        $mail->Password   = 'idkzwqxmxbrbvipk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('mariatalavera301207@gmail.com', 'Sistemas');
        $mail->addAddress('katamaria2006@gmail.com', 'Karla');

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo fallo reportado en Ascardio';
        $mail->Body    = '
        <div style="font-family: Arial, sans-serif; background: #f7f7f7; padding: 30px;">
            <div style="max-width: 500px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #e0e0e0; padding: 24px;">
                <h2 style="color:rgb(163, 52, 52); border-bottom: 1px solid #eee; padding-bottom: 10px;">Nuevo fallo reportado</h2>
                <table style="width:100%; border-collapse:collapse; font-size:16px;">
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Dispositivo:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($codigo_dispositivo).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Ubicación:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($ubicacion).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Tipo:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($tipo).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Nivel de urgencia:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($nivel_urgencia).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Descripción:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($descripcion).'</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555;"><b>Reportado por:</b></td>
                        <td style="padding:8px 0;">'.htmlspecialchars($usuario).'</td>
                    </tr>
                </table>
                <div style="margin-top:24px; color:#888; font-size:13px; text-align:center;">
                    Ascardio - Sistema de Gestión de Fallos
                </div>
            </div>
        </div>
        ';

        $mail->send();

    } catch (Exception $e) {
        echo "El mensaje correo no pudo ser enviado, mailer error: {$mail->ErrorInfo}";
    }
}
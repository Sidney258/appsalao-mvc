<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];

        $mail->setFrom('noreply@appsalon.com');
        $mail->addAddress('contas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma a tua cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Ola <strong>' . $this->nombre . '</strong> Criaste uma conta em AppSalon, so deves confirmer presionando o seguinte link</p>';
        $contenido .= '<p>Pressiona aqui: <a href="' . $_ENV['APP_URL'] . '/confirmar-cuenta?token=' . $this->token . '">Confirmar Conta</a></p>';
        $contenido .= '<p>Se tu nao solicitaste esta conta, podes ignorar esta mensagem</p>';
        $contenido .= '</html>';
        $mail->Body = $contenido;
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];

        $mail->setFrom('noreply@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestabelece a tua password';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Ola <strong>' . $this->nombre . '</strong> solicaste reestabelecer a tua password, 
        segue o seguinte link para reestabelecer</p>';
        $contenido .= '<p>Pressiona aqui: <a href="' . $_ENV['APP_URL'] . '/recuperar?token=' . $this->token . '">Reestabelecer Password</a></p>';
        $contenido .= '<p>Se tu nao  solicitaste esta mudanca, podes ignorar esta mensagem</p>';
        $contenido .= '</html>';
        $mail->Body = $contenido;
        $mail->send();
    }
}

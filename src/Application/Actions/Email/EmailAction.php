<?php

// src/Application/Actions/Email/EmailAction.php
namespace App\Application\Actions\Email;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailAction
{
    public function __invoke(Request $request, Response $response): Response
    {

        $data = $request->getParsedBody();

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Recuperar archivos subidos
            $uploadedFiles = $request->getUploadedFiles();
            $frontPhoto = $uploadedFiles['frontPhoto'];
            $backPhoto = $uploadedFiles['backPhoto'];

            $mail->isSMTP();
            $mail->Host = 'mail.blessingstoyoucr.com'; //
            $mail->SMTPAuth = true;
            $mail->Username = 'it@blessingstoyoucr.com';
            $mail->Password = 'GoBeyond2023';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('it@blessingstoyoucr.com', 'Desarrollo Freelance JZUAR');
            //$data['email'] = "juandiegoster@gmail.com";
            $mail->addAddress($data['correo'], $data['nombre']);
            $mail->addCC('4peacenfreedom@gmail.com');
            $mail->addBCC('juandiegoster@gmail.com');

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Beyond Demo';
            $mail->Body = 'Estos son los datos del formulario:' . "<br>";



            // Añade los archivos adjuntos
            if (isset($data['frontPhoto']) && isset($data['backPhoto'])) {
                $frontPhotoData = base64_decode($data['frontPhoto']);
                $backPhotoData = base64_decode($data['backPhoto']);

                $mail->AddStringAttachment($frontPhotoData, 'img1.jpg', 'base64', 'image/jpeg');
                $mail->AddStringAttachment($backPhotoData, 'img2.jpg', 'base64', 'image/jpeg');
            }

            foreach ($data as $key => $value) {

                $mail->Body .= $key . ': ' . $value . "<br>";
            }

            $mail->send();

            $response->getBody()->write(json_encode(['mensaje' => 'Correo enviado']));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Error al enviar el correos'. $e]));
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}

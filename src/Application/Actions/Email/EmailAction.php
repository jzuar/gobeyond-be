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
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; //
            $mail->SMTPAuth = true;
            $mail->Username = 'desarrollofreelancejzuar@gmail.com';
            $mail->Password = 'Desarrollando2023.';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('desarrollofreelancejzuar@gmail.com', 'Desarrollo Freelance JZUAR');
            $data['email'] = "juandiegoster@gmail.com";
            $mail->addAddress($data['email']); // Cambiar al destinatario correcto

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Beyond Demo';
            $mail->Body = 'estos es una prueba de correo';

            $mail->send();

            $response->getBody()->write(json_encode(['mensaje' => 'Correo enviado']));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['error' => 'Error al enviar el correo']));
        }

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}

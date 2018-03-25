<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 24/03/18
 * Time: 18:13
 */
class Postman
{
    public static function sendEmail($address, $subject, $body)
    {
        $mail = new PHPMailer();
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();

        $mail->Host = 'smtp.mailtrap.io';
        $mail->Port = 2525;
        $mail->Username = getenv('MAILTRAP_USERNAME');
        $mail->Password = getenv('MAILTRAP_PASSWORD');
        $mail->SMTPAuth = true;

        $mail->IsSMTP();

        $mail->Timeout = 10;

        //Recipients
        $mail->setFrom('passwords@cscu9w6.com', 'cscu9w6 password manager');
        $mail->addAddress($address);

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
    }
}
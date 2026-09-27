<?php
/**
 * send_mail() - Send email via Gmail SMTP using PHPMailer.
 * Credentials are read from config/.env:
 *   MAIL_USER = your Gmail address (e.g. devzs2026@gmail.com)
 *   MAIL_PASS = your Gmail App Password (16-char, no spaces)
 */
function send_mail(string $toEmail, string $toName, string $subject, string $body, string $replyTo = ''): string {
    $dir = __DIR__ . '/PHPMailer/';
    require_once $dir . 'Exception.php';
    require_once $dir . 'PHPMailer.php';
    require_once $dir . 'SMTP.php';

    $mailUser = env_get('MAIL_USER');
    $mailPass = env_get('MAIL_PASS');
    $fromName = env_get('MAIL_FROM_NAME', 'DEVS Team');

    if (!$mailUser || !$mailPass) {
        return 'MAIL_USER or MAIL_PASS not set in .env';
    }

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailUser;
        $mail->Password   = $mailPass;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($mailUser, $fromName);
        $mail->addAddress($toEmail, $toName);
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($replyTo);
        }

        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->isHTML(false);

        $mail->send();
        return ''; // empty string = success
    } catch (\Exception $e) {
        return $mail->ErrorInfo;
    }
}

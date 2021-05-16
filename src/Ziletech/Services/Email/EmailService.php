<?php

namespace Ziletech\Services\Email;

use PHPMailer\PHPMailer\PHPMailer;

class EmailService {

    const EMAIL_SMTP_DEBUG = false;

    /**
     *
     * @var EmailProvider
     */
    private $emailProvider;

    public function __construct(EmailProvider $emailProvider) {
        $this->emailProvider = $emailProvider;
    }

    public function test() {
        send(array("'sks.256@gmail.com'" => "Sunil"), "PHPMailer Test Subject via mail()", "Message goes here");
    }

    public function contact_us($htmlMessage, $sendTo) {
        //$htmlMessage = $htmlMessage;
        return $this->send(array($sendTo => ""), "Contact Me", $htmlMessage, $sendTo);
    }

    public function send($toArray, $subject, $htmlMessage) {
        $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        $mail->IsSMTP(); // telling the class to use SMTP
        try {
            $mail->SMTPDebug = EmailService::EMAIL_SMTP_DEBUG;                     // enables SMTP debug information (for testing)
            $mail->SMTPAutoTLS = $this->emailProvider->getSMTPAutoTLS();
            $mail->SMTPAuth = $this->emailProvider->getSMTPAuth();//getenv("EMAIL_AUTH");                  // enable SMTP authentication
            $mail->SMTPSecure = $this->emailProvider->getSMTPSecure();//getenv("EMAIL_SECURED");                 // sets the prefix to the servier
            $mail->Host = $this->emailProvider->getHost();//getenv("EMAIL_HOST");      // sets GMAIL as the SMTP server
            $mail->Port = $this->emailProvider->getPort();//getenv("EMAIL_PORT");                   // set the SMTP port for the GMAIL server
            $mail->Username = $this->emailProvider->getUsername();//getenv("EMAIL_EMAIL");    // GMAIL username
            $mail->Password = $this->emailProvider->getPassword();//getenv("EMAIL_PASSWORD");           // GMAIL password
            foreach ($toArray as $email) {
                $mail->AddAddress($email);
            }
            //@TODO need to configureable
            $mail->SetFrom($this->emailProvider->getUsername(), 'Sunil Alert');
            //$mail->AddReplyTo(getenv("EMAIL_EMAIL"), '');
            $mail->Subject = $subject;
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
            $mail->MsgHTML($htmlMessage);
            #$mail->MsgHTML(file_get_contents('contents.html'));
            #$mail->AddAttachment('images/phpmailer.gif');      // attachment
            #$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
            $mail->Send();
            #echo "Message Sent OK</p>\n";
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
            return false;
        } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
            return false;
        }
        return false;

    }

}

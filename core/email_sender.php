<?php
// Name: email_sender php
// Description: To send email to users
// Author: KTK27
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'includes/Exception.php';
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require_once 'welcome_template.php';
require_once 'export_sender.php';
require_once 'inventory_pdf_maker.php';
// Welcome Email sender
function welcome_mail($to, $to_name, $to_avatar){
    $mail = new PHPMailer(true);
    require "config.php";
    try {
        $mail -> isSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = 'smtp.gmail.com';
        $mail -> Port = 587;
        $mail -> Username = $emailusername;
        $mail -> Password = $emailpassword;
        $mail -> isHTML(true);
        $mail -> addAddress($to, $to_name);
        $mail -> setFrom( $emailusername , "DND");
        $mail -> Subject = "Welcome " . $to_name . " to DND";
        $mail -> Body = mail_template($to_name, $to_avatar);
        $mail->send();
    } catch (Exception $e) {
        echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
        echo '<div class="alert alert-danger" style="z-index: 100;" role="alert">
        We couldn\'t send you a welcome email? We often use email as a means of delievering you information related to your account.
        </div>';
echo '</div>';
        echo "Message Could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
//Inventory Export Email
function inventory_export_mail($to,$to_name){
    $mail = new PHPMailer(true);
    require "config.php";
    try {
        $mail -> isSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = 'smtp.gmail.com';
        $mail -> Port = 587;
        $mail -> Username = $emailusername;
        $mail -> Password = $emailpassword;
        $mail -> isHTML(true);
        $mail -> addAddress($to, $to_name);
        $mail -> setFrom($emailusername , "DND");
        $mail -> Subject = "Hello " . $to_name . " Inventory Export ";
        $mail -> Body = export_sender();
        $mail->send();
        $success = " Message has been sent";
        echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
        echo '<div class="alert alert-success" style="z-index: 100;"  role="alert">
        ' . $success . '
      </div>';
      echo '</div>';
    } catch (Exception $e) {
        $ERROR = $mail->ErrorInfo;
        echo '<div class="alerts" id="hideMe" style="z-index: 100;">';
        echo '<div class="alert alert-danger" style="z-index: 100;" role="alert">
     '. $ERROR . '
    </div>';
       echo '</div>';
    }
}


?>
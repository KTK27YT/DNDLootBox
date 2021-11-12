<?php
// Name: welcome_template php
// Description: template for creating the welcome email!
// Author: KTK27
    function mail_template($name,$avatar) {
        $message = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>
        <head>
            </xml>
            <![endif]-->
            <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
            <!--[if !mso]><!-->
            <link href='https://fonts.googleapis.com/css?family=Muli:400,400i,700,700i' rel='stylesheet' />
            <!--<![endif]-->
            <title>Email Template</title>
            <!--[if gte mso 9]>
            <style type='text/css' media='all'>
                sup { font-size: 100% !important; }
            </style>
            <![endif]-->
            <style>
            .body {
                    color: white; }
            
                #avatar {
            /* This image is 687 wide by 1024 tall, similar to your aspect ratio */
            background-image: url('". $avatar . "');
            
            /* make a square container */
            width: 100px;
            height: 100px;
        
            /* fill the container, preserving aspect ratio, and cropping to fit */
            background-size: cover;
        
            /* center the image vertically and horizontally */
            background-position: top center;
        
            /* round the edges to a circle with border radius 1/2 container size */
            border-radius: 50%;
        
            margin-left:360px;
        
            margin-bottom: 20px;
    
            margin-top: 20px;
        }
            </style>
        
            <style type='text/css' media='screen'>
                /* Linked Styles */
                body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#001736; -webkit-text-size-adjust:none; color: white; }
                a { color:#66c7ff; text-decoration:none  }
                p { padding:0 !important; margin:0 !important } 
                img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
                .mcnPreviewText { display: none !important; }
                    
                }
            </style>
        </head>
        <body class='body' style='padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#001736; -webkit-text-size-adjust:none; padding-top: 50px;'>
        <div style='width:800px; margin:0 auto; content-align: center; text-align: center;'>
        <div id='avatar'> </div>
        <br>
        <h1 style='font='Open Sans';'> Welcome  ". $name . " </h1>
        <br>
        <h3 style='font='arial';'> to DND ! Hope you enjoy your stay! <h3>
        <hr>
        <br>
        <h5 style='font='arial';'> please do not respond to this email this is an automated email</h5>
                </div>
        </body>
        </html>        
        ";

        return $message;
    }


?>
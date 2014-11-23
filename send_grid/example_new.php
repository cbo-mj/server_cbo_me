<?php

//
// SendGrid PHP Library Example
//
// This example shows how to send email through SendGrid
// using the SendGrid PHP Library.  For more information
// on the SendGrid PHP Library, visit:
//
//     https://github.com/sendgrid/sendgrid-php
//

require 'vendor/autoload.php';


/* USER CREDENTIALS
/  Fill in the variables below with your SendGrid
/  username and password.
====================================================*/
$sg_username = "your_sendgrid_username";
$sg_password = "your_sendgrid_password";


/* CREATE THE SENDGRID MAIL OBJECT
====================================================*/
$sendgrid = new SendGrid( $sg_username, $sg_password );
$mail = new SendGrid\Email();



/* SMTP API
====================================================*/
// ADD THE RECIPIENTS
/*$emails = array (
    "anshuman.saraswat@gmail.com"
);
foreach($emails as $recipient) {
    $mail->addTo($recipient);
}*/

// ADD THE SUBSTITUTIONS
$subs = array (
    "%name%" => array (
        "anshuman"
    ),
    "%price%" => array (
        "4$"
    )
);
foreach($subs as $tag => $replacements) {
    $mail->addSubstitution($tag, $replacements);
}

// ADD THE SECTIONS
$sections = array (
    "-name-" => "%name%",
    "-price-" => "%price%"
);
foreach($sections as $tag => $section) {
    $mail->addSection($tag, $section);
}

// ADD THE APP FILTERS
$filters = array (
    "templates" => array (
        "settings" => array (
            "enabled" => 1,
            "template_id" => "c3efb2d0-5cbb-456b-89a4-08982f82cde0"
        )
    )
);
foreach($filters as $filter => $contents) {
    $settings = $contents['settings'];
    foreach($settings as $key => $value) {
        $mail->addFilterSetting($filter, $key, $value);
    }
}


/* SEND MAIL
/  Replace the the address(es) in the setTo/setTos
/  function with the address(es) you're sending to.
====================================================*/

try {
    $mail->
    setFrom( "info@cbo.me" )->
    addTo( "kamalchoudharyindia@gmail.com" )->
    setSubject( "Refrigrator" )->
    setText( "hello" )/*->
    setHtml( "" )*/;
    $sendgrid->send( $mail );

    echo "Sent mail successfully.";
} catch ( Exception $e ) {
    echo "Unable to send mail: ", $e->getMessage();
}


?>

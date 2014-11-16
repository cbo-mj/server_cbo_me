<?php
 // INCLUDE THE phpToPDF.php FILE
require("examples/phpToPDF.php"); 

// PUT YOUR HTML IN A VARIABLE
$my_html = "
<html>
        <h1>WEBSITE SUBSCRIPTION SERVICE AGREEMENT</h1>
        <p>I/We request and authorise Acknowledement. By signing and/or providing us with a valid instruction in respect to yourDirect Debit Request, you have understood and agreed to the terms and conditions governing the debit arrangements between you and Complete Business Online Pty Ltd as set out in the Direct Debit Request Service Agreement below.</p>
        
        <table border=\"0\" style=\"width: 100%; margin-bottom: 20px;\">
            <tr>
                <td style=\"width: 40%\"><strong>Amount:</strong></td>
                <td>" . htmlspecialchars($_GET["a"]) . "</td>
            </tr>
            <tr>
                <td><strong>Date of First Payment:</strong></td>
                <td>" . htmlspecialchars($_GET["b"]) . "</td>
            </tr>
            <tr>
                <td><strong>Frequency:</strong></td>
                <td>" . htmlspecialchars($_GET["c"]) . "</td>
            </tr>
            <tr>
                <td><strong>No. of Payments:</strong></td>
                <td>" . htmlspecialchars($_GET["d"]) . "</td>
            </tr>
            <tr>
                <td><strong>Website URL:</strong></td>
                <td>" . htmlspecialchars($_GET["e"]) . "</td>
            </tr>
            <tr>
                <td><strong>Company Name:</strong></td>
                <td>" . htmlspecialchars($_GET["f"]) . "</td>
            </tr>
        </table>
        
        <table border=\"0\" style=\"width: 100%; margin-bottom: 20px;\">
            <tr>
                <td style=\"width: 50%\"><strong>" . htmlspecialchars($_GET["g"]) . "</strong></td>
                <td><strong>" . htmlspecialchars($_GET["h"]) . "</strong></td>
            </tr>
            <tr>
                <td><img src=\"http://projects.cbo.me/signature/images/" . htmlspecialchars($_GET["i"]) . "\" /></td>
                <td><img src=\"http://projects.cbo.me/signature/images/" . htmlspecialchars($_GET["j"]) . "\" /></td>
            </tr>
        </table>
    </body>";

// SET YOUR PDF OPTIONS
// FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
$pdf_options = array (
  "source_type" => 'html',
  "source" => $my_html,
  "action" => 'save',
  "save_directory" => 'subscription-agreement',
  "file_name" => htmlspecialchars($_GET["k"]).'.pdf');

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);


//header("Location: html_01.pdf");
//OPTIONAL - PUT A LINK TO DOWNLOAD THE PDF YOU JUST CREATED
echo ("<a href='/pdf/project-portal/subscription-agreement/" . htmlspecialchars($_GET["k"]) . ".pdf'>Download Your PDF</a>");

?>
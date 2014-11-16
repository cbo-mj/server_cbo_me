<?php
 // INCLUDE THE phpToPDF.php FILE
require("examples/phpToPDF.php"); 

// PUT YOUR HTML IN A VARIABLE
$my_html = "
<html>
        <h1>DIGITAL SERVICE ACCEPTANCE</h1>
        <p>In the final stages of your website construction it is important to us that we acknowledge the processes that have taken place and we have reached the desired outcome. </p>
        <p id='data-a'>" . htmlspecialchars($_GET["a"]) . "</p>
        <p id='data-b'>" . htmlspecialchars($_GET["b"]) . "</p>
        <h3>IMPORTANT:</h3>
        <p>In signing this document, you are in agreement that the above work meets your specifications. Please note that changes to any project elements after sign-off may be subject to additional charges. We stand by our work and offer a 30 day  Warranty on all Digital services to ensure you are completely satisfied with the outcome. You guarantee that any elements of text, graphics, photos, designs, trademarks, or other artwork furnished to CBO for inclusion on your website are owned by you, or that you have permission from the rightful owner to use each of these elements, and will hold harmless, protect, and defend CBO from any claim or suit arising from the use of such elements furnished by You.</p>
        <p>Further to this, upon marking the project as complete and accepted as the final product, you accept all terms set out in the Web Services / Hosting Terms and Conditions. These terms are listed below and are available online. </p>
        <p><img id='data-c' src='http://projects.cbo.me/signature/images/" . htmlspecialchars($_GET["c"]) . "' /></p>
    </body>";

// SET YOUR PDF OPTIONS
// FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
$pdf_options = array(
  "source_type" => 'html',
  "source" => $my_html,
  "action" => 'save',
  "save_directory" => 'digital-service-acceptance',
  "file_name" => htmlspecialchars($_GET["d"]).'.pdf');

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);


//header("Location: html_01.pdf");
//OPTIONAL - PUT A LINK TO DOWNLOAD THE PDF YOU JUST CREATED
echo ("<a href='/pdf/project-portal/digital-service-acceptance/" . htmlspecialchars($_GET["d"]) . ".pdf'>Download Your PDF</a>");

?>
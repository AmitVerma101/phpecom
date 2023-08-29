<?php 
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');  
// Include the TCPDF library
// Create a new TCPDF instance
function createPdf($username){
    $pdf = new TCPDF();

    // Add a page
    $pdf->AddPage();

    // Your PHP content to include in the PDF
    $file = 'utils/template.html';
    #opening file for reading
    $handle = fopen($file, 'r');
    #reading file
    $fileContent = fread($handle, filesize($file));
    $pattern = "/username/i";
    $content = preg_replace($pattern, $username, $fileContent);
    $name = $username.bin2hex(random_bytes(3)).".pdf";
    // Add the content to the PDF
    $pdf->writeHTML($content, true, false, true, false, '');
    $PATH = $_SERVER['DOCUMENT_ROOT'];
    $PATH = $PATH.'myEcom/attatchment/'.$name;
    // Output the PDF to a file (e.g., 'output.pdf')
    $pdf->Output("$PATH", 'F');
    return $name;

}

?>
<?php 
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->getOptions()->getChroot(); 

$html = <<<HTML
<!DOCTYPE html>
<html lang="de">
    <body>
        <h4>Product Name</h4>
        <h4>Product Id</h4>
        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        <img src="uploads/amazefit.jpg" width=100px;>
    </body>
</html>
HTML;

$dompdf->loadHtml($html);
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
?>
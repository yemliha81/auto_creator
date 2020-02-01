<?php
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$post = $_POST;

$imgname = trim($post['imgname']);
$printer_ip = trim($post['printer_ip']);


function debug($arr){
	echo '<pre>';
	print_r( $arr );
	die(); 
}

$connector = new WindowsPrintConnector($printer_ip);


/* Information for the receipt */

$printer = new Printer($connector);

try{
	$dest = $_SERVER['DOCUMENT_ROOT'].'/aaaa_print1/escpos/example/tmpimg/'.$imgname;
    /* Load up the image */
    try {
        $img = EscposImage::load($dest);
    } catch (Exception $e) {
        //unlink($dest);
        throw $e;
    }
   //unlink($dest);

    /* Print it */
    $printer -> bitImage($img); // bitImage() seems to allow larger images than graphics() on the TM-T20. bitImageColumnFormat() is another option.
    $printer -> cut();
} catch (Exception $e) {
    echo $e -> getMessage();
} finally {
    $printer -> close();
}
 ?>

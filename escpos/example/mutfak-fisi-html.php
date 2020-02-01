<?php
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;

/* if($_POST['printer_type'] == 'usb'){
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
} */
//if($_POST['printer_type'] == 'network'){
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
//}


$post = $_POST;

$imgname = trim($post['imgname']);
$printer_ip = trim($post['printer_ip']);


function debug($arr){
	echo '<pre>';
	print_r( $arr );
	die(); 
}
//debug($post);

/* Fill in your own connector here */
//$connector = new WindowsPrintConnector("SLK-TL320");


/* if($post['printer_type'] == 'usb'){
	$connector = new WindowsPrintConnector($printer_ip);
} */
//if($post['printer_type'] == 'network'){
$connector = new NetworkPrintConnector($printer_ip, 9100);
//}

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

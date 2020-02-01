<?php
require __DIR__ . '\..\..\autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
		
function replaceStr($s) {
	$tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','%','₺');
	$eng = array('s','S','i','I','g','G','u','U','o','O','C','c','', '');
	$s = str_replace($tr,$eng,$s);
 
	return $s;
}

function print_rows($array, $order_id, $printer_name){
	$connector = new WindowsPrintConnector($printer_name);
	//$logo = EscposImage::load( __DIR__ . "/../../img/panda.jpg", false);
	$printer = new Printer($connector);
	$printer->getPrintConnector()->write(PRINTER::ESC . "B" . chr(5) . chr(1));
	/* Print top logo */
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	//$printer -> bitImage($logo);
	$printer -> text(  "Fis No: ".$order_id."\n" );
	$printer -> text(  date("d-m-Y H:i")."\n" );
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> feed(2);
	$printer -> setEmphasis(true);
	$printer -> text(  "Urun                      Fiyat   Adet     Tutar\n" );
	$printer -> setEmphasis(false);
	$printer -> text("------------------------------------------------");
	$total = 0.00;
	
	foreach($array as $key => $val){
		$printer -> text( rowsArrange( substr( replaceStr($val['pro_name']),0,20  ), $val['qty'], $val['price'])."\n" );
		
		$total += ($val['qty'] * $val['price']);
		
	}
	
	$printer -> text("------------------------------------------------");
	$printer -> setEmphasis(true);
	$printer -> text(str_pad("TOPLAM",38," ").str_pad((number_format($total,2)),10," ",STR_PAD_LEFT));
	$printer -> setEmphasis(false);

	$printer -> feed(2);
	//$printer -> text($date . "\n");

	/* Cut the receipt and open the cash drawer */
	
	$printer -> cut();
	$printer -> pulse();
	
	$printer -> close();
}

function rowsArrange($pro_name, $qty, $price){
	return str_pad($pro_name,23," ") . str_pad($price,8," ", STR_PAD_LEFT). str_pad($qty,7," ", STR_PAD_LEFT) . str_pad(number_format(($qty*$price),2),10," ",STR_PAD_LEFT);
}
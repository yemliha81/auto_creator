<?php
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

$post = $_POST['items'];
//debug($post);
$itemsArray = $post;


function debug($arr){
	echo '<pre>';
	print_r( $arr );
	die(); 
}
//debug($itemsArray['printer_ip']);

/* Fill in your own connector here */
$connector = new WindowsPrintConnector("SLK-TL320");
//$connector = new NetworkPrintConnector($itemsArray['printer_ip'], 9100);

/* Information for the receipt */


	foreach( $itemsArray['products'] as $key => $val ){
		$items[] = new item($val['pro_name']." x ".$val['qty'], "");
		//$items[] = new item("-----------------------------------", "----------");
	} 


//$subtotal = new item('Subtotal', '12.95');
//$tax = new item('A local tax', '1.30');
//$total = new item('Total', '14.25', true);
/* Date is kept the same for testing */
// $date = date('l jS \of F Y h:i:s A');
//$date = "Monday 6th of April 2015 02:56:25 PM";

/* Start the printer */
//$logo = EscposImage::load("resources/escpos-php.png", false);
$printer = new Printer($connector);

/* Print top logo */
$printer -> setJustification(Printer::JUSTIFY_CENTER);
//$printer -> graphics($logo);

/* Name of shop */
//$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> setEmphasis(true);
$printer -> text($itemsArray['restaurant_name']);
$printer -> selectPrintMode();


/* Title of receipt */
$printer -> setEmphasis(true);
$printer -> feed(2);
$printer -> text("MUTFAK Fisi\n");
$printer -> feed(2);
$printer -> text($itemsArray['kitchen_name']);
$printer -> feed();
$printer -> text($itemsArray['time']);
$printer -> feed();

/* Items */
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
//$printer -> text(new item('', '$'));
$printer -> setEmphasis(false);
foreach ($items as $item) {
    $printer -> text($item);
}
//$printer -> setEmphasis(true);
//$printer -> text($subtotal);
$printer -> setEmphasis(false);
$printer -> feed();

/* Tax and total */
//$printer -> text($tax);
//$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
//$printer -> text($total);
//$printer -> selectPrintMode();

/* Footer */
$printer -> feed(2);
$printer -> setJustification(Printer::JUSTIFY_CENTER);
//$printer -> text("Thank you for shopping at ExampleMart\n");
//$printer -> text("For trading hours, please visit example.com\n");
$printer -> feed(2);
$printer -> text($date . "\n");

/* Cut the receipt and open the cash drawer */
$printer -> cut();
$printer -> pulse();

$printer -> close();

/* A wrapper to do organise item names & prices into columns */
class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
        $rightCols = 1;
        $leftCols = 28;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        
        $sign = ($this -> dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}

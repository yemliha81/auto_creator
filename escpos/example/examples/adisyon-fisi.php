<?php
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
//use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

$post = $_POST['items'];
//debug($post);
$itemsArray = $post;

//debug($post);

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


	foreach( $itemsArray['order_details'] as $key => $val ){
		$items[] = new item($val['pro_name']." ".$val['description'], $val['qty'], $val['price']);
		//$items[] = new item("-----------------------------------", "----------");
	} 


$tot = new item('Toplam', $itemsArray['total_price']." TL");
$discount = new item('İndirim', $itemsArray['discount_price']." TL");
$paid = new item('Ödenen', $itemsArray['paid_price']." TL");
//$tax = new item('A local tax', '1.30');
$total = new item('Kalan', $itemsArray['rest_price']." TL", true);
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
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text($itemsArray['restaurant_name']);
$printer -> selectPrintMode();


/* Title of receipt */
$printer -> setEmphasis(true);
$printer -> feed(2);
$printer -> text("Masa : ".$itemsArray['table_name']);
$printer -> feed(2);
$printer -> text("Garson : ".$itemsArray['user_name']);
$printer -> feed();
$printer -> text($itemsArray['order_insert_time']);
$printer -> feed();

/* Items */
$printer -> setJustification(Printer::JUSTIFY_LEFT);
$printer -> setEmphasis(true);
//$printer -> text(new item('', '$'));
$printer -> setEmphasis(false);
foreach ($items as $item) {
    $printer -> text($item);
}
$printer -> setEmphasis(true);
$printer -> text($tot);
$printer -> setEmphasis(true);
$printer -> text($paid);
$printer -> setEmphasis(true);
$printer -> text($discount);
$printer -> setEmphasis(false);
$printer -> feed();

/* Tax and total */
//$printer -> text($tax);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text($total);
$printer -> selectPrintMode();

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
    private $qty;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $qty = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> qty = $qty;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }
    
    public function __toString()
    {
        $rightCols = 8;
        $middleCols = 4;
        $leftCols = 30;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        $middle = str_pad($this -> qty, $middleCols) ;
        
        $sign = ($this -> dollarSign ? '' : '');
        $right = str_pad($this -> price , $rightCols, ' ', STR_PAD_LEFT);
        return "$left$middle$right\n";
    }
}

<?php $post = $_POST['items'];

/* echo '<pre>';
print_r($post);
die(); */
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
	<style type="text/css">
		body{font-family:arial;font-size:16px;}
		.cnt{text-align:center}
		.p10{padding:10px;}
		.clr{clear:both;}
		
		.w70{width:70%; float:left;}
		.w30{width:30%; float:left;}
	</style>
</head>
<body>
	<div id="capture" style="padding: 10px;">
		<div class="p10 cnt"><strong><?php echo $post['restaurant_name'];?></strong></div>
		<div class="p10 cnt"><strong>Mutfak Fişi</strong></div>
		<div class="p10 cnt"><?php echo date('d-m-Y H:i');?></div>
		<div class="p10 cnt"><?php echo $post['kitchen_name'];?></div>
		
		<?php foreach( $post['products'] as $key => $val ){ ?>
		
			<div class="">
				<div class="w70"><?php echo $val['pro_name'];?></div>
				<div class="w30"><?php echo $val['qty'];?></div>
				<div class="clr"></div>
			</div>
		
		<?php } ?>
		
		<div style="border-bottom:1px solid #000;"></div>
		
		
	</div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/html2canvas.js"></script>

<?php $file_name = uniqid().'.png';?>

<script type="text/javascript">
	
	$(document).ready(function(){
	
	html2canvas(document.querySelector("#capture")).then(canvas => {
		//document.body.appendChild(canvas);
		saveAs(canvas.toDataURL(), '<?php echo $file_name;?>'); //or whatever you want to execute
	});
	
	function saveAs(uri, filename) {

		
		$.ajax({
			url: 'save_image.php',
			data: {
			       imgdata:uri,
				   file_name : filename
				   },
			type: 'post',
			success: function (response) {   
               //console.log(response);
			   
			   /* if( response != '' ){
				   
				   if( response != 'error' ){
					   console.log('img created '+response);
					   $.ajax({
						   type : "post",
						   url : "mutfak-fisi-html.php",
						   data : "imgname" : response,
						   success : function(response2){
							   console.log(response2);
						   }
					   });
					   
				   }
				   
			   } */
			   
			}
		});
	}
	});
</script>
</html>
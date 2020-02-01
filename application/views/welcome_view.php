<?php include('includes/header.php');?>
<div class="w10 h100 bR p5" style="position:relative;">
	<a href="<?php echo MAIN_BOARD;?>" class="btn btn-info form-control">Anasayfa</a>
</div>
<div class="w40 h100 bR" style="position:relative;">
	<input type="text" class="barcodeInput bB foc" placeholder="Barkodu Okutunuz..." />
		<form id="shopForm">
			<div class="ShopList"></div>
		</form> 
	<div class="total_p">0.00</div>
	<a href="javascript:;" class="btn btn-success svShop" >KAYDET</a>
</div>
<div class="w50 h100">
	<div class="products">
		<?php foreach ($pro_list as $key => $val) { ?>
			<div class="proBox" rel="<?php echo $val['pro_barcode'];?>">
				<img src="<?php echo FATHER_BASE;?>img/<?php echo $val['pro_img'];?>" width="100%">
				<div class="proName">
					<?php echo $val['pro_name'];?>
				</div>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
	</div>
</div>

<!-- Modal -->
<div id="newModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
		<form id="newPro">
			<p><input type="text" class="form-control pB" name="pro_barcode"></p>
			<p><input type="text" class="form-control pN" name="pro_name" placeholder="Ürün Adı Giriniz"></p>
			<p><input type="text" class="form-control pP" name="pro_price" placeholder="Fiyat Giriniz"></p>
			<p><a href="javascript:;" class="btn btn-success form-control svPro">KAYDET</a></p>
		</form>
	  </div>
    </div>

  </div>
</div>
<input type="hidden" class="focc" value="0">
<?php include('includes/footer.php');?>
<script>

$(document).on("click", ".proBox", function(){
	var rel = $(this).attr("rel");
	$(".barcodeInput").val(rel);
	sell();
});

	setInterval(function(){
		var isFocus = $(".focc").val();
		
		if(isFocus == '0'){
			if (!($(".foc").is(":focus"))) {
				$(".foc").focus();
			}
		}
		
		
	},500);
	
	$(".barcodeInput").change(function(){
		sell();
	});
	
	function sell(){
		var barcode = $(".barcodeInput").val();
			
			if(barcode != ''){
				$.ajax({
					type : "post",
					url : "<?php echo SEARCH_PRO;?>",
					data : { "barcode" : barcode },
					success : function(response){
						
						if(response == "newProduct"){
							$('.pB').val(barcode);
							$(".focc").val("1");
							$('#newModal').modal('show');
						}else{
							proData = JSON.parse(response);
							addProRow(proData.pro_name, proData.pro_price, 1 , proData.pro_id);
							$(".barcodeInput").val("");
						}
					}
				});
			}
			$(".focc").val('0');
	}

	function addProRow(proName, proPrice, qty, pro_id){
		
		var proHtml = '<div class="proRow bB xRow">\
						<div class="w40 bR divBox tt">'+proName+'</div>\
						<div class="w10 bR text-center divBox tt qqty">'+qty+'</div>\
						<div class="w20 bR text-center divBox tt totPrice">'+proPrice+'</div>\
						<div class="w10 bR text-center divBox">\
							<a href="javascript:;" class="minus"><i class="fa fa-minus"></i></a>\
						</div>\
						<div class="w10 bR text-center divBox">\
							<a href="javascript:;" class="plus"><i class="fa fa-plus"></i></a>\
						</div>\
						<div class="w10 text-center divBox">\
							<a href="javascript:;" class="del"><i class="fa fa-trash"></i></a>\
						</div>\
						<div class="clearfix"></div>\
						<input type="hidden" name="pro_id[]" value="'+pro_id+'">\
						<input class="xqty" type="hidden" name="qty[]" value="'+qty+'">\
						<input type="hidden" name="proPrice[]" value="'+proPrice+'">\
					</div>';
		
		
		$(".ShopList").append(proHtml);
		update_total_price();
	}
	
	function update_total_price(){
		
		var totP = 0.00;
		
		$(".xRow").each(function(){
			var q = parseFloat($(this).children('.qqty').text());
			var tot = parseFloat($(this).children('.totPrice').text());
			
				var rowTot = parseFloat(q*tot);
				
				totP += rowTot;
			
		});
		
		totP = parseFloat(totP).toFixed(2);
		$(".total_p").text(totP);
		console.log(totP);
		
	}
	
	$(document).on("click", ".plus", function(){
		var qty = $(this).parent().parent().children('.qqty');
		var xqty = $(this).parent().parent().children('.xqty');
		var qqty = parseInt($(qty).text());
		
		var plus = qqty+1;
		
		$(qty).text(plus);
		$(xqty).val(plus);
		update_total_price();
	});
	
	$(document).on("click", ".minus", function(){
		var qty = $(this).parent().parent().children('.qqty');
		var xqty = $(this).parent().parent().children('.xqty');
		var qqty = parseInt($(qty).text());
		
		if(qqty > 1){
			var plus = qqty-1;
		
			$(qty).text(plus);
			$(xqty).val(plus);
		}
		update_total_price();
		
	});
	
	$(document).on("click", ".del", function(){
		$(this).parent().parent().remove();
		update_total_price();
		
	});
	
	
	$(".svPro").click(function(){
		var formData = $("#newPro").serialize();
		
		$.ajax({
			type : "post",
			url : "<?php echo ADD_PRO_POST;?>",
			data : formData,
			success : function(response){
				if(response == "error"){
					$('#newModal').modal('hide');
					alert("Hata Oluştu!!!");
					$(".focc").val("0");
				}else{
					proData = JSON.parse(response);
					addProRow(proData.pro_name, proData.pro_price, 1 , proData.pro_id);
					$(".barcodeInput").val("");
					$('#newModal').modal('hide');
					$(".focc").val("0");
				}
			}
		});
		
	});
	
	$(".svShop").click(function(){
		var formD = $("#shopForm").serialize();
		
		$.ajax({
			type : "post",
			url : "<?php echo ORDER_SAVE_POST;?>",
			data : formD,
			success : function(response){
				if(response == 'success'){
					location.reload();
				}
			}
		});
		
	});
	
</script>
<?php include('includes/header.php');?>
<style type="text/css">
	.row_content{
		padding: 5px; background: #f5f5f5; border: 1px solid #ddd;
	}
</style>
<div class="container">
	<form action="<?php echo TABLE_CREATOR_POST;?>" method="post">
		<div>
			<a href="javascript:;" class="btn btn-info pull-right addRow">ADD ROW</a>
			<div class="clearfix"></div>
		</div>
		<div class="row_content">
			<div class="col-sm-6">
				<input class="form-control" type="text" name="table_name" placeholder="table_name">
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="main_body">		
		</div>
		<div>
			<input type="submit" class="btn btn-success pull-right saveBtn" value="SAVE">
			<div class="clearfix"></div>
		</div>
	</form>
</div>

<?php include('includes/footer.php');?>
<script>
	
var row = '<div class="row_content first_row">\
			<div class="col-sm-3">\
				<input class="form-control" type="text" name="field_name[]" placeholder="field_name">\
			</div>\
			<div class="col-sm-3">\
				<select name="field_type[]" class="form-control">\
					<option value="int">int</option>\
					<option value="bigint">bigint</option>\
					<option value="varchar">varchar</option>\
					<option value="text">text</option>\
					<option value="float">float</option>\
					<option value="boolean">boolean</option>\
					<option value="timestamp DEFAULT current_timestamp">timestamp</option>\
					<option value="file">file</option>\
				</select>\
			</div>\
			<div class="col-sm-3">\
				<input class="form-control" type="text" name="char_length[]" placeholder="char_length">\
			</div>\
			<div class="col-sm-2">\
				<select name="null[]" class="form-control">\
					<option value="null">null</option>\
					<option value="not null">not null</option>\
				</select>\
			</div>\
			<div class="col-sm-1">\
				<button class="btn btn-danger rmv"> X </button>\
			</div>\
			<div class="clearfix"></div>\
		</div>';

	$(".addRow").click(function(){
	   $(".main_body").append(row);
	});
	$(document).on("click", ".rmv", function(){
	   $(this).parent().parent().remove();
	});
</script>
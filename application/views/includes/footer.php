<?php if( !empty($this->session->flashdata('day')) ){ ?>
	<div class="alert msg alert-<?php echo $this->session->flashdata('type');?>">
		<?php echo $this->session->flashdata('day');?>
	</div>
<?php } ?>

</body>
<script type="text/javascript" src="<?php echo ASSETS;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS;?>js/bootstrap.min.js"></script>
</html>

<script>
	$(document).ready(function(){
		$(".msg").fadeOut(5000);
	});
</script>
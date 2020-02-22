<?php if( !empty($this->session->flashdata('day')) ){ ?>
	<div class="alert msg alert-<?php echo $this->session->flashdata('type');?>">
		<?php echo $this->session->flashdata('day');?>
	</div>
<?php } ?>

</body>
<script type="text/javascript" src="<?php echo ASSETS;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ASSETS;?>js/bootstrap.min.js"></script>
	  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	  <script>
	  $( function() {
		$( ".datepicker" ).datepicker();
	  } );
	  </script>
</html>

<script>
	$(document).ready(function(){
		$(".msg").fadeOut(5000);
	});
</script>
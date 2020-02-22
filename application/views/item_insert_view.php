<?php include('includes/header.php');?>
    <div class='container'>
        <form action='<?php echo $post_link;?>' method='post' enctype="multipart/form-data">
            <?php foreach($fields as $field){ ?>
				<?php echo input_type($field->type, $field->name, NULL, $field->primary_key, $field->default);?>
			<?php } ?>
			<div>
				<input type='submit' class='btn btn-success btn-sm pull-right' value='SAVE' />
			</div>
        </form>
    </div>
<?php include('includes/footer.php');?>
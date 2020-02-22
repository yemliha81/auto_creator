<?php include('includes/header.php');?>
    <div class='container'>
        <form action='<?php echo $post_link;?>' method='post'>
            <?php foreach($fields as $field){ ?>
				<?php echo input_type($field->type, $field->name, $item_details[$field->name], $field->primary_key);?>
			<?php } ?>
			<p>
				<input type='submit' class='btn btn-success' value='SAVE' />
			</p>
        </form>
    </div>
<?php include('includes/footer.php');?>
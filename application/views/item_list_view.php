<?php include('includes/header.php');?>
    <div class='container'>
        <table class='table'>
            <tr>
				<?php foreach($fields as $vv){ ?>
					<?php if(($vv->default == 1) OR ( $vv->default == "'abc'" )){ ?>
						<td>
							<b><?php echo $vv->name;?></b>
						</td>
					<?php } ?>
				<?php } ?>
			</tr>
			<?php foreach($item_list as $key => $val){ ?>
                <tr>
                    <?php foreach($fields as $vv){ ?>
						<?php if(($vv->default == 1) OR ( $vv->default == "'abc'" )){ ?>
							<td>
								<?php echo $val[$vv->name];?>
							</td>
						<?php } ?>
					<?php } ?>
                    <td><a href='<?php echo FATHER_BASE;?>controller/update_item/<?php echo $table_name;?>/<?php echo $val['id'];?>' class='pull-right btn btn-info'>DETAIL</a></td>
                </tr>
            <?php } ?>
        </table>
	</div>
<?php include('includes/footer.php');?>
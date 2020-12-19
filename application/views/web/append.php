<?php $j=sizeof($chart)/3; ?>
<div class="row" id="here">
	<div class="col-md-4">
		<div class="row heading">
			<div class="col-xs-1">
				Sr No
			</div>
			<div class="col-xs-3">
				Tank Name
			</div>
			<div class="col-xs-3">
				Tank Reading
			</div>
			<div class="col-xs-3">
				Tank Volume
			</div>
			<div class="col-xs-2">
				Action
			</div>
		</div>
		<?php $i=1; foreach($chart as $t){ if($i <= $j){ ?>
		<div class="row">
			<div class="col-xs-1">
				<?php echo $i; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->tank_name; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->reading; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->volume; ?>
			</div>
			<div class="col-xs-2">
				<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
				<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $id; ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
			</div>
		</div>
		<?php }$i++; } ?>
	</div>
	<div class="col-md-4">
		<div class="row heading">
			<div class="col-xs-1">
				Sr No
			</div>
			<div class="col-xs-3">
				Tank Name
			</div>
			<div class="col-xs-3">
				Tank Reading
			</div>
			<div class="col-xs-3">
				Tank Volume
			</div>
			<div class="col-xs-2">
				Action
			</div>
		</div>
		<?php $i=1; foreach($chart as $t){ if($i <= $j*2 && $i > $j){ ?>
		<div class="row">
			<div class="col-xs-1">
				<?php echo $i; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->tank_name; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->reading; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->volume; ?>
			</div>
			<div class="col-xs-2">
				<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
				<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $id; ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
			</div>
		</div>
		<?php }$i++; } ?>
	</div>
	<div class="col-md-4">
		<div class="row heading">
			<div class="col-xs-1">
				Sr No
			</div>
			<div class="col-xs-3">
				Tank Name
			</div>
			<div class="col-xs-3">
				Tank Reading
			</div>
			<div class="col-xs-3">
				Tank Volume
			</div>
			<div class="col-xs-2">
				Action
			</div>
		</div>
		<?php $i=1; foreach($chart as $t){ if($i > $j*2){ ?>
		<div class="row">
			<div class="col-xs-1">
				<?php echo $i; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->tank_name; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->reading; ?>
			</div>
			<div class="col-xs-3">
				<?php echo $t->volume; ?>
			</div>
			<div class="col-xs-2">
				<a href='#' onclick='edit("<?php echo $t->id; ?>","<?php echo $t->reading; ?>","<?php echo $t->volume; ?>")'><i class='fa fa-edit'></i></a>
				<a href='<?php echo base_url(); ?>tank_list/chartdelete/<?php echo $t->id; ?>/<?php echo $id; ?>' onclick='return confirm("Are you sure you want to remove this data?");'><i class='fa fa-trash-o'></i></a>
			</div>
		</div>
		<?php }$i++; } ?>
	</div>
</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rbt_id')); ?>:</b>
	<?php echo CHtml::encode($data->rbt_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rbt_code')); ?>:</b>
	<?php echo CHtml::encode($data->rbt_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from_phone')); ?>:</b>
	<?php echo CHtml::encode($data->from_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to_phone')); ?>:</b>
	<?php echo CHtml::encode($data->to_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel')); ?>:</b>
	<?php echo CHtml::encode($data->channel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->download_datetime); ?>
	<br />

	*/ ?>

</div>
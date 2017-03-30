<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_id')); ?>:</b>
	<?php echo CHtml::encode($data->content_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_name')); ?>:</b>
	<?php echo CHtml::encode($data->content_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_type')); ?>:</b>
	<?php echo CHtml::encode($data->content_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apply')); ?>:</b>
	<?php echo CHtml::encode($data->apply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('begin_time')); ?>:</b>
	<?php echo CHtml::encode($data->begin_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('channel')); ?>:</b>
	<?php echo CHtml::encode($data->channel); ?>
	<br />

	*/ ?>

</div>
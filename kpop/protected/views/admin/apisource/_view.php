<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('api_url')); ?>:</b>
	<?php echo CHtml::encode($data->api_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('protocol')); ?>:</b>
	<?php echo CHtml::encode($data->protocol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('method')); ?>:</b>
	<?php echo CHtml::encode($data->method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('partner')); ?>:</b>
	<?php echo CHtml::encode($data->partner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('object_type')); ?>:</b>
	<?php echo CHtml::encode($data->object_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('params')); ?>:</b>
	<?php echo CHtml::encode($data->params); ?>
	<br />

	*/ ?>

</div>
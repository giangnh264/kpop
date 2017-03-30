<?php
$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('logAction')),
);
$this->pageLabel = Yii::t('admin', "Thông tin tác động thuê bao").":".$model->msisdn;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'adminName',	
		'action',
		'ip',
        'params',
		'created_time',
	),
)); ?>
</div>

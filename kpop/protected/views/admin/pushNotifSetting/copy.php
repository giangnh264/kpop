<?php
$this->breadcrumbs=array(
	'Push Notif Setting Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PushNotifSettingIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('PushNotifSettingCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PushNotifSettingView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép PushNotifSetting")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
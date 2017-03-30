<?php
$this->breadcrumbs=array(
	'Push Notif Setting Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PushNotifSettingIndex')),	
);
$this->pageLabel = "Create PushNotifSetting";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
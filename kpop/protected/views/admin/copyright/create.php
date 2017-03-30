<?php
$this->breadcrumbs=array(
	'Copyright Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CopyrightCreate')),	
);
$this->pageLabel = "Thêm m?i";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'ccpList' => $ccpList)); ?>
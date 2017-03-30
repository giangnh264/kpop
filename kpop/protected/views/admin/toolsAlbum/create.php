<?php
$this->breadcrumbs=array(
	'Admin Album Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('/album/index'), 'visible'=>UserAccess::checkAccess('AlbumIndex')),	
);
$this->pageLabel = Yii::t('admin','Thông tin album'); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,
												'categoryList'=>$categoryList,
												'uploadModel'=>$uploadModel,
												'cpList'=>$cpList,
												'albumMeta'=>$albumMeta
								)); ?>
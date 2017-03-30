<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('NewsEventCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách NewsEvent");

?>


<?php

if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));

if(Yii::app()->user->hasFlash('NewsEvent')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('NewsEvent').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-news-event-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

			'name',
			'type',            
			'object_id',
			//'sorder',
			array(
	              'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"", array("class"=>"reorder","rel"=>$this->createUrl('newsEvent/reorder'))  ),
	              'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	              'type' => 'raw',
              ),
            'id',
            'channel',
            'created_time',
			array(
				'class'=>'CButtonColumn',
			),
	),
));
$this->endWidget();

?>

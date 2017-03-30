<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Ccp Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CcpCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách Ccp");


?>


<?php

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));
echo '<div class="op-box" style="display: none;">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','1'=>'Update'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';

if(Yii::app()->user->hasFlash('Ccp')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Ccp').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-ccp-model-grid',
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

		'id',
		'name',
		'description',
		'created_time',
		'sorder',
		'status',
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-ccp-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),

			'template'=>'{view}{update}'
		),
	),
));
$this->endWidget();

?>

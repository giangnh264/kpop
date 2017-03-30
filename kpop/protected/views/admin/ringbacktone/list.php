<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách nhạc chờ đã duyệt'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-rbt-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Lọc trên danh sách','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_searchPopup',array(
	'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
)); ?>
</div>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));

$columns = array(
    
                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'code',
		        'name',
                
                'artist_name',
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-rbt-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=> $columns,
));
   
    echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('ringbacktone/list','render'=>false)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        window.location.reload( true );
                    }'),array('id'=>'closeJobDialog'));
// used by RbtCollectionModel
echo CHtml::hiddenField("collection", $collection);      
echo CHtml::hiddenField("group_id", $group_id);
echo CHtml::hiddenField("actiontype", $actiontype);

// used by CollectionModel
echo CHtml::hiddenField("object", $object);
echo CHtml::hiddenField("collect_id", $collect_id);

echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));

$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

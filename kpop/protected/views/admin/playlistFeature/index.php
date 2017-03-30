<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");

$this->breadcrumbs=array(
	'Admin Feature Playlist Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('addItems'),'linkOptions'=>array('id'=>'add-item'), 'visible'=>UserAccess::checkAccess('PlaylistFeatureCreate')));
$this->pageLabel = Yii::t("admin","Danh sách FeaturePlaylist");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-feature-playlist-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<?php /*
<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
*/?>


<?php
$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">'. Yii::t("admin","Chọn trang này").'('.$model->search()->getItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="all-item">'.  Yii::t("admin","Chọn tất cả").' ('.$model->count().')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">'.  Yii::t("admin","Bỏ chọn tất cả").'</a></li>
        </ul>
    </div>
';

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
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteItems'=>Yii::t('admin','Xóa') ,'publishItems'=>Yii::t('admin','Hiển thị'),'unpublishItems' =>Yii::t('admin','Ẩn')),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
if(Yii::app()->user->hasFlash('FeaturePlaylist')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('FeaturePlaylist').'</div>';
}

echo '</div>';
echo $html_exp;


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-feature-playlist-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'     =>  array('width'=>'50px','style'=>'text-align:left;height:30px;padding-top:10px'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'id',
        array(
        	'header'=>Yii::t('admin','Tên'),
            'name' => 'playlist.name',
		),
        array(
        	'header'=>Yii::t('admin','Người tạo'),
            'name' => 'admin.username',
		),
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),'',array("class"=>"reorder",'rel'=>$this->createUrl('playlistFeature/reorderItems')) ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("playlistFeature/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("playlistFeature/publishItems",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
		),
	),
));
$this->endWidget();

?>

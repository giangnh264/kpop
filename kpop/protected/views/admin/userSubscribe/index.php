<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('UserSubscribeCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách thuê bao");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-user-subscribe-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'msisdn'=>$msisdn
)); ?>
</div><!-- search-form -->

<?php

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));


if(Yii::app()->user->hasFlash('UserSubscribe')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('UserSubscribe').'</div>';
}

$tryReg = UserAccess::checkAccess('UserSubscribeTryRegister',true) && UserAccess::checkAccess('UserSubscribeCancel',true);
$checkRight = (!$tryReg)? array('header'=>'','name'=>'event'):
				array(
          	  	'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-user-subscribe-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
				'value'=>'($data->status==1)?CHtml::link("Hủy",Yii::app()->createUrl("/userSubscribe/cancel",array("phone"=>$data->user_phone)),array(\'onclick\'=>\'return confirm("Bạn có chắc chắn muốn hủy cho thuê bao này?")\')):CHtml::link("Đăng ký lại",Yii::app()->createUrl("/userSubscribe/tryRegister",array("phone"=>$data->user_phone)),array(\'onclick\'=>\'return confirm("Bạn có chắc chắn muốn đăng ký lại cho thuê bao này?")\'))',
				'type'=>'raw',
			);
?>
<script>
    var idf = 'admin-user-subscribe-model-grid';
    var modelf = 'AdminUserSubscribeModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-user-subscribe-model-grid',
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
         array(
         	'header'=>'SDT',
         	'name'=>'user_phone',
         ),
         array(
         	'header'=>'Gói cước',
         	'name'=>'package.name',
         ),
         array(
         	'header'=>'Ngày đăng ký',
         	'name'=>'created_time',
         ),
         array(
         	'header'=>'Ngày hết hạn',
         	'name'=>'expired_time',
         ),
         array(
         	'header'=>'Trạng thái',
         	'value'=>'($data->status==1)?"Hoạt động":"Không hoạt động"',
         ),
		 $checkRight,
		 array(
				'header'=>'Edit',
				'value'=> 'CHtml::link("Edit",Yii::app()->createAbsoluteUrl("userSubscribe/update",array("id"=>$data->id)))',
				'type' => 'raw',
		 ),
	),
));





$this->endWidget();

?>

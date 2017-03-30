<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");


$this->pageLabel = Yii::t("admin","Lịch sử giao dịch từ {from} tới {to}",array('{from}'=>$this->time['fromTime'],'{to}'=>$this->time['toTime']));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.sms-button').click(function(){
	$('.sms-form').toggle();
	return false;
});

$('.send-sms-form').submit(function(){
	var url = '". Yii::app()->createUrl('/transLog/sendsms')."';
	var datas =  $('.send-sms-form').serialize();
	$.ajax({
		  type: 'POST',
		  url: url,
		  data:datas,
		  context: document.body,
		  beforeSend:function(){			
		  },
		  success: function(data){
		  	  $('#return-msg').show().fadeIn(1000);
			  $('#return-msg').html(data);			  
		  },
		  complete:function(){
			  
		  },	
		  statusCode: {
			404: function() {
		    	alert('Request not found');
		  	}
		  } 		  
		});
	return false;
});

");
?>

<div class="title-box search-box">
<?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?>
</div>

<div class="search-form" style="display: block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
<!-- search-form -->
<div class="title-box search-box">
<?php echo CHtml::link(yii::t('admin','Gửi tin nhắn'),'#',array('class'=>'sms-button')); ?>
</div>

<div class="sms-form content-body" style="display: block">
	<div id="return-msg"></div>
	<?php $this->renderPartial('_smsform',array(
			'model'=>$model,
		)); ?>
	
</div>


<?php
if($this->state){
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-user-activity-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
		'user_phone',
		'transaction',
		'obj1_id',
		'obj1_name',
		'obj2_id',
		'channel',
		'price',
		'return_code',
        'created_time',
	),
	));
}


?>

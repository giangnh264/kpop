<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/transLog/sendsms'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'send-sms-form')
)); ?>
    <div class="fl">
        <div class="row">
            <?php echo CHtml::label("SĐT", ""); ?>
            <?php echo CHtml::textField("user_phone") ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::label("ID content", ""); ?>
            <?php echo CHtml::textField("content_id") ?>
        </div>
                
        <div class="row">
            <?php echo CHtml::label("Giao dịch", ""); ?>
            <?php echo CHtml::dropDownList("trans_type", "", 
            								array('download_song'=>"Tải bài hát",'download_video'=>"Tải video",'download_ringtone'=>"Tải nhạc chuông")
            								) ?>
        </div>        
   </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Send'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
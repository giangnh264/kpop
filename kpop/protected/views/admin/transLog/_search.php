<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'loged_time'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'filter[time]',
                    'value'=>trim((isset($_GET['filter']['loged_time']))?$_GET['filter']['loged_time']:""),
		        ));
		     ?>
        </div>  	        
        <div class="row">
            <?php echo $form->label($model,'channel'); ?>
            <?php echo CHtml::dropDownList('filter[channel]',$model->channel, $this->channelList); ?>
        </div>        
        <div class="row">
            <?php echo $form->label($model,'transaction'); ?>
            <?php 
            echo CHtml::dropDownList('filter[transType]',$model->transaction,$this->transList ); ?>
        </div>                   

        
   </div>
   <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'user_phone'); ?>
            <?php echo CHtml::textField("filter[phone]",$this->phone)?>
        </div>
       

        <div class="row">
            <?php echo $form->label($model,'obj1_id'); ?>
             <?php echo CHtml::textField("filter[obj1_id]",$this->objId1)?>
        </div>        

        <div class="row">
            <?php echo $form->label($model,'obj2_id'); ?>
            <?php echo CHtml::textField("filter[obj2_id]",$this->objId2)?>
        </div>       
   </div>

<!--


	<div class="row">
		<?php echo $form->label($model,'obj1_name'); ?>
		<?php echo $form->textField($model,'obj1_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obj1_url_key'); ?>
		<?php echo $form->textField($model,'obj1_url_key',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obj2_name'); ?>
		<?php echo $form->textField($model,'obj2_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>
-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
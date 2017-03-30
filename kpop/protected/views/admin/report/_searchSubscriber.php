<?php
    $period = array();
    foreach (ReportController::$period as $key=>$val){
        $period[$key] = Yii::t('admin',$val);
    }
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

  <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'date'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>$model->className.'[date]',
                    'value'=>trim((isset($_GET[$model->className]['date']))?$_GET[$model->className]['date']:""),
		        ));
		     ?>
        </div>  	        
    </div>
   <div class="fl">    
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin',"Xem theo"),"period"); ?>
            <?php echo CHtml::dropDownList("period", $_GET["period"], $period); ?>
        </div>
   </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
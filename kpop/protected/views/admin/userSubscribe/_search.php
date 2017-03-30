<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table>
		<tr><td>
			<div class="">
			<?php echo $form->label($model,'Số điện thoại'); ?>
			<?php
			echo $form->textField($model,'user_phone',array('value' => $msisdn,'size'=>16,'maxlength'=>16)); ?>
			</div>
			</td>
		</tr>
		<tr>
			<td>
		        <div class="row created_time">
	            <?php echo $form->label($model,'Thời gian'); ?>
		            <?php 
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'AdminUserSubscribeModel[created_time]',
				       		'value'=>isset($_GET['AdminUserSubscribeModel']['created_time'])?$_GET['AdminUserSubscribeModel']['created_time']:'',
				        ));
				     ?>
		        </div> 
			</td>
		</tr>
	</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Tìm kiếm'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
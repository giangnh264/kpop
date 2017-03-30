<div class="login-box">
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		'method'=>'get',
		'enableAjaxValidation'=>true,
	)); ?>
	
	    <?php if($model->getErrors()):?>
	    <div class="row errorSummary" style="text-align:center">
	        <?php
	            echo $form->error($model,'username');
	            echo $form->error($model,'password');
	            echo $form->error($model,'verifyCode');
	        ?>
	    </div>
	    <?php endif;?>
    		
		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo  CHtml::textField("txtUsername");?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo  CHtml::passwordField("txtPassword");?>
		</div>
		<?php echo CHtml::hiddenField("login",1)?>
		<div class="clb"></div>
		<div class="row submit">
			<?php echo CHtml::submitButton('Login'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
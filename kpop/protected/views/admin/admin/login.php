<div class="login-box">
	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
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
			<?php echo $form->textField($model,'username'); ?>
			<?php //echo $form->error($model,'username'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php //echo $form->error($model,'password'); ?>
		</div>
		<?php if(extension_loaded('gd')): ?>
	    <div class="row clearfix" style="margin-bottom:0">
	        <div class="cell first pl15 fl"><?php echo $form->labelEx($model,'verifyCode'); ?></div>
	        <div class="fl pl30">
	        <div class="cell fl "><?php echo $form->textField($model,'verifyCode', array('class'=>'text w50', 'size' => 4,'style'=>'width:60px;margin-right:5px')); ?></div>
	        <div class="cell fr"><?php $this->widget('CCaptcha', array('showRefreshButton'=>false)); ?></div>
	        </div>
	        
	    </div>
	    <?php endif; ?>
		<?php /*
		<div class="row rememberMe">
			<?php echo $form->checkBox($model,'rememberMe',array('class'=>'fl')); ?>
			<?php echo $form->label($model,'rememberMe',array('class'=>'fl')); ?>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>
		*/?>
		<div class="clb"></div>
		<div class="row submit">
			<?php echo CHtml::submitButton('Login'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
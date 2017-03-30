<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-content-limit-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'content_id'); ?>
			<?php //echo $form->textField($model,'content_id'); ?>
			<?php
				if($model->isNewRecord){
					$keepIds = isset($_POST["ids"])?$_POST["ids"]:"";
					echo CHtml::textArea("ids",$keepIds, array("cols"=>50,"rows"=>10));	
				}else{
					echo CHtml::textArea("ids",$model->content_id, array("cols"=>50,"rows"=>10,"readonly"=>"readonly"));
				}
				?>
			<?php echo $form->error($model,'content_id'); ?>
		</div>
	
		<?php if($model->isNewRecord):?>
		<div class="row">
			<?php echo $form->labelEx($model,'content_type'); ?>
			<?php //echo $form->textField($model,'content_type',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->dropDownList($model, "content_type", $this->listContentType) ?>
			<?php echo $form->error($model,'content_type'); ?>
		</div>
		<?php endif;?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'apply'); ?>
			<?php //echo $form->textField($model,'apply',array('size'=>60,'maxlength'=>100)); ?>
			<div style="margin-left: 120px">
				<div>
					<input type="checkbox" name="apply_for[]" value="GUEST" <?php echo (strrpos($model->apply, "GUEST")!==false)?"checked":""?> /> 
					<span>Guest - Không nhận diện TB</span>
				</div> 
				<div>
					<input type="checkbox" name="apply_for[]" value="MEMBER" <?php echo (strrpos($model->apply, "MEMBER")!==false)?"checked":""?> /> 
					<span>Member - Đã nhận diện chưa đăng ký gói</span>
				</div> 
				<div>
					<input type="checkbox" name="apply_for[]" value="SUB_A1"  <?php echo (strrpos($model->apply, "SUB_A1")!==false)?"checked":""?> />
					<span>Sub - Đang dùng gói ngày Amusic</span>
				</div>
				<div>
					<input type="checkbox" name="apply_for[]" value="SUB_A7"  <?php echo (strrpos($model->apply, "SUB_A7")!==false)?"checked":""?> />
					<span>Sub - Đang dùng gói tuần Amusic</span>
				</div>
			</div>
			<?php echo $form->error($model,'apply'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'channel'); ?>
			<?php //echo $form->textField($model,'channel',array('size'=>60,'maxlength'=>100)); ?>
			<div style="margin-left: 120px">
				<div>
					<input type="checkbox" name="channel[]" value="ALL" <?php echo (strrpos($model->channel, "ALL")!==false)?"checked":""?> /> 
					<span>All</span>
				</div> 
				<div>
					<input type="checkbox" name="channel[]" value="WEB" <?php echo (strrpos($model->channel, "WEB")!==false)?"checked":""?> /> 
					<span>Web</span>
				</div> 
				<div>
					<input type="checkbox" name="channel[]" value="WAP" <?php echo (strrpos($model->channel, "WAP")!==false)?"checked":""?> /> 
					<span>Wap</span>
				</div> 
				<div>
					<input type="checkbox" name="channel[]" value="APP" <?php echo (strrpos($model->channel, "APP")!==false)?"checked":""?> /> 
					<span>App</span>
				</div> 
			</div>
			<?php echo $form->error($model,'channel'); ?>
		</div>

		<!--<div class="row">
			<?php /*echo $form->labelEx($model,'begin_time'); */?>
			<?php /*//echo $form->textField($model,'begin_time'); */?>
			<?php
/*				if(!$model->isNewRecord &&  !empty($model->begin_time) && $model->begin_time!=''){
					$model->begin_time = date('Y/m/d H:i',strtotime($model->begin_time));
				}				
				echo $form->textField($model,'begin_time',array('style'=>'width: 150px;', 'id'=>'begin_time')); */?>
			<?php /*echo $form->error($model,'begin_time'); */?>
		</div>-->
	
		<!--<div class="row">
			<?php /*echo $form->labelEx($model,'end_time'); */?>
			<?php /*//echo $form->textField($model,'end_time'); */?>
			<?php
/*				if(!$model->isNewRecord &&  !empty($model->end_time) && $model->end_time!=''){
					$model->end_time = date('Y/m/d H:i',strtotime($model->end_time));
				} 
				echo $form->textField($model,'end_time',array('style'=>'width: 150px;', 'id'=>'end_time')); */?>
			<?php /*echo $form->error($model,'end_time'); */?>
		</div>-->
		<div class="row">
			<?php echo $form->labelEx($model, 'begin_time'); ?>
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => 'AdminContentLimitModel[begin_time]',
				'value' => $model->end_time,
				// additional javascript options for the date picker plugin
				'options' => array(
					'showAnim' => 'fold',
					'dateFormat' => 'yy-mm-dd',
				),
				'htmlOptions' => array(
					'style' => 'height:20px;'
				),
			));
			echo $form->error($model, 'end_time');
			?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'end_time'); ?>
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name' => 'AdminContentLimitModel[end_time]',
				'value' => $model->end_time,
				// additional javascript options for the date picker plugin
				'options' => array(
					'showAnim' => 'fold',
					'dateFormat' => 'yy-mm-dd',
				),
				'htmlOptions' => array(
					'style' => 'height:20px;'
				),
			));
			echo $form->error($model, 'end_time');
			?>
		</div>
		
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Message Warning'), ''); ?>
            <?php
            $this->widget('ext.elrtef.elRTE', array(
                'model' => $model,
                'attribute' => 'msg_warning',
                'options' => array(
                    'doctype' => 'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                    'cssClass' => 'el-rte',
                    'cssfiles' => array('css/elrte-inner.css'),
                    'absoluteURLs' => true,
                    'allowSource' => true,
                    'lang' => 'vi',
                    'styleWithCss' => '',
                    'height' => 400,
                    'fmAllow' => true, //if you want to use Media-manager
                    'fmOpen' => 'js:function(callback) {$("<div id=\"elfinder\" />").elfinder(%elfopts%);}', //here used placeholder for settings
                    'toolbar' => 'maxi',
                ),
                'elfoptions' => array(//elfinder options
                    'url' => 'auto', //if set auto - script tries to connect with native connector
                    'passkey' => 'mypass', //here passkey from first connector`s line
                    'lang' => 'ru',
                    'dialog' => array('width' => '900', 'modal' => true, 'title' => 'Media Manager'),
                    'closeOnEditorCallback' => true,
                    'editorCallback' => 'js:callback'
                ),
                    )
            );
            ?>

        </div>
        		
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
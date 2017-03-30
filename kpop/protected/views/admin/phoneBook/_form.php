
<div class="content-body">
	<div class="form">
		<?php
		if (Yii::app()->controller->action->id == 'create') {
			?>
		<p class="note"
			style="margin-top: 20px; font-size: 16px; font-weight: bold;">Note:
			Thêm nhiều thuê bao từ file .txt, các số điện thoại cách nhau bởi dấu
			phẩy</p>
		<div class="row">
			<?php echo CHtml::label("TXT File", "") ?>
			<?php
			$this->widget('ext.xupload.XUploadWidget', array(
					'url' => Yii::app()->createUrl("phoneBook/upload", array("parent_id" => 'tmp')),
					'model' => $uploadModel,
					'attribute' => 'file',
					'options' => array(
							'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
							if(handler.response.error){
							alert(handler.response.msg);
							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ': "+handler.response.msg+"</div></td></tr>");
		}else{
							$("#file_name").val(handler.response.name);
							$("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload file thành công') . '</div></td></tr>");
							$(".errorSummary").hide();
		}
		}'
					)
			));
			?>
		</div>
		<?php
		}
		?>

		<?php
		$form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-phone-book-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>
		<?php
		if (Yii::app()->controller->action->id == 'create') {
            ?>

		<?php
        }
        ?>
		<?php echo $form->errorSummary($model); ?>
		<div class="row ">
			<?php echo $form->label($model,'Loại thuê bao'); ?>
			<select id="type_phone" name="type_phone">
				<option value="MIENTAY">Thuê bao Miền Tây</option>
				<option value="PROMOTION-WEEK">Khuyễn mãi theo tuần</option>
			</select>
		</div>
		<div class="row">
			<input id="file_name" type="hidden" name="file_name" value="">
		</div>
		<?php
		if (Yii::app()->controller->action->id == 'update') {
            ?>
		<div class="row ">
			<?php echo $form->labelEx($model, 'phone'); ?>
			<?php echo $form->textField($model, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
			<?php echo $form->error($model, 'phone'); ?>
		</div>
		<?php
        }
        ?>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>

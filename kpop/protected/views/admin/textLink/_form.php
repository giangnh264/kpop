<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'text-link-model-form',
            'enableAjaxValidation' => false,
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'url'); ?>
<?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 255)); ?>
<?php echo $form->error($model, 'url'); ?>
        </div>

       
        <div class="row">
            <?php echo $form->labelEx($model, 'start_time'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'TextLinkModel[start_time]',
                'value' => $model->start_time,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            echo $form->error($model, 'start_time');
            ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'end_time'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'TextLinkModel[end_time]',
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
			<label for="TextLinkModel_position">Vị trí</label>
			<?php 
			if($model->position &&  !is_array($model->position)){
				$position = explode(',', $model->position);
			}else{
				$position = array();
			}
			?>
			<div id="TextLinkModel_position" style="margin-left: 120px">
				<input id="TextLinkModel_position_0" value="site" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('site', $position)) echo 'checked="checked"';?>> <span>Trang chủ</span><br>
				<input id="TextLinkModel_position_1" value="song" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('song', $position)) echo 'checked="checked"';?>> <span>Song</span><br>
				<input id="TextLinkModel_position_2" value="video" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('video', $position)) echo 'checked="checked"';?>> <span>Video</span><br>
				<input id="TextLinkModel_position_3" value="album" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('album', $position)) echo 'checked="checked"';?>> <span>Album</span><br>
				<input id="TextLinkModel_position_4" value="bxh" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('bxh', $position)) echo 'checked="checked"';?>> <span>BXH</span><br>
				<input id="TextLinkModel_position_5" value="videoPlaylist" type="checkbox" name="TextLinkModel[position][]" <?php if(in_array('videoPlaylist', $position)) echo 'checked="checked"';?>> <span>Video collection</span><br>
			</div>
			<?php echo $form->error($model,'day_week'); ?>
		</div>
        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php
            $status = array(
                AdminBannerModel::ACTIVE => "Hoạt động",
                AdminBannerModel::INACTIVE => "Không hoạt động",
            );
            echo CHtml::dropDownList("TextLinkModel[status]", $model->status, $status)
            ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
        
        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
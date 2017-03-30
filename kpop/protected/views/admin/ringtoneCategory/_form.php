<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-ringtone-category-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150, 'class' => 'txtchange')); ?>
<?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'url_key'); ?>
<?php echo $form->textField($model, 'url_key', array('size' => 60, 'maxlength' => 150, 'class' => 'txtrcv')); ?>
<?php echo $form->error($model, 'url_key'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'parent_id'); ?>
            <?php
            $category = CMap::mergeArray(
                            array('0' => "  "), CHtml::listData($categoryList, 'id', 'name')
            );
            echo CHtml::dropDownList("AdminRingtoneCategoryModel[parent_id]", $model->parent_id, $category)
            ?>
<?php echo $form->error($model, 'parent_id'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('cols' => 40, 'rows' => 5)); ?>
<?php echo $form->error($model, 'description'); ?>
        </div>


        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php
            $data = array(
                1 => Yii::t('admin', 'Đang kích hoạt'),
                0 => Yii::t('admin', 'Không kích hoạt'),
            );
            echo CHtml::dropDownList("AdminRingtoneCategoryModel[status]", $model->status, $data)
            ?>
<?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
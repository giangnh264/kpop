<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'copyright-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'Loại'); ?>
            <?php
            echo CHtml::dropDownList('CopyrightModel[type]', $model->type, array(
                "0" => "Tác quyền",
                "1" => "Quyền liên quan",
            ));
            ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Số hợp đồng'); ?>
            <?php echo $form->textField($model, 'contract_no', array('size' => 45, 'maxlength' => 45)); ?>
            <?php echo $form->error($model, 'contract_no'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Số phụ lục'); ?>
            <?php echo $form->textField($model, 'appendix_no', array('size' => 45, 'maxlength' => 45)); ?>
            <?php echo $form->error($model, 'appendix_no'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'Nhà cung cấp'); ?>

            <?php
            $cp = CHtml::listData($ccpList, 'id', 'name');
            echo CHtml::dropDownList("CopyrightModel[ccp]", $model->ccp, $cp)
            ?>

            <?php echo $form->error($model, 'ccp'); ?>
        </div>

        <div class="row active_fromtime">
            <div style="float: left;"><?php echo $form->label($model, 'Thời gian hiệu  lực'); ?></div>
            <div style="float: left; ">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'active_time',
                    'value' => (isset($activetime) && ($activetime[0] <> '01/01/1970')) ? $activetime[0] . ' - ' . $activetime[1] : '',
                ));
                ?>
            </div>
        </div>
		<div class="row">
            <?php echo $form->labelEx($model, 'Ưu tiên'); ?>
            <?php echo $form->textField($model, 'priority', array('size' => 45, 'maxlength' => 45)); ?>
            <?php echo $form->error($model, 'priority'); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
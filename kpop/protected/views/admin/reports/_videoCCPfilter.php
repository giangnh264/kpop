<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="fl">
        <div class="row">

                <?php echo CHtml::label(Yii::t('admin', 'Tên video'), "") ?>
                <?php echo CHtml::textField('songreport[video_name]', isset($_GET['songreport']['video_name']) ? $_GET['songreport']['video_name'] : ''); ?>

           </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ'), "") ?>
            <?php
           /*  $this->widget('application.widgets.admin.ArtistFeild', array(
                'fieldId' => 'songreport[artist_id]',
                'fieldName' => 'songreport[artist_name]',
                'fieldIdVal' => $model->artist_id,
                'fieldNameVal' => isset($_GET['songreport']['artist_name']) ? $_GET['songreport']['artist_name'] : ''
                    )
            ); */

			$this->widget('application.widgets.admin.ArtistAuto', array(
					'fieldId' => 'songreport[artist_id]',
					'fieldName' => 'songreport[artist_name]',
					'fieldIdVal' => $model->artist_id,
					'fieldNameVal' => isset($_GET['songreport']['artist_name']) ? $_GET['songreport']['artist_name'] : '',
			)
			);

            ?>
        </div>
         
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
            <?php
            $this->widget('ext.daterangepicker.input', array(
                'name' => 'songreport[date]',
                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
            ));
            ?>
        </div>
    </div>
     <div class="fl">
        	<?php if($this->levelAccess <=2):?>
         <div class="row">
          <label><?php echo Yii::t('admin','Nhà cung cấp'); ?></label>
           <?php
		           $ccp = CMap::mergeArray(array(''=>'Chọn nhà cung cấp'), CHtml::listData($ccpList, 'id', 'name'));

	               echo CHtml::dropDownList("ccp_id",  $ccp_id, $ccp )
	        ?>
        </div>
        <?php endif;?>
        <div class="row">
		<label><?php echo  Yii::t('admin','Kiểu bản quyền'); ?></label>
			<?php 
				$data = array(0=>'Tác Quyền', 1=>'Quyền Liên Quan');
				echo CHtml::dropDownList('ccp_type', $copyrightType, $data);
			?>
		</div>
		</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
        <?php echo CHtml::resetButton('Reset') ?>
        <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
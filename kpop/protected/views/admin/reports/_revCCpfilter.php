<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="100%">
	<tr>
		<td align="right" valign="middle">
			<?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?>
		</td>
		
		<td align="left"  valign="middle" style="float: left;text-align: left;">
			<?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
		</td>
		<?php if($this->levelAccess <=2):?>
		<td align="right"  valign="middle">
			<?php echo Yii::t('admin','Nhà cung cấp');?>
		</td>
		<td align="left"  valign="middle">
			<?php
			$ccp = CMap::mergeArray(array(''=>'Chọn nhà cung cấp'), CHtml::listData($ccpList, 'id', 'name'));
			$this->widget('application.widgets.admin.button.SelectAutocompleteWidget', array('id'=>'combobox','name'=>'ccp_id', 'select'=>$ccp_id, 'data'=>$ccp))
			?>
		</td>
		<?php endif;?>
	</tr>
	<tr>
		<td></td><td></td>
		<td align="right"><?php echo Yii::t('admin','Kiểu bản quyền'); ?></td>
		<td align="left">
			<?php 
				$data = array(0=>'Tác Quyền', 1=>'Quyền Liên Quan');
				echo CHtml::dropDownList('ccp_type', $copyrightType, $data);
			?>
		</td>
	</tr>
	<tr>
		<td></td><td></td>
		<td align="right"><?php echo Yii::t('admin','Chọn gói cước'); ?></td>
		<td align="left">
			<select name="package">
				<option value="3" <?php echo ($package==3)?" SELECTED":""?>>Tất cả</option>
				<option value="1" <?php echo ($package==1)?" SELECTED":""?>>Gói ngày</option>
				<option value="2" <?php echo ($package==2)?" SELECTED":""?>>Gói tuần</option>
			</select>
		</td>
	</tr>
</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
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

	               echo CHtml::dropDownList("ccp_id",  $ccp_id, $ccp )
	        ?>
		</td>
		<?php endif;?>
	</tr>
	<tr>
		<td align="right">Tỉ lệ:</td><td align="left"><input style="width:50px!important;" type="text" name="perc" value="<?php echo $perc;?>" /> %</td>
		<td align="right"><?php echo Yii::t('admin','Kiểu bản quyền'); ?></td>
		<td align="left">
			<?php 
				$data = array(0=>'Tác Quyền', 1=>'Quyền Liên Quan');
				echo CHtml::dropDownList('ccp_type', $copyrightType, $data);
			?>
		</td>
	</tr>
</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="100%">
	<tr>
		<?php if($this->levelAccess <=2):?>
		<td style="vertical-align: middle;" align="right">
			<?php echo CHtml::label(Yii::t('admin','CP'), "") ?>
		</td>

		<td style="vertical-align: middle;" align="left" >
		 <?php
		           $cp = CMap::mergeArray(
	                                    array(''=> "Tất cả"),
	                                       CHtml::listData($cpList, 'id', 'name')
	                                    );
	                echo CHtml::dropDownList("songreport[cp_id]", $cpId, CHtml::listData($cpList, 'id', 'name') )
		        ?>
		</td>
	 	<?php endif;?>

		<td style="vertical-align: middle;" align="right"><?php echo Yii::t('admin','Thời gian'); ?></td>
		<td style="vertical-align: middle;" align="left">
			<?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
		</td>
	</tr>
	<?php if(isset($hasPackage)):?>
	<tr><td colspan="4"><br /></td></tr>
	<tr>
		<td style="vertical-align: middle;" align="right">
		<?php echo CHtml::label(Yii::t('admin','Gói cước'), "") ?>
		</td>
		<td style="vertical-align: middle;" align="left">
			<?php echo CHtml::dropDownList('package', $packageId, $packageList)?>
		</td>
		<td></td>
		<td></td>
	</tr>
	<?php endif;?>

 	<tr><td colspan="4"><br /></td></tr>
	<tr>
		<td></td>
		<td><?php echo CHtml::submitButton('Search'); ?></td>
		<td><?php echo CHtml::resetButton('Reset') ?></td>
	</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<?php /*

	                <td style="vertical-align: middle;">
		<?php echo CHtml::label(Yii::t('admin','Gói cước'), "") ?>
		</td>
		<td style="vertical-align: middle;">
			<?php echo CHtml::dropDownList('package', $package, $packageList)?>
		</td>

		*/?>

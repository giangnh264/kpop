<?php
$this->pageLabel = Yii::t('admin', "Thống kê thuê bao hưởng KM Promotion");

$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(	
	//array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
);

?>

<div class="title-box search-box">
    <?php echo CHtml::link('Bộ lọc','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form oflowh">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table>
		<tr>
			<td style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?></td>
			<td>
				<div class="row created_time">
					<?php 
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'songreport[date]',
				       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
				        ));
				     ?>
		        </div>  
		                    
            <td> &nbsp; &nbsp;</td>
            <td valign="middle" style="vertical-align:middle"> Giao dịch</td>
            <td valign="middle" style="vertical-align:middle">
 				<select name="trans">
	            	<option value="subscribe">Đăng ký</option>
	            	<option value="unsubscribe_a">Tự hủy</option>
	            	<option value="unsubscribe_b">Hủy do hết hạn</option>
	            </select>           	
            </td>
		</tr>
		<tr>
			<td colspan="5" style="vertical-align:middle;" align="center">
				<input type="submit" value="View" />
			</td>
		</tr>
	</table>
<?php $this->endWidget(); ?>
</div><!-- search-form -->
    <div class="clb"></div>
    
<div class="content-body grid-view">
	<table width="100%" class="items">
		<tr>
			<th height="20" style="vertical-align: middle; color: #FFF">Ngày</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số</th>
		</tr>
		<?php foreach ($data as $data):?>
		<tr>
			<td><?php echo $data['m']?></td>
			<td><?php echo $data['total']?></td>
		</tr>
		<?php endforeach;?>
	</table>
</div>


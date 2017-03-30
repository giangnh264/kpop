<?php
$this->pageLabel = Yii::t('admin', "Thống kê gia hạn");

$this->menu=array(	
	array('label'=>Yii::t('admin','Export'), 'url'=>array('reports/subscribeExt','export'=>1)),
);
$check = Yii::app()->request->getparam('p',null); 

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
			<td><?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?></td>
			<td>
				<div class="row created_time">
					<?php 
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'songreport[date]',
				       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
				        ));
				     ?>
		        </div>  
			</td>
			<td> &nbsp; &nbsp;</td>
			<?php /*
			<td valign="middle" style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin','Trạng thái'), "") ?></td>
			<td valign="middle" style="vertical-align:middle"> 
				<select name="fillter[status]">
	            	<option value="0" <?php echo ($status==0)?" SELECTED":""?> >Thành công</option>
	            	<option value="1" <?php echo ($status==1)?" SELECTED":""?>>Thất bại</option>
	            </select>
            </td>
            */?>
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
			<?php if($check):?>
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số lượt</th>
			<?php endif;?>
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số thuê bao</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Số TB thành công</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Số TB thất bại</th>
		</tr>
		<?php 
                $total1 = 0;
                $total = 0;
                $total2 = 0;
                $total3 = 0;
                foreach ($data as $data):
                    $total1 += 0;
                    $total2 += 0;
                    $total3 += 0;
                    ?>
		<tr>
			<td><?php echo $data['m']?></td>
			<?php if($check):?>
			<td><?php echo $data['total']?></td>
			<?php endif;?>
			<td><?php echo $data['total_phone']?></td>
			<td><?php echo $data['total_success']?></td>
			<td><?php echo ($data['total_phone'] -$data['total_success']) // $data['total_fail']?></td>
		</tr>
		<?php
                if($check)
                    $total += $data['total'];
                $total1 += $data['total_phone'];
                $total2 += $data['total_success'];
                $tp = ($data['total_phone'] - $data['total_success']);
                $total3 += $tp;
                endforeach;?>
                <tr>
                    <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                    <?php if($check):?>
                        <td height="20" style="vertical-align: middle;color: #FFF"><?php echo $total; ?></td>
                    <?php endif;?>
                    <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                </tr>
	</table>
</div>


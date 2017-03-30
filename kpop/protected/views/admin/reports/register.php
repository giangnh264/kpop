<?php
$this->pageLabel = Yii::t('admin', "Thống kê Đăng ký");

$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(	
	array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
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
			<?php /*
			<td valign="middle" style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin','Trạng thái'), "") ?></td>
			<td valign="middle" style="vertical-align:middle"> 
				<select name="fillter[status]">
	            	<option value="0" <?php echo ($status==0)?" SELECTED":""?> >Thành công</option>
	            	<option value="1" <?php echo ($status==1)?" SELECTED":""?>>Thất bại</option>
	            </select>
            </td>
            */?>
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
            <td valign="middle" style="vertical-align:middle"> Nguồn giao dịch</td>
            <td valign="middle" style="vertical-align:middle">
 				<select name="fillter[channel]">
	            	<option value="0" <?php echo ($channel=='0' || $channel==0)?" SELECTED":""?> >Tất cả</option>
	            	<option value="wap" <?php echo ((string) $channel=='wap')?" SELECTED":""?> >WAP</option>
	            	<option value="sms" <?php echo ((string) $channel=='sms')?" SELECTED":""?>>SMS</option>
	            	<option value="api-ios" <?php echo ((string) $channel=='api-ios')?" SELECTED":""?>>IOS-APP</option>
	            	<option value="api-android" <?php echo ((string) $channel=='api-android')?" SELECTED":""?>>ANDROID-APP</option>
	            	<option value="web" <?php echo ((string) $channel=='web')?" SELECTED":""?>>WEB</option>
	            	<option value="ivr" <?php echo ((string) $channel=='ivr')?" SELECTED":""?>>IVR</option>
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
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số lượt</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Tổng số thuê bao</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Số TB thành công</th>
			<th height="20" style="vertical-align: middle;color: #FFF">Số TB thất bại</th>
		</tr>
		<?php 
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                foreach ($data as $data):?>
		<tr>
			<td><?php echo $data['m']?></td>
			<td><?php echo $data['total']?></td>
			<td><?php echo $data['total_phone']?></td>
			<td><?php echo $data['total_success']?></td>
			<td><?php echo ($data['total_phone'] -$data['total_success'])<0?0:($data['total_phone'] -$data['total_success']) // $data['total_fail']?></td>			
		</tr>
		<?php 
                $total1 += $data['total'];
                $total2 += $data['total_phone'];
                $total3 += $data['total_success'];
                $tmp = $tmp + ($data['total_phone'] - $data['total_success'])<0?0:($data['total_phone'] -$data['total_success']);
                $total4 = $total4 + $tmp;
                endforeach;?>
                <tr>
                    <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                    <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                    <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                </tr>
	</table>
</div>


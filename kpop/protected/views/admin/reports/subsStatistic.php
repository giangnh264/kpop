<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê thuê bao từ {from} tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));

$this->menu=array(
);

?>

<div class="search-form oflowh">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table>
		<tr>
			<td style="vertical-align: middle;"><?php echo Yii::t('admin','Gói cước'); ?></td>
			<td style="vertical-align: middle;">
			<?php echo CHtml::dropDownList('package', $package, $packageList)?>
			</td>
			<td style="vertical-align: middle;"><?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?></td>
			<td style="vertical-align: middle;">
				<div class="row created_time">
					<?php
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'songreport[date]',
				       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
				        ));
				     ?>
		        </div>
			</td>
			<td style="vertical-align: middle;"><input type="submit" value="View" /></td>
		</tr>
	</table>
<?php $this->endWidget(); ?>
</div><!-- search-form -->


<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
        <tr>
            <th height="20" style="vertical-align: middle; color: #FFF">Ngày</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Số TB hoạt động</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Số lượt ĐK</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Số lượt gia hạn</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Tổng số TB hủy</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Số TB hủy do hết hạn</th>
            <th height="20" style="vertical-align: middle; color: #FFF">Số TB cần gia hạn ngày tiếp</th>
    	</tr>
        <?php
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            $total5 = 0;
            $total6 = 0;
            foreach ($data as $rev):
    	?>
        <tr>
    		<td><?php echo $rev['date']?></td>
    		<td><?php echo $rev['active_count']?></td>
    		<td><?php echo $rev['subscribe_count']?></td>
    		<td><?php echo $rev['subscribe_ext_count']?></td>
    		<td><?php echo $rev['unsubscribe_count']?></td>
    		<td><?php echo $rev['expired_count']?></td>
    		<td><?php echo $rev['ext_nextday']?></td>
    	</tr>
        <?php
            $total1 += $rev['active_count'];
            $total2 += $rev['subscribe_count'];
            $total3 += $rev['subscribe_ext_count'];
            $total4 += $rev['unsubscribe_count'];
            $total5 += $rev['expired_count'];
            $total6 += $rev['ext_nextday'];
             endforeach;?>
        <tr>
            <td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
            <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
            <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
            <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
            <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
            <td style="background: #5ec411!important;"><?php echo $total5; ?></td>
            <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
    	 </tr>
    </table>
</div>


<?php
$this->pageLabel = Yii::t('admin', "Thống kê thuê bao");

$this->menu=array(	
	//array('label'=>Yii::t('admin','Export'), 'url'=>array('reports/subscribeReport','export'=>1)),
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
			<td valign="middle" style="vertical-align:middle"><?php echo CHtml::label(Yii::t('admin','Trạng thái'), "") ?></td>
			<td>&nbsp;&nbsp; </td>
			<td valign="middle" style="vertical-align:middle"> 
				<select name="fillter[status]">
	            	<option value="0" <?php echo ($status==0)?" SELECTED":""?> >Tất cả</option>
	            	<option value="1" <?php echo ($status==1)?" SELECTED":""?>>Đang hoạt động</option>
	            	<option value="2" <?php echo ($status==2)?" SELECTED":""?>>Không hoạt động</option>
	            </select>
            </td>
            <td>&nbsp;&nbsp; </td>
			<td valign="middle" style="vertical-align:middle">
				<input type="submit" value="View" />
			</td>
		</tr>
	</table>
<?php $this->endWidget(); ?>
<div class="summer fr p10 bcl2" style="border: 1px solid #376fa6;">
	<p><b>Tổng số: </b><?php echo $total[0]['total_subs'] ?></p>
	<p><b>Đang hoạt động: </b><?php echo $total[0]['total_subs_active'] ?></p>
	<p><b>Không hoạt động: </b><?php echo $total[0]['total_subs_notactive'] ?></p>
</div>
</div><!-- search-form -->
    <div class="clb"></div>
    
<div class="content-body">
    <div class="clearfix"></div>
    <script>
        var idf = 'usersubscribe-report';
        var modelf = 'AdminUserSubscribeModel_page';
    </script>
    <?php
    $this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'usersubscribe-report',
    	'dataProvider'=>$userSubsModel->search(),	
		'columns'=>array(
	        array(
	         	'header'=>'SDT',
	         	'name'=>'user_phone',
	         ),
	         array(
	         	'header'=>'Gói cước',
	         	'name'=>'package.name',
	         ),
	         array(
	         	'header'=>'Ngày đăng ký',
	         	'name'=>'created_time',
	         ),
	         array(
	         	'header'=>'Ngày hết hạn',
	         	'name'=>'expired_time',
	         ),
	         array(
	         	'header'=>'Trạng thái',
	         	'value'=>'($data->status==1)?"Hoạt động":"Không hoạt động"',
	         ),
		),
	));
    ?>
</div>


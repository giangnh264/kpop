<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Content Approve Models'=>array('index'),
	'Manage',
);
$this->pageLabel = Yii::t("admin","Thống kê khối lượng công việc");
?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'sidebar_left')); ?>
<ul id="sub_menu" class="_submenu">
<li class="topline"><a class="menulink" href="<?php echo Yii::app()->createUrl('contentApprove/index')?>">Quản lý CTV</a></li>
<li class="topline"><a class="menulink" href="<?php echo Yii::app()->createUrl('reportAccount/index')?>">Thống kê khối lượng cv</a></li>
</ul>
<?php $this->endWidget();?>
<div class="search-form">
<div class="wide form">
<form id="ad" action="<?php echo Yii::app()->createUrl('reportAccount/index')?>" method="get">
	<input type="hidden" value="reportAccount/index" name="r">
	<table>
		<tr>
			<td style="vertical-align: middle">
				<div class="fl">
			        <div class="row">
			            <?php 
					       $this->widget('ext.daterangepicker.input',array(
					            'name'=>'datetime',
			                    'value'=>isset($_GET['datetime'])?trim($_GET['datetime']):"",
					        ));
					     ?>
			        </div>  	        
			    </div>
			</td>
			<td style="vertical-align: middle">
			 <input type="submit" name="Submit" value="Submit" />
			</td>
		</tr>
	</table>
</form>
</div>
</div>
<h3>Thống kê công việc từ <?php echo $time['from'];?> đến <?php echo $time['to'];?></h3>
<div class="content-body">
    <div class="clearfix"></div>
    <?php 
    $this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'admin-report-account-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'Tài khoản',
	            'value' => '$data["username"]',
				'type'=>'raw'
			),
	        array(
	        	'header'=>'Số video thêm mới',
	            'value' => '$data["add_video_count"]',
				'type'=>'raw'
			),
	        array(
	        	'header'=>'Số bài hát thêm mới',
	            'value' => '$data["add_song_count"]',
				'type'=>'raw'
			),
	        array(
	        	'header'=>'Số lượng đã duyệt',
	            'value' => '$data["approved"]',
				'type'=>'raw'
			),
	        array(
	        	'header'=>'Số lượng chưa duyệt',
	            'value' => '$data["not_approved"]',
				'type'=>'raw'
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'',
				'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
						'onchange'=>"$.fn.yiiGridView.update('admin-report-account-model-grid',{ data:{pageSize: $(this).val() }})",
				)),
			
			
			),
		),
	));
    ?>
</div>

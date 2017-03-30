<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê truy cập trên apps,wap từ {from} tới {to}", array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));

$this->menu=array(	
	//array('label'=>Yii::t('admin','Export'), 'url'=>array('reports/song','export'=>1)),
);
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
?>

<div class="search-form oflowh">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table>
		<tr>
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


<div class="content-body grid-view" style="overflow: scroll">

	    <table width="100%" class="items">
    	<tr>
    		<th>Ngày</th>
    		<th colspan="4">Chung</th>
    		<th colspan="3">Wap</th>
    		<th colspan="3">App IOS</th>
    		<th colspan="3">App ANDROID</th>
    		<th colspan="3">WiFi</th>
    	</tr>
    	<tr>
    		<th></th>
    		<th>Tổng số truy cập</th>
    		<th>Số truy cập nhận diện thành công</th>
    		<th>Tổng số TB</th>
    		<th>Là TB đã ĐK</th>

			<th>Tổng số</th>
			<th>Số truy cập nhận diện thành công</th>
			<th>Là TB đã ĐK</th>
			<th>Tổng số</th>
    		<th>Số truy cập nhận diện thành công</th>
    		<th>Là TB đã ĐK</th>
    		<th>Tổng số</th>
    		<th>Số truy cập nhận diện thành công</th>
    		<th>Là TB đã ĐK</th>
    		<th>Tổng số</th>
    		<th>Số truy cập nhận diện thành công</th>
    		<th>Là TB đã ĐK</th>
    	</tr>
    	<?php foreach ($data as $data ):?>
     	<tr>
    		<td><?php echo $data['date'] ?></td>
    		<td><?php echo $data['total_count'] ?></td>
    		<td><?php echo $data['sucessful_count'] ?></td>
    		<td><?php echo $data['phone_count'] ?></td>
    		<td><?php echo $data['subs_count'] ?></td>


    		<td><?php echo $data['total_count_wap'] ?></td>
    		<td><?php echo $data['sucessful_count_wap'] ?></td>
    		<td><?php echo $data['subs_count_wap'] ?></td>
    		<td><?php echo $data['total_count_ios'] ?></td>
    		<td><?php echo $data['sucessful_count_ios'] ?></td>
    		<td><?php echo $data['subs_count_ios'] ?></td>
    		<td><?php echo $data['total_count_android'] ?></td>
    		<td><?php echo $data['sucessful_count_android'] ?></td>
    		<td><?php echo $data['subs_count_android'] ?></td>
    		<!-- WiFi -->
    		<td><?php echo $data['total_count_wifi'] ?></td>
    		<td><?php echo $data['sucessful_count_wifi'] ?></td>
    		<td><?php echo $data['subs_count_wifi'] ?></td>
    	</tr>   	
    	<?php endforeach;?>
    	</table>
</div>


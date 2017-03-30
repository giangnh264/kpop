<style>
table tr td{
	vertical-align: midle!important;
	padding: 5px;
}
.search-form .ui-daterangepicker-arrows{
	float: none!important;
}
</style>
<?php 
$this->pageLabel = Yii::t('admin', "Thống kê giao dịch / thuê bao Từ {from} Tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));
?>
<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="100%">
	<tr>
		<td width="50">Phone</td>
		<td>
	        <?php 
                echo CHtml::textField("user_phone",$userPhone)
	        ?>
		</td>
	</tr>
	<tr>
		<td width="100">Thời gian</td>
		<td>
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
		</td>
	</tr>
</table>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>    
<?php $this->endWidget(); 
?>

</div><!-- search-form -->
<div class="content-body grid-view" style="overflow: auto">
<?php

function getLinkOrder($field='')
{
	if(!isset($_GET['order'])){
		$order="ASC";
		$linkOrder = $_SERVER["REQUEST_URI"]."&order=DESC";
	}else{
		if($_GET['order']=='DESC'){
			$linkOrder = str_replace('DESC', 'ASC', $_SERVER["REQUEST_URI"]);
		}else{
			$linkOrder = str_replace('ASC', 'DESC', $_SERVER["REQUEST_URI"]);
		}
	}
	$f = isset($_GET['f'])?$_GET['f']:'';
	if($f==''){
		$linkOrder .="&f=".$field;
	}else{
		$linkOrder = str_replace($f, $field, $linkOrder);
	}
	return $linkOrder;
}
?>
<?php if($data){?>
<?php
	$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-detail-by-trans-grid',
	'enablePagination'=> false,
	'dataProvider'=>$data,
	'columns'=>array(
		array(
			'header'=>'SĐT',
			'value'=>"\$data['user_phone']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playsong').'">Tổng lượt nghe bài hát</a>',
			'value'=>"\$data['total_playsong']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playsong_free').'">Tổng lượt nghe  bài hát miễn phí</a>',
			'value'=>"\$data['total_playsong_free']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playsong_price').'">Tổng lượt nghe  bài hát có phí</a>',
			'value'=>"\$data['total_playsong_price']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadsong').'">Tổng lượt tải bài hát</a>',
			'value'=>"\$data['total_downloadsong']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadsong_free').'">Tổng lượt tải bài hát miễn phí</a>',
			'value'=>"\$data['total_downloadsong_free']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadsong_price').'">Tổng lượt tải bài hát có phí</a>',
			'value'=>"\$data['total_downloadsong_price']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playvideo').'">Tổng lượt xem video</a>',
			'value'=>"\$data['total_playvideo']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playvideo_free').'">Tổng lượt xem video miễn phí</a>',
			'value'=>"\$data['total_playvideo_free']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_playvideo_price').'">Tổng lượt xem video có phí</a>',
			'value'=>"\$data['total_playvideo_price']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadvideo').'">Tổng lượt tải video</a>',
			'value'=>"\$data['total_downloadvideo']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadvideo_free').'">Tổng lượt tải video miễn phí</a>',
			'value'=>"\$data['total_downloadvideo_free']",
		),
		array(
			'header'=>'<a href="'.getLinkOrder('total_downloadvideo_price').'">Tổng lượt tải video có phí</a>',
			'value'=>"\$data['total_downloadvideo_price']",
		),
	),
	));

?>

<div class="pagging">
	<?php
		$this->widget('CLinkPager',
			array(
				'pages'				=> $page,
				'maxButtonCount'	=> 10,
		));					
	?>
</div>
<?php }?>
</div>
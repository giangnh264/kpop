<?php 
$this->pageLabel = Yii::t('admin', "Thống kê giao dịch  Từ {from} Tới {to}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));

	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
	$cs->registerCssFile(Yii::app()->theme->baseUrl."/css/report.css");
?>
<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?>
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
        </div>  	    
    </div>
    <div class="fl">
	    <div class="row">
	        <?php echo CHtml::label(Yii::t('admin','Nguồn'), "") ?>
            <?php echo CHtml::dropDownList('channel',$channel, $channelList); ?>
	    </div>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>    
<?php $this->endWidget(); ?>

<div style="border: 1px solid #376fa6;" class="summer fr p10 bcl2">
	<p><b>Lưu ý: </b></p>
	<p>Các cell đánh đấu <b>-X-</b> là không lấy được dữ liệu</p>
	<p>Các cột thống kê số TB là trên tất cả các kênh</p>
</div>

</div><!-- search-form -->
<div class="content-body grid-view" style="overflow: auto">
<table width="100%" class="items">
	<tr>
		<th>Ngày</th>
		<th colspan="5"> Nghe bài hát</th>
		<th colspan="5"> Tải bài hát</th>
		<th colspan="5">Xem video</th>
		<th colspan="5">Tải video</th>
	</tr>
	<tr>
		<th></th>
		<th>Tổng lượt nghe</th>
		<th>Lượt nghe miễn phí</th>
		<th>Lượt nghe có phí</th>
		<th>Số TB nghe đã DK</th>
		<th>Số TB nghe chưa DK</th>
		<th>Tổng lượt tải</th>
		<th>Lượt tải miễn phí</th>
		<th>Lượt tải có phí</th>
		<th>Số TB tải đã DK</th>
		<th>Số TB tải chưa DK</th>
		<th>Tổng lượt xem</th>
		<th>Lượt xem miễn phí</th>
		<th>Lượt xem có phí</th>
		<th>Số TB xem chưa ĐK</th>
		<th>Số TB xem đã ĐK</th>
		<th>Tổng lượt tải</th>
		<th>Lượt tải miễn phí</th>
		<th>Lượt tải có phí</th>
		<th>Số TB tải chưa ĐK</th>
		<th>Số TB tải đã ĐK</th>
	</tr>
	<?php 
	$total_1=0;
	$total_2=0;
	$total_3=0;
	$total_4=0;
	$total_5=0;
	$total_6=0;
	$total_7=0;
	$total_8=0;
	$total_9=0;
	$total_10=0;
	$total_11=0;
	$total_12=0;
	$total_13=0;
	$total_14=0;
	$total_15=0;
	$total_16=0;
	$total_17=0;
	$total_18=0;
	$total_19=0;
	$total_20=0;
	?>
	<?php foreach($data['trans'] as $item):?>
	<?php 
	
	?>
	<tr>
		<td><?php echo $item['m']?></td>
		<td><?php 
			echo $item['total_playsong'];
			$total_1 +=$item['total_playsong'];
		?></td>
		<td><?php 
				echo $item['total_playsong_free'];
				$total_2 +=$item['total_playsong_free'];
			?></td>
		<td><?php 
			echo $item['total_playsong_price'];
			$total_3 +=$item['total_playsong_price'];
			?></td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_dk_nghe_bai_hat'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_dk_nghe_bai_hat'];
					$total_4 +=$data['msisdn'][$item['m']]['so_thue_bao_dk_nghe_bai_hat'];
				}else{
					echo "-X-";
				}
			?>
		</td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_chua_dk_nghe_bai_hat'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_chua_dk_nghe_bai_hat'];
					$total_5 +=$data['msisdn'][$item['m']]['so_thue_bao_chua_dk_nghe_bai_hat'];
				}else{
					echo "-X-";
				}
			?>
		</td>
		<td><?php 
			echo $item['total_downloadsong'];
			$total_6 +=$item['total_downloadsong'];
			?></td>
		<td><?php 
			echo $item['total_downloadsong_free'];
			$total_7 +=$item['total_downloadsong_free'];
		?></td>
		<td><?php 
				echo $item['total_downloadsong_price'];
				$total_8 +=$item['total_downloadsong_price'];
		?></td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_bai_hat'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_bai_hat'];
					$total_9+=$data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_bai_hat'];
				}else{
					echo "-X-";
				}
				
			?>			
		</td>		
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_bh'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_bh'];
					$total_10 +=$data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_bh'];
				}else{
					echo "-X-";
				}
			?>		
		</td>

		<td><?php echo $item['total_playvideo'];
		$total_11 +=$item['total_playvideo'];
		?></td>
		<td><?php echo $item['total_playvideo_free'];
		$total_12 +=$item['total_playvideo_free'];
		?></td>
		<td><?php echo $item['total_playvideo_price'];
		$total_13 +=$item['total_playvideo_price'];
		?></td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_chua_dk_xem_video'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_chua_dk_xem_video'];
					$total_14 +=$data['msisdn'][$item['m']]['so_thue_bao_chua_dk_xem_video'];
				}else{
					echo "-X-";
				}
			?>			
		</td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_dk_xem_video'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_dk_xem_video'];
					$total_15 +=$data['msisdn'][$item['m']]['so_thue_bao_dk_xem_video'];
				}else{
					echo "-X-";
				}
			?>			
		</td>			
		<td><?php echo $item['total_downloadvideo'];
				$total_16 +=$item['total_downloadvideo'];
		?></td>
		<td><?php echo $item['total_downloadvideo_free'];
				$total_17 +=$item['total_downloadvideo_free'];
		?></td>
		<td><?php echo $item['total_downloadvideo_price'];
		$total_18 +=$item['total_downloadvideo_price'];
		?></td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_video'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_video'];
					$total_19 +=$data['msisdn'][$item['m']]['so_thue_bao_mac_dinh_tai_video'];
				}else{
					echo "-X-";
				}
			?>			
		</td>
		<td>
			<?php 
				if(isset($data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_video'])){
					echo $data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_video'];
					$total_20 +=$data['msisdn'][$item['m']]['so_thue_bao_dang_ky_tai_video'];
				}else{
					echo "-X-";
				}
			?>			
		</td>				
	</tr>
	<?php endforeach?>
	<tr>
		<th>Tổng</th>
		<th><?php echo $total_1;?></th>
		<th><?php echo $total_2;?></th>
		<th><?php echo $total_3;?></th>
		<th><?php echo $total_4;?></th>
		<th><?php echo $total_5;?></th>
		<th><?php echo $total_6;?></th>
		<th><?php echo $total_7;?></th>
		<th><?php echo $total_8;?></th>
		<th><?php echo $total_9;?></th>
		<th><?php echo $total_10;?></th>
		<th><?php echo $total_11;?></th>
		<th><?php echo $total_12;?></th>
		<th><?php echo $total_13;?></th>
		<th><?php echo $total_14;?></th>
		<th><?php echo $total_15;?></th>
		<th><?php echo $total_16;?></th>
		<th><?php echo $total_17;?></th>
		<th><?php echo $total_18;?></th>
		<th><?php echo $total_19;?></th>
		<th><?php echo $total_20;?></th>
	</tr>
</table>

<?php
/*
	$this->widget('application.widgets.admin.grid.GGridView', array(
	'id'=>'admin-detail-by-trans-grid',
	'treeData'=>$data,
	'enablePagination'=> false,	
	'columns'=>array(
		array(
			'header'=>'Ngày',
			'value'=>"\$data['m']",
		),
		array(
			'header'=>'Tổng lượt nghe bài hát',
			'value'=>"\$data['total_playsong']",
		),
		array(
			'header'=>'Tổng lượt nghe  bài hát miễn phí',
			'value'=>"\$data['total_playsong_free']",
		),
		array(
			'header'=>'Tổng lượt nghe  bài hát có phí',
			'value'=>"\$data['total_playsong_price']",
		),
		array(
			'header'=>'Tổng lượt tải bài hát',
			'value'=>"\$data['total_downloadsong']",
		),
		array(
			'header'=>'Tổng lượt tải bài hát miễn phí',
			'value'=>"\$data['total_downloadsong_free']",
		),
		array(
			'header'=>'Tổng lượt tải bài hát có phí',
			'value'=>"\$data['total_downloadsong_price']",
		),
		array(
			'header'=>'Tổng lượt xem video',
			'value'=>"\$data['total_playvideo']",
		),
		array(
			'header'=>'Tổng lượt xem video miễn phí',
			'value'=>"\$data['total_playvideo_free']",
		),
		array(
			'header'=>'Tổng lượt xem video có phí',
			'value'=>"\$data['total_playvideo_price']",
		),
		array(
			'header'=>'Tổng lượt tải video',
			'value'=>"\$data['total_downloadvideo']",
		),
		array(
			'header'=>'Tổng lượt tải video miễn phí',
			'value'=>"\$data['total_downloadvideo_free']",
		),
		array(
			'header'=>'Tổng lượt tải video có phí',
			'value'=>"\$data['total_downloadvideo_price']",
		),
	),
	));
*/
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
</div>
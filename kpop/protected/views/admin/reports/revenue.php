<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê Doanh thu ngày");
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
			<td style="vertical-align: middle;" ><?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?></td>
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
			<td style="vertical-align: middle;">
					<input type="submit" value="View" />			
			</td>
		</tr>
	</table>
<?php $this->endWidget(); ?>
</div><!-- search-form -->

<div class="content-body" style="overflow: auto;">
    <div class="clearfix"></div>
    <script>
        var idf = 'admin-revenue-model-grid';
        var modelf = 'AdminStatisticRevenueModel_page';
    </script>
    <div style="overflow: hidden;padding-top: 5px;">
    <table style="float: right">
    	<tr><td style="vertical-align: middle"><label>Hiển thị:</label></td>
    	<td style="vertical-align: middle">
    		<?php  echo CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
							'onchange'=>"$.fn.yiiGridView.update('admin-revenue-model-grid',{ data:{pageSize: $(this).val() }})",
					));
    		?>
    	</td>
    	</tr>
    </table>
    </div>
    <?php
    $this->widget('application.widgets.admin.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$model->search(),	
		'columns'=>array(
	
			'date'=>array(
				'value' => '$data->date',
				'footer'=>'Tổng'
    		),
	        array(
	        	'header'=>'Bài hát',
	            'name' => 'song_revenue',
	            'value' => '$data->song_revenue',
	            'headerHtmlOptions'   =>  array('style'=>'text-align:left;width:200px'),
	        	'htmlOptions'=>array('style'=>'text-align:left;width:200px','class'=>'song_revenue'),
        		'footer'=>'<div class="sum_song_revenue"></div>'
			),
	        array(
	        	'header'=>'Nghe bài hát',
	            'name' => 'song_play_revenue',
	            'value' => '$data->song_play_revenue',
				'htmlOptions'=>array('class'=>'song_play_revenue'),
				'footer'=>'<div class="sum_song_play_revenue"></div>'
			),
	        array(
	        	'header'=>'Tải bài hát',
	            'name' => 'song_download_revenue',
	            'value' => '$data->song_download_revenue',
				'htmlOptions'=>array('class'=>'song_download_revenue'),
				'footer'=>'<div class="sum_song_download_revenue"></div>'
			),
	        array(
	        	'header'=>'Video',
	            'name' => 'video_revenue',
	            'value' => '$data->video_revenue',
        		'htmlOptions'=>array('class'=>'video_revenue'),
        		'footer'=>'<div class="sum_video_revenue"></div>'
			),
	        array(
	        	'header'=>'Xem Video',
	            'name' => 'video_play_revenue',
	            'value' => '$data->video_play_revenue',
				'htmlOptions'=>array('class'=>'video_play_revenue'),
				'footer'=>'<div class="sum_video_play_revenue"></div>'
			),
	        array(
	        	'header'=>'Tải Video',
	            'name' => 'video_download_revenue',
	            'value' => '$data->video_download_revenue',
				'htmlOptions'=>array('class'=>'video_download_revenue'),
				'footer'=>'<div class="sum_video_download_revenue"></div>'
			),
	        array(
	        	'header'=>'Nhạc chuông',
	            'name' => 'ringtone_revenue',
	            'value' => '$data->ringtone_revenue',
				'htmlOptions'=>array('class'=>'ringtone_revenue'),
				'footer'=>'<div class="sum_ringtone_revenue"></div>'
			),
	        array(
	        	'header'=>'Album',
	            'name' => 'album_revenue',
	            'value' => '$data->album_revenue',
				'htmlOptions'=>array('class'=>'album_revenue'),
				'footer'=>'<div class="sum_album_revenue"></div>'
			),
	        array(
	        	'header'=>'Đăng ký',
	            'name' => 'subscribe_revenue',
	            'value' => '$data->subscribe_revenue',
				'htmlOptions'=>array('class'=>'subscribe_revenue'),
				'footer'=>'<div class="sum_subscribe_revenue"></div>'
			),
	        array(
	        	'header'=>'Gia hạn',
	            'name' => 'subscribe_ext_revenue',
	            'value' => '$data->subscribe_ext_revenue',
				'htmlOptions'=>array('class'=>'subscribe_ext_revenue'),
				'footer'=>'<div class="sum_subscribe_ext_revenue"></div>'
			),
	        array(
	        	'header'=>'Tổng số',
	            'name' => 'total_revenue',
	            'value' => '$data->total_revenue',
				'htmlOptions'=>array('class'=>'total_revenue'),
				'footer'=>'<div class="sum_total_revenue"></div>',
			),
		),
	));
    ?>
    <button id="sum">sum</button>
</div>
<script>
jQuery(function(){
	$("#sum").live("click", function(){
		var index;
		var a = ["song_revenue","song_play_revenue", "song_download_revenue", "video_revenue","video_revenue","video_play_revenue","video_download_revenue","ringtone_revenue","album_revenue","subscribe_revenue","subscribe_ext_revenue","total_revenue"];
		for (index = 0; index < a.length; ++index) {
		    console.log(a[index]);
		    var sum = 0;
			$('.'+a[index]).each(function() {
				sum = sum + parseInt($(this).text()); 
			})
			$('.sum_'+a[index]).text(sum);
		}
	})
})
</script>


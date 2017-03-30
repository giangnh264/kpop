<meta charset="utf-8" />
<style>
table, table tr td{
	border: 1px solid #000!important;
}
</style>
<?php if($data):?>
<div class="content-body">
    <?php ?>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'ID',
	            'name' => 'song_id',
			),
	        array(
	        	'header'=>'Bài hát',
	            'name' => 'song_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => '@$data->artist->name',
			),
	        array(
	        	'header'=>'Nghe Gói',
	            'type' => 'raw',
				'value'=> '$data->played_count-$data->play_not_free'
			),
	        array(
	        	'header'=>'Tải Gói',
				'type' => 'raw',
	        	'value'=> '$data->downloaded_count-$data->download_not_free'
			),
			array(
					'header'=>'Nghe mất phí',
					'name'=>'play_not_free',
			),
	        array(
	        	'header'=>'Tải mất phí',
				'name'=>'download_not_free'
			),
		),
	));
    ?>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>

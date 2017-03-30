    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,	
		'columns'=>array(
	        array(
	        	'header'=>'Bài hát',
	            'name' => 'song_name',
			),
	        array(
	        	'header'=>'Ca sỹ',
	            'value' => 'isset($data->artist->name)?$data->artist->name:""',
			),
	        array(
	        	'header'=>'CP',
	            'value' => 'isset($data->cp->name)?$data->cp->name:""',
			),
	        array(
	        	'header'=>'Nghe',
	            'name' => 'played_count',
			),
	        array(
	        	'header'=>'Tải',
	            'name' => 'downloaded_count',
			),
	        array(
	        	'header'=>'Doanh thu nghe',
	            'name' => 'revenue_play',
			),
	        array(
	        	'header'=>'Doanh thu tải',
	            'name' => 'revenue_download',
			),
		),
	));
    ?>


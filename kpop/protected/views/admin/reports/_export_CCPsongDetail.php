<meta charset="utf-8" />
<style>
table, table tr td{
	border: 1px solid #000!important;
}
</style>
<h3><?php echo Yii::t('admin', "Chi tiết bài hát từ {from} tới {to} CCP {CCPNAME}",array('{from}'=>$this->time['from'],'{to}'=>$this->time['to'],'{CCPNAME}'=>$ccp->name));?></h3>
<?php if($data):?>
<div class="content-body">
    <?php ?>
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'admin-revenue-model-grid',
		'dataProvider'=>$data,
		'columns'=>array(
			array(
				'header'=>'Max Bài hát',
				'name' => 'song_id',
			),  array(
				'header'=>'Bài hát',
				'name' => 'song_name',
			),
			array(
				'header'=>'Ca sỹ',
				'value' => '@$data->artist->name',
			),
			array(
				'header'=>'Nghe Gói Ngày',
				'type' => 'raw',
				'value'=> '$data->played_count_A1'
			),
			array(
				'header'=>'Nghe Gói Tuần',
				'type' => 'raw',
				'value'=> '$data->played_count_A7'
			),
			array(
				'header'=>'Tải Gói Ngày',
				'type' => 'raw',
				'value'=> '$data->downloaded_count_A1'
			),
			array(
				'header'=>'TTải Gói Tuần',
				'type' => 'raw',
				'value'=> '$data->downloaded_count_A7'
			),
		),
	));
    ?>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>

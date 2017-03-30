<a class="button" id="add-item" href="<?php echo $this->createUrl('playlist/addItems',array('playlis_id'=>$id)); ?>">
	<?php echo Yii::t('admin','Thêm bài hát'); ?>
</a> 
<?php
$form=$this->beginWidget('CActiveForm', array(
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-playlist-song-model-grid',
	'dataProvider'=>$listSong->search(),	
	'columns'=>array(
		'id',
        array(
        	'header'=>'Bài hát',
            'name' => 'song.name',
		),
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),$this->createUrl('playlist/reorderItems'),array("id"=>"reorder") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("playlist/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("playlist/publishItems",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
		),
	),
));

$this->endWidget();
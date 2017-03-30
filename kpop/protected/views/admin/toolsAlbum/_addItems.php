<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách bài hát'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-song-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Lọc trên danh sách','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form">

<?php $this->renderPartial('_searchPopup',array(
	'model'=>$songModel,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
	'lyric'=>$lyric
)); ?>
</div>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));
$columns = array(

                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'sid[]'),
                    'headerHtmlOptions'   	=>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'sid',
                    'checked'               =>  'false'
                ),
                'id',
		        'code',
		        'name',
                array(
                    'name' => Yii::t('admin', 'Thể loại'),
                    'value' => 'AdminSongGenreModel::model()->getCatBySong($data->id,true);',
                ),
                'artist_name',
            );

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$songModel->simpleSearch(isset($_GET['AdminSongModel']['genre_id'])?$_GET['AdminSongModel']['genre_id']:null),
	'columns'=> $columns,
));

echo CHtml::hiddenField("album_id",$album_id);

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('/ToolsAlbum/AddItem','album_id'=>$album_id)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        //inlistzone = false;
						//$("#inlist-info").click();
						//window.location.reload(true);
						reloadSonsg();
                    }'),array('id'=>'closeJobDialog', 'live'=>false));
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));


$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<script>

function reloadSonsg()
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('/ToolsAlbum/ReloadSong'); ?>",
		data: {album_id:<?php echo $album_id;?>},
		beforeSend: function(){
			$("#loading-tt").html("<img src='<?php echo Yii::app()->theme->baseUrl;?>/images/ajax-loader-top-page.gif' />");
		},
		success: function(response){
			$("#loading-tt").html("");
			$("#songlist").html(response)
		}
	})
}
function removeItem(id)
{
	$.ajax({
		url: "<?php echo Yii::app()->createUrl('/ToolsAlbum/removeItem'); ?>",
		data: {id:id, album_id:<?php echo $album_id;?>},
		beforeSend: function(){
			$("#loading-tt").html("<img src='<?php echo Yii::app()->theme->baseUrl;?>/images/ajax-loader-top-page.gif' />");
		},
		success: function(response){
			reloadSonsg();
		}
	})
}
</script>
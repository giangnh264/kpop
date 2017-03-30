<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách bài hát đã duyệt'),
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
	'model'=>$model,
    'categoryList'=>$categoryList,
    'cpList'=>$cpList,
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
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
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
                array(
                    'class' => 'CLinkColumn',
                    'header' => 'Lyrics',
                    'labelExpression' => '($data->songextra->lyrics=="")?CHtml::image(Yii::app()->request->baseUrl."/css/img/lyric.png", "#", array("id"=>$data->id)):CHtml::image(Yii::app()->request->baseUrl."/css/img/lyric_new.png", "#", array("id"=>$data->id))',
                    'urlExpression' => 'Yii::app()->createUrl("/song/lyric", array("id"=>$data->id,"YII_CSRF_TOKEN"=>Yii::app()->request->getCsrfToken()))',
                    'linkHtmlOptions' => array('onclick' => '
                                                                                            var url = $(this).attr("href");
                                                                                            editlyric(url);
                                                                                            return false;
                                                                                    '),
                ),
                array(
                    'name' => 'Nghe',
                    'value' => 'isset($data->songstatistic->played_count)?$data->songstatistic->played_count:0',
                ),
                array(
                    'name' => 'Down',
                    'value' => 'isset($data->songstatistic->downloaded_count)?$data->songstatistic->downloaded_count:0',
                ),
            );

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-song-model-grid',
	'dataProvider'=>$model->simpleSearch($_GET['AdminSongModel']['genre_id']),
	'columns'=> $columns,
));

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('song/list','render'=>false)),array('success'=>'js: function(data) {
                        if (data) {
                            obj = jQuery.parseJSON(data);
                            $("#AdminContestContentModel_content_id").attr("value",obj.id);
                            $("#AdminContestContentModel_content_code").attr("value",obj.code);
                            $("#jobDialog").dialog("close");
                        } else {
                            $("#jobDialog").dialog("close");
                            window.location.reload( true );
                        }
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::hiddenField("object", $object);
echo CHtml::hiddenField("collect_id", $collect_id);
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));

$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>

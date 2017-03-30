<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");

?>
<div class="submenu title-box xfixed">
    <div id="yw5" class="portlet">
        <div class="portlet-content">

            <div class="page-title">Danh sách nhạc chờ thuộc bộ sưu tập</div><ul id="yw6" class="operations">
                <li><a href="#"  onclick="popuprbt()" >Thêm mới</a></li>
            </ul></div>
    </div>
</div>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
        console.log($(this).serialize());
	$.fn.yiiGridView.update('admin-spam-sms-group-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

window.reorder = function()
{
   $.post('".$this->createUrl('rbtCollectionItem/reorder')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}
window.popuprbt = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'". $this->createUrl("ringbacktone/list")."',
          'data': { collection :'yes',group_id: '".$group_id."'},    
	  'type':'GET',
	  'cache':false,
	  'success':function(html){
	      jQuery('#jobDialog').html(html)
	      }
	});
    return;
}


");
?>

<!--<div class="search-form" id="search-form" style="display:block">
    <?php
//    $this->renderPartial('_searchRbt', array(
//        'model' => $rbt,
//    ));
    ?>
</div>-->
<?php

$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">' . Yii::t("admin", "Chọn trang này") . '(' . $model->search()->getItemCount() . ')</a></li>
            <li><a href="javascript:void(0)" class="all-item">' . Yii::t("admin", "Chọn tất cả") . ' (' . $model->count() . ')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">' . Yii::t("admin", "Bỏ chọn tất cả") . '</a></li>
        </ul>
    </div>
';

if ($model->search()->getItemCount() == 0) {
    $padding = "padding:26px 0";
} else {
    $padding = "";
}
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'adminform', 'style' => $padding),
        ));

if (Yii::app()->user->hasFlash('RbtCollection')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('RbtCollection') . '</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-spam-sms-group-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('rbt_id' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
//        'id',   
        'rbt_id',
        array(
	        	'header'=>'code',
	            'value' => '$data->rbt->code',
			),
        array(
	        	'header'=>'name',
	            'value' => '$data->rbt->name',
			),
        array(
	        	'header'=>'artist_name',
	            'value' => '$data->rbt->artist_name',
			),
//        array(
//	        	'header'=>'status',
//	            'value' => '$data->rbt->status',
//			),
         array(
	              'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder()") ),
	              'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	              'type' => 'raw',
              ),
        array(
	        	'header'=>'created_time',
	            'value' => '$data->rbt->created_time',
			),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("RbtCollectionItem/delete",array("id"=>$data["id"]))',
        ),
    ),
));
$this->endWidget();
?>

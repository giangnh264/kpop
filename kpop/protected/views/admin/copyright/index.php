<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->breadcrumbs = array(
    'Copyright Models' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('CopyrightCreate')),
);
$this->pageLabel = Yii::t("admin", "Danh sách");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('copyright-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin', 'Tìm kiếm'), '#', array('class' => 'search-button')); ?></div>

<div class="search-form" style="display:block">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>

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
echo '<div class="op-box">';
//echo CHtml::dropDownList('bulk_action', '', array('' => Yii::t("admin", "H�nh ??ng"), 'deleteAll' => 'X�a', '1' => 'C?p nh?t'), array('onchange' => 'return submitform(this)'));
echo Yii::t("admin", " Tổng số chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">' . CHtml::checkBox("all-item", false, array("value" => $model->count(), "style" => "width:30px")) . '</div>';
echo '</div>';

if (Yii::app()->user->hasFlash('Copyright')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('Copyright') . '</div>';
}

if(UserAccess::checkAccess("CopyrightDelete", Yii::app()->user->Id)){
	$accessDelete = array(
		            'visible'=>'true',
				);
}else{
	$accessDelete = array(
		            'visible'=>'false',
				);
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'copyright-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('name' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
//        'id',
		array(
			'header' => 'Mã hợp đồng',
			'type'=>'raw',
			'value'=>'$data->id'
		),
        array(
            'header' => 'Loại',
            'value' => '($data->type==0)?"Tác quyền":"Quyền liên quan"',
            'type' => 'raw'
        ),
        array(
            'header' => 'Số hợp đồng',
            'value' => '$data->contract_no',
            'type' => 'raw'
        ),
        array(
            'header' => 'Số phụ lục',
            'value' => '$data->appendix_no',
            'type' => 'raw'
        ),
        array(
            'header' => 'Cung cấp',
            'value' => '$data->ccP->name',
        ),
        array(
            'header' => 'Hiệu lực',
            'value' => '$data->start_date',
            'type' => 'raw'
        ),
        array(
            'header' => 'Hết hạn',
            'value' => '$data->due_date',
            'type' => 'raw'
        ),
        array(
            'header' => 'Ưu tiên',
            'value' => '$data->priority',
        ),
        /*
          'copyright_method',
          'start_date',
          'due_date',
          'added_by',
          'added_time',
          'updated_by',
          'updated_time',
          'status',
         */
        array(
            'class' => 'CButtonColumn',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('copyright-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
			'template'=>'{view}{update}{delete}',
			'buttons'=>array(
				'delete'=>$accessDelete
			),
			'deleteConfirmation'=>'Tất cả những bài hát và video sẽ được remove mã bản quyền này?'
        ),
    ),
));
$this->endWidget();
?>

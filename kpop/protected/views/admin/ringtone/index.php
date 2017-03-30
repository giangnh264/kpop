<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");

$this->menu = array(
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('RingtoneCreate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");

switch ($this->type) {
    case AdminRingtoneModel::NOT_CONVERT:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - chưa convert');
        break;
    case AdminRingtoneModel::WAIT_APPROVED:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - chờ duyệt');
        break;
    case AdminRingtoneModel::CONVERT_FAIL:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - convert lỗi');
        break;
    case AdminRingtoneModel::ACTIVE:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - đã duyệt');
        break;
    case AdminRingtoneModel::DELETED:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - đã xóa');
        break;
    default:
        $title = Yii::t('admin', 'Danh sách nhạc chuông - tất cả');
        break;
}
$this->pageLabel = $title;
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin', 'Tìm kiếm'), '#', array('class' => 'search-button')); ?></div>

<div class="search-form" style="display:block">

    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
        'categoryList' => $categoryList,
        'cpList' => $cpList
    ));
    ?>
</div><!-- search-form -->

<?php
switch ($this->type) {
    case AdminRingtoneModel::WAIT_APPROVED:
        $column = array(
            'class' => 'CButtonColumn',
            'template' => '{approved}',
            'buttons' => array(
                'approved' => array(
                    'label' => 'Duyệt',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/img/approved.png',
                    'url' => 'Yii::app()->createUrl("ringtone/approved", array("id"=>$data->id))',
                ),
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-ringtone-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        );
        $action = array('' => Yii::t("admin", "Hành động"), 'deleteAll' => Yii::t('admin', 'Xóa'), 'approvedAll' => Yii::t('admin', 'Duyệt'));
        break;
    case AdminRingtoneModel::DELETED:
        $script = <<<EOD
			function() {
				$("input[name='cid\[\]']").each(function(){
			        this.checked = false;
			    });
			    
				$(this).parent().parent().find('td:first-child input').attr('checked',true);
				this.form.submit();
				return false;
			}
EOD;
        $column =
                array(
                    'class' => 'CButtonColumn',
                    'buttons' => array(
                        'delete' => array(
                            'click' => $script,
                            'title' => Yii::t('admin', 'Khôi phục'),
                        ),
                    ),
                    'deleteButtonLabel' => Yii::t('admin', 'Khôi phục'),
                    'deleteButtonImageUrl' => Yii::app()->request->baseUrl . "/css/img/revert.png",
                    'deleteButtonUrl' => 'Yii::app()->createUrl("ringtone/restore",array("cid[]"=>$data->id))',
                    'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                        'onchange' => "$.fn.yiiGridView.update('admin-ringtone-model-grid',{ data:{pageSize: $(this).val() }})",
                    )),
        );
        $action = array('' => Yii::t("admin", "Hành động"), 'restore' => Yii::t('admin', 'Khôi phục'));
        break;

    default:
        $url = Yii::app()->createUrl("/ringtone/confirmDel");
        $script = <<<EOD
			function() {
				//if(!confirm('Xóa bản ghi này?')) return false;
				$("input[name='cid\[\]']").each(function(){
			        this.checked = false;
			    });
			    
				$(this).parent().parent().find('td:first-child input').attr('checked',true);
				deleteConfirm('yw1','$url');
				return false;
			}
EOD;
        $column = array(
            'class' => 'CButtonColumn',
            'buttons' => array(
                'delete' => array(
                    'click' => $script,
                ),
            ),
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-ringtone-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        );
        $action = array('' => Yii::t("admin", "Hành động"), 'deleteAll' => Yii::t('admin', 'Xóa'));

        break;
}

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
echo CHtml::dropDownList('bulk_action', '', $action, array('onchange' => 'return ringtone_submit_form(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">'
 . CHtml::checkBox("all-item", false, array("value" => $model->count(), "style" => "width:30px"))
 . CHtml::hiddenField("type", $this->type)
 . '</div>';

if (Yii::app()->user->hasFlash('Ringtone')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('Ringtone') . '</div>';
}
echo '</div>';
//echo $html_exp;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-ringtone-model-grid',
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
        'id',
        array(
            'name' => 'name',
            'value' => 'Chtml::link($data->name,Yii::app()->createUrl("ringtone/update",array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        'code',
        array(
            'name' => Yii::t('admin', 'Thể loại'),
            'value' => '!empty($data->genre)?$data->genre->name:Yii::t("admin","Chưa xác định")'
        ),
        'artist_name',
        array(
            'class' => 'CLinkColumn',
            'header' => 'Hot',
            'labelExpression' => '($data->featured==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data->featured==1)?Yii::app()->createUrl("ringtone/unhot",array("cid[]"=>$data->id)):Yii::app()->createUrl("ringtone/hot",array("cid[]"=>$data->id))',
            'linkHtmlOptions' => array(
            ),
        ),
        array(
            'name' => 'CP',
            'value' => '$data->cp->name',
        ),
        array(
        	'name'=>'Sync',
        	'value'=>'$data->sync_status'
        ),
        /*
          'song_id',
          'created_by',
          'approved_by',
          'updated_by',
          'cp_id',
          'source_path',
          'bitrate',
          'duration',
          'price',
          'created_time',
          'sorder',
          'status',
          'updated_time',
         */
        /*
          array(
          'class'=>'CButtonColumn',
          'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
          'onchange'=>"$.fn.yiiGridView.update('admin-ringtone-model-grid',{ data:{pageSize: $(this).val() }})",
          )),


          ),
         */
        $column
    ),
));
$this->endWidget();
?>

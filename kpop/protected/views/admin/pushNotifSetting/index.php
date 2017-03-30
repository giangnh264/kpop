<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->breadcrumbs = array(
    'Push Notif Setting Models' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => Yii::t("admin", "Thêm mới"), 'url' => array('create'), 'visible' => UserAccess::checkAccess('PushNotifSettingCreate')),
);
$this->pageLabel = Yii::t("admin", "Danh sách cài đặt");

?>

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
echo CHtml::dropDownList('bulk_action', '', array('' => Yii::t("admin", "Hành động"), 'deleteAll' => 'Delete', '1' => 'Update'), array('onchange' => 'return submitform(this)')
);
echo Yii::t("admin", " Tổng số được chọn") . ": <span id='total-selected'>0</span>";

echo '<div style="display:none">' . CHtml::checkBox("all-item", false, array("value" => $model->count(), "style" => "width:30px")) . '</div>';
echo '</div>';

if (Yii::app()->user->hasFlash('PushNotifSetting')) {
    echo '<div class="flash-success">' . Yii::app()->user->getFlash('PushNotifSetting') . '</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'push-notif-setting-model-grid',
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
        'device_os',
        'message',
        array(
            'header'=>'Kiểu',
            'value'=>'$data->type==1?"Show 1 quảng cáo trên web":($data->type==2?"Show chi tiết một album":($data->type==3?"Show chi tiết một playlist":($data->type==4?"Play một bài hát":($data->type==5?"Play một clip":($data->type==6?"Đăng ký tài khoản":($data->type==7?"Show 1 tin tức":"Thông báo văn bản thường"))))))'
        ),
        'data',
    	'timesend',
        array(
            'header'=>'Trạng thái',
            'value'=>'$data->status?"<span class=\"s_label s_0\">Chưa gửi</span>":"<span class=\"s_label s_1\">Đã gửi</span>"',
        	'type'=>'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('push-notif-setting-model-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
$this->endWidget();
?>

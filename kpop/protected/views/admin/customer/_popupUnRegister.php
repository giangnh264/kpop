<?php
$linkSubmit = Yii::app()->createUrl('Customer/unregister');
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>"dialog",
    'options'=>array(
        'title'=>Yii::t('admin','Hành động người dùng'),
        'autoOpen'=>false,
        'modal'=>'true',
        'width'=>'450px',
        'height'=>'auto',
        'buttons' => array(
            'Close'=>'js:function(){$(this).dialog("close")}',
            'Xác nhận'=>'js:function(){
                        $.ajax({
                        url: "'.$linkSubmit.'",
                        type: "POST",
                        dataType:"json",
                        async: true,
                        data: {"phone":"'.$msisdn.'","package_id":"'.$subscribe->package_id.'"},
                        beforeSend: function(){
                        $("#ajax-loadding").show();
                        },
                        success: function(Response) {
                           alert(Response.msg);
                          window.location.reload();
                        }
                    })
                    return false;
			        $(this).dialog("close");

			                    }'

        ),
    ),
));

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl('Customer/register'),
    'method'=>'post',
    'htmlOptions'=>array('id'=>'merge_artist_form'),
));
?>
<div class="form">
    <div style="margin: 10px;">
        <h3 style="padding: 5px;">Trạng thái thuê bao <span style="color: green;"><?php echo $msisdn ?></span></h3>
        - Đã đăng ký gói cước <?php echo $package_code?><br>
        - Tự động gia hạn<br>
        - Thuê bao còn hiệu lực tới <b><?php echo date('d/m/Y H:i:s', strtotime($subscribe->expired_time)); ?></b>
        <div>
            <b style="font-size: 13px;">Bạn đã chọn hủy gói cước <?php echo $package_code?></b>
        </div>
        <div style="margin: 5px 0;" id="processing"></div>
    </div>
</div>
<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

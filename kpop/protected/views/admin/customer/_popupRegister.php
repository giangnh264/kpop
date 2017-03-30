<?php
$linkSubmit = Yii::app()->createUrl('Customer/register');
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
            var radios = document.getElementsByTagName("input");
                var value;
                for (var i = 0; i < radios.length; i++) {
                    if (radios[i].type === "radio" && radios[i].checked) {
                        package = radios[i].value;
                    }
                }
                        $.ajax({
                        url: "'.$linkSubmit.'",
                        type: "POST",
                        dataType:"json",
                        async: true,
                        data: {"phone":"'.$msisdn.'","package":package},
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
        - Chưa đăng ký

        <div>
            <b style="font-size: 13px;">Bạn đã chọn đăng ký thuê bao. Vui lòng chọn gói cước:</b><br>
            <?php $package = PackageModel::model()->published()->findAll();?>

            <?php foreach ($package as $item):?>
                <input type="radio" name="package" value="<?php echo $item->code?>"><?php echo $item->code?> - <?php echo $item->name?>  <br>
            <?php endforeach;?>
            <input type="hidden" value="1" id="subscribe" name="subscribe">
        </div>
    </div>

</div>
<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

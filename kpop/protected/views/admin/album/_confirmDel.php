<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('admin','Lý do xóa album'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'400px',
                    'height'=>'auto',
                ),
                ));

?>

<div class="form" id="jobDialogForm">
 
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'job-form',
    'enableAjaxValidation'=>true,
)); 
?>

    <div class="row">
        <?php
        $status = array(
            0=>'Xóa vẫn show info',
            3=>'Xóa vĩnh viễn'
        );
        echo CHtml::dropDownList('status','',$status, array('style'=>'width: 200px;'));
        ?>
    </div>
    <div class="row">
        <?php
        $reason = Yii::app()->params['reason_delete'];
        echo CHtml::dropDownList('reason','',$reason, array('style'=>'width: 200px;'));
        ?>
    </div>
 
    <div class="row buttons pl50">
        <?php echo CHtml::hiddenField("popup", "1") ?>
        <?php echo CHtml::hiddenField("conten_id", $massList)?>
        <?php echo CHtml::hiddenField("is_all",$isAll )?>
        <?php echo CHtml::hiddenField("type",$type )?>
        <?php
        	if($reqsource == 'list'){
        		echo CHtml::ajaxSubmitButton(Yii::t('admin','Xóa'),CHtml::normalizeUrl(array('album/confirmDel','render'=>false)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
        				window.location.reload();
                    }'),array('id'=>'closeJobDialog')); 
	        	echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'
	        																$("#cid_all").attr("checked",false);
																		    $("#all-item").attr("checked",false);
																		    $("input[name=\'cid\[\]\']").each(function(){
																		        this.checked = false;
																		    });
																		    $("#total-selected").html("0");
	        																$("#jobDialog").dialog("close");
	        														'));
        		
        	}else{
        		echo CHtml::ajaxSubmitButton(Yii::t('admin','Xóa'),CHtml::normalizeUrl(array('album/confirmDel','render'=>false)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        window.location.reload();
                    }'),array('id'=>'closeJobDialog')); 
        		echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'
        																$("#jobDialog").dialog("close");
        														'));
        		
        	}
        ?>
    </div>
 
<?php $this->endWidget(); ?>
 
</div>


<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
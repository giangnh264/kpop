<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Rbt Download Models'=>array('index'),
	'Manage',
);


if(is_array($this->time)){
    $time = " from ".$this->time['from']." to ".$this->time['to'];
}
else{
    $time = " ".$this->time;
}
$this->pageLabel = Yii::t("admin","Thống kê".$time);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});


");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

 
<div class="search-form oflowh">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<table style="width: 300px; float: left;">
		<tr>
			<td style="vertical-align: middle;" ><?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?></td>
			<td style="vertical-align: middle;">
				<div class="row created_time" style="width: 213px;"> 
					<?php 
				       $this->widget('ext.daterangepicker.input',array(
				            'name'=>'songreport[date]',
				       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:date("m/d/Y"),
				        ));
				     ?>
		        </div>  
			</td>
                </tr>
                <tr>
                        <td style="vertical-align: middle;" ><?php echo CHtml::label(Yii::t('admin','Kênh'), "") ?></td>
                        <td>
                            <?php
                            if(isset($_GET['channel']))
                                echo CHtml::dropDownList('channel', $_GET['channel'], $channel);
                            else
                                echo CHtml::dropDownList('channel', 'all', $channel);
                            ?>
                        </td>
			
		</tr>
                <tr style=" line-height: 40px;">
                    <td>&nbsp;</td>
                    <td style="vertical-align: middle;">
					<input type="submit" value="View" />			
			</td>
                </tr>
	</table>
    <style>
        .grid-view td{padding: 6px;}
    </style>
        <table style="width: 360px; float: left; border-left: 1px solid rgb(34, 34, 34);" class="grid-view">
            <tr>
                <td><b><?php echo CHtml::label(Yii::t('admin','Lượt tải'), "") ?></b></td>
                <td>
                    <table>
                        <tr>
                            <td><b><?php echo CHtml::label(Yii::t('admin','Tổng số'), "") ?></b></td>
                            <td><b><?php echo $count_channel['all'];?></b></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::label(Yii::t('admin','web'), "") ?></td>
                            <td><?php echo $count_channel['web'];?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::label(Yii::t('admin','wap'), "") ?></td>
                            <td><?php echo $count_channel['wap'];?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::label(Yii::t('admin','sms'), "") ?></td>
                            <td><?php echo $count_channel['sms'];?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::label(Yii::t('admin','api'), "") ?></td>
                            <td><?php echo $count_channel['api'];?></td>
                        </tr>
                        <tr>
                            <td><?php echo CHtml::label(Yii::t('admin','crbt'), "") ?></td>
                            <td><?php echo $count_channel['crbt'];?></td>
                        </tr>

                    </table>
                </td>
            </tr>   
            <tr>
                <td><b><?php echo CHtml::label(Yii::t('admin','Tổng doanh thu'), "") ?></b></td>
                <td><b><?php echo number_format($total_money, 2, ',', ' ');?></b></td>
            </tr>
        </table>
    
<?php $this->endWidget(); ?>
</div><!-- search-form -->
<?php

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rbt-download-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

//		'id',
		'rbt_id',
		'rbt_code',
		'user_id',
		'from_phone',
		'to_phone',		
		'price',
		'amount',
		'message',
		'channel',
		'download_datetime',
//		array(
//			'class'=>'CButtonColumn',
//                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
//                            'onchange'=>"$.fn.yiiGridView.update('rbt-download-model-grid',{ data:{pageSize: $(this).val() }})",
//                        )),
//		),
	),
));
$this->endWidget();

?>

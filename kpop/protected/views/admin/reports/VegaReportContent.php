<div class="content-body grid-view">
<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="fl">        
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
            <?php
            $this->widget('ext.daterangepicker.input', array(
                'name' => 'songreport[date]',
                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
            ));
            ?>
        </div>
    </div>
    <div class="" style="float:left">
        <?php echo CHtml::submitButton('Search'); ?>
        <?php echo CHtml::resetButton('Reset') ?>
        <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->    
<style>
	table#list{width: 100%}
	table#list tr:hover td,
	table#list tr.actived td{
		background: #F5DB1D!important;
		#font-weight: bold;
	}
    .popdiv{ left: 0;
    overflow: scroll;margin-top: 20px;
    position: absolute;
    width: 100%;}
    #showp{float:right;position: relative;z-index: 1000;}
    
</style>

<?php 
$fieldList = array('song_new','song_hot','album_new','album_hot','count_album_new','count_album_hot','video_new','video_hot','count_radio_new','count_album_radio','count_song_album_radio');
?>
<div style="overflow: auto; clear: both">
<table id="list">
<tr><td><strong>Từ khóa</strong></td><?php foreach ($arr_date as $date){?><td><strong><?php echo date('d/m/Y', strtotime($date))?></strong></td><?php }?><td><strong>Total</strong></td></tr>
<?php foreach ($fieldList as $field){?>
<tr>
	<td><?php echo Yii::t("report",$field)?></td>
	<?php foreach ($arr_date as $date){?>
	<td><?php echo isset($arr_res[$date][$field])?$arr_res[$date][$field]:0?></td>
	<?php 
		$total[$field] += $arr_res[$date][$field];
	?>
	<?php }?>
	<td><?php echo $total[$field];?></td>
</tr>
<?php }?>
</table>
</div>
</div>
<script>
$("table#list tr").click(function(){
	$("table#list tr").removeClass("actived");
	if($(this).hasClass("actived")){
			$(this).removeClass("actived")
		}else{
			$(this).addClass("actived")
		}
})
</script>
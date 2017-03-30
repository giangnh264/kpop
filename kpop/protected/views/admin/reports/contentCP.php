<?php
$cs=Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('bbq');

$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
$cssFile=$baseScriptUrl.'/styles.css';
$cs->registerCssFile($cssFile);

?>
<div class="search-form">
	<div class="wide form">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'method'=>'get',
		));
		?>
		<table width="100%">
			<tr>
				<td style="vertical-align: middle;" align="left">
					Chọn tháng
				</td>
				<td  style="vertical-align: middle;" align="left">
					<select name="month" id="month"  class="fl">
						<?php for($i=1;$i<=12;$i++):
							$i = str_pad($i, 2, 0, STR_PAD_LEFT);
						?>
						<option value="<?php echo $i?>" <?php echo ($i==$month)?"SELECTED":"" ?>>
							<?php echo $i ?>
						</option>
						<?php endfor;?>
					</select>
				</td>
				<td  style="vertical-align: middle;" align="left">
					Chọn năm
				</td>
				<td  style="vertical-align: middle;" align="left">
					<select name="year" id="year" class="fl">
					<?php for($i=2013;$i<2050;$i++):?>
					<option value="<?php echo $i ?>" <?php echo ($i==$year)?"SELECTED":"" ?>>
						<?php echo $i ?></option>
					<?php endfor;?>
					</select>
				</td>
				<td style="vertical-align: middle;" align="left" >
					Chọn CP
				</td>
				<td style="vertical-align: middle;" align="left" >
					<select name="cp" id="cp"  class="fl">
					<?php foreach ($this->cpList as $cp):?>
					<option value="<?php echo $cp->id ?>"><?php echo $cp->name ?></option>
					<?php endforeach;?>
					</select>
				</td>
				<td><?php echo CHtml::submitButton('Xem', array('style'=>'float: right')); ?></td>
		</table>
		<?php $this->endWidget(); ?>
	</div>
</div>
<div class="content-body grid-view">
<table width="100%" class="items">
    	<tr>
    		<th>Nội dung</th>
    		<th>Lượt nghe/tải CP</th>
    		<th>Lượt nghe/tải hệ thống</th>
    		<th>Doanh thu</th>
    	</tr>
    	<tr>
    		<td>Bài hát Việt</td>
    		<td><?php echo $reportContent["total_count_song_vi"]?></td>
    		<td></td>
    		<td><?php echo number_format($reportContent["total_price_song_vi"], 0, ',', ' ') ?></td>
    	</tr>
    	<tr>
    		<td>Bài hát quốc tế</td>
    		<td><?php echo $reportContent["total_count_song_qte"]?></td>
    		<td></td>
    		<td><?php echo number_format($reportContent["total_price_song_qte"], 0, ',', ' ')?></td>
    	</tr>
    	<tr>
    		<td>Video Việt</td>
    		<td><?php echo $reportContent["total_count_video_vi"]?></td>
    		<td></td>
    		<td><?php echo number_format($reportContent["total_price_video_vi"], 0, ',', ' ')?></td>
    	</tr>
    	<tr>
    		<td>Video Quốc tế</td>
    		<td><?php echo $reportContent["total_count_video_qte"]?></td>
    		<td></td>
    		<td><?php echo number_format($reportContent["total_price_video_qte"], 0, ',', ' ')?></td>
    	</tr>
    	<tr>
    		<td>Gói CHACHAFUN</td>
    		<td><?php echo $reportContent["total_cp_trans_chachafun"]?></td>
    		<td><?php echo $reportContent["total_all_trans_chachafun"]?></td>
    		<td><?php echo number_format($reportContent["total_price_chachafun"], 0, ',', ' ')?></td>
    	</tr>
    	<tr>
    		<td>MUSICGIFT (Tính cho SP VEGA)</td>
    		<td><?php echo $reportContent["total_count_musicgift"]?></td>
    		<td></td>
    		<td><?php echo number_format($reportContent["total_price_musicgift"], 0, ',', ' ')?></td>
    	</tr>
</table>
<p class="b p10" style="color: red;">Lưu ý: Chỉ áp dụng cho các report từ tháng 10-2013
</p>
</div>
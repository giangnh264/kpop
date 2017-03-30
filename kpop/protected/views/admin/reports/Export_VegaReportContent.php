<div class="content-body grid-view">
<style>
	table#list{width: 100%; border-spacing: 0;}
	table#list tr td{
		border: 1px solid #333;
	}
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
<tr><td>Field Name</td><?php foreach ($arr_date as $date){?><td><?php echo date('d/m/Y', strtotime($date))?></td><?php }?><td>Total</td></tr>
<?php foreach ($fieldList as $field){?>
<tr>
	<td><?php echo Yii::t("main",$field)?></td>
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
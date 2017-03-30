<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê ngày "). "[".date("d-m-Y")."]";
?>


<div class="content-body grid-view">
<?php //echo "<pre>";print_r($totalSubsctibe);exit();  ?>
<?php 
	$detailSubscribe = '';
	$totalSubs = 0;
	 for($i=0;$i<count($totalSubsctibe);$i++){
		$detailSubscribe .= "
			<tr>
				<td> {$totalSubsctibe[$i]['channel']} : {$totalSubsctibe[$i]['total'] }</td>
			</tr>";
		$totalSubs =  $totalSubs + $totalSubsctibe[$i]['total']; 			 	
	 }
	 
	$detailUnsubs = '';
	$totalUnsubs = 0;
	 for($i=0;$i<count($totalUnsubsctibe);$i++){
		$detailUnsubs .= "
			<tr>
				<td> {$totalUnsubsctibe[$i]['channel']} : {$totalUnsubsctibe[$i]['total'] }</td>
			</tr>";
		$totalUnsubs =  $totalUnsubs + $totalUnsubsctibe[$i]['total']; 			 	
	 }
	 
	$detailListenSong = '';
	$totalListenSongCount = 0;
	 foreach($totalListenSong as $item){
		$detailListenSong .= "
			<tr>
				<td> {$item['channel']} : {$item['total'] }</td>
			</tr>";
		$totalListenSongCount =  $totalListenSongCount + $item['total']; 			 	
	 }
	$detailDownloadSong = '';
	$totalDownloadSongCount = 0;
	 foreach($totalDownloadSong as $item){
		$detailDownloadSong .= "
			<tr>
				<td> {$item['channel']} : {$item['total'] }</td>
			</tr>";
		$totalDownloadSongCount =  $totalDownloadSongCount + $item['total']; 			 	
	 }
	$detailPlayVideo = '';
	$totalPlayVideoCount = 0;
	 foreach($totalPlayVideo as $item){
		$detailPlayVideo .= "
			<tr>
				<td> {$item['channel']} : {$item['total'] }</td>
			</tr>";
		$totalPlayVideoCount =  $totalPlayVideoCount + $item['total']; 			 	
	 }
	$detailDownVideo = '';
	$totalDownVideo = 0;
	 foreach($totalDownloadVideo as $item){
		$detailDownVideo .= "
			<tr>
				<td> {$item['channel']} : {$item['total'] }</td>
			</tr>";
		$totalDownVideo =  $totalDownVideo + $item['total']; 			 	
	 }
	 
	 $totalExt = 0;
	 foreach($totalSubsctibeExt as $ext){
		$totalExt = $totalExt + $ext['total'];	 	
	 }
	 
	 /*So Đăng ký free*/
 	$detailSubsFree = '';
	$totalSubsFreeCount = 0;
	 foreach($totalSubsFree as $item){
		$detailSubsFree .= "
			<tr>
				<td> {$item['channel']} : {$item['total'] }</td>
			</tr>";
		$totalSubsFreeCount =  $totalSubsFreeCount + $item['total']; 			 	
	 }
	 
	 
	 
?>

<table class="items" width="60%">
	<tr>
		<td rowspan="<?php echo count($totalSubsctibe)+1 ?>" valign="middle"><b>Tổng đăng ký:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalSubs ?></b> </td>
	</tr>
	<?php echo $detailSubscribe; ?>
	
	<tr>
		<td rowspan="<?php echo count($totalSubsFree)+1 ?>" valign="middle"><b>Đăng ký FREE:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalSubsFreeCount ?></b> </td>
	</tr>
	<?php echo $detailSubsFree; ?>
	
	<tr>
		<td><b>Gia hạn:</b></td>
		<td  style="background: #f8eea7!important;"><?php echo $totalExt ?></td>
	</tr>
	<tr>
		<td rowspan="<?php echo count($totalUnsubsctibe)+1 ?>" valign="middle"><b>Huỷ:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalUnsubs ?></b> </td>
	</tr>
	<?php echo $detailUnsubs; ?>
	<tr>
		<td rowspan="<?php echo count($totalListenSong)+1 ?>" valign="middle"><b>Nghe bài hát:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalListenSongCount ?></b> </td>
	</tr>
	<?php echo $detailListenSong; ?>
	
	<tr>
		<td rowspan="<?php echo count($totalDownloadSong)+1 ?>" valign="middle"><b>Tải bài hát:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalDownloadSongCount?></b> </td>
	</tr>
	<?php echo $detailDownloadSong; ?>
	<tr>
		<td rowspan="<?php echo count($totalPlayVideo)+1 ?>" valign="middle"><b>Xem video:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalPlayVideoCount?></b> </td>
	</tr>
	<?php echo $detailPlayVideo; ?>
	<tr>
		<td rowspan="<?php echo count($totalDownloadVideo)+1 ?>" valign="middle"><b>Tải video:</b></td>
		<td  style="background: #f8eea7!important;"><b>Tổng số: <?php echo $totalDownVideo?></b> </td>
	</tr>
	<?php echo $detailDownVideo; ?>
	
	<tr>
		<td><b>Tổng doanh thu:</b></td>
		<td style="background: #5ec411!important;"><b><?php echo  number_format($totalRev, 2, ',', ' ');  ?></b></td>
	</tr>
</table>

</div>

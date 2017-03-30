<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
if(is_array($this->time)){
	$this->pageLabel = Yii::t('admin', "Thống kê từ [{from}] tới [{to}] ", array('{from}'=>$this->time['from'],'{to}'=>$this->time['to']));	
}else{
		$this->pageLabel = Yii::t('admin', "Thống kê ngày [{from}]", array('{from}'=>$this->time));	
}

	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
	//$cs->registerCssFile(Yii::app()->theme->baseUrl."/css/report.css");
	

?>


<div class="search-form report-search-form">
<form action="">
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin','Thời gian'), "") ?>
			<input type="hidden" name="r" value="reports/dailyTime">
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
		     <input type="submit" value="View" />
        </div>  
</form>
</div><!-- search-form -->


<div class="content-body grid-view">
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

<table class="items" style="width: 60%">
	<tr>
		<td rowspan="<?php echo count($totalSubsctibe)+1 ?>" valign="middle"><b>Tổng đăng ký thành công:</b></td>
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

<hr />
<br /><br />
<div class="title-box"><div class="fz14 fclwhite b p10 mb10">Chi tiết từng ngày</div></div>

<table width="100%" class="items">
	<tr>
		<th>Ngày</th>
		<th>Tổng đăng ký thành công</th>
		<th>Đăng ký Free</th>
		<th>Gia hạn</th>
		<th>Hủy</th>
		<th>Nghe bài hát</th>
		<th>Tải bài hát</th>
		<th>Xem video</th>
		<th>Tải video</th>
	</tr>
	<?php foreach ($allReport as $data):?>
	<tr>
		<td><?php echo $data['m']?></td>
		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_subscribe']?></td></tr>
				<?php
					if($data['total_wap_subscribe']){
						echo "<tr><td>WAP: ".$data['total_wap_subscribe']."</td></tr>";
					}
					if($data['total_sms_subscribe']){
						echo "<tr><td>SMS: ".$data['total_sms_subscribe']."</td></tr>";
					}
					if($data['total_web_subscribe']){
						echo "<tr><td>WEB: ".$data['total_web_subscribe']."</td></tr>";
					}
					if($data['total_android_subscribe']){
						echo "<tr><td>ANDROID: ".$data['total_android_subscribe']."</td></tr>";
					}
					if($data['total_ios_subscribe']){
						echo "<tr><td>IOS: ".$data['total_ios_subscribe']."</td></tr>";
					}
					if($data['total_admin_subscribe']){
						echo "<tr><td>IOS: ".$data['total_admin_subscribe']."</td></tr>";
					}
                    if($data['total_ivr_subscribe']){
						echo "<tr><td>IVR: ".$data['total_ivr_subscribe']."</td></tr>";
					}
                    if($data['total_vinaphone_subscribe']){
						echo "<tr><td>VINAPHONE: ".$data['total_vinaphone_subscribe']."</td></tr>";
					}
				?>
			</table>
		</td>
		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_subscribe_free']?></td></tr>
				<?php
					if($data['total_wap_subscribe_free']){
						echo "<tr><td>WAP: ".$data['total_wap_subscribe_free']."</td></tr>";
					}
					if($data['total_sms_subscribe_free']){
						echo "<tr><td>SMS: ".$data['total_sms_subscribe_free']."</td></tr>";
					}
					if($data['total_web_subscribe_free']){
						echo "<tr><td>WEB: ".$data['total_web_subscribe_free']."</td></tr>";
					}
					if($data['total_android_subscribe_free']){
						echo "<tr><td>ANDROID: ".$data['total_android_subscribe_free']."</td></tr>";
					}
					if($data['total_ios_subscribe_free']){
						echo "<tr><td>IOS: ".$data['total_ios_subscribe_free']."</td></tr>";
					}
					if($data['total_admin_subscribe_free']){
						echo "<tr><td>ADMIN: ".$data['total_admin_subscribe_free']."</td></tr>";
					}
                    if($data['total_ivr_subscribe_free']){
						echo "<tr><td>IVR: ".$data['total_ivr_subscribe_free']."</td></tr>";
					}
					if($data['total_vinaphone_subscribe_free']){
						echo "<tr><td>VINAPHONE: ".$data['total_vinaphone_subscribe_free']."</td></tr>";
					}
				?>
			</table>
		</td>
		<td><?php echo $data['total_subscribe_ext']?></td>

		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_unsubscribe']?></td></tr>
				<?php
					if($data['total_wap_unsubscribe']){
						echo "<tr><td>WAP: ".$data['total_wap_unsubscribe']."</td></tr>";
					}
					if($data['total_sms_unsubscribe']){
						echo "<tr><td>SMS: ".$data['total_sms_unsubscribe']."</td></tr>";
					}
					if($data['total_web_unsubscribe']){
						echo "<tr><td>WEB: ".$data['total_web_unsubscribe']."</td></tr>";
					}
					if($data['total_android_unsubscribe']){
						echo "<tr><td>ANDROID: ".$data['total_android_unsubscribe']."</td></tr>";
					}
					if($data['total_ios_unsubscribe']){
						echo "<tr><td>IOS: ".$data['total_ios_unsubscribe']."</td></tr>";
					}
					if($data['total_admin_unsubscribe']){
						echo "<tr><td>ADMIN: ".$data['total_admin_unsubscribe']."</td></tr>";
					}
                    if($data['total_vinaphone_unsubscribe']){
						echo "<tr><td>VINAPHONE: ".$data['total_vinaphone_unsubscribe']."</td></tr>";
					}
				?>
			</table>
		</td>	
				
		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_playsong']?></td></tr>
				<?php
					if($data['total_wap_playsong']){
						echo "<tr><td>WAP: ".$data['total_wap_playsong']."</td></tr>";
					}
					if($data['total_android_playsong']){
						echo "<tr><td>ANDROID: ".$data['total_android_playsong']."</td></tr>";
					}
					if($data['total_ios_playsong']){
						echo "<tr><td>IOS: ".$data['total_ios_playsong']."</td></tr>";
					}
				?>
			</table>
		</td>			
		

		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_downloadsong']?></td></tr>
				<?php
					if($data['total_wap_downloadsong']){
						echo "<tr><td>WAP: ".$data['total_wap_downloadsong']."</td></tr>";
					}
					if($data['total_sms_downloadsong']){
						echo "<tr><td>SMS: ".$data['total_sms_downloadsong']."</td></tr>";
					}
					if($data['total_web_downloadsong']){
						echo "<tr><td>WEB: ".$data['total_web_downloadsong']."</td></tr>";
					}
					if($data['total_android_downloadsong']){
						echo "<tr><td>ANDROID: ".$data['total_android_downloadsong']."</td></tr>";
					}
					if($data['total_ios_downloadsong']){
						echo "<tr><td>IOS: ".$data['total_ios_downloadsong']."</td></tr>";
					}
					if($data['total_chachastar_downloadsong']){
						echo "<tr><td>ChachaStar: ".$data['total_chachastar_downloadsong']."</td></tr>";
					}
				?>
			</table>
		</td>	
				
		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_playvideo']?></td></tr>
				<?php
					if($data['total_wap_playvideo']){
						echo "<tr><td>WAP: ".$data['total_wap_playvideo']."</td></tr>";
					}
					if(isset($data['total_sms_playvideo']) && $data['total_sms_playvideo']){
						echo "<tr><td>SMS: ".$data['total_sms_playvideo']."</td></tr>";
					}
					if(isset($data['total_web_playvideo']) && $data['total_web_playvideo']){
						echo "<tr><td>WEB: ".$data['total_web_playvideo']."</td></tr>";
					}
					if($data['total_android_playvideo']){
						echo "<tr><td>ANDROID: ".$data['total_android_playvideo']."</td></tr>";
					}
					if(isset($data['total_ios_playvideo']) && $data['total_ios_playvideo']){
						echo "<tr><td>IOS: ".$data['total_ios_playvideo']."</td></tr>";
					}
					/* if($data['total_admin_playvideo']){
						echo "<tr><td>IOS: ".$data['total_admin_playvideo']."</td></tr>";
					} */
				?>
			</table>
		</td>	
				
		<td style="padding: 0!important;">
			<table style="border: 0;width: 100%">
				<tr><td class="first-row">Tổng:<?php echo $data['total_downloadvideo']?></td></tr>
				<?php
					if($data['total_wap_downloadvideo']){
						echo "<tr><td>WAP: ".$data['total_wap_downloadvideo']."</td></tr>";
					}
					if($data['total_sms_downloadvideo']){
						echo "<tr><td>SMS: ".$data['total_sms_downloadvideo']."</td></tr>";
					}
					if($data['total_web_downloadvideo']){
						echo "<tr><td>WEB: ".$data['total_web_downloadvideo']."</td></tr>";
					}
					if($data['total_android_downloadvideo']){
						echo "<tr><td>ANDROID: ".$data['total_android_downloadvideo']."</td></tr>";
					}
					if($data['total_ios_downloadvideo']){
						echo "<tr><td>IOS: ".$data['total_ios_downloadvideo']."</td></tr>";
					}
					if($data['total_chachastar_downloadvideo']){
						echo "<tr><td>ChachaStar: ".$data['total_chachastar_downloadvideo']."</td></tr>";
					}
				?>
			</table>
		</td>
				
	</tr>
	<?php endforeach;?>
</table>

</div>

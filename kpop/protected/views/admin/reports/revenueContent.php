<?php
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Thống kê doanh thu CP: {CPNAME}",array('{CPNAME}'=>$cpName->name));
$curentUrl =  Yii::app()->request->getRequestUri();
$this->menu=array(
	array('label'=>Yii::t('admin','Export'), 'url'=>$curentUrl.'&export=1'),
);

	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');

	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
	$cs->registerCssFile(Yii::app()->theme->baseUrl."/css/report.css");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Tìm kiếm','#',array('class'=>'search-button')); ?></div>

<div class="search-form">
<?php $this->renderPartial('_revCpfilter',array(
    'cpList'=>$cpList,
    'cpId'=>$cpId,
)); ?>
</div><!-- search-form -->
<div class="content-body grid-view" style="overflow: auto">
    <div class="clearfix"></div>
    <?php //echo "<pre>";print_r($data);exit(); ?>
    <table width="100%" class="items">
    	<tr>
    		<th>Ngày</th>
    		<th>Tổng doanh thu</th>
    		<th colspan="6">Bài hát Việt </th>
    		<th colspan="6">Bài hát QTẾ </th>
    		<th colspan="4">Video Việt </th>
    		<th colspan="4">Video QTẾ </th>
    		<th colspan="2">Nhạc chuông Việt </th>
    		<th colspan="2">Nhạc chuông QTẾ</th>
    	</tr>
    	<tr>
    		<th></th>
    		<th><img src="1.gif" width="80" height="1" /> </th>
    		<th>Lượt nghe</th>
    		<th> <img src="1.gif" width="80" height="1" />Doanh thu nghe</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    		<th>Quà tặng</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu Quà tặng</th>
    		<th>Lượt nghe</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu nghe</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    		<th>Quà tặng</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu Quà tặng</th>

    		<th>Lượt xem</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu xem</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    		<th>Lượt xem</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu xem</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    		<th>Lượt tải</th>
    		<th><img src="1.gif" width="80" height="1" />Doanh thu tải</th>
    	</tr>
    	<?php
    		$total = 0;
    		$total_play_song_vi = 0;
    		$total_down_song_vi = 0;
    		$total_play_song_qt = 0;
    		$total_down_song_qt = 0;
    		$total_play_video_vi = 0;
    		$total_down_video_vi = 0;
    		$total_play_video_qt = 0;
    		$total_down_video_qt = 0;
    		$total_trans_rt_vi = 0;
    		$total_trans_rt_qt = 0;
    		$total_gift_song_vi = 0;
    		$total_gift_song_qt = 0;

    		$total_rev_play_song_vi = 0;
    		$total_rev_down_song_vi = 0;
    		$total_rev_play_song_qt = 0;
    		$total_rev_down_song_qt = 0;
    		$total_rev_play_video_vi = 0;
    		$total_rev_down_video_vi = 0;
    		$total_rev_play_video_qt = 0;
    		$total_rev_down_video_qt = 0;
    		$total_rev_rt_vi = 0;
    		$total_rev_rt_qt = 0;
    		$total_rev_gift_song_vi = 0;
    		$total_rev_gift_song_qt = 0;


    		$total_rev = 0;
    		foreach ($data as $data):
                $total_rev_day = (($data['total_rev_play_song_vi'] + $data['total_rev_down_song_vi'] + $data['total_rev_rt_vi'] + $data['total_rev_gift_song_vi']) * 0.3)
                                + (($data['total_rev_play_song_qt']+ $data['total_rev_down_song_qt'] + $data['total_rev_rt_qt'] + $data['total_rev_play_video_vi'] + $data['total_rev_down_video_vi'] + $data['total_rev_gift_song_qt'])*0.45)
                                + (($data['total_rev_play_video_qt'] + $data['total_rev_down_video_qt'])*0.55);
    		$total_rev = $total_rev + $total_rev_day;




    	?>
    	<tr>
    		<td><?php echo $data['date']; ?> </td>
    		<td style="background: #f4b82c!important;"><?php echo number_format($total_rev_day, 0, ',', ' '); ?> </td>
    		<td><?php echo $data['total_play_song_vi']?></td>
    		<td><?php echo number_format($data['total_rev_play_song_vi'], 0, ',', ' ') ?></td>
    		<td><?php echo $data['total_down_song_vi']?></td>
    		<td><?php echo number_format($data['total_rev_down_song_vi'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_gift_song_vi']?></td>
    		<td><?php echo number_format($data['total_rev_gift_song_vi'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_play_song_qt']?></td>
    		<td><?php echo number_format($data['total_rev_play_song_qt'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_down_song_qt']?></td>
    		<td><?php echo number_format($data['total_rev_down_song_qt'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_gift_song_qt']?></td>
    		<td><?php echo number_format($data['total_rev_gift_song_qt'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_play_video_vi']?></td>
    		<td><?php echo number_format($data['total_rev_play_video_vi'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_down_video_vi']?></td>
    		<td><?php echo number_format($data['total_rev_down_video_vi'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_play_video_qt']?></td>
    		<td><?php echo number_format($data['total_rev_play_video_qt'], 0, ',', ' ')?></td>
    		<td><?php echo $data['total_down_video_qt']?></td>
    		<td><?php echo number_format($data['total_rev_down_video_qt'], 0, ',', ' ')?></td>

    		<td><?php echo $data['total_trans_rt_vi']?></td>
    		<td><?php echo $data['total_rev_rt_vi']?></td>
    		<td><?php echo $data['total_trans_rt_qt']?></td>
    		<td><?php echo $data['total_rev_rt_qt']?></td>
    	</tr>
    	<?php
    		$total_play_song_vi = $total_play_song_vi+$data['total_play_song_vi'];
    		$total_down_song_vi = $total_down_song_vi+$data['total_down_song_vi'];
    		$total_play_song_qt = $total_play_song_qt+$data['total_play_song_qt'];
    		$total_down_song_qt = $total_down_song_qt+$data['total_down_song_qt'];
    		$total_play_video_vi = $total_play_video_vi+$data['total_play_video_vi'];
    		$total_down_video_vi = $total_down_video_vi+$data['total_down_video_vi'];
    		$total_play_video_qt = $total_play_video_qt+$data['total_play_video_qt'];
    		$total_down_video_qt = $total_down_video_qt+$data['total_down_video_qt'];
    		$total_trans_rt_vi = $total_trans_rt_vi+$data['total_trans_rt_vi'];
    		$total_trans_rt_qt = $total_trans_rt_qt+$data['total_trans_rt_qt'];
    		$total_gift_song_vi = $total_gift_song_vi+$data['total_gift_song_vi'];
    		$total_gift_song_qt = $total_gift_song_qt+$data['total_gift_song_qt'];


    		$total_rev_play_song_vi = $total_rev_play_song_vi + $data['total_rev_play_song_vi'];
    		$total_rev_down_song_vi = $total_rev_down_song_vi+$data['total_rev_down_song_vi'];
    		$total_rev_play_song_qt = $total_rev_play_song_qt+$data['total_rev_play_song_qt'];
    		$total_rev_down_song_qt = $total_rev_down_song_qt+$data['total_rev_down_song_qt'];
    		$total_rev_play_video_vi = $total_rev_play_video_vi+$data['total_rev_play_video_vi'];
    		$total_rev_down_video_vi = $total_rev_down_video_vi+$data['total_rev_down_video_vi'];
    		$total_rev_play_video_qt = $total_rev_play_video_qt+$data['total_rev_play_video_qt'];
    		$total_rev_down_video_qt = $total_rev_down_video_qt+$data['total_rev_down_video_qt'];
    		$total_rev_rt_vi = $total_rev_rt_vi + $data['total_rev_rt_vi'];
    		$total_rev_rt_qt = $total_rev_rt_qt + $data['total_rev_rt_qt'];
    		$total_rev_gift_song_vi = $total_rev_gift_song_vi + $data['total_rev_gift_song_vi'];
    		$total_rev_gift_song_qt = $total_rev_gift_song_qt + $data['total_rev_gift_song_qt'];

    	 endforeach;?>
    	<tr>
    		<td style="background: #5ec411!important;"><b>Tổng số</b></td>
    		<td style="background: #5ec411!important;"><b><?php echo number_format($total_rev, 0, ',', ' ')?></b></td>
    		<td style="background: #5ec411!important;"><?php echo $total_play_song_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_play_song_vi, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_down_song_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_down_song_vi, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_gift_song_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_gift_song_vi, 0, ',', ' ') ?></td>

    		<td style="background: #5ec411!important;"><?php echo $total_play_song_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_play_song_qt, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_down_song_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_down_song_qt, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_gift_song_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_gift_song_qt, 0, ',', ' ') ?></td>


    		<td style="background: #5ec411!important;"><?php echo $total_play_video_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_play_video_vi, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_down_video_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_down_video_vi, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_play_video_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_play_video_qt, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_down_video_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_down_video_qt, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_trans_rt_vi ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_rt_vi, 0, ',', ' ') ?></td>
    		<td style="background: #5ec411!important;"><?php echo $total_trans_rt_qt ?></td>
    		<td style="background: #5ec411!important;"><?php echo number_format($total_rev_rt_qt, 0, ',', ' ') ?></td>
    	</tr>
    </table>
</div>


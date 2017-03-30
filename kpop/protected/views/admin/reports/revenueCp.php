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
	'packageId' => $packageId,
	'packageList' => $packageList,
	'hasPackage'=>true
)); ?>

</div><!-- search-form -->
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items">
    	<tr>
    		<th>Ngày</th>
    		<th colspan="2">Lượt nghe</th>
    		<th colspan="2">Lượt tải</th>
    		<th colspan="2">Tổng Nghe+Tải</th>
    		<th>Doanh thu thuê bao</th>
    		<th>Doanh thu CP</th>
    	</tr>
    	<tr>
    		<th></th>
    		<th>Lượt nghe của CP</th>
    		<th>Tổng lượt nghe</th>
    		<th>Lượt tải của CP</th>
    		<th>Tổng lượt tải</th>
    		<th>Tổng Nghe+Tải của CP</th>
    		<th width="60">Tổng Nghe+Tải</th>
    		<th width="80"></th>
    		<th></th>
    	</tr>

    	<?php
    		$total = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total5 = 0;
                $total6 = 0;
                $total7 = 0;
    		foreach ($data['cpTrans'] as $rev):
    	?>
    	<tr>
    		<td><?php echo $rev['m']?></td>
    		<td><?php echo $rev['streaming_cp']?></td>
    		<td><?php echo $rev['total_streaming']?></td>
    		<td><?php echo $rev['download_cp']?></td>
    		<td><?php echo $rev['total_download']?></td>
    		<td><?php 
    			//Tổng Nghe+Tải của CP
    			echo ($rev['download_cp']+$rev['streaming_cp'])
    			?>
    		</td>
    		<td><?php echo ($rev['total_download']+$rev['total_streaming'])?></td>
    		<td><?php 
    		$revPack = isset($data['revPackage'][$rev['m']])?$data['revPackage'][$rev['m']]:0; 
    		echo $revPack = number_format($revPack, 0, ',', ''); ?>
    		</td>
    		<td>
    			<?php
    				$abc = (($rev['streaming_cp']+$rev['download_cp'])/($rev['total_streaming']+$rev['total_download']))*$revPack*0.3;
    				 echo $abc = number_format($abc, 0, ',', ''); ?>
    		</td>
    	</tr>
    	<?php
    	$total = $total+$abc;
        $total1 += $rev['streaming_cp'];
        $total2 += $rev['total_streaming'];
        $total3 += $rev['download_cp'];
        $total4 += $rev['total_download'];
        $total5 = $total5 + ($rev['download_cp']+$rev['streaming_cp']);
        $tp = $tp + $rev['total_download']+$rev['total_streaming'];
        $total6 = $tp;
        $total7 += $revPack;
        $total_c += $abc;
    	endforeach;
    	 ?>


    	 <tr>
    	 	<td style="background: #5ec411!important;"> <b>Tổng số:</b></td>
                <td style="background: #5ec411!important;"><?php echo $total1; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total2; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total3; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total4; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total5; ?></td>
                <td style="background: #5ec411!important;"><?php echo $total6; ?></td>
                <td style="background: #5ec411!important;"><?php echo number_format($total7, 0, ',', ''); ?></td>
    	 	<td style="background: #5ec411!important;"><b><?php echo number_format($total_c, 0, ',', '') ?></b></td>
    	 </tr>

    </table>
</div>


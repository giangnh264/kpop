<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/swfobject.js");

$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Revenue',
);
$this->pageLabel = Yii::t('admin', "Thống kê doanh thu");
?>
<div class="search-form" style="display:block">
    <?php
    $this->renderPartial('_searchRevenue',array('model'=>$model,
                                                'cpList'=>$cpList,
                        ));
    ?>
</div>
<?php
echo "<div  class='report-zone mt10'>-".Yii::t('admin',"Thống kê doanh thu")."</span>";
$this->renderPartial('_graph',array("graphId"=>"revenueReport","graphData"=>$revenueReport));        
?>

<div style="background: #eee;margin:25px 0px;padding:5px;">
    <div class="wide">
        <div class="fl" style="width:500px;">
            <?php
                foreach ($packages as $package){
            ?>
            <div class="row">
                <?php echo Yii::t('admin',$package['format'],$package);?>
            </div>            
            <?php
            
                }
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-statistic-cp-model-grid',
	'dataProvider'=>$model->getCpRevenueRecords($_GET["period"]),	
	'columns'=>array(
		'period',
		'sum_played_count',
		'sum_downloaded_count',
		'sum_revenue',
		/*
		'date',
		*/
	),
));
echo "</div>";
echo "</div>";
?>
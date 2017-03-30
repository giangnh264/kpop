<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/swfobject.js");

$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Overview',
);
$this->pageLabel = Yii::t('admin', "Tổng hợp");

echo "<div class='report-zone'>-".Yii::t('admin',"Thống kê doanh thu 7 ngày gần đây")."</span>";
$this->renderPartial('_graph',array("graphId"=>"revenueLast7Days","graphData"=>$revenueLast7DaysReport));        

echo "<div style='margin-top:25px;'>-".Yii::t('admin',"Thống kê nội dung 7 ngày gần đây")."</span>";
$this->renderPartial('_graph',array("graphId"=>"contentLast7Days","graphData"=>$contentLast7DaysReport));        
?>
<div style="background: #eee;margin:25px 0px;padding:5px;">
    <div class="wide">
        <div class="fl" style="width:500px;">
            <div class="row">
                <?php echo Yii::t('admin','Tổng số bài hát')?>:
            </div>
            <div class="row">
                <?php echo Yii::t('admin','Tổng số lượt nghe')?>:
            </div>
        </div>
        <div class="fl">
            <div class="row">
                <?php echo Yii::t('admin','Tổng số lượt tải')?>:
            </div>
        </div>    
    </div>
    <div class="clearfix"></div>
</div>
<?php
if ($subscriberLast7DaysReport&&$subscriberLast7DaysReport!=""){
    echo "<div style='margin-top:25px;'>-".Yii::t('admin',"Thống kê thuê bao 7 ngày gần đây")."</span>";
    $this->renderPartial('_graph',array("graphId"=>"subscriberLast7Days","graphData"=>$subscriberLast7DaysReport));      
}
echo "</div>";
echo "</div>";
?>


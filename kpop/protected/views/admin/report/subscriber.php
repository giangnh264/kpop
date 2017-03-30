<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/swfobject.js");

$this->breadcrumbs=array(
	'Admin Statistic Subscribe Models'=>array('index'),
	'Manage',
);

$this->pageLabel = Yii::t("admin","Thống kê thuê bao");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_searchSubscriber',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
echo "<div class='report-zone mt10'>-".Yii::t('admin',"Thống kê thuê bao")."</span>";
$this->renderPartial('_graph',array("graphId"=>"subscriberReport","graphData"=>$subscriberReport));

$summaryText= CHtml::dropDownList('pageSize',$pageSize,array(1=>1,10=>10,30=>30,50=>50,100=>100),array('onchange'=>"$.fn.yiiGridView.update('admin-statistic-subscribe-model-grid',{ data:{pageSize: $(this).val() }})", ))."&nbsp;".Yii::t('zii','Displaying {start}-{end} of {count} result(s).');

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-statistic-subscribe-model-grid',
	'dataProvider'=>$model->getSubscriberRecords($_GET["period"]),	
    'summaryText'=>$summaryText,
	'columns'=>array(
		'period',
		'sum_subscribe_count',
		'sum_subscribe_ext_count',
        'sum_expired_count',
		'sum_unsubscribe_count',
	),
	)
);
echo "</div>";
?>

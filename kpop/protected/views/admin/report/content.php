<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/swfobject.js");

$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Content',
);
$this->pageLabel = Yii::t('admin', "Thống kê nội dung");
?>
<div class="search-form" style="display:block">
    <?php
        $this->renderPartial('_searchContent',array('model'=>$model, 
                                                    'cpList'=>$cpList, 
                                                    'genreList'=>$genreList,
                                                )
        );
    ?>
</div>
<?php
echo "<div class='report-zone mt10'>-".Yii::t('admin',"Thống kê doanh thu")."</span>";
$this->renderPartial('_graph',array("graphId"=>"contentReport","graphData"=>$contentReport));

$summaryText= CHtml::dropDownList('pageSize',$pageSize,array(1=>1,10=>10,30=>30,50=>50,100=>100),array('onchange'=>"$.fn.yiiGridView.update('admin-statistic-song-model-grid',{ data:{pageSize: $(this).val() }})", ))."&nbsp;".Yii::t('zii','Displaying {start}-{end} of {count} result(s).');
$this->widget('zii.widgets.grid.CGridView', array(
    'summaryText'=>$summaryText,
	'id'=>'admin-statistic-song-model-grid',
	'dataProvider'=>$model->getContentRecords($_GET['period']),	
	'columns'=>array(
		'name',
		'sum_played_count',
		'sum_downloaded_count',
        array(
            'type' => 'raw',
            'header' => '',
            'value' => 'number_format(($data->sum_played_count+$data->sum_downloaded_count)*100/'.$total.',0)." %";',
            //'value' => '$a = (isset($a))?36:6;',
        ),
		/*
		'downloaded_count',
		'revenue',
		*/
	
	),
));
echo "</div>";
?>

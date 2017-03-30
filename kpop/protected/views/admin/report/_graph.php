<div id="<?php echo $graphId?>" style="border:2px solid;border-radius: 5px 5px 5px 5px;">
    <strong>You need to upgrade your Flash Player</strong>
</div>
<?php
    $setting_url = Yii::app()->createUrl("amChartSettingXML/index",array("graphs"=>urlencode($graphData['graphs'])));
//so.addVariable("settings_file", escape("/amChartSettingXML?graphs=<?php echo urlencode($graphData['graphs']);"));      
?>
<script  language="javascript">
// <![CDATA[		
    var width =  800;
    var so = new SWFObject("/flash/amline.swf", "amline", width, "250", "8", "#FFFFFF");
    so.addVariable("path", "/flash/");    
    so.addVariable("settings_file", escape("<?php echo $setting_url;?>"));      
    so.addVariable("chart_data", "<?php echo $graphData['data']?>");  
    so.addParam("wmode", "transparent");
    so.addVariable("preloader_color", "#999999");    
    so.write("<?php echo $graphId?>");
// ]]>
</script> 
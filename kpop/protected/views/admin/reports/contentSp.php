<?php

	$this->breadcrumbs=array(
		'Report'=>array('/report'),
		'Overview',
	);
	$curentUrl =  Yii::app()->request->getRequestUri();
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
<div class="search-form">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table>
	<tr>
		<td>
		<?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		?>
		</td>
		<td><?php echo CHtml::submitButton('Search', array('style'=>'float: right')); ?></td>
		<td><?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export','style'=>'float: right')); ?></td>
	</tr>
</table>

<?php $this->endWidget(); ?>
</div><!-- search-form -->
</div>
<?php 
if(count($data)>0):
$priceUnique = array_unique($price);
if(isset($_GET['dev']) && $_GET['dev']==1){
	echo '<pre>';print_r($priceUnique);
	echo '<pre>';print_r($price);
}
?>
<div class="content-body grid-view" style="overflow: auto;">
    <div class="clearfix"></div>
    <table width="100%" class="items">
    	 <tr>
    		<th>Ngày</th>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):
    				$k=0;
    		?>
    			<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value){$k++;} ?>
    			<?php endforeach;?>
    		<th colspan="<?php echo $k;?>"><?php echo $value;?></th>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<tr>
    		<th>#</th>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):?>
    				<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value): ?>
    					<th><?php 
    					if(strpos($key, $item)!==false){
    						 echo str_replace($item, '', $key);
    					}else{
							echo $key;
						}
    						 ?>
    					</th>
    					<?php endif;?>
    				<?php endforeach;?>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<?php
		if(count($timeLabel)>0):
	    	foreach ($timeLabel as $keyData => $valueData):
		?>
				<?php if(is_array($valueData)):?>
			    	<tr>
			    		<td><?php echo $valueData['date'];?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td><?php echo $valueData['total_'.$key.'_'.$value];?></td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
			    <?php else:?>
			    <tr>
			    		<td><?php echo $valueData;?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td>0</td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
			    <?php endif;?>
	    <?php
	    	endforeach;
    	endif;
    	?>
    	<!-- Total -->
    	<tr>
    		<td>Tổng</td>
    		<?php if(count($priceUnique)>0):?>
    		<?php foreach ($priceUnique as $value):?>
    				<?php foreach ($price as $key => $item):?>
    					<?php if($item==$value): ?>
    					<td><?php echo $total['total_'.$key.'_'.$value];?></td>
    					<?php endif;?>
    				<?php endforeach;?>
    		<?php endforeach;?>
    		<?php endif;?>
    	</tr>
    	<?php
		/*if(count($data)>0):
	    	foreach ($data as $key => $valueData):
		?>
			    	<tr>
			    		<td><?php echo $valueData['date'];?></td>
			    		<?php if(count($priceUnique)>0):?>
			    		<?php foreach ($priceUnique as $value):?>
			    				<?php foreach ($price as $key => $item):?>
			    					<?php if($item==$value): ?>
			    					<td><?php echo $valueData['total_'.$key.'_'.$value];?></td>
			    					<?php endif;?>
			    				<?php endforeach;?>
			    		<?php endforeach;?>
			    		<?php endif;?>
			    	</tr>
	    <?php
	    	endforeach;
    	endif;*/
    	?>
  	</table>
</div>
<?php else:?>
<p>Không có dữ liệu</p>
 <?php endif;?>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/docsupport/prism.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/chosen.css">
<style>
div.form{
	overflow: visible;
}
table tr td{
	padding: 5px;
	}
</style>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="100%">
	<tr>
		<td align="right" valign="middle">
			Thời gian
		</td>
		
		<td align="left"  valign="middle" style="float: left;text-align: left;">
			<?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'songreport[date]',
		       		'value'=>isset($_GET['songreport']['date'])?$_GET['songreport']['date']:'',
		        ));
		     ?>
		<td align="right">Ca sỹ:</td>
		<td>
		<?php 
		$artistList = AdminArtistModel::model()->published()->findAll();
		?>
          <select name="artist" data-placeholder="Chọn ca sỹ..." class="chosen-select" style="width:350px;" tabindex="1">
          <?php foreach ($artistList as $key => $value):
		          if($artist ==$value->id){
		          	$selected = "selected";
		          }else{
		          	$selected = "";
		          }
          ?>
          <option value=""></option>
          <option value="<?php echo $value->id;?>" <?php echo $selected;?>><?php echo $value->name;?></option>
          <?php endforeach;?>
          </select>
		</td>
	</tr>
	<tr>
		<td align="right"  valign="middle">
			<?php echo Yii::t('admin','Nhà cung cấp');?>
		</td>
		<td align="left"  valign="middle">
			<?php
				$cpList = AdminCpModel::model()->findAll();
	        ?>
        	<select name="cp" data-placeholder="Chọn CP..." class="chosen-select" style="width:350px;" tabindex="1">
          		<?php foreach ($cpList as $key => $value):
          		if($cp ==$value->id){
          			$selected = "selected";
          		}else{
          			$selected = "";
          		}
          		?>
          		<option value=""></option>
          		<option value="<?php echo $value->id;?>" <?php echo $selected;?>><?php echo $value->name;?></option>
          		<?php endforeach;?>
          	</select>
		</td>
		
		<td align="right">Nhạc sỹ:</td>
		<td>
			<?php 
			$artist = AdminArtistModel::model()->published()->findAll();
			?>
          <select name="composer" data-placeholder="Chọn nhạc sỹ..." class="chosen-select" style="width:350px;" tabindex="1">
          <?php foreach ($artist as $key => $value):
		          if($composer ==$value->id){
		          	$selected = "selected";
		          }else{
		          	$selected = "";
		          }
          ?>
          <option value=""></option>
          <option value="<?php echo $value->id;?>" <?php echo $selected;?>><?php echo $value->name;?></option>
          <?php endforeach;?>
          </select>
		</td>
	</tr>
</table>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/docsupport/prism.js"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>
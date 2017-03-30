<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/docsupport/prism.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/admin/chosen_v1.0.0/chosen.css">
<style>
div.form,
.form .row,
#content .row{
	overflow: visible;
}
table tr td{
	padding: 5px;
	}
</style>
<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="fl">
        <div class="row">

                <?php echo CHtml::label(Yii::t('admin', 'Tên bài hát'), "") ?>
                <?php echo CHtml::textField('song_name', isset($song_name) ? $song_name : ''); ?>

           </div>
        <div class="row">
            <label>Ca sỹ:</label>
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
        </div>
         
        <div class="row created_time">
            <?php echo CHtml::label(Yii::t('admin', 'Thời gian'), "") ?>
            <?php
            $this->widget('ext.daterangepicker.input', array(
                'name' => 'songreport[date]',
                'value' => isset($_GET['songreport']['date']) ? $_GET['songreport']['date'] : '',
            ));
            ?>
        </div>
    </div>
     <div class="fl">
        	<?php if($this->levelAccess <=2):?>
         <div class="row">
          	<label>
			<?php echo Yii::t('admin','Nhà cung cấp');?>
			</label>
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
        </div>
        <?php endif;?>
        <div class="row">
			<label>Nhạc sỹ:</label>
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
		</div>
		</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
        <?php echo CHtml::resetButton('Reset') ?>
        <?php echo CHtml::submitButton('Export', array('name'=>'Export', 'value'=>'Export')) ?>
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
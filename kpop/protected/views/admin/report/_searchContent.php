<?php
    $period = array();
    foreach (ReportController::$period as $key=>$val){
        $period[$key] = Yii::t('admin',$val);
    }
    $content = array();
    foreach (ReportController::$content as $key=>$val){
        $content[$key] = Yii::t('admin',$val);
    }    
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin',"Nội dung"),"content_type"); ?>
            <?php echo CHtml::dropDownList("content_type", (isset($_GET["content_type"]))?$_GET["content_type"]:"",$content); ?>
        </div>                  
        <div class="row">
            <?php echo $form->label($model,'date'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>$model->className.'[date]',
                    'value'=>trim((isset($_GET[$model->className]['date']))?$_GET[$model->className]['date']:""),
		        ));
		     ?>
        </div>  	                
        <div class="row">
			<?php echo $form->label($model,'artist_id'); ?>
			<?php 
		       $this->widget('application.widgets.admin.ArtistFeild',
		                            array(
                                         'fieldId'=>$model->className.'[artist_id]',
                                         'fieldName'=>'artist_name',
                                         'fieldIdVal'=>$model->artist_id,
                                         'fieldNameVal'=>(isset($_GET['artist_name']))?$_GET['artist_name']:'',
		                            )
		                        );
		        
		        ?>
            <?php echo $form->error($model,'artist_id'); ?>
        </div>
    </div>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'genre_id'); ?>
            <?php 				
                $category = CMap::mergeArray(
									array(''=> Yii::t('admin',"Tất cả")),
									   CHtml::listData($genreList, 'id', 'name')
									);
                echo CHtml::dropDownList($model->className."[genre_id]", $model->genre_id, $category ); 
            ?>
        </div>
        <div class="row">
            <?php echo $form->label($model,'cp_id'); ?>
	        <?php 
	           $cp = $cpList;
                echo CHtml::dropDownList($model->className."[cp_id]", $model->cp_id, $cp )
	        ?>
        </div>
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin',"Xem theo"),"period"); ?>
            <?php echo CHtml::dropDownList("period", $_GET["period"], $period); ?>
        </div>                  
   </div>
<!--
	<div class="row">
		<?php echo $form->label($model,'artist_id'); ?>
		<?php echo $form->textField($model,'artist_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'played_count'); ?>
		<?php echo $form->textField($model,'played_count',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'downloaded_count'); ?>
		<?php echo $form->textField($model,'downloaded_count',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'revenue'); ?>
		<?php echo $form->textField($model,'revenue'); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search',array('name'=>'search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
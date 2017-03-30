<?php 
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
?>

<div class="content-body">
	<div class="form formcontent" id="basic-zone" >
	<?php /*
	    <div class="row upload-avatar" style="position: relative; left: 0; top: 0 ">
	    <?php echo CHtml::label(yii::t('admin','Ảnh đại diện'), ""); ?>
		    <div class="thumb pl130">
		    <?php
		        echo CHtml::image($model->getAvatarUrl(),"avatar",array("id"=>"img-display", "width"=>150,"height"=>150,"style"=>"margin-left:10px"));
		        $this->widget('ext.xupload.XUploadWidget', array(
		                            'url' => $this->createUrl("playlist/upload", array("parent_id" => 'tmp')),
		                            'model' => $uploadModel,
		                            'attribute' => 'file',
		                            'options' => array(
		                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                                               $("#img-display").attr("src","'.Yii::app()->params['storage']['staticUrl']."tmp/".'"+handler.response.name+"?rand='.time().'");
		                                                               $("#AdminPlaylistModel_source_path").val(handler.response.name);
		                                                            }'
		                                        )
		        ));
		    ?>
		    </div>
	    </div>
	  */?>  
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-playlist-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<?php echo $form->errorSummary($model); ?>
		
		<?php if(!$model->isNewRecord):?>
		<div class="row">
		<label>Icon cho app Radio</label>
		<div id="files-x">
			<img src="<?php echo Common::getLinkIconsRadio($model->id, 'genre');?>" />
		</div>
		<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
					array(
					        'id'=>'uploadFile',
					        'config'=>array(
					               'action'=>Yii::app()->createUrl('/radio/default/uploadAvartar', array('id'=>$model->id, 'type'=>'playlist')),
					               'allowedExtensions'=>array("png"),//array("jpg","jpeg","gif","exe","mov" and etc...
					               'sizeLimit'=>100*1024*1024,// maximum file size in bytes
					               'minSizeLimit'=>1,// minimum file size in bytes
					               'onComplete'=>"js:function(id, fileName, responseJSON){
					        			if(responseJSON.success){
						 					$('#files-x').html('<img src=\''+responseJSON.data+'\'/>');
					        				location.reload();
					        			}else{
											alert(responseJSON.data);
										}
									}",
					              )
					));
		?>
		</div>
		<?php endif;?>
		
		
		<?php echo CHtml::hiddenField("AdminPlaylistModel[source_path]", 0) ?>
		<div class="row  global_field">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160,'class'=>'txtchange')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
		<div class="row global_field">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>160,'class'=>'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	
		<?php echo $form->hiddenField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
		
		<div class="row global_field">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php #echo $form->textField($model,'username',array('size'=>60,'maxlength'=>160)); ?>
			<?php $this->widget('CAutoComplete',
	          array(
	             'name'=>'AdminPlaylistModel_username',
	          	  'value'=>$model->username, 
	             'url'=>array('user/autoList'), 
	             'max'=>10, //specifies the max number of items to display
	             'minChars'=>2, 
	             'delay'=>500, //number of milliseconds before lookup occurs
	             'matchCase'=>false, //match case when performing a lookup?
	             'htmlOptions'=>array('size'=>'40',), 
	 
	             'methodChain'=>".result(function(event,item){\$(\"#AdminPlaylistModel_user_id\").val(item[1]);})",
	             ));
	    	?>
			<?php echo $form->error($model,'username'); ?>
		</div>
	
	
	
		<div class="row global_field">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php    
			$status = array(
	                                '1'=> Yii::t('admin','Đang kích hoạt') ,
	                                '0'=> Yii::t('admin','Không kích hoạt'),
	                            );
	        echo CHtml::dropDownList("AdminPlaylistModel[status]",  $model->status, $status ) ?>
	        <?php echo $form->error($model,'status'); ?>		
		</div>
		
		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Tiêu đề') , "") ?>
			<?php echo CHtml::textField("playlistMeta[title]",isset($playlistMeta->title)?$playlistMeta->title:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>
        
        
        <?php
        $className = get_class($model);
        //// array(1) { ["suggest_1"]=> string(21) "0++Nhạc miền tây" } 
        $suggestItems = MainContentModel::updateSuggestList($className,$model->id);
        foreach ($suggestItems as $key => $val):
            $val = explode('++',$val);            
            ?>        
            <div class="row global_field">
                <?php echo $form->labelEx($model, $val[1]); ?>
                <?php
                if (empty($val[0]))
                    $val[0] = 0;
                    $suggest = array(
                        1 => "Yes",
                        0 => "No",
                    );                    
                echo CHtml::dropDownList($className."[".$key."]", $val[0], $suggest);
                ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        <?php endforeach; ?>
        
	
		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Từ khóa') , "") ?>
			<?php echo CHtml::textField("playlistMeta[keywords]",isset($playlistMeta->keywords)?$playlistMeta->keywords:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Mô tả') , "") ?>
			<?php echo CHtml::textField("playlistMeta[description]",isset($playlistMeta->description)?$playlistMeta->description:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
	
	<div class="form" id="inlist-zone" style="display: none;">
	</div>
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>
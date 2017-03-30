<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js"); ?>
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
<style>
table tr td{
	vertical-align: middle;
}
<!--
table.album-fx tr td{
	text-align: left;
}
table.album-fx label{
	float: left;
	display: block;
	background: #C4C4C4;
	min-width: 120px;
	padding: 5px;
	text-shadow: none;
	margin-right: 5px;
}
.artist-zone{
	margin-left: 137px
}
.form{
	background: transparent!important;
}
li.ul-files{
	border: 1px dashed #333;
}
.success{
	padding: 5px
}
#files-x li{
	margin-bottom: 10px;
}
table.album-fx input[type="text"]{
}
#upload{
	margin:30px 200px; padding:15px;
	font-weight:bold; font-size:1.3em;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	background:#f2f2f2;
	color:#3366cc;
	border:1px solid #ccc;
	width:150px;
	cursor:pointer !important;
	-moz-border-radius:5px; -webkit-border-radius:5px;
}
.darkbg{
	background:#ddd !important;
}
#status{
	font-family:Arial; padding:5px;
}
.artist-ids p,
.composer-ids p{
	border: 1px dashed #888;
	margin: 5px 0;
	padding: 5px;
}
ul#files{ list-style:none; padding:0; margin:0; }
ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
ul#files li img{ max-width:180px; max-height:150px; }
.success{ background:#99f099; border:1px solid #339933; }
.error{ background:#f0c6c3; border:1px solid #cc6622; }
-->
</style>
<div style="background: #ddd; border-radius: 6px 6px 6px 6px;padding: 10px;">
<div class="row global_field upload-avatar" style="position: relative; left: 0; top: 0 ">
			    <div class="thumb pl130">
			    <?php
			    	if(isset($_POST['AdminAlbumModel']['source_path']) && $_POST['AdminAlbumModel']['source_path'] != 0){
			    		$url = Yii::app()->request->baseUrl."/data/tmp/".$_POST['AdminAlbumModel']['source_path'];
			    	}else{
			    		$url = $model->getAvatarUrl();
			    	}
			        echo CHtml::image($url,"avatar",array("id"=>"img-display", "width"=>150,"height"=>150,"style"=>"margin-left:10px"));
			        $this->widget('ext.xupload.XUploadWidget', array(
			                            'url' => $this->createUrl("album/upload", array("parent_id" => 'tmp')),
			                            'model' => $uploadModel,
			                            'attribute' => 'file',
			                            'options' => array(
			                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
			                                           						if(handler.response.error){
			                                           							alert(handler.response.msg);
			                                           						}else{
			                                           							$("#img-display").attr("src","'.Yii::app()->request->baseUrl."/data/tmp/".'"+handler.response.name+"?rand='.time().'");
			                                                               		$("#AdminAlbumModel_source_path").val(handler.response.name);
			                                           						}
	
			                                                            }'
			                                        )
			        ));
			    ?>
			    </div>
		    </div>
<div>
	<div class="form" id="basic-zone" >
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-album-model-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('onSubmit'=>'return GetSongInfo();')
	)); ?>
	<?php echo $form->errorSummary($model); ?>
	    <?php
	    	$fileTmp = 0;
	    	if(isset($_POST['AdminAlbumModel']['source_path'])){
	    		$fileTmp = $_POST['AdminAlbumModel']['source_path'];
	    	}
	    	echo CHtml::hiddenField("AdminAlbumModel[source_path]", $fileTmp);
	    ?>
	<table width="100%" class="album-fx">
		<tr>
			<td>
				<div class="row global_field">
					<label>Tên Album</label>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160,'class'=>'txtchange')); ?>
					<?php echo $form->error($model,'name'); ?>
				</div>
				<div class="row global_field">
					<label>Thể loại</label>
			        <?php echo CHtml::dropDownList("AdminAlbumModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name') ) ?>
					<?php echo $form->error($model,'genre_id'); ?>
				</div>
				<?php if($this->cpId == 0):?>
			    <div class="row global_field">
			        <label>Nhà cung cấp</label>
			        <?php
				           $cp = CHtml::listData($cpList, 'id', 'name');
			               echo CHtml::dropDownList("AdminAlbumModel[cp_id]", $model->cp_id, $cp )
				        ?>
			    </div>
				<?php endif;?>
			</td>
			<td>
				<div class="row global_field">
					<?php echo $form->labelEx($model,'url_key'); ?>
					<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>160,'class'=>'txtrcv')); ?>
					<?php echo $form->error($model,'url_key'); ?>
				</div>
				<div class="row global_field">
					<?php echo $form->labelEx($model,'artist_name'); ?>
		            <?php
		            $this->widget('application.widgets.admin.artist.Feild', array(
		                'fieldId' => 'AdminAlbumModel[artist_id]', 				               
		                'fieldIdVal' => $this->albumArtist,
		                    )
		            );
		            ?>
				</div>
				<?php if($this->cpId == 0):?>
				<div class="row global_field">
					<?php echo $form->labelEx($model,'Trạng thái'); ?>			
					<?php
						$status = array(
										AdminAlbumStatusModel::WAIT_APPROVED=>Yii::t('admin','Chờ duyệt'),
										AdminAlbumStatusModel::APPROVED=>Yii::t('admin','Đã duyệt'),
										AdminAlbumStatusModel::REJECT=>Yii::t('admin','Đã xóa'),
									);
						echo CHtml::dropDownList("AdminAlbumModel[appstatus]", !$model->isNewRecord?AdminAlbumStatusModel::model()->findByPk($model->id)->approve_status:0, $status );
					?>
				</div>
				<?php endif; ?>
			</td>
		</tr>
	</table>
	    
		<div class="row global_field">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>

		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Tiêu đề'), ""); ?>
			<?php echo CHtml::textField("albumMeta[title]",isset($albumMeta->title)?$albumMeta->title:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>

		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Từ khóa'), ""); ?>
			<?php echo CHtml::textField("albumMeta[keywords]",isset($albumMeta->keywords)?$albumMeta->keywords:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>
		<div class="row meta_field">
			<?php echo CHtml::label(Yii::t('admin','Mô tả'), ""); ?>
			<?php echo CHtml::textField("albumMeta[description]",isset($albumMeta->description)?$albumMeta->description:"",array('size'=>60,'maxlength'=>255)); ?>
		</div>
		<?php if($model->isNewRecord):?>
		<div class="row meta_field">
			<?php echo $form->hiddenField($model, 'created_by', array('value'=>Yii::app()->user->id))?>
		</div>
		<?php endif;?>
		<input type="hidden" name="albumId" id="albumId" value="0" />
		<div class="row buttons">
			<?php echo CHtml::button('Completed', array('class'=>'ui-button ui-widget ui-state-default ui-corner-all','role'=>'button', 'aria-disabled'=>'false','onclick'=>'completedAlbum();')); ?>
			<?php echo CHtml::ajaxSubmitButton('Save and Continue',CHtml::normalizeUrl(Yii::app()->createUrl('/toolsAlbum/saveAlbum')), array(
					'dataType'=>'json',
					'beforeSend'=>'function(){
						$("#loading-tt").html("<img src=\''.Yii::app()->theme->baseUrl.'/images/ajax-loader-top-page.gif\' />");	
					}',
					'success'=>
						'function(data){
							$("#loading-tt").html("");
							if(data.error_code==0){
								$("#albumId").attr("value",data.album_id);
								$("#add-songs").show();
								$("#album-result").html("<div class=\"success\">"+data.error_msg+"</div>");
							}else{
								$("#album-result").html("<div class=\"error\">"+data.error_msg+"</div>");
							}
							
	                   }'
			), array('id'=>'save-album-btn')); ?>
		</div>
		<div id="album-result"></div>
		<div id="loading-tt"></div>
		<div id="add-songs" style="display: none">
		<div class="submenu title-box xfixed">
			<div class="portlet" id="yw0">
				<div class="portlet-content">
				<div class="page-title">Thông tin bài hát</div>
					<ul class="operations menu-toolbar" id="yw1">
						<li><a href="#" onclick="popupsong();">Thêm bài hát đã tạo</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div style="height: 10px;"></div>
		<div id="songlist"></div>
		<ul id="files-x"></ul>
	<?php $this->endWidget(); ?>
	<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
	array(
	        'id'=>'uploadFile',
	        'config'=>array(
	               'action'=>Yii::app()->createUrl('/toolsAlbum/uploadFile'),
	               'allowedExtensions'=>array("mp3"),//array("jpg","jpeg","gif","exe","mov" and etc...
	               'sizeLimit'=>100*1024*1024,// maximum file size in bytes
	               'minSizeLimit'=>1*1024,// minimum file size in bytes
	               'onComplete'=>"js:function(id, fileName, responseJSON){ 
		 				$('#files-x').append(responseJSON.data);
					}",
	               //'messages'=>array(
	               //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
	               //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
	               //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
	               //                  'emptyError'=>"{file} is empty, please select files again without it.",
	               //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
	               //                 ),
	               //'showMessage'=>"js:function(message){ alert(message); }"
	              )
	)); ?>
	</div>
	</div><!-- form -->

	<div class="form" id="inlist-zone" style="display: none;">
	</div>
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>
</div>

<script type="text/javascript" >
	function getArtistList(index){
		$.ajax({
	        onclick: '$("#jobDialog").dialog("open"); return false;',
	        url: "/admin.php?r=toolsAlbum/popupList&index="+index,
	        cache:false,
	        success: function(html) {
	            $('#arttt').html(html);
	        }
	    });
	}
	function getComposerList(index){
		$.ajax({
	        onclick: '$("#jobDialog").dialog("open"); return false;',
	        url: "/admin.php?r=toolsAlbum/popupList&type=2&index="+index,
	        cache:false,
	        success: function(html) {
	            $('#arttt').html(html);
	        }
	    });
	}
	function GetSongInfo(){
        var artistCount = $("#AdminAlbumModel_artist_id p").size();
        if(artistCount < 1){
            alert("Cần chọn ít nhất 1 ca sỹ");
            return false;
        }
		/* var dataSong = $("form#XXX").serialize();
		$("#SongInfo").attr('value',dataSong); */
		return true;
	}
	function AddSongToAlbum(songIndex)
	{
		var albumId = $("#albumId").val();
		var dataPost = $("form#S-"+songIndex).serialize();
		var cpId = $("#AdminAlbumModel_cp_id").val();
		var genreId = $("#AdminAlbumModel_genre_id").val();
		$.ajax({
	        url: "/admin.php?r=toolsAlbum/addSong&index="+songIndex,
	        type: "POST",
	        dataType:"json",
	        data: {dataSong:dataPost, cpId:cpId, genreId:genreId, albumId:albumId},
	        beforeSend: function(){
				$("#res-load-"+songIndex).html("<img src='<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-top-page.gif' />")
		    },
	        success: function(Response) {
	        	$("#res-load-"+songIndex).html("");
	            if(Response.error_id==0){
	            	$("#sdx-song-"+songIndex).html("<img src='<?php echo Yii::app()->theme->baseUrl; ?>/images/ok.png' />")
					//success
					
		        }else{
		        	//$("#save-song-"+songIndex).html("Fail!")
		        	$("#res-load-"+songIndex).html("<div class='error'>"+Response.error_msg+"</div>");
					//alert(Response.error_msg);
			    }
	        }
	    });
	}
	function completedAlbum(){
		var albumId = $("#albumId").val();
		if(albumId>0){
			window.location.href="admin.php?r=album/view&id="+albumId;
		}else{
			alert('Still Not completed');
		}
	}
	function display_com2(alist, index,count)
	{
	        artistList = null;
	        var html = "";
	        for (i in alist) {
	            if (alist[i].id) {
	                html += '<p id="'+ alist[i].id +'">';
	                html += '<input class="SongNameIF" type="hidden" name="songInfo['+index+'][comid]" value="' + alist[i].id + '" />';
	                html += '<span>' + alist[i].name + '</span>';
	                html += '<span class="remove-artist" onclick="remove_artist2(' + alist[i].id + ',\'composer_ids_'+index+'\')">Remove</span>';
	                html += '</p>';
	            }
	        }
	        $('#'+count).html(html);

	}
</script>
<div id="arttt"></div>
<script>
window.popupsong = function(){
	var album_id=$("#albumId").val();
	jQuery.ajax({
	  'onclick':'$("#jobDialog").dialog("open"); return false;',
	  'url':'<?php echo Yii::app()->createUrl("/ToolsAlbum/PopupSong");?>',
	  'data':{album_id:album_id},
	  'type':'GET',
	  'cache':false,
	  'beforeSend':function(){
	  		overlayShow();
	  },
	  'success':function(data){
	      jQuery('#jobDialog').html(data);
		  overlayHide();
      }
	});
    return;
}

</script>
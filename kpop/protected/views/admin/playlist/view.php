<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
	

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PlaylistIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PlaylistUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('PlaylistDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('PlaylistCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Playlist")."#".$model->id;
?>
<div class="content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
			<?php 
            
            $listItems = array(
					'id',
					'name',
					'url_key',
					'user_id',
					'username',
					'song_count',
					'artist_ids',
					'created_time',
					'updated_time',
					'status',
				);
                $className = get_class($model);            
                $suggestItems = MainContentModel::viewSuggestList($className,$model->id);
                $items = array_merge($listItems,$suggestItems);  
                
				 
            
                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=> $items,
                )); ?>
		</div>
		<div class="row meta_field">
			<?php 
			if($metaModel){
				$this->widget('zii.widgets.CDetailView', array(
					'data'=>$metaModel,
					'attributes'=>array(
						'title',
						'keywords',
						'description',
					),
				));
			}
			 ?>			
		</div>
	</div>
		
	<div class="form" id="inlist-zone" style="display: none;">
	</div>
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>

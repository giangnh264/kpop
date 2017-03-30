<?php

class RadioModel extends BaseRadioModel
{
	const _ACTIVE = 1;
	const _DE_ACTIVE = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Radio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/* public function defaultScope()
	{
		return array(
				'condition'=>"status='".self::_ACTIVE."'",
		);
	} */
	public function scopes()
	{
		return array(
				'published'=>array(
						'condition'=>'status='.self::_ACTIVE,
				),
				'deleted'=>array(
						'condition'=>'status='.self::_DE_ACTIVE,
				),
		);
	}
	public function getAvatarPath($id=null,$size=150,$isFolder = false)
	{
		if(!isset($id)) $id = $this->id;
		$model = self::model()->findByPk($id);
		$type = '';
		if($model) $type=$model->type;
		if($isFolder){
			$savePath = Common::storageSolutionEncode($id);
		}else{
			$savePath = Common::storageSolutionEncode($id).DS.$id.".jpg";
		}
		$path = Yii::app()->params['storage']['radioDir'].DS.$size.DS.$savePath;
		return $path;
	}
	
	public function getAvatarUrl($id=null, $size="150", $cacheBrowser = false)
	{
		if(!isset($id)) $id = $this->id;
	
		// browser cache
		if($cacheBrowser)
		{
			$version = isset($this->updated_time) ? $this->updated_time:0;
		}
		else $version = time();
	
		$path = AvatarHelper::getAvatar("radio", $id, $size);
		return $path."?v=".$version;
	}
}
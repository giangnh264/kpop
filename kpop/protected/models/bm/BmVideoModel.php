<?php

Yii::import('application.models.db.VideoModel');

class BmVideoModel extends VideoModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function scopes() {
		return array(
			'published'=>array(
                'condition' => 'status = '.self::ACTIVE,
            ),
            'recently'=>array(
                'order'=>'id desc',
            ),
        );
	}
	public function getVideoByCode($code) {
		$criteria = new CDbCriteria();
		$criteria->condition = "code = :CODE";
		$criteria->params = array(
			':CODE' => $code,
		);
		return self::model()->published()->find($criteria);
	}
	public function get($id) {
		return self::model()->published()->findByPk($id);
	}
	
}
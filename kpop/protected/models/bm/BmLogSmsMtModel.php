<?php

Yii::import('application.models.db.LogSmsMtModel');

class BmLogSmsMtModel extends LogSmsMtModel
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
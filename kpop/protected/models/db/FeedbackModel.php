<?php

class FeedbackModel extends BaseFeedbackModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function attributeLabels()
	{
		return array(
				'content'=>'Nội dung',
				'title'		=>'Tiêu đề',
		);
	}
}
<?php

class NewsModel extends BaseNewsModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    const DEACTIVE = 0;
    const ACTIVE = 1;

    public function scopes() {
        return array(
            "published" => array(
                "condition" => "`t`.`status` = " . self::ACTIVE,
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'relations_tag_news'=>array(self::HAS_MANY, 'RelationsTagNewsModel', 'news_id', 'joinType'=>'INNER JOIN'),
        );
    }

    public function getAvatarUrl($id=null, $size="150")
    {
        return Yii::app()->params['storage']['NewsUrl'] . $this->url_img;
    }


}
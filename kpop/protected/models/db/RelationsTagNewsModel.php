<?php

class RelationsTagNewsModel extends BaseRelationsTagNewsModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RelationsTagNews the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function relations(){

        return CMap::mergeArray(parent::relations(),array(
            'tag'  => array(self::BELONGS_TO, 'TagModel', 'tag_id'),
            'news' => array(self::BELONGS_TO, 'NewsModel', 'news_id'),
        ));
    }
}
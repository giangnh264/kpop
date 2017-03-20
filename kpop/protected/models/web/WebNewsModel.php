<?php

Yii::import('application.models.db.NewsModel');

class WebNewsModel extends NewsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param $cat_id
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getNewsByCat($cat_id, $limit, $offset){
        $cr = new CDbCriteria();
        $cr->condition = 'category_id = :CAT_ID';
        $cr->params = array(':CAT_ID'=>$cat_id);
        $cr->limit = $limit;
        $cr->offset = $offset;
        $cr->order = 'id DESC';
        return self::model()->published()->findAll($cr);
    }

    public function getLastet($limit, $offset){
        $cr = new CDbCriteria();
        $cr->limit = $limit;
        $cr->offset = $offset;
        $cr->order = 'id DESC';
        return self::model()->published()->findAll($cr);
    }

    public function getImgById($news_id){

        return Yii::app()->params['storage']['NewsUrl'];
    }

}
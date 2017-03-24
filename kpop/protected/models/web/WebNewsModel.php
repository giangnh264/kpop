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

    public function getNewsByTag($news_obj, $limit = 10, $offset = 0){
        $list_tags = array();
        foreach ($news_obj->relations_tag_news as $tag){
            $list_tags[] = $tag->tag_id;
        }
        $criteria = new CDbCriteria;
        $criteria->alias = 't';
        $criteria->join = 'INNER JOIN relations_tag_news ON relations_tag_news.news_id = t.id';
        $criteria->addInCondition('relations_tag_news.tag_id', $list_tags);

        $criteria->limit = $limit;
        $criteria->offset = $offset;

        return NewsModel::model()->findAll($criteria);

    }

    public function countNewsByCat($category_id){
        $cr = new CDbCriteria();
        $cr->condition = 'category_id = :CAT_ID';
        $cr->params = array(':CAT_ID'=>$category_id);
        return self::model()->published()->count($cr);
    }

}
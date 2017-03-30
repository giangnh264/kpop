<?php

class ListHotNews extends CWidget {
    public function run() {
        //list hot new
        $list_categorys = array(1,2,3,5);
        $limit = 3;
        $offset = 0;
        $list_data = array();
        foreach ($list_categorys as $category){
            $category_obj = CategoryModel::model()->findByPk($category);
            $list_data[$category] = array($category_obj);

            $news = WebNewsModel::model()->getNewsByCat($category, $limit, $offset);
            $list_data[$category]['news'] = $news;
        }
    	$this->render("list_hot_news", array('list_data'=>$list_data));
    }
}
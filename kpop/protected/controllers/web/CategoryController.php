<?php

/**
 * Created by PhpStorm.
 * User: KOIGIANG
 * Date: 3/19/2017
 * Time: 2:28 PM
 */
class CategoryController extends Controller
{
    public function actionIndex(){
        $url_key = CHtml::encode(Yii::app()->request->getParam('url_key', ''));
        if(empty($url_key)) die('not found');

        $category = CategoryModel::model()->published()->findByAttributes(array('url_key'=> $url_key));
        if(empty($category)) die('not found');

        $pagesize = Yii::app()->params['constLimit']['number.of.category_news'];

        $count = WebNewsModel::model()->countNewsByCat($category->id);
        $page = new CPagination($count);
        $page->pageSize = $pagesize;

        $news = WebNewsModel::model()->getNewsByCat($category->id, $page->getLimit(), $page->getOffset());

        $this->render('index', compact('news', 'category', 'page'));
    }
}
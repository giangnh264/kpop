<?php

class NewsController extends Controller
{
    public function actionIndex(){
        $id = CHtml::encode(Yii::app()->request->getParam('id', ''));
        if(empty($id)) die('not found');

        $news = WebNewsModel::model()->published()->findByPk($id);

        if(empty($news)) die('not found');

        $limit = 10;
        $offset = 0;

        $this->htmlTitle = $news->title;

        $news_relate = WebNewsModel::model()->getNewsByTag($news, $limit, $offset);

        $this->render('index', compact('news', 'news_relate'));
    }
}
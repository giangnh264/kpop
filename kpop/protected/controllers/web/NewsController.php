<?php

/**
 * Created by PhpStorm.
 * User: KOIGIANG
 * Date: 3/19/2017
 * Time: 2:28 PM
 */
class NewsController extends Controller
{
    public function actionIndex(){
        $id = CHtml::encode(Yii::app()->request->getParam('id', ''));
        if(empty($id)) die('not found');

        $news = WebNewsModel::model()->published()->findByPk($id);
        if(empty($news)) die('not found');

        $this->render('index', compact('news'));
    }
}
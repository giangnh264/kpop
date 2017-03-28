<?php

class FeaturedPic extends CWidget {
    public function run() {
        $pic_id = 4;
        $pics = WebNewsModel::model()->getNewsByCat($pic_id, 5, 0);
        $this->render("featured_pic", array('datas'=>$pics));
    }
}
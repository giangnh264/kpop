<?php

class Popular extends CWidget {
    public function run() {
        $video_id = 7;
        $pic_id = 4;
        $videos = WebNewsModel::model()->getNewsByCat($pic_id, 5, 0);
        $pics = WebNewsModel::model()->getNewsByCat($video_id, 5, 0);
        $datas = array_merge($pics, $videos);
        shuffle($datas);
        $this->render("popular", array('datas'=>$datas));
    }
}
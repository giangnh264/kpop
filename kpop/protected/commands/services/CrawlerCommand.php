<?php
ini_set("max_execution_time", 1800000);
ini_set("memory_limit", -1);

class CrawlerCommand extends CConsoleCommand {

    public function actionIndex(){
        require_once (dirname(__FILE__) . '/../../components/common/simple_html_dom.php');
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>"Accept-language: vi\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad

            ));

        $context = stream_context_create($opts);
        $source = CategoryModel::model()->published()->findAll(array('order'=>'sorder DESC'));
        foreach ($source as $item){
            $original_url = $item->original_url;
            echo '-------------original_url--------------' . $original_url . '-----------------------------------';
            echo "\n";
            $pages = 20;
            if($item->id == 5){
                $pages = 4;
            }
            if($item->id == 6){
                $pages = 14;
            }

            for($page = 1 ; $page >=0; $page--){
                try{
                    echo '-------------PAGE--------------' . $page . '-----------------------------------';
                    echo "\n";
                    $url = "$original_url/trang-$page.html" ;

                    if($page == '0'){
                        $url = "$original_url.html" ;
                    }
                    echo '-------------URL--------------' . $url . '-----------------------------------';
                    echo "\n";
                    $html = file_get_html($url, false, $context);
                    $tins = $html->find(".group-prd li .box-prd");
                    for($i = 20; $i>=0; $i--){
                        $t = $tins[$i];

                        //title
                        $dom = $t->find(".content .title a", 0);
                        $title = $dom->plaintext;
                        $href = $dom->href;

                        //desc
                        $dom_description = $t->find(".premise", 0);
                        $description = $dom_description->plaintext;

                        //img
                        $dom_img = $t->find(".image a img", 0);
                        $src = $dom_img->src;
                        $src = str_replace('262x197', "760x430", $src);
                        $storageDir = Yii::app()->params['storage']['NewsDir'];
                        $year = date('Y');
                        $month = date('m');
                        $day = date('d');
                        $storage =  $storageDir . DS .$year. DS .$month . DS .$day;
                        if (!is_dir($storage)) {
                            mkdir( $storage , 0777, true);
                        }

                        $check = NewsModel::model()->findByAttributes(array('original_url'=>$href));
                        if(empty($check)){
                            $basename = trim(basename($src));

                            $file_put = file_put_contents($storage . DS . $basename , file_get_contents($src));
                            $img_Dir = $year. DS .$month . DS .$day . DS . $basename;
                            if(!$file_put) continue;

                            $title = htmlentities($title, ENT_QUOTES, "UTF-8");
                            $href = htmlentities($href, ENT_QUOTES, "UTF-8");
                            $description = htmlentities($description, ENT_QUOTES, "UTF-8");

                            $title = str_replace('&amp;#8221;', "’", $title);
                            $title = str_replace('&amp;#8220;', "‘", $title);
                            $title = str_replace('&amp;#8216;', '“', $title);
                            $title = str_replace('&amp;#8217;', '”', $title);
                            $title = str_replace('&amp;', '&', $title);
                            $title = str_replace('&apos;', "'", $title);
                            $title = str_replace('&gt;', ">", $title);
                            $title = str_replace('&lt;', "<", $title);



                            $description = str_replace('&amp;#8221;', "’", $description);
                            $description = str_replace('&amp;#8220;', "‘", $description);
                            $description = str_replace('&amp;#8216;', '“', $description);
                            $description = str_replace('&amp;#8217;', '”', $description);
                            $description = str_replace('&amp;', '&', $description);
                            $description = str_replace('&apos;', "'", $description);
                            $description = str_replace('&gt;', ">", $description);
                            $description = str_replace('&lt;', "<", $description);

                            $news = new NewsModel();
                            $news->category_id = $item->id;
                            $news->created_time = date('Y-m-d H:i:s');
                            $news->updated_time = date('Y-m-d H:i:s');
                            $news->original_url = trim($href);
                            $news->description = trim($description);
                            $news->title = $title;
                            $news->url_img = $img_Dir;
                            $news->url_key = Common::makeFriendlyUrl($title);
                            $news->save();
                        }
                    }
                }catch (Exception $ex){
                    echo $ex->getMessage();
                    echo "\n";
                }

            }
        }

    }

    public function actionView(){
        require_once (dirname(__FILE__) . '/../../components/common/simple_html_dom.php');
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>"Accept-language: vi\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad

            ));

        $context = stream_context_create($opts);

        $cr = new CDbCriteria();
        $cr->condition = 'content IS NULL';
        $cr->order = 'id DESC';
        $news = NewsModel::model()->published()->findAll($cr);

        foreach ($news as $item){
            try{
                $url =  'http://tintuckpop.net' . $item->original_url;
                echo '-------------original_url--------------' . $url . '-----------------------------------';
                echo "\n";
                $doms = file_get_html($url, false, $context);
                $tins = $doms->find(".content-news-detail", 0);
                $content = $tins->outertext;
                if($content != ''){
                    $content = str_replace("<br>", "", $content);
                    $item->content = $content;
                    $item->save();
                }
                //tag 1
                $dom_tags = $doms->find(".folder-title-news-detail .mg-top-10 a");
                foreach ($dom_tags as $dom_tag){
                    $tag = $dom_tag->plaintext;

                    $tag = str_replace('#', "", $tag);
                    $tag = htmlspecialchars_decode($tag, ENT_QUOTES);
                    echo $tag;
                    echo "\n";
                    //check tag
                    $check_tag = TagModel::model()->findByAttributes(array('name'=>$tag));
                    if(!$check_tag){
                        $tag_model = new TagModel();
                        $tag_model->name = $tag;
                        $tag_model->status = 1;
                        $save = $tag_model->save();
                        if($save){
                            $relation = new RelationsTagNewsModel();
                            $relation->tag_id = $tag_model->id;
                            $relation->news_id = $item->id;
                            $relation->save();
                        }
                    }else{
                        //check relation new tag
                        $check_relation = RelationsTagNewsModel::model()->findByPk(array('tag_id'=>$check_tag->id, 'news_id'=>$item->id));
                        if(!$check_relation){
                            $relation = new RelationsTagNewsModel();
                            $relation->tag_id = $check_tag->id;
                            $relation->news_id = $item->id;
                            $relation->save();
                        }
                    }
                    //tag
                }

                //tag 2
                $dome_upper_tags = $doms->find(".tags-detail a.transition");
                foreach ($dome_upper_tags as $dome_upper_tag){
                    $tag = $dome_upper_tag->plaintext;

                    $tag = str_replace('#', "", $tag);
                    $tag = htmlspecialchars_decode($tag, ENT_QUOTES);
                    echo $tag;
                    echo "\n";
                    //check tag
                    $check_tag = TagModel::model()->findByAttributes(array('name'=>$tag));
                    if(!$check_tag){
                        $tag_model = new TagModel();
                        $tag_model->name = $tag;
                        $tag_model->status = 1;
                        $save = $tag_model->save();
                        if($save){
                            $relation = new RelationsTagNewsModel();
                            $relation->tag_id = $tag_model->id;
                            $relation->news_id = $item->id;
                            $relation->save();
                        }
                    }else{
                        //check relation new tag
                        $check_relation = RelationsTagNewsModel::model()->findByPk(array('tag_id'=>$check_tag->id, 'news_id'=>$item->id));
                        if(!$check_relation){
                            $relation = new RelationsTagNewsModel();
                            $relation->tag_id = $check_tag->id;
                            $relation->news_id = $item->id;
                            $relation->save();
                        }
                    }
                }
            }catch (Exception $ex){
                echo $ex->getMessage();
                echo "\n";
            }


            echo '----------------------------------------- DONE---------------------------------------';
            echo "\n";
        }

    }

    public function actionTag(){
        require_once (dirname(__FILE__) . '/../../components/common/simple_html_dom.php');
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>"Accept-language: vi\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad

            ));

        $context = stream_context_create($opts);

        $news = NewsModel::model()->published()->findAll(array('order'=>'id DESC'));


        foreach ($news as $item){
            $url =  'http://tintuckpop.net' . $item->original_url;
            echo '-------------original_url--------------' . $url . '-----------------------------------';
            echo "\n";
            $doms = file_get_html($url, false, $context);
            $tins = $doms->find(".tags-detail a.transition");
            foreach ($tins as $tin){
                $tag = $tin->plaintext;

                $tag = str_replace('#', "", $tag);
                echo $tag;exit;
                echo "\n";
                //check tag
                $check_tag = TagModel::model()->findByAttributes(array('name'=>$tag));
                if(!$check_tag){
                    $tag_model = new TagModel();
                    $tag_model->name = $tag;
                    $tag_model->status = 1;
                    $save = $tag_model->save();
                    if($save){
                        $relation = new RelationsTagNewsModel();
                        $relation->tag_id = $tag_model->id;
                        $relation->news_id = $item->id;
                        $relation->save();
                    }
                }else{
                    //check relation new tag
                    $check_relation = RelationsTagNewsModel::model()->findByPk(array('tag_id'=>$check_tag->id, 'news_id'=>$item->id));
                    if(!$check_relation){
                        $relation = new RelationsTagNewsModel();
                        $relation->tag_id = $check_tag->id;
                        $relation->news_id = $item->id;
                        $relation->save();
                    }
                }
                //tag


            }
            echo '----------------------------------------- DONE---------------------------------------';
            echo "\n";
        }

    }

    public function actionIndexPic(){
        require_once (dirname(__FILE__) . '/../../components/common/simple_html_dom.php');
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>"Accept-language: vi\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad

            ));

        $context = stream_context_create($opts);
        $source = CategoryModel::model()->published()->findAll(array('order'=>'sorder DESC'));
        foreach ($source as $item){
            if($item->id == 4 || $item->id == 7){
                $original_url = $item->original_url;
                echo '-------------original_url--------------' . $original_url . '-----------------------------------';


                for($page = 50 ; $page >=0; $page--){
                    try{
                        echo '-------------PAGE--------------' . $page . '-----------------------------------';
                        echo "\n";
                        $url = "$original_url/trang-$page.html" ;

                        if($page == '0'){
                            $url = "$original_url.html" ;
                        }
                        echo '-------------URL--------------' . $url . '-----------------------------------';
                        echo "\n";
                        $html = file_get_html($url, false, $context);
                        $tins = $html->find(".content-tabs ul.group-prd li");
                        for($i = 9; $i>=0; $i--){
                            $t = $tins[$i];

                            //title
                            $dom = $t->find(".content .title a", 0);
                            $title = $dom->plaintext;
                            $href = $dom->href;

                            //desc
                            $dom_description = $t->find(".premise", 0);
                            $description = $dom_description->plaintext;

                            //img
                            $dom_img = $t->find(".image a img", 0);
                            $src = $dom_img->src;
                            $src = str_replace('262x197', "760x430", $src);
                            $storageDir = Yii::app()->params['storage']['NewsDir'];
                            $year = date('Y');
                            $month = date('m');
                            $day = date('d');
                            $storage =  $storageDir . DS .$year. DS .$month . DS .$day;
                            if (!is_dir($storage)) {
                                mkdir( $storage , 0777, true);
                            }

                            $check = NewsModel::model()->findByAttributes(array('original_url'=>$href));
                            if(empty($check)){
                                $basename = trim(basename($src));

                                $file_put = file_put_contents($storage . DS . $basename , file_get_contents($src));
                                $img_Dir = $year. DS .$month . DS .$day . DS . $basename;
                                if(!$file_put) continue;

                                $title = htmlentities($title, ENT_QUOTES, "UTF-8");
                                $href = htmlentities($href, ENT_QUOTES, "UTF-8");
                                $description = htmlentities($description, ENT_QUOTES, "UTF-8");

                                $title = str_replace('&amp;#8221;', "’", $title);
                                $title = str_replace('&amp;#8220;', "‘", $title);
                                $title = str_replace('&amp;#8216;', '“', $title);
                                $title = str_replace('&amp;#8217;', '”', $title);
                                $title = str_replace('&amp;', '&', $title);
                                $title = str_replace('&apos;', "'", $title);
                                $title = str_replace('&gt;', ">", $title);
                                $title = str_replace('&lt;', "<", $title);



                                $description = str_replace('&amp;#8221;', "’", $description);
                                $description = str_replace('&amp;#8220;', "‘", $description);
                                $description = str_replace('&amp;#8216;', '“', $description);
                                $description = str_replace('&amp;#8217;', '”', $description);
                                $description = str_replace('&amp;', '&', $description);
                                $description = str_replace('&apos;', "'", $description);
                                $description = str_replace('&gt;', ">", $description);
                                $description = str_replace('&lt;', "<", $description);

                                $news = new NewsModel();
                                $news->category_id = $item->id;
                                $news->created_time = date('Y-m-d H:i:s');
                                $news->updated_time = date('Y-m-d H:i:s');
                                $news->original_url = trim($href);
                                $news->description = trim($description);
                                $news->title = $title;
                                $news->url_img = $img_Dir;
                                $news->url_key = Common::makeFriendlyUrl($title);
                                $news->save();
                            }
                        }
                    }catch (Exception $ex){
                        echo $ex->getMessage();
                        echo "\n";
                    }

                }
            }

        }

    }


    public function actionUpdate(){
        $news = NewsModel::model()->published()->findAll(array('order'=>'id desc'));

        foreach ($news as $item){
            echo '-------------original_url--------------' . $item->id . '-----------------------------------';
            echo "\n";
            $original_url = $item->original_url;
            $original_url = str_replace('.html', "", $original_url);
            $original_url = str_replace('/', "", $original_url);
            $data = explode('-', $original_url);
            count($data);exit;
            print_r($data);exit;
            echo $original_url;exit;
            $url_key = Common::makeFriendlyUrl($item->title);
            $item->url_key = $url_key;
            $res = $item->save();
            print_r($res);
            echo '----------------------------------------- DONE---------------------------------------';
            echo "\n";
        }
    }


}
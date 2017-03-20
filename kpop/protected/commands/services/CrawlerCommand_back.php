<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set("max_execution_time", 18000);
ini_set("memory_limit", "2048M");
define('FOLDER','E:\\MyProject\\kpop\\protected\\commands\\services\\img\\');

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
           /* $pages = 100;
            if($item->id == 4 || $item->id ==3){
                $pages = 19;
            }*/
            for($page = 10 ; $page >=0; $page--){
                try{
                    echo '-------------PAGE--------------' . $page . '-----------------------------------';
                    echo "\n";
//                    $url = "$original_url/page/$page" ;
                    $url = "$original_url/trang-$page.html" ;
                    echo $url;exit;
                    $html = file_get_html($url, false, $context);
                    $tins = $html->find(".cb-blog-style-a");
                    for($i = 20; $i>=0; $i--){
                        $t = $tins[$i];

                        //title
                        $dom = $t->find(".cb-meta .cb-post-title a", 0);
                        $title = $dom->plaintext;
                        $href = $dom->href;

                        //desc
                        $dom_description = $t->find(".cb-meta .cb-excerpt", 0);
                        $description = $dom_description->plaintext;

                        //img
                        $dom_img = $t->find(".cb-mask a img", 0);
                        $s = $dom_img->src;

                        //statistic
                        $dom_statistic = $t->find(".cb-meta .cb-post-views", 0);
                        $view_count = (int) $dom_statistic->plaintext;

                        $check = NewsModel::model()->findByAttributes(array('original_url'=>$href));
                        if(empty($check)){
                            $basename = trim(basename($s));
                            $storageDir = Yii::app()->params['storage']['NewsDir'] .$basename;
                            $file_put = file_put_contents($storageDir, file_get_contents($s));
                            if(!$file_put) continue;

                            $title = htmlentities($title, ENT_QUOTES, "UTF-8");
                            $href = htmlentities($href, ENT_QUOTES, "UTF-8");
                            $description = htmlentities($description, ENT_QUOTES, "UTF-8");

                            $title = str_replace('&amp;#8221;', "’", $title);
                            $title = str_replace('&amp;#8220;', "‘", $title);
                            $title = str_replace('&amp;#8216;', '“', $title);
                            $title = str_replace('&amp;#8217;', '”', $title);

                            $description = str_replace('&amp;#8221;', "’", $description);
                            $description = str_replace('&amp;#8220;', "‘", $description);
                            $description = str_replace('&amp;#8216;', '“', $description);
                            $description = str_replace('&amp;#8217;', '”', $description);

                            $news = new NewsModel();
                            $news->category_id = $item->id;
                            $news->created_time = date('Y-m-d H:i:s');
                            $news->updated_time = date('Y-m-d H:i:s');
                            $news->original_url = trim($href);
                            $news->description = $description;
                            $news->title = $title;
                            $news->url_img = $basename;
                            $news->url_key = Common::makeFriendlyUrl($title);
                            $res = $news->save();
                            if($res){
                                $statistic = new StatisticNewsModel();
                                $statistic->news_id = $news->id;
                                $statistic->view_count = $view_count;
                                $statistic->save();
                            }
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

        $news = NewsModel::model()->published()->findAll(array('order'=>'id desc'));

        foreach ($news as $item){
            if($item->content != '') continue;
            $url = $item->original_url;
            echo '-------------original_url--------------' . $url . '-----------------------------------';
            echo "\n";
            $doms = file_get_html($url, false, $context);
            $tins = $doms->find(".cb-entry-content p");
            $content = '';
            foreach ($tins as $tin){
                $content .= $tin->outertext;
            }
            if($content != ''){
                $item->content = $content;
                $item->save();
            }
            echo '----------------------------------------- DONE---------------------------------------';
            echo "\n";
        }

    }

    public function actionUpdate(){
        $news = NewsModel::model()->published()->findAll(array('order'=>'id desc'));

        foreach ($news as $item){
            echo '-------------original_url--------------' . $item->id . '-----------------------------------';
            echo "\n";
            $url_key = Common::makeFriendlyUrl($item->title);
            $item->url_key = $url_key;
            $res = $item->save();
            print_r($res);
            echo '----------------------------------------- DONE---------------------------------------';
            echo "\n";
        }
    }

}
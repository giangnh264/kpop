<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set("max_execution_time", 18000);
ini_set("memory_limit", "2048M");
define('FOLDER','E:\\MyProject\\kpop\\protected\\commands\\services\\img\\');
header('Content-Type: text/html; charset=ISO-8859-1');

class JobCommand extends CConsoleCommand {


    public function actionView(){
        require_once (dirname(__FILE__) . '/../../components/common/simple_html_dom.php');
        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'header'=>"Accept-language: vi\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad

            ));
        $url= 'http://tinnhac.com/';
        $context = stream_context_create($opts);
        $doms = file_get_html($url, false, $context);
        $tins = $doms->find("a");
        print_r($doms);exit;


    }

}
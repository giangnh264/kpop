<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmsHelper
 *
 * @author longnt2
 */
class SmsHelper {

    protected static $_instance = null;

    private function __clone() {
        
    }

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function checkAutoContent($keyword, $groupkey, $indexkey) {
        $config = SmsConfigModel::model()->findByAttributes(array("keyword" => "{$keyword}", 'group_key' => "{$groupkey}", 'index_key' => "{$indexkey}"));
        if ($config->status == 1) {
            return $config->content;
        } else {
            return false;
        }
    }

    public function checkValidateSmsDownload($content) {
        $str = strtoupper($content);
        $pattern1 = '/^CHACHA [SRV][0-9]+$/';
        $pattern2 = '/^CHACHA [SRV][0-9]+ [0-9]+$/';

        /// Cu phap moi: tu ngay 30/9/2012
        $pattern1_1 = '/^TAI [SRV][0-9]+$/';
        $pattern2_1 = '/^TAI [SRV][0-9]+ [0-9]+$/';

        $check = (preg_match($pattern1, $str) || preg_match($pattern2, $str)
                || preg_match($pattern1_1, $str) || preg_match($pattern2_1, $str));
        return $check;
    }

    public function processString($string, $keyword) {
        $string = strtoupper($string);
        $keyword = strtoupper($keyword);
        $string = str_replace($keyword, '', $string);
        $string = trim(strtoupper($string));

        $string = str_replace('.', '', $string);
        $string = str_replace('%', '', $string);
        $string = str_replace('#', '', $string);
        $string = str_replace('?', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('[', '', $string);
        $string = str_replace(']', '', $string);
        $string = str_replace('{', '', $string);
        $string = str_replace('}', '', $string);
        $string = str_replace('+', '', $string);
        $string = str_replace('_', '', $string);
        $string = str_replace('/', '', $string);
        $string = str_replace("\\", '', $string);
        //$string = preg_replace('/[^0-9-]/','',$string);

        $arrKey = array("     ", "    ", "   ", "  ", " ");
        $string = str_replace($arrKey, '', $string);

        return $string;
    }

    public function isPhone($phoneNumber) {
        $pattern = "/^(09|01)([0-9]{8,9})/";
//        $pattern = "/^(091|094|0123|0125|0127|0129|0124|0164)([0-9]{6,7})$/";
        return preg_match($pattern, $phoneNumber);
    }

    public function searchSolr($key, $field, $limit) {
        $solr = $this->getSolr();
        $rs = $solr->search($key, 0, $limit, array('fq' => 'type:rbt', 'pf' => "{$field}^30"));
        $response = $rs->response;
        $results = $this->copyAndCast($response->docs, array('name' => 'name', 'artist_id' => 'artist_id', 'artist_name' => 'artist_name'));
        return $results;
    }

    public function getSolr() {
        require_once(_APP_PATH_ . '/protected/vendors/Apache/Solr/Service.php');
        require_once(_APP_PATH_ . '/protected/vendors/Apache/Solr/HttpTransport/Curl.php');
        return new Apache_Solr_Service(
                        yii::app()->params['solr.server.host'],
                        yii::app()->params['solr.server.port'],
                        yii::app()->params['solr.server.path'],
                        new Apache_Solr_HttpTransport_Curl()
        );
    }

    public function copyAndCast($array, $mapping) {
        $rs = array();
        foreach ($array as $item) {
            $cast = array();
            foreach ($item as $key => $value) {
                if ($key == 'id') {
                    $cast['id'] = substr($value, strlen($item->type));
                } elseif (array_key_exists($key, $mapping)) {
                    $key = $mapping[$key];
                    if (is_array($key)) {
                        $value = explode('|', $value);
                        for ($index = 0; $index < count($key);) {
                            $key2 = $key[$index++];
                            $cast[$key2] = $value[$key[$index++]];
                        }
                    }else
                        $cast[$key] = $value;
                }else
                    $cast[$key] = $value;
            }
            $rs[] = $cast;
        }
        return $rs;
    }

}

?>

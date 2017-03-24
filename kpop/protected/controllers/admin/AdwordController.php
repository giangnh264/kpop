<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdwordController
 *
 * @author longnt
 */
class AdwordController extends CController {

    public $time;
    public $pageLabel;
    public $menu;

    public function init() {
        parent::init();
        $this->layout = false;
        if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
            $createdTime = $_GET['songreport']['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['songreport']['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $this->time = $time;
            }
        } else {
            $startDay = date("Y") . "-" . date("m") . "-01";
            $fromDate = date("Y-m-d", strtotime($startDay));
            $toDate = date("Y-m-d");
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
    }

    public function actionLogin() {
        $sesstion = Yii::app()->session;
        $acount = $sesstion['useradword'];
        if (isset($acount) && count($acount) > 0) {
            $this->redirect('/admin.php?r=adword/index');
        }
        if (Yii::app()->request->isPostRequest) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $buzzcity = Yii::app()->params['acount.adword']['Buzzcity'];
            $clevernet = Yii::app()->params['acount.adword']['Clevernet'];
            $eway = Yii::app()->params['acount.adword']['Eway'];
            $smm = Yii::app()->params['acount.adword']['Smm'];
            $admob = Yii::app()->params['acount.adword']['Admob'];
            $sosmart = Yii::app()->params['acount.adword']['Sosmart'];
            $vserv = Yii::app()->params['acount.adword']['Vserv'];
            $error = 0;
            if (($user == $buzzcity['username'] && $pass == $buzzcity['password']) || ($user == $clevernet['username'] && $pass == $clevernet['password']) || ($user == $eway['username'] && $pass == $eway['password']) || ($user == $smm['username'] && $pass == $smm['password']) || ($user == $admob['username'] && $pass == $admob['password']) || ($user == $sosmart['username'] && $pass == $sosmart['password']) || ($user == $vserv['username'] && $pass == $vserv['password'])) {
                $acount['user'] = $user;
                $acount['pass'] = $pass;
                $acount['type'] = strtoupper($user);
                $sesstion['useradword'] = $acount;
                $this->redirect('/admin.php?r=adword/index');
            } else {
                $error = 1;
            }
        }
        $this->render('login', array('error' => $error));
    }

    public function actionIndex() {
        $sesstion = Yii::app()->session;
        $acount = $sesstion['useradword'];
        if (isset($acount) && count($acount) > 0) {
            $ads = $acount['type'];
            if (is_array($this->time)) {
                $tt = $this->time['from'] . " - " . $this->time['to'];
                $from = $this->time['from'] . " 00:00:00";
                $to = $this->time['to'] . " 23:59:59";
                $this->pageLabel = "Thống kê lượt Click ngày: {$this->time['from']} tới {$this->time['to']}";
            } else {
                $tt = $this->time;
                $from = $this->time . " 00:00:00";
                $to = $this->time . " 23:59:59";
                $this->pageLabel = "Thống kê lượt Click ngày: {$this->time}";
            }
            $action = $_GET['action'] ? $_GET['action'] : 'click';
            if ($action == 'click') {
                $where = " and date >= '{$from}' AND date <= '{$to}'";
                $sql = "SELECT * FROM statistic_ads WHERE ads = '{$ads}' $where ORDER BY date DESC";
                $data = Yii::app()->db->createCommand($sql)->queryAll();
                if (Yii::app()->request->getParam('export', false)) {
                    ini_set('display_errors', 'On');
                    $label = array(
                        'date' => Yii::t('admin', 'Ngày'),
                        'click_total' => Yii::t('admin', 'Tổng số click'),
                        'click_unique' => Yii::t('admin', 'Số click ko trùng IP'),
                        'click_detect' => Yii::t('admin', 'Số click Nhận diện được'),
                        'click_detect_unique' => Yii::t('admin', 'Số click Nhận diện Ko trùng Ip'),
                        'total_subs_success' => Yii::t('admin', 'Số đăng ký thành công'),
                        'total_unsubs' => Yii::t('admin', 'Số thuê bao hủy'),
                    );
                    $datas = $data;
                    $title = Yii::t('admin', 'Thống kê banner ' . $ads . " " . $tt . " ");
                    $excelObj = new ExcelExport($datas, $label, $title);
                    $excelObj->export();
                }
                $this->render('index', array(
                    'data' => $data,
                    'type' => $acount['type'],
                    'action' => $action
                ));
            } else {
                if (is_array($this->time)) {
                    $tt = $this->time['from'] . " - " . $this->time['to'];
                    $from = $this->time['from'] . " 00:00:00";
                    $to = $this->time['to'] . " 23:59:59";
                    $this->pageLabel = "Thống kê IP ngày: {$this->time['from']} tới {$this->time['to']}";
                } else {
                    $tt = $this->time;
                    $from = $this->time . " 00:00:00";
                    $to = $this->time . " 23:59:59";
                    $this->pageLabel = "Thống kê IP ngày: {$this->time}";
                }

                $where = " and created_time >= '{$from}' AND created_time <= '{$to}'";
                $sql = "SELECT concat(date(created_time),user_ip) as uc, date(created_time) as m, user_ip, count(*) as total from log_ads_click where ads='{$ads}' $where group by  uc order by m desc";
                $listIP = Yii::app()->db->createCommand($sql)->queryAll();

                if (Yii::app()->request->getParam('export', false)) {
                    $dataexport = array();
                    foreach ($listIP as $item) {
                        if ($item['total'] <= 1)
                            continue;
                        $dataexport[] = $item;
                    }
                    ini_set('display_errors', 'On');
                    $label = array(
                        'm' => Yii::t('admin', 'Ngày'),
                        'user_ip' => Yii::t('admin', 'IP'),
                        'total' => Yii::t('admin', 'Số click'),
                    );

                    $title = Yii::t('admin', 'Danh sách IP click trùng banner ' . $ads . " " . $tt . " ");
                    $excelObj = new ExcelExport($dataexport, $label, $title);
                    $excelObj->export();
                }

                $this->render('index', array(
                    'listIP' => $listIP,
                    'type' => $acount['type'],
                    'action' => $action
                ));
            }
        } else {
            $this->redirect(Yii::app()->createUrl('adword/login'));
        }
    }

    public function actionLogout() {
        $sesstion = Yii::app()->session;
        $acount = $sesstion['useradword'];
        unset($acount);
        $sesstion['useradword'] = $acount;
        $this->redirect(Yii::app()->createUrl('adword/login'));
    }

}

?>

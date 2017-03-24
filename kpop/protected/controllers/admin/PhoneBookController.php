<?php
Yii::import("ext.xupload.models.XUploadForm");
@ini_set("max_execution_time", 300);
@ini_set("memory_limit", "1024M");

class PhoneBookController extends Controller {

	public function init() {
		parent::init();
		$this->pageTitle = Yii::t('admin', "Quản lý  Phone Book ");
	}

	public function actions() {
		return array(
				'upload' => array(
						'class' => 'ext.xupload.actions.XUploadAction',
						'subfolderVar' => 'parent_id',
						'path' => _APP_PATH_ . DS . "data",
						'alowType' => 'text/plain'
				),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize', $pageSize);

		$model = new AdminPhoneBookModel('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['AdminPhoneBookModel']))
			$model->attributes = $_GET['AdminPhoneBookModel'];

		$this->render('index', array(
				'model' => $model,
				'pageSize' => $pageSize
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
				'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new AdminPhoneBookModel;
		$group_code = Yii::app()->request->getParam('phone-type');
		if (isset($group_code)){
			$phone_num = Yii::app()->request->getParam('phone');
			$phone = Formatter::formatPhone($phone_num);
			if ($group_code == 'MIENTAY')
			{
				$group_name = "Thuê bao miền tây";
			}
			else
			{
				$group_name = "Khuyến mãi theo tuần";
			}
			$data = array(
					'phone' => $phone,
					'group_code' => $group_code,
					'group_name' => $group_name,
					'created_time' => date("Y-m-d H:i:s"),
			);
			$phoneModel = $model::model()->findByAttributes(array('phone' => $phone,'group_code'=>$group_code));
			if (empty($phoneModel) && Formatter::isVinaphoneNumber($phone)) {
				 
				//if (!$model->findByAttributes(array('phone' => $phone,'group_code'=>$group_code)) && Formatter::isVinaphoneNumber($phone)) {
				$model->setAttributes($data);
				try{
					$model->save();
					$message = "Success";
				}
				catch (Exception $exc) {
					echo $exc->getTrace();
				}
				 
			}
			else{ $message = 'The number had exists';
			}
			echo $message;
			return ;
		}
		if (isset($_POST['file_name']) && $_POST['file_name']) {
			$fileName = $_POST['file_name']; //ten file excel
			$file = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $fileName;
			$contents = file($file);
			$string = implode(',', $contents);
			$array = explode(',', $string);
			$arrayVal = array();
			$created_time = date("Y-m-d H:i:s");
			$group_code = $_REQUEST['type_phone'];
			if ($group_code == 'MIENTAY')
			{
				$group_name = "Thuê bao miền tây";
			}
			else
			{
				$group_name = "Khuyến mãi theo tuần";
			}
			foreach ($array as $item) {
				if (Formatter::isVinaphoneNumber($item)) {
					$number = Formatter::formatPhone($item);
					$arr = array();
					$arr['value'] = "('$number','$group_code','$group_name','$created_time')";
					$arr['number'] = $number;
					$arrayVal[] = $arr;
				}
			}
			$arrs = array_chunk($arrayVal, 200);
			foreach ($arrs as $key => $arr) {
				$newarray = array();
				foreach ($arr as $k => $v) {
					$exist = AdminPhoneBookModel::model()->exists('phone= :phone and group_code = :group_code', array(':phone' => $v['number'],'group_code'=>$group_code));
					if ($exist === true) {
						continue;
					}
					$newarray[] = $v['value'];
				}
				$vals = implode(",", $newarray);
				try {
					$sql = "INSERT INTO phone_book (`phone`,`group_code`,`group_name`,`created_time`) VALUES $vals";
					$command = Yii::app()->db->createCommand($sql);
					$command->execute();
				} catch (Exception $exc) {
					echo $exc->getMessage();
				}
			}
			unlink($file);
		}
		//         $this->redirect(array('index'));
		$uploadModel = new XUploadForm();
		$this->render('create', array(
				'model' => $model,
				'uploadModel' => $uploadModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['AdminPhoneBookModel'])) {
			$group_code = $_REQUEST['type_phone'];
			if ($group_code == 'MIENTAY')
			{
				$group_name = "Thuê bao miền tây";
			}
			else
			{
				$group_name = "Khuyến mãi theo tuần";
			}
			 
			$model->attributes = $_POST['AdminPhoneBookModel'];
			$model->group_code = $group_code;
			$model->group_name = $group_name;
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
				'model' => $model,
		));
	}

	/**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id) {
		$data = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['AdminPhoneBookModel'])) {
			$model = new AdminPhoneBookModel;
			$model->attributes = $_POST['AdminPhoneBookModel'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('copy', array(
				'model' => $data,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * bulk Action.
	 * @param string the action
	 */
	public function actionBulk() {
		$act = Yii::app()->request->getParam('bulk_action', null);
		if (isset($act) && $act != "") {
			$this->forward($this->getId() . "/" . $act);
		} else {
			$this->redirect(array('index'));
		}
	}

	/**
	 * Delete all record Action.
	 * @param string the action
	 */
	public function actionDeleteAll() {
		if (isset($_POST['all-item'])) {
			AdminPhoneBookModel::model()->deleteAll();
		} else {
			$item = $_POST['cid'];
			$c = new CDbCriteria;
			$c->condition = ('id in (' . implode($item, ",") . ')');
			$c->params = null;
			AdminPhoneBookModel::model()->deleteAll($c);
		}
		$this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = AdminPhoneBookModel::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-phone-book-model-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	private function isPhone($phoneNumber) {
		$pattern = "/^(09|01)([0-9]{8,9})/";
		return preg_match($pattern, $phoneNumber);
	}

}

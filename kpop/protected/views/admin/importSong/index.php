<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

$this->menu=array(	
	array('label'=>Yii::t('admin','New Import'), 'url'=>array('newImport'), 'visible'=>UserAccess::checkAccess('ImportSongNewimport')),
);
$this->pageLabel = Yii::t('admin','Import bài hát');
?>
<br>
<div>Hướng dẫn : <br><br> - Bấm vào <b>new import</b> để thực hiện import dữ liệu mới<br>
				<br> - Duyệt file excel chứa thông tin về các bài hát<br>
				<br> - Bấm vào nút<b> Import</b> để hệ thống import dữ liệu cho bạn<br>
</div>
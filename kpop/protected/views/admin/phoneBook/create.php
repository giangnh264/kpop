<?php
$this->breadcrumbs = array(
    'Admin Phone Book Models' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List', 'url' => array('index'), 'visible' => UserAccess::checkAccess('PhoneBookIndex')),
);
$this->pageLabel = "Tạo mới thuê bao Miền Tây";
?>




<?php echo $this->renderPartial('_form', array('model' => $model, 'uploadModel' => $uploadModel)); ?>
<?php include_once '_header.php';?>
<?php
$categorys = WebCategoryModel::model()->published()->findAll(array('order'=>'sorder asc'));
?>
<?php include_once '_topmenu.php';?>

<div id="main-wrapper">
    <?php echo $content ?>
</div>
<?php include_once '_footer.php';?>

</body>
</html>

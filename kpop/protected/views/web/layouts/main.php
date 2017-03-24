<?php include_once '_header.php';?>
<?php
$categorys = WebCategoryModel::model()->published()->findAll(array('order'=>'sorder asc'));
?>
<?php include_once '_topmenu.php';?>

<?php include_once '_top_mobile_menu.php';?>
<div id="content" class="herald-site-content herald-slide">

    <?php echo $content ?>
</div>
<?php include_once '_footer.php';?>

</body>
</html>

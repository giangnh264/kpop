<div id="herald-responsive-header" class="herald-responsive-header herald-slide hidden-lg hidden-md">
    <div class="container">
        <div class="herald-nav-toggle"><i class="fa fa-bars"></i></div>
        <div class="site-branding mini">
            <span class="site-title h1"><a href="<?php echo Yii::app()->params['base_url']?>" rel="home"><img class="herald-logo-mini" src="<?php echo Yii::app()->request->baseUrl?>/web/images/logo-kpop-mini.png" alt="ALL KPOP"></a></span>
        </div>
        <div class="herald-menu-popup-search">
            <span class="fa fa-search"></span>
            <div class="herald-in-popup">
                <form class="herald-search-form" action="http://demo.mekshq.com/herald/" method="get">
                    <input name="s" class="herald-search-input" type="text" value=""
                           placeholder="Type here to search..."/>
                    <button type="submit" class="herald-search-submit"></button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="herald-mobile-nav herald-slide hidden-lg hidden-md">
    <ul id="menu-herald-main-2" class="herald-mob-nav">
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-207 current_page_item current-menu-ancestor current-menu-parent current_page_parent current_page_ancestor  menu-item-984">
            <a href="<?php echo Yii::app()->params['base_url']?>">Home</a>
        </li>
        <?php
        foreach ($categorys as $category):
        ?>
        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-991"><a
                href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>$category->url_key));?>"><?php echo strtoupper($category->name);?></a>
        </li>
        <?php endforeach;?>

    </ul>
</div>
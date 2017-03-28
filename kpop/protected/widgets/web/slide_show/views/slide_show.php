<div id="vce-featured-grid" class="vce-featured-grid">
    <?php
    $news = WebNewsModel::model()->getLastet(6, 0);
    foreach ($news as $item):
    $category = WebCategoryModel::model()->findbyPk($item->category_id);
    ?>
        <div class="vce-grid-item">

            <div class="vce-grid-text">
                <div class="vce-featured-info">
                    <div class="vce-featured-section">
                        <a href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>Common::makeFriendlyUrl($category->url_key)));?>" class="category-<?php echo $category->id;?>"><?php echo $category->name;?></a></div>

                    <h2 class="vce-featured-title">
                        <a class="vce-featured-link-article" href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
                           title="<?php echo $item->title;?>"><?php echo $item->title;?></a>
                    </h2>

                    <div class="entry-meta">
                        <div class="meta-item date"><span class="updated">1 week ago</span></div>
                    </div>
                </div>

                <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" class="vce-featured-header-background"></a>

            </div>

            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>"
               title="Making a Commitment to Environmental Sustainability">
                <img width="380" height="260"
                     src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>"
                     class="attachment-vce-fa-grid size-vce-fa-grid wp-post-image" alt=""
                     srcset="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 380w,
                     <?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?> 145w"
                     sizes="(max-width: 380px) 100vw, 380px"/> </a>

        </div>

    <?php endforeach;?>


</div>
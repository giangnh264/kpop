<div id="main-box-11" class="main-box vce-border-top  ">
    <h3 class="main-box-title ">Tin Mới Cập Nhật</h3>
    <div class="main-box-inside ">
        <div class="vce-loop-wrap">
            <?php
                $news = WebNewsModel::model()->getLastet(10, 0);
                foreach ($news as $item):
                    $category = CategoryModel::model()->findByPk($item->category_id);
            ?>
                    <article class="vce-post vce-lay-b post-174 post type-post status-publish format-standard has-post-thumbnail hentry category-environment">

                        <div class="meta-image">
                            <a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title="San Francisco is the Most Photographed City in North America">
                                <img width="375" height="195" src="<?php echo Yii::app()->params['storage']['NewsUrl'] . $item->url_img;?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="<?php echo $item->title; ?>">
                                <?php if($category->id == 4):?>
                                    <span class="vce-format-icon"> <i class="fa fa-picture-o"></i> </span>
                                <?php elseif($category->id == 7):?>
                                    <span class="vce-format-icon"> <i class="fa fa-play"></i> </span>
                                <?php endif;?>

                            </a>
                        </div>


                        <header class="entry-header">
                            <span class="meta-category"><a href="<?php echo Yii::app()->createUrl('category/index', array('url_key'=>$category->url_key));?>" class="category-<?php echo $category->id; ?>"><?php echo $category->name; ?></a></span>
                            <h2 class="entry-title"><a href="<?php echo Yii::app()->createUrl('news/index', array('id'=>$item->id, 'url_key'=>Common::makeFriendlyUrl($item->title)));?>" title=" <?php echo Formatter::smartCut($item->title, 90, 0); ?>"> <?php echo Formatter::smartCut($item->title, 90, 0); ?></a></h2>
                            <div class="entry-meta"><div class="meta-item date"><span class="updated"><?php echo Formatter::formatTimeAgo($item->created_time);?></span></div></div>	</header>

                    </article>
            <?php endforeach;?>
        </div>
        <nav id="vce-pagination" class="vce-load-more">
            <a href="http://demo.mekshq.com/voice/?paged=2"> Load more</a></nav>


    </div>
</div>
<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
<head>
<!--    <meta charset="UTF-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="<?php echo Yii::app()->language?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php echo Yii::t('web',$this->htmlTitle);?></title>

    <?php
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl."/web/css/theme.css?v=".time());
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl."/web/js/jquery-1.9.1.min.js");
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl."/web/js/themes.js");
    ?>

    <?php Yii::app()->SEO->renderMeta();?>
    <link rel="icon" href="http://demo.mekshq.com/herald/wp-content/uploads/2015/12/cropped-favicon_default-65x65.png"
          sizes="32x32"/>
    <link rel="icon" href="http://demo.mekshq.com/herald/wp-content/uploads/2015/12/cropped-favicon_default-300x300.png"
          sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed"
          href="http://demo.mekshq.com/herald/wp-content/uploads/2015/12/cropped-favicon_default-180x180.png"/>
    <meta name="msapplication-TileImage"
          content="http://demo.mekshq.com/herald/wp-content/uploads/2015/12/cropped-favicon_default-300x300.png"/>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var mks_ep_settings = 0;
        var wc_add_to_cart_params = 0;
        /* ]]> */
    </script>


    <script type='text/javascript'>
        /* <![CDATA[ */
        var vce_js_settings = {
            "sticky_header": "1",
            "sticky_header_offset": "700",
            "sticky_header_logo": "",
            "logo": "http:\/\/demo.mekshq.com\/voice\/wp-content\/themes\/voice\/images\/voice_logo.png",
            "logo_retina": "http:\/\/demo.mekshq.com\/voice\/wp-content\/uploads\/2015\/05\/voice_logo@2x.png",
            "logo_mobile": "",
            "logo_mobile_retina": "",
            "rtl_mode": "0",
//            "ajax_url": "http:\/\/demo.mekshq.com\/voice\/wp-admin\/admin-ajax.php",
            "ajax_mega_menu": "1",
            "mega_menu_slider": "",
            "mega_menu_subcats": "",
            "lay_fa_grid_center": "",
            "full_slider_autoplay": "",
            "grid_slider_autoplay": "",
            "fa_big_opacity": {"1": "0.5", "2": "0.7"}
        };
        /* ]]> */
    </script>
</head>

<body class="home page-template page-template-template-modules page-template-template-modules-php page page-id-207 chrome herald-boxed">
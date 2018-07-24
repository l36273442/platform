<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','helps');?></title>
    <style>

        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }
        .slDetail_cont{
            background: #1c192e;
            color: #fff;
        }
        .slDetail_cont p{
            padding: 175px 0;
            text-align: center;
        }
        .currency{
            display: block;
            font-size: 80px;
            margin-bottom: 44px;
        }
        .help{
            font-size: 30px;
            display: block;
        }
        .process{
            margin-top: 60px;
            line-height: 102px;
            font-size: 26px;
            color: #009dea;
            clear: both;
        }
        .line{
            width: 530px;
            height: 2px;
            background: url("/images/anvantage-分割装饰@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .type_area .layui-collapse{
            margin: 40px 0 120px 0;
            border:none;
        }
        .layui-collapse .layui-colla-content {
            padding-left: 25px;
            border: none;
            color: #8e8e8e;
        }
        .layui-collapse .layui-colla-item{
            margin-bottom: 20px;
        }
        .layui-collapse .layui-colla-title{
            height: 56px;
            line-height: 56px;
            margin-bottom: 20px;
            border-left: 7px solid #009dea;
            padding: 0 15px 0 25px;
            background: #f5f5f5;
            color: #696969;
        }
        .layui-colla-icon{
            display: none;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="slDetail_cont">
        <p>
        <span class="currency"><?php echo Yii::t('common','faqs');?> </span>
            <span class="help"><?php echo Yii::t('common','help_content');?></span>
        </p>
</div>
<div class="type_area">
    <?php 
        if( $help ){
            foreach( $help as $k=>$v){
    ?>
    <p class="process"><?php echo Yii::t('common','help_faq_type'.$k);?></p>
    <p class="line"></p>
    <div class="layui-collapse">
                <?php foreach( $v as $val ) {?>
                <div class="layui-colla-item">
                <h2 class="layui-colla-title"><?php echo $val['title_'.Yii::app()->language];?></h2>
                    <div class="layui-colla-content layui-show"><?php echo $val['content_'.Yii::app()->language];?></div>
                </div>
                <?php
                    }?>
            </div>
        <?php

            }
        }
        ?>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="dist/layui.all.js"></script>
<script>
    var element = layui.element;


</script>
</body>
</html>

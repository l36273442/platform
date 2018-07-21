<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','page_error');?></title>
    <style>
        .error{
            width: 200px;
            margin: 188px auto 0;
        }
        .error img{
            width: 175px;
            height: 165px;
            background-size: 100% 100%;
        }
        .error p{
            text-align: center;
            line-height: 46px;
            color: #7e7e7e;
        }
        .back{
            width: 64px;
            height: 26px;
            margin:0 0 265px 55px;
            background: #009dea;
            color: #fff;
            border: none;
            border-radius: 3px;
            line-height: 26px;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="error">
    <img src="/images/error.png">
    <p><?php echo Yii::t('common','page_error_content');?></p>
     <button class="back"><?php echo Yii::t('common','back_home');?></button>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script>

    $('.back').on('click',function () {
        window.location.href = "/";
    })
</script>
</body>
</html>

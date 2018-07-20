<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','about');?></title>
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
        .currency{
            margin: 230px auto;
            text-align: center;
            font-size: 80px;
        }
        .mine{
            margin-top: 79px;
            font-size: 32px;
            color: #009dea;
            line-height: 65px;
        }
        .intro{
            display: block;
            line-height: 36px;
            font-size: 22px;
            color: #696969;
            padding: 0 175px 115px 0;
        }
        .founder{
            background: #1c192e;
        }
        .founder h2{
            margin-top: 28px;
            line-height: 192px;
            font-size: 46px;
            color: #fff;
        }
        .row{
            overflow: auto;
            color: #fff;
        }
        .row li{
            float: left;
            width: 273px;
            margin-right: 34px;
        }
        .row li:last-child{
            margin-right: 0;
        }
        .icon{
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: green;
            margin-bottom: 18px;
        }
        .row li h3{
            line-height: 72px;
            font-size: 26px;
        }
        .line1{
            width: 100%;
            height: 8px;
            background: url("/images/商店-分割装饰1@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .row li h4{
            line-height: 70px;
            font-size: 16px;
        }
        .line2{
            width: 100%;
            height: 2px;
            background: url("/images/商店-分割装饰2@2x.png") no-repeat;
            background-size: 100% 100%;
            margin-bottom: 14px;
        }
        .row li h5{
            font-size: 16px;
            margin-bottom: 82px;
            line-height: 40px;
        }
        .process{
            margin-top: 60px;
            line-height: 102px;
            font-size: 32px;
            color: #009dea;
            clear: both;
        }
        .line{
            width: 530px;
            height: 2px;
            background: url("/images/anvantage-分割装饰@2x.png")no-repeat;
            background-size: 100% 100%;
            margin-bottom: 40px;
        }
        .touch{
            overflow: auto;
            margin-bottom: 22px;
        }
        .touch span{
            float: left;
            width: 518px;
            height: 56px;
            border: 1px solid #c1c1c1;
            line-height: 58px;
            margin-bottom: 18px;
            padding: 0 30px;
            color: #696969;
            font-size: 20px;
        }
        .touch span b{
            float: right;
            color: #0092da;
        }
        .mar-let{
            margin-left: 38px;
        }
        .touch input[type="text"]{
            float: left;
            width: 518px;
            height: 56px;
            border: 1px solid #c1c1c1;
            line-height: 58px;
            margin-bottom: 18px;
            padding: 0 30px;
            color: #696969;
            font-size: 20px;
            background: none;
        }
        .put{
            clear: both;
            width: 1138px;
            height: 268px;
            border: 1px solid #c1c1c1;
            color: #696969;
            font-size: 20px;
            padding: 0 30px;
            margin-bottom: 60px;
        }
        textarea{
            width: 100%;
            height: 190px;
            resize: none;
            line-height: 58px;
            border: none;
            color: #696969;
        }
        .put .send {
            border: none;
            width: 100px;
            height: 40px;
            border-radius: 4px;
            background: #42d06c;
            color: #fff;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
        }
        .collaborate{
            margin-bottom: 100px;
            line-height: 60px;
            font-size: 22px;
            color: #696969;
        }
        .collaborate img{
            width: 60px;
            height: 60px;
            background-size: 100% 100%;
            margin-right: 30px;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="slDetail_cont">
    <div class="type_area">
        <p class="currency"><?php echo Yii::t('common','about');?></p>
    </div>
</div>
<div class="type_area">
<p class="mine"><?php echo $about['title_'.Yii::app()->language] ?></p>
<span class="intro"><?php echo $about['about_'.Yii::app()->language];?></span>
</div>
<div class="founder">
    <div class="type_area">
        <h2><?php echo Yii::t('common','founder');?></h2>
        <ul class="row">
            <?php
                if($employee){
                    foreach( $employee as $v ){
            ?>
            <li>
                <div class="icon"><img src="<?php echo $v['img_url']; ?>"/></div>
                <h3><?php echo $v['name_'.Yii::app()->language]?></h3>
                <p class="line1"></p>
                <h4><?php echo $v['position_'.Yii::app()->language]?></h4>
                <p class="line2"></p>
                <h5><?php echo $v['introduction_'.Yii::app()->language]?></h5>
            </li>
            <?php
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="question">
    <div class="type_area">
        <p class="process"><?php echo Yii::t('common','customer_sercvice');?></p>
        <p class="line"></p>
        <p class="touch">
        <span><?php echo Yii::t('common','wechat_service');?>: <b><?php echo $info['wechat1'];?></b></span>
        <span class="mar-let"><?php echo Yii::t('common','wechat_service');?>: <b><?php echo $info['wechat2'];?></b></span>
        <span><?php echo Yii::t('common','working_hours');?>: <b><?php echo $info['working_hours'];?></b></span>
        <span class="mar-let"><?php echo Yii::t('common','service_tell');?>: <b><?php echo $info['phone'];?></b></span>
        </p>
        <p class="process"><?php echo Yii::t('common','business_cooperation');?></p>
        <p class="line"></p>
        <div class="touch">
        <input type="text" class="name" placeholder="<?php echo Yii::t('common','your_name');?>" maxlength="64">
            <input type="text" class="mar-let email" placeholder="<?php echo Yii::t('common','your_email');?>" maxlength="255">
            <div class="put">
                <textarea class="offer" placeholder="<?php echo Yii::t('common','message');?>" maxlength="255"></textarea>
                <button class="send"><?php echo Yii::t('common','send');?></button>
            </div>
            <p class="collaborate">
                <img src="/images/email@2x.png">
                <?php echo Yii::t('common','contact_text');?><?php echo $info['email'];?><?php echo Yii::t('common','contact_reply');?>
            </p>
        </div>
    </div>
</div>

<script>
    var element = layui.element;

    let obj = {};
    $('.name').on('change',function () {
        obj.name = $(this).val();
    });
    $('.email').on('change',function () {
        obj.email = $(this).val();
    });

    // send
    $('.send').on('click',function () {
         let name = $('.name').val();
         let email = $('.email').val();
         let offer = $('.offer').val();

         if(!obj.name) return layer.msg('名字不能为空!');
         if(!obj.email) return layer.msg('邮箱不能为空！');

         if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/)) {
               layer.msg('请输入正确的邮箱！');
         }else{
              $.ajax({
                   type: 'POST',
                   url: '/contactmessage/setmessage',
                   data:{
                       name: name,
                       email: email,
                       offer: offer,
                   },
                   dataType: 'json',
                   success: function(data){
                       //console.log(data);
                       if(data.ret =='1') {  // 成功
                           layer.msg(data.msg);
                           setTimeout(function () {
                               location.reload();
                           },1500)
                       }else{
                           layer.msg(data.msg);
                       }
                   }
              })
         }
    })

</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SIGH UP</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/intlTelInput.css">
    <link rel="stylesheet" href="/dist/css/layui.css">
    <style>
        html,body{
            width: 100%;
            height: 100%;
            background: #12101d;;
        }
        .register{
            width: 380px;
            height: 465px;
            background: #fff;
            overflow: auto;
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
            border-radius: 5px;
        }
        .left{
            width: 130px;
            float: left;
            height: 100%;
            background: url("/images/左侧背景@2x.png")no-repeat;
            background-size: 100% 100%;
            position: relative;
        }
        .wrap{
            height: 60px;
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
        }
        .left P{
            font-size: 14px;
            font-weight: 600;
            color: #d4d5da;
            text-align: center;
            line-height: 40px;
        }
        .left span{
            float: left;
            width: 100%;
            color: #565564;
            text-align: center;
        }
        .right{
            float: right;
            width: 226px;
            position: relative;
        }
        .reg-title{
            font-weight: 600;
            font-size: 20px;
            color:#05a0e8;
            line-height: 86px;
            margin-top: 8px;
        }
        .reg-center{
            width: 180px;
            height: 33px;
            line-height: 33px;
            border-left: 4px solid #009de9;
            margin-bottom: 10px;
            box-shadow: 5px 10px 10px #efeff0;
            position: relative;
        }
        .intl-tel-input{
            width: 70px;
        }
        .intl-tel-input .country-list{
            width: 220px;
        }
        #country_code{
            width: 100%;
            height: 100%;
        }
        li.reg-center .tel{
            width: 100px;
            height: 32px;
        }
        .reg-center input{
            border: none;
           /* height: 100%;*/
            width: 120px;
            padding-left: 5px;
        }
        .auth{
            display: inline-block;
            width: 50px;
            height: 30px;
            position: absolute;
            cursor: pointer;
        }
        .auth img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
        .security{
            display: inline-block;
            width: 40px;
            height: 18px;
            border: none;
            line-height: 18px;
            text-align: center;
            position: absolute;
            cursor: pointer;
            font-family: HelveticaNeue;
            top: 9px;
            right: 8px;
            font-size: 10px;
            color: #fdfdfd;
            background: #009dea;
            border-radius: 6px;
        }
        .text{
            color: #009dea;
            line-height: 26px;
            font-family: HelveticaNeue;
        }
        .up{
            margin: 14px 0;
        }
        .login{
            width: 180px;
            height: 33px;
            line-height: 33px;
            color: #fff;
            border: none;
            background: #009dea;
            border-radius: 3px;
            cursor: pointer;
        }
        .already a{
            position: absolute;
            color: #67b9ef;
            right: 48px;
            line-height: 20px;
        }
    </style>
</head>
<body>
<div class="register">
    <div class="left">
        <div class="wrap">
            <p>M I N B I T</p>
            <span><?php echo Yii::t('common','welcome');?></span>
        </div>
    </div>
    <ul class="right">
        <li class="reg-title"><?php echo Yii::t('common','register');?></li>
        <li class="reg-center">
            <div>
                <input type="text" id="country_code">
                <input type="text" class="tel" placeholder="<?php echo Yii::t('common','phone_number');?>">
            </div>

        </li>
        <li class="reg-center">
            <input type="text" class="random" placeholder="<?php echo Yii::t('common','img_code');?>">
            <span class="auth"><img src="/code.php" onClick="this.src='/code.php?' + new Date().getTime();"></span>
        </li>
        <li class="reg-center">
            <input type="text" class="code" placeholder="<?php echo Yii::t('common','sms_code');?>">
            <button class="security"><?php echo Yii::t('common','send');?></button>
        </li>
        <li class="reg-center">
            <input type="password" class="password" placeholder="<?php echo Yii::t('common','password_len');?>">
        </li>
        <li class="reg-center">
            <input type="password" class="repetition" placeholder="<?php echo Yii::t('common','repeat_password');?>">
        </li>
        <li class="text"><?php echo Yii::t('common','repeat_password');?></li>
        <li class="up">
            <button class="login"><?php echo Yii::t('common','signup');?></button>
        </li>
        <li class="already">
            <a href="/login/signin"><?php echo Yii::t('common','exists_accound');?></a>
        </li>
    </ul>
</div>


<script src="/js/jquery.min.js"></script>
<script src="/js/intlTelInput.js"></script>
<script src="/dist/layui.all.js"></script>
<script>
    let layer = layui.layer;

    // 电话区号
    $("#country_code").intlTelInput({
        autoHideDialCode: false,
        defaultCountry: "cn",
        nationalMode: false,
        preferredCountries: ['cn', 'us', 'hk', 'tw', 'mo'],
    });

    // sign Up
    let obj = {};
    $('.tel').on('change',function () {
        obj.phone = $(this).val();
        obj.country = $('#country_code').val();
    });
    $('.random').on('change',function () {
        obj.random = $(this).val();
    });
    $('.code').on('change',function () {
        obj.code = $(this).val();
    });
    $('.password').on('change',function () {
        obj.password = $(this).val();
    });
    $('.repetition').on('change',function () {
        obj.repetition = $(this).val();
    });

    // 倒计时
        var num=60;
        function setNum(){
            clearInterval(Countdown);
            //$('.security').html(num+'S');
           var Countdown = setInterval(function () {
                num--;
               $('.security').html(num+'S');
               if(num<=0){
                   clearInterval( Countdown);
                   $('.security').html('send');
                   $('.security').attr('disabled','false');
               }
            },1000);
        }


    // 发送验证码
    $('.security').on('click',function () {
        if(obj.phone && obj.random){
            $.ajax({
                type: 'POST',
                url: '/sms/sendsmscode',
                data:{
                    country_code: obj.country,
                    code:obj.random,
                    mobile: obj.phone
                },
                dataType: 'json',
                success: function(data){
                   // console.log(data);
                    if(data.ret =='1') {  // 成功
                       layer.msg('验证码发送成功！');
                       setNum();
                       $('.security').attr('disabled','true');
                    }else{
                        layer.msg(data.msg);
                    }
                }
            })
        }else{
            layer.msg('fail!');
           /* layer.open({
                title: '',
                content: '接口调用失败！'
            });*/
        }
    });

    //注册
    $('.login').on('click',function () {
        if(!obj.phone) return layer.msg('<?php echo Yii::t('common','phone_empty');?>');
        if(!obj.random) return layer.msg('<?php echo Yii::t('common','img_empty');?>');
        if(!obj.code) return layer.msg('<?php echo Yii::t('common','sms_code_empty');?>');
        if(!obj.password) return layer.msg('<?php echo Yii::t('common','password_empty');?>');
        if(!obj.repetition) return layer.msg('<?php echo Yii::t('common','repeat_password_empty');?>');
        if(obj.password === obj.repetition) {
            $.ajax({
                type: 'POST',
                url: '/register/doregister',
                data:{
                    country_code: obj.country,
                    mobile: obj.phone,
                    sms_code:obj.code,
                    password:obj.password
                },
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    if(data.ret =='1') {  // 成功
                       // alert('注册成功！');
                        window.location.href = "/login/signin";
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

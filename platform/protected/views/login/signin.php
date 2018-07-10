<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SIGH IN</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/intlTelInput.css">
    <link rel="stylesheet" href="dist/css/layui.css">
    <style>
        html,body{
            width: 100%;
            height: 100%;
            background: #12101d;
        }
        .register{
            width: 380px;
            height: 360px;
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
            background: url("images/左侧背景@2x.png")no-repeat;
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
        .security{
            display: inline-block;
            width: 40px;
            height: 18px;
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
            line-height: 26px;
            text-align: right;
            margin-right: 43px;
            font-family: HelveticaNeue;
        }
        .text a{
            color: #009dea;
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
            width: 180px;
            text-align: center;
            line-height: 20px;
        }
        .close{
            position: absolute;
            right: 10px;
            top: 8px;
            width: 14px;
            height: 14px;
            cursor: pointer;
        }
        .close img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
<div class="register">
    <div class="left">
        <div class="wrap">
            <p>M I N B I T</p>
            <span>WELCOME</span>
        </div>
    </div>
    <ul class="right">
        <li class="reg-title">SIGH IN</li>
        <li class="reg-center">
            <div>
                <input type="text" id="country_code">
                <input type="text" class="tel" placeholder="Mailbox number">
            </div>

        </li>
        <li class="reg-center">
            <input type="password" class="password" placeholder="Password (6-8 bits)">
        </li>
        <li class="reg-center">
            <input type="text" class="code" placeholder="Verification code">
            <span class="security">Send</span>
        </li>
        <li class="text"><a href="resetpassword.html">Forgot Password</a></li>
        <li class="up">
            <button class="login">Sign In</button>
        </li>
        <li class="already">
            <a href="signup.html">sign Up</a>
        </li>
    </ul>
    <div class="close"><img src="images/icon_close@2x.png"></div>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/intlTelInput.js"></script>
<script src="dist/layui.all.js"></script>
<script>
    let layer = layui.layer;

    // 电话区号
    $("#country_code").intlTelInput({
        autoHideDialCode: false,
        defaultCountry: "cn",
        nationalMode: false,
        preferredCountries: ['cn', 'us', 'hk', 'tw', 'mo'],
    });

    let obj = {};
    $('.tel').on('change',function () {
        obj.phone = $(this).val();
        obj.country = $('#country_code').val();
    });
    $('.code').on('change',function () {
        obj.code = $(this).val();
    });
    $('.password').on('change',function () {
        obj.password = $(this).val();
    });

    // 发送验证码
    $('.security').on('click',function () {
        if(obj.phone && obj.password){
            $.ajax({
                type: 'POST',
                url: '/sms/sendsmslogincode',
                data:{
                    country_code: obj.country,
                    mobile: obj.phone,
                    password:obj.password
                },
                dataType: 'json',
                success: function(data){
                     console.log(data);
                    if(data.ret =='1') {  // 成功
                        $('.security').html('60秒');

                    }else{
                        layer.msg(data.msg);
                    }
                }
            })
        }else{
            layer.msg('接口调用失败！');
            /* layer.open({
                 title: '',
                 content: '接口调用失败！'
             });*/
        }
    });

    //logn in
    $('.login').on('click',function () {
        if(!obj.phone) return layer.msg('电话号码不能为空!');
        if(!obj.code) return layer.msg('验证码不能为空！');
        if(!obj.password) return layer.msg('密码不能为空！');
        $.ajax({
            type: 'POST',
            url: '/login/dologin',
            data:{
                country_code: obj.country,
                mobile: obj.phone,
                password:obj.password,
                sms_code:obj.code
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                   // alert('登录成功！');
                    window.location.href = "index.html";
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    })

</script>
</body>
</html>
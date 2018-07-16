<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','home');?></title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/dist/css/layui.css">
    <style>
        .user{
            background: #1c192e;
        }
        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }
        .user_title1{
            padding-top: 41px;
            line-height: 34px;
            font-size: 14px;
            color: #fff;
        }
        .user_title2{
            font-size: 28px;
            line-height: 106px;
            color: #74737b;
        }
        .user_content,.user_content1,.user_content2{
            background: #252236;
            border: 2px solid #514e5e;
            padding:  0 32px;
            margin-bottom: 30px;
        }
        .survey{
            line-height: 56px;
            border-bottom: 2px solid #514e5e;
            color: #fff;
            font-size: 20px;
        }
        .survey img{
            width: 36px;
            height: 34px;
            background-size: 100% 100%;
            margin-right: 10px;
        }
        .row{
            border-bottom: 1px solid #302d40;
            color: #78767f;
            line-height: 72px;
            margin-left: 8px;
        }
        .power{
            color: #0092da;
        }
        .mill{
            color: #78767f;
        }
        .row span{
            display: inline-block;
            font-size: 14px;
            width: 33%;
        }
        .row span b{
            font-size: 24px;
            color: #009dea;
        }
        .row:last-child{
            border: none;
        }
        .row span a{
            display: inline-block;
            padding: 0 38px;
            height: 40px;
            margin-right: 20px;
            line-height: 40px;
            background: #009dea;
            font-size: 16px;
            color: #fff;
            border-radius: 4px;
            text-align: center;
        }
        .user_content2{
            display: none;
        }
    </style>
</head>
<body>
 <?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="user">
    <div class="type_area">
        <p class="user_title1">
            <a href="#" style="color: #74737b;">首页 / </a>
            <span>用户面板</span>
        </p>
        <p class="user_title2">
            <span class="power">算力详情</span>
            <b> | </b>
            <span class="mill">矿机详情</span>
        </p>
        <ul class="user_content1">
            <li class="survey"><img src="images/云算力icon@2x.png">云算力概况</li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
        </ul>
        <ul class="user_content2">
            <li class="survey"><img src="images/云算力icon@2x.png">矿机概况</li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <!--<li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>
            <li class="row">
                <span>s9总量&nbsp;|&nbsp;<b>0.00</b>&nbsp;T</span>
                <span>CNY总收益&nbsp;|&nbsp;<b>0.00</b></span>
                <span>BTC总收益&nbsp;|&nbsp;<b>0.00000000</b></span>
            </li>-->
        </ul>
        <!--<ul class="user_content">
            <li class="survey"><img src="images/矿场基建icon@2x.png">矿场基建</li>
            <li class="row">
                <span>投入&nbsp;|&nbsp;<b>0.00</b>&nbsp;CYN</span>
                <span>收益&nbsp;|&nbsp;<b>0.00</b>CYN</span>
                <span><a href="#">收益详情</a></span>
            </li>
        </ul>-->
        <ul class="user_content">
            <li class="survey"><img src="images/tethericon@2x.png">USDT账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00000000</b>&nbsp;USDT</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00000000</b>USDT</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        <ul class="user_content">
            <li class="survey"><img src="images/cyn账户icon@2x.png">CYN账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00</b>&nbsp;CYN</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00</b>CYN</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        <ul class="user_content">
            <li class="survey"><img src="images/bc_logo_@2x.png">BTC账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00000000</b>&nbsp;BTC</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00000000</b>BTC</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        <ul class="user_content">
            <li class="survey"><img src="images/eth账户@2x.png">ETH账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00000000</b>&nbsp;ETH</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00000000</b>ETH</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        <ul class="user_content">
            <li class="survey"><img src="images/litecoin@2x.png">LTC账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00000000</b>&nbsp;LTC</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00000000</b>LTC</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        <ul class="user_content">
            <li class="survey"><img src="images/btm账户icon@2x.png">ETH账户</li>
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00000000</b>&nbsp;BTM</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00000000</b>BTM</span>
                <span>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
    </div>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script src="/js/jquery.min.js"></script>
<script src="/dist/layui.all.js"></script>
<script>
    // 算力详情
  $('.mill').on('click',function () {
      $('.mill').css('color','#0092da');
      $('.power').css('color','#78767f');
      $('.user_content1').hide();
      $('.user_content2').show();
  })

   // 矿机详情
  $('.power').on('click',function () {
      $('.power').css('color','#0092da');
      $('.mill').css('color','#78767f');
      $('.user_content2').hide();
      $('.user_content1').show();
  })

</script>
</body>
</html>

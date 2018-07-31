<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','cash_withdrawal');?></title>
    <style>
        .recharge{
            background: #1c192e;
        }
        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }?php echo Yii::t('common','home');?>
        .user_title1{
            padding-top: 90px;
            font-size: 14px;
            color: #fff;
        }
        .user_title2 {
            font-size: 32px;
            line-height: 106px;
            color: #0092da;
        }
        .recharge_con{
            border: 2px solid #494758;
            margin-bottom: 42px;
            padding: 30px;
            font-size: 20px;
            color: #fff;
        }
        .site{
            line-height: 80px;
        }
        #withdraw,.money,.password,.note{
            width: 450px;
            height: 40px;
            line-height: 38px;
            color: #fff;
            padding-left: 20px;
            background: none;
            font-size: 14px;
            margin-right:20px;
            border: 1px solid #514e5e;
        }
        #withdraw option{
            color: #696969;
        }
        .manage,.send{
            display: inline-block;
            width: 110px;
            height: 40px;
            font-size: 16px;
            line-height: 40px;
            text-align: center;
            border-radius: 4px;
            background: #009dea;
            cursor: pointer;
        }
        .balance{
            line-height: 58px;
            color:  #a8a8ac;
            font-size: 14px;
           display: inline-block;
            margin-right: 70px;
        }
        .balance span{
            font-size: 20px;
            color: #fff;
        }
        .balance b{
            font-size: 20px;
            color: #009dea;
        }
        .promptly{
            width: 450px;
            height: 40px;
            font-size: 16px;
            line-height: 40px;
            text-align: center;
            border-radius: 4px;
            background: #009dea;
            cursor: pointer;
            margin: 50px 0;
        }



        .record{
            border: 2px solid #333043;
            overflow: auto;
            margin-bottom: 76px;
        }
        .line_hrader{
            line-height: 88px;
            background: #201d34;
            font-size: 24px;
            color: #fff;
            overflow: auto;
            margin-bottom: 24px;
        }
        .record .line_hrader span,.record li span{
            float: left;
            width: 25%;
            text-align: center;
        }
        .matter span{
            font-size: 16px;
            color: #a1a0a5;
            line-height: 54px;
        }
        .matter span b{
            font-weight: 500;
        }
        .line_footer{
            line-height: 76px;
            text-align: center;
            font-size: 16px;
            color: #7f7d89;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="recharge">
    <div class="type_area">
        <p class="user_title1">
            <a href="#" style="color: #74737b;"><?php echo Yii::t('common','home');?> / </a>
            <span><?php echo Yii::t('common','cash_withdrawal');?></span>
        </p>
        <p class="user_title2" id="USDT"><?php echo strtoupper($coin['name']);?></p>
        <ul class="recharge_con">
            <li class="site"><?php echo Yii::t('common','withdrawal_address');?></li>
            <li style="margin-bottom: 30px;">
                <select name="withdraw" id="withdraw">
                    <!--<option value="0">11KSGQ2PTIXO89LYQKEGA1DBGXY7V316AGID</option>
                    <option value="1">3333333333333333333</option>-->
                </select>
                <span class="manage"><?php echo Yii::t('common','manage_address');?></span>
            </li>
            <li class="balance"><span><?php echo Yii::t('common','available_balance');?>:</span>&nbsp;&nbsp;<b><?php echo isset($uc['current_total'])?sprintf("%.8f",$uc['current_total']):0;?></b>&nbsp;<?php echo strtoupper($coin['name']);?></li>
            <li class="site"><?php echo Yii::t('common','withdrawal_amount');?></li>
            <li><input type="text" class="money"></li>
            <li class="balance"><span><?php echo Yii::t('common','handling_fee');?>:</span>&nbsp;&nbsp;<b><?php echo $coin['extract_fee'];?></b>&nbsp;<?php echo strtoupper($coin['name']);?></li>
            <li class="balance"><span><?php echo Yii::t('common','actual_arrival');?>:</span>&nbsp;&nbsp;<b>0</b>&nbsp;<?php echo strtoupper($coin['name']);?></li>
            <li class="site" style="margin-top: 30px;"><?php echo Yii::t('common','transaction_password');?></li>
            <li><input type="text" class="password"></li>
            <!--<li class="site" style="margin-top: 20px;">短信验证码</li>
            <li>
                <input type="text" class="note">
                <span class="send">发送验证码</span>
            </li>-->
            <li class="promptly"><?php echo Yii::t('common','immediate_withdrawal');?></li>
        </ul>

        <div class="record">
            <p class="line_hrader">
              <span><?php echo Yii::t('common','update_time');?></span>
              <span><?php echo Yii::t('common','withdrawal_address');?></span>
              <span><?php echo Yii::t('common','withdrawal_amount');?></span>
              <span><?php echo Yii::t('common','withdrawal_status');?></span>
            </p>
            <ul class="log"></ul>
            <!--<p class="line_footer">加载更多</p>-->
        </div>
    </div>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script>
    let layer = layui.layer;

    // 地址
    function getaddress() {
        let coin_id = 1;
        $.ajax({
            type: 'POST',
            url: '/coin/getusercoinaddress',
            data:{
                coin_id :coin_id ,
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(Array.isArray(data.data)){
                        let html = data.data.map((item, index) => {
                            return `<option value=${index} id=${item.id}>${item.remark}${item.address}</option>`
                        });
                        $('#withdraw').html(html.join(' '));
                    }else{
                        $('#withdraw').html(' ');
                    }
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    getaddress();


     let coin_id = window.location.search.substr(1).split('=')[1];
    // 虚拟币提现
    $('.promptly').on('click',function () {
        let count = $('.money').val(),
            address_id = $('#withdraw option:selected').attr('id'),
            tpassword = $('.password').val();
        $.ajax({
            type: 'POST',
            url: '/coin/withdraw',
            data:{
                coin_id :coin_id ,
                count: count,
                address_id: address_id,
                tpassword:tpassword
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    layer.msg('提现成功');
                    setTimeout(function () {
                        window.location.reload();
                    },1500)
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    })

    //记录
    function record() {
        $.ajax({
            type: 'POST',
            url: '/coin/getwithdrawlist',
            data:{ coin_id :coin_id },
            dataType: 'json',
            success: function(data){
               //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(Array.isArray(data.data)){
                        let html = data.data.map((item, index) => {
                            return ` <li class="matter">
                                        <span>${item.uptime_text}</span>
                                        <span>${item.address}</span>
                                        <span><b>${item.count}</b> BTC</span>
                                        <span>${item.co_status_text}</span>
                                     </li>`
                        });
                        $('.log').html(html.join(' '));
                    }else{
                        $('.log').html(' ');
                    }
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    record();
</script>
</body>
</html>

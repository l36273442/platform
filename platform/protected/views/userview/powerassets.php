<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','hash_assets');?></title>
    <style>
        .customer{
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
        .profit_btc,.recharge_list{
            background: #252236;
            border: 2px solid #514e5e;
            margin-bottom: 50px;
        }
        .user_content{
            padding:  33px 32px 20px 32px;
            border-bottom: 1px solid #302d40;
            overflow: auto;
        }
        .profit_btc ul:last-child{
            border-bottom: none;
        }
        .row{
            float: left;
            width: 33%;
        }
        .row P{
            color: #aca8ad;
            font-size: 14px;
        }
        .row P:nth-child(1){
            line-height: 34px;
        }
        .row P:nth-child(2){
            line-height: 39px;
        }
        .row p b{
            font-size: 24px;
            color: #009dea;
        }
        .profit_head{
            margin: 0 32px;
            border-bottom: 2px solid #514e5e;
            font-size: 20px;
            line-height: 54px;
            color: #fff;
        }
        .table{
            color: #96959b;
            width: 95%;
            margin: 0 32px 84px;
        }
        .table tr{
            line-height: 54px;
            text-align: center;
            border-bottom: 1px solid #302d40;
        }
        .row span{
            display: inline-block;
            font-size: 22px;
        }

        .cyn{
            color:#0092da;
        }

        div.layui-tab-content,div.layui-tab{
            margin: 0;
            padding: 0;
        }
        div.layui-tab-brief>.layui-tab-title .layui-this{
            color: #0092da
        }
        ul.layui-tab-title li{
            line-height: 106px;
            font-size: 28px;
            color: #74737b;
            padding: 0;
            text-align: left;
            min-width: 60px;
        }
        ul.layui-tab-title{
            height: auto;
            border: none;
            color: #74737b;
            font-size: 24px;
        }
        div.layui-tab-brief>.layui-tab-more li.layui-this:after, div.layui-tab-brief>.layui-tab-title .layui-this:after{
            border: none;
        }
        .profit_btc{
            display: none;
        }
    </style>
</head>
<body>
 <?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="customer">
    <div class="type_area">
        <p class="user_title1">
            <a href="/" style="color: #74737b;"><?php echo Yii::t('common','home');?> / </a>
            <span><?php echo Yii::t('common','hash_assets');?></span>
        </p>
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <?php
                    if($coins){
                        $i=0;
                        $len = count($coins)-1;
                        foreach( $coins as $v ){
                ?>
                    <li <?php if( $i==0 ){echo 'class="layui-this very"';}?> coin_id="<?php echo $v['id'];?>"><?php echo $v['name'];?></li><?php if($i!=$len) echo '&nbsp;&nbsp;|&nbsp;&nbsp;';?>
                <?php
                    $i++;                
                    }
                }
                ?> 
            </ul>
            <?php
                if( $coins ){
                    foreach($coins as $v){
            ?>
                <div class="profit_btc" id="<?php echo $v['id'];?>">
                <ul class="user_content">
                    <li class="row">
                        <p><?php echo Yii::t('common','total_power');?></p>
                        <p> <b></b> <?php echo $v['total_power'];?> <?php echo $v['unit_name'];?></p>
                    </li>
                    <li class="row">
                    <p><?php echo Yii::t('common','my_recharge');?> USD</p>
                    <p> <b><?php echo $v['power_total_investment'];?></b></p>
                    </li>
                    <li class="row">
                        <p><?php echo Yii::t('common','my_recharge');?> BTC</p>
                        <p> <b><?php echo (isset($btc['latest_price'])&&$btc['latest_price']!=0)?(  sprintf("%.8f",$v['power_total_investment']/$btc['latest_price']) ):''?></b> </p>
                    </li>
                </ul>
                <ul class="user_content">
                    <li class="row">
                        <p><?php echo Yii::t('power','return_status');?></p>
                        <p> <b><?php if($v['power_total_investment'] >0 ) echo sprintf("%.4f",$v['power_total_income']*$v['latest_price']/$v['power_total_investment']);?> </b> </p>
                    </li>
                    <li class="row">
                        <p><?php echo Yii::t('common','my_income');?> </p>
                        <p> <b><?php echo $v['power_total_income']; ?> <?php echo $v['name'];?></b></p>
                    </li>
                    <li class="row">
                        <p><?php echo Yii::t('common','my_income');?> BTC</p>
                        <p> <b><?php echo $v['power_total_income']*$v['latset_btc_price'];?></b> </p>
                    </li>
                </ul>
                <!--
                <ul class="user_content">
                    
                    <li class="row">
                        <p>收益方式
                            <span class="cyn btn" flag=false style="padding-left: 10px;">CYN</span>
                            <span>&nbsp;&nbsp;|&nbsp;&nbsp; </span>
                            <span class="btc btn" flag=false>BTC</span>
                        </p>
                    </li>
                    
                </ul>
                -->
            </div>
            <?php
                }
            }
            ?>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div class="recharge_list">
                        <div class="profit_head"><?php echo Yii::t('power','income_breakdown');?></div>
                        <!--<div class="profit_head"><span style="color: #fff;">收益明细</span>
                            <span class="a cyn" style="padding-left: 10px;">CYN</span>
                            <span>&nbsp;&nbsp;|&nbsp;&nbsp; </span>
                            <span class="a">BTC</span>
                        </div>-->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php  echo Yii::t('common','time');?></th>
                                    <th><?php echo Yii::t('common','total_income');?></th>
                                    <th><?php echo Yii::t('common','electricity_fee');?></th>
                                    <th><?php echo Yii::t('common','manage_fee');?></th>
                                    <th><?php echo Yii::t('common','real_income');?></th>
                                    <th>BTC<?php echo Yii::t('common','price');?></th>
                                </tr>
                                </thead>
                                <tbody class="coin">

                                </tbody>
                            </table>

                    </div>

                    <div class="recharge_list">
                        <div class="profit_head"><?php echo Yii::t('power','buy_breakdown');?></div>
                        <!--<div class="profit_head"><span style="color: #fff;">算力明细</span>
                            <span class="b cyn" style="padding-left: 10px;">购买明细</span>
                            <span>&nbsp;&nbsp;|&nbsp;&nbsp; </span>
                            <span class="b">交易明细</span>
                        </div>-->
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><?php  echo Yii::t('common','time');?></th>
                                    <th><?php echo Yii::t('common','price');?></th>
                                    <th><?php echo Yii::t('common','count');?></th>
                                    <th><?php echo Yii::t('common','total_price');?></th>
                                </tr>
                                </thead>
                                <tbody class="assets">

                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script src="js/jquery.min.js"></script>
<script src="dist/layui.all.js"></script>
<script>
    var element = layui.element;
    element.on('tab(docDemoTabBrief)', function(data){
       currency($(this).attr('coin_id'));
        millassets($(this).attr('coin_id'));
        render($(this).attr('coin_id'));
    });

    // 币种切换
    function render(id) {
        $('.profit_btc').hide();
        $('#'+id).show();
    }
    render($('.profit_btc').attr('id'));


    // 收益方式 CYN || BTC
    window.flag=false;
    $('.btn').on('click',function () {
        let _this=this;
        if($(this).hasClass('cyn')){
            layer.msg('您目前的收益方式就是:'+_this.innerText);
        }else {
            layer.open({
                title: '消息',
                content: `更改收益方式为${_this.innerText} ?`,
                btn: ['确定', '取消'],
                yes:function(index, layero){
                    layer.msg(`更改收益方式为${_this.innerText} `);
                    $('.btn').removeClass('cyn');
                    $(_this).addClass('cyn');
                },
                btn2:function () {

                }
            });
        }
    })


    //  CYN && BTC
   /* $('.a').on('click',function () {
        if(!$(this).hasClass('cyn')){
            if($(this).text()=='CYN'){
                $('.www').html(`<table class="table">
                                <tr>
                                    <th>时间</th>
                                    <th>已交割</th>
                                    <th>未交割</th>
                                    <th>总收益</th>
                                    <th>电费</th>
                                    <th>管理费</th>
                                    <th>实际收益</th>
                                    <th>汇率</th>
                                    <th>BTC价格</th>
                                </tr>
                            </table>`)
            }else if($(this).text()=='BTC'){
                $('.www').html(` <table class="table">
                                <tr>
                                    <th>时间</th>
                                    <th>已交割</th>
                                    <th>未交割</th>
                                    <th>总收益</th>
                                    <th>电费</th>
                                    <th>管理费</th>
                                    <th>实际收益</th>
                                    <th>汇率</th>
                                    <th>BTC价格</th>
                                </tr>
                            </table>`)
            }
            $('.a').removeClass('cyn');
            $(this).addClass('cyn')
        }
    })*/


    // 购买明细 && 交易明细
   /* $('.b').on('click',function () {
        if(!$(this).hasClass('cyn')){
            if($(this).text()=='购买明细'){
                currency($(this).attr('coin_id'));
            }else if($(this).text()=='交易明细'){
                let a='11';
                currency(a);
            }
            $('.b').removeClass('cyn');
            $(this).addClass('cyn')
        }
    })*/


    // 收益明细
    function millassets(coin_id) {
        let size = 20;
        let page = 1;
        $.ajax({
            type: 'POST',
            url: '/user/getpowerrecord',
            data:{
                id:coin_id,
                size:size,
                page:page
            },
            dataType: 'json',
            success: function(data){
                 //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(Array.isArray(data.data)){
                        let html = data.data.map((item, index) => {
                            return `<tr>
                                   <td>${item.release_time_text}</td>
                                   <td>${item.count}</td>
                                   <td>${item.electricity_fee}</td>
                                   <td>${item.manage_fee}</td>
                                   <td>${item.real_count}</td>
                                   <td>${item.btc_price}</td>
                               </tr>`
                            });
                        $('.coin').html(html.join(' '));
                    }else{
                        $('.coin').html(' ');
                    }
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    millassets($('.very').attr('coin_id'));

     // 购买明细
    function currency(coin_id) {
        let size = 20;
        let page = 1;
        $.ajax({
            type: 'POST',
            url: '/powercontractorder/getuserlist',
            data:{
                coin_id:coin_id,
                size:size,
                page:page,
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(Array.isArray(data.data)){
                        let html = data.data.map((item, index) => {
                            //console.log(item)
                            return `<tr >
                                <td>${item.ctime}</td>
                                <td>${item.price}</td>
                                <td>${item.count}</td>
                                <td>${item.order_price}</td>
                                 </tr>`
                        });
                        $('.assets').html(html.join(' '));
                    }else{
                        $('.assets').html(' ');
                    }
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    currency($('.very').attr('coin_id'));


</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','machine_assets');?></title>
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
        .profit_btc1,.recharge_list{
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
        .table,.earningstable{
            color: #96959b;
            width: 95%;
            margin: 0 32px;
        }
        .table tr,.earningstable tr{
            line-height: 54px;
            text-align: center;
            border-bottom: 1px solid #302d40;
        }
        .table .data{
            font-size: 24px;
            color: #0092da;
        }
        .layui-tab-content,.layui-tab{
            padding: 0;
        }
        .layui-tab-brief>.layui-tab-title .layui-this{
            color: #0092da
        }
        .layui-tab-title li{
            line-height: 106px;
            font-size: 28px;
            color: #74737b;
            padding: 0;
            min-width: 70px;
        }
        .layui-tab-title{
            height: auto;
            border: none;
        }
        .layui-tab-brief>.layui-tab-more li.layui-this:after, .layui-tab-brief>.layui-tab-title .layui-this:after{
            border: none;
        }
    </style>
</head>
<body>
 <?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="customer">
    <div class="type_area">
        <p class="user_title1">
            <a href="/" style="color: #74737b;"><?php echo Yii::t('common','home');?> / </a>
            <span><?php echo Yii::t('common','machine_assets');?></span>
        </p>
        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <?php
                    if($coins){
                        $i=0;
                        foreach( $coins as $v ){
                ?>
                    <li <?php if( $i==0 ){echo 'class="layui-this"';}?> coin_id="<?php echo $v['id']?>"><?php echo $v['name'];?></li>
                <?php
                    $i++;                
                    }
                }
                ?>
            </ul>

            <div class="layui-tab-content">
                <?php
                    if($coins){
                        $i=0;
                        foreach( $coins as $v){
                ?>  
                    <div class="layui-tab-item <?php if($i==0) echo 'layui-show';?>">
                    <div class="profit_btc1">
                        <ul class="user_content">
                            <li class="row">
                                <p><?php echo Yii::t('common','my_recharge');?> USD</p>
                                <p> <b><?php echo $v['machine_total_investment'];?></b></p>
                            </li>
                            <li class="row">
                                <p><?php echo Yii::t('common','my_income');?> USD</p>
                                <p> <b><?php echo $v['machine_total_income']*$v['latest_price'];?></b></p>
                            </li>
                            <li class="row">
                            <p><?php echo Yii::t('common','total_income');?><?php echo $v['name'];?></p>
                            <p> <b><?php echo $v['machine_total_income'];?></b> </p>
                            </li>
                        </ul>
                    </div>
                    <div class="recharge_list">
                        <div class="profit_head">S9</div>
                        <table class="table">
                            <tr>
                                <th><?php echo Yii::t('common','name');?></th>
                                <th><?php echo Yii::t('common','count');?></th>
                                <th><?php echo Yii::t('common','status');?></th>
                                <th><?php echo Yii::t('common','start_time');?></th>
                                <th><?php echo Yii::t('common','end_time');?></th>
                                <th><?php echo Yii::t('common','price');?></th>
                                <th><?php echo Yii::t('common','manage_fee');?></th>
                                <th><?php echo Yii::t('common','electricity_fee');?>/<?php echo Yii::t('common','day');?></th>
                            </tr>
                            <tbody class="tbody">

                            </tbody>
                        </table>
                    </div>
                    <div class="recharge_list">
                        <div class="profit_head">收益明细</div>
                            <table class="earningstable">
                                <tr>
                                    <th>时间</th>
                                    <th>总收益</th>
                                    <th>电费</th>
                                    <th>管理费</th>
                                    <th>实际收益</th>
                                    <th>BTC价格</th>
                                </tr>
                                <tbody class="coin">

                                </tbody>
                            </table>
                    </div>
                </div>
                <?php
                    $i++;                
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    var element = layui.element;
    element.on('tab(docDemoTabBrief)', function(data){
           currency($(this).attr('coin_id'));
           millassets($(this).attr('coin_id'));
    });


    // 币种
    function currency(coin_id) {
        let size = 20;
        let page = 1;
        $.ajax({
            type: 'POST',
            url: '/machinecontractorder/getuserlist',
            data:{
                coin_id:coin_id,
                size:size,
                page:page,
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(data.data){
                        let html = data.data.map((item, index) => {
                            //console.log(data)
                            return `<tr class="data">
                               <td style="max-width: 250px;">${item.machine_name}</td>
                                <td>${item.count}</td>
                                <td>${item.status_text}</td>
                                <td>${item.start_time_text}</td>
                                <td>${item.end_time_text}</td>
                                <td>${item.price}</td>
                                <td>${item.manage_fee}</td>
                                <td>${item.electricity_fee}/$</td>
                            </tr>`
                        });
                        $('.tbody').html(html.join(' '));
                    }

                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    currency($('.layui-this').attr('coin_id'));


    // 收益明细
    function millassets(coin_id) {
        let size = 20;
        let page = 1;
        $.ajax({
            type: 'POST',
            url: '/user/getmachinerecord',
            data:{
                id:coin_id,
                size:size,
                page:page
            },
            dataType: 'json',
            success: function(data){
                //  console.log(data);
                if(data.ret =='1') {  // 成功
                    if(data.data){
                        let html = data.data.map((item, index) => {
                            return `<tr>
                                   <td>${item.release_time}</td>
                                   <td>${item.count}</td>
                                   <td>${item.electricity_fee}</td>
                                    <td>${item.real_count}</td>
                                   <td>${item.manage_fee}</td>
                                   <td>0.00</td>
                               </tr>`
                        });
                        $('.coin').html(html.join(' '));
                    }

                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    millassets($('.layui-this').attr('coin_id'));
</script>
</body>
</html>
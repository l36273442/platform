<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','machine_detail');?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="dist/css/layui.css">
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
            margin-top: 72px;
            font-size: 48px;
            line-height: 66px;
        }
        .currency img{
            display: inline-block;
            width: 36px;
            height: 36px;
            background-size: 100% 100%;
        }
        .text{
            line-height: 48px;
            font-size: 20px;
            color: #9c9c9c;
        }
        .left1{
            width: 752px;
            float: left;
            margin-bottom: 50px;
        }
        .surplus{
            line-height: 100px;
            font-size: 22px;
            color: #0092da;
            margin-top: 54px;
        }
        .content{
            position: relative;
            width: 100%;
            margin: 0 190px 18px 0;
            height: 60px;
        }
        .buyinput{
            height: 56px;
            border: 2px solid #fff;
            border-radius: 3px;
            width: 376px;
            background: #15385b;
            line-height: 60px;
            padding-left: 20px;
            color: #fff;
        }
        .int_rig,.buy:hover{
                    color: #fff;
        }
        .trade{
            position: absolute;
            font-size: 22px;
            line-height: 60px;
            right: 50%;
        }
        .int_rig,.buy{
            text-align: center;
            line-height: 60px;
            position: absolute;
            margin-left: 16px;
            border-radius: 3px;
            font-size: 22px;
        }
        .int_rig{
            width: 158px;
            background: #15385b;
        }
        .buy{
            width: 160px;
            background: #42d06c;
            right: 0;
            color: #fff;
            cursor: pointer;
        }
        .active{
            width:100%;
            height: 50px;
            background: #192540;
            position: relative;
        }
        .bar{
            display: inline-block;
            width: 589px;
            height: 10px;
            position: absolute;
            background:-webkit-linear-gradient(left,transparent,#0092da);/* Safari 5.1 - 6.0 */
            background:-o-linear-gradient(right,transparent,#0092da);/* Opera 11.1 - 12.0 */
            background:-moz-linear-gradient(right,transparent,#0092da);/* Firefox 3.6 - 15 */
            background:linear-gradient(to right,transparent,#0092da);/* 标准*/
        }
        .progress{
            display: inline-block;
            line-height: 40px;
            font-size: 20px;
            padding: 10px 0 0 20px;
        }
        .right1{
            float: right;
        }
        .right1 .row{
            width: 262px;
            height: 80px;
            background: url("images/top-右侧背景@2x.png") no-repeat;
            background-size: 100% 100%;
            margin-bottom: 10px;
        }
        .right1 .row span{
            display: block;
            padding-left: 40px;
        }
        .right1 .row span b{
            font-size: 32px;
        }
        .right1 .row span:nth-child(1){
            color: #0092da;
            font-size: 22px;
            line-height: 40px;
        }
        .right1 .row span:nth-child(2){
            font-size: 16px;
        }
        .millleft{
            float: left;
            margin-bottom: 40px;
            width: 690px;
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
            background: url("images/anvantage-分割装饰@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .introduction{
            display: block;
            font-size: 22px;
            color: #696969;
            line-height: 30px;
            margin: 43px 0 8px 0;
        }
        .productlist{
            float: left;
            width: 305px;
        }
        .productlist li{
            line-height: 38px;
            color: #9c9c9c;
            font-size: 12px;
        }
        .productlist li i{
            float: left;
            width: 6px;
            height: 6px;
            background: url("images/菱形@2x.png") no-repeat;
            background-size: 100% 100%;
            margin: 15px 10px 0 0;
        }
        .figure{
            width: 372px;
            height: 304px;
            float: right;
            margin-top: 110px;
        }
        .figure img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
        .card{
            overflow: auto;
            clear: both;
            padding-top: 40px;
        }
        .card li{
            float: left;
            width: 380px;
            height: 280px;
            background: #232134;
            color: #fff;
            margin-right: 30px;
            position: relative;
        }
        .card li:last-child{
            margin-right: 0;
        }
        .cardleft1,.cardleft2,.cardleft3{
            position: absolute;
            width: 85px;
            height: 80px;
            top: 10px;
            left: 20px;
        }
        .cardleft1{
            background: url("images/卡片1icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardleft2{
            background: url("images/卡片2icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardleft3{
            background: url("images/卡片3icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardright1,.cardright2,.cardright3{
            position: absolute;
            right: 20px;
            top: 30px;
            width: 90px;
            height: 30px;
        }
        .cardright1{
            background: url("images/step-1@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardright2{
            background: url("images/step-2@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardright3{
            background: url("images/step-3@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .carline{
            position: absolute;
            top: 110px;
            z-index: 1;
            width: 200px;
            height: 16px;
            background:-webkit-linear-gradient(left,transparent,#0c73ac);/* Safari 5.1 - 6.0 */
            background:-o-linear-gradient(right,transparent,#0c73ac);/* Opera 11.1 - 12.0 */
            background:-moz-linear-gradient(right,transparent,#0c73ac);/* Firefox 3.6 - 15 */
            background:linear-gradient(to right,transparent,#0c73ac);/* 标准*/
        }
        .cardtext{
            line-height: 40px;
            font-size: 16px;
            position: absolute;
            z-index: 2;
            margin:90px 0 0 23px;
        }
        .cardcontent{
            position: absolute;
            top: 142px;
            font-size: 14px;
            line-height: 25px;
            margin: 13px 23px 0;
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
        .msk{
            width: 160px;
            background: transparent;
            right: 0;
            height: 64px;
            position: absolute;
            display: none;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="slDetail_cont">
    <div class="type_area">
        <p class="currency">
            <img src="<?php echo $coin['img_url'];?>" style="vertical-align: inherit;">
            <span><?php echo $coin['name'];?>+<?php echo $machine['name_'.Yii::app()->language];?></span>
        </p>
        <div class="left1">
            <p class="text"><?php echo $machine['content_'.Yii::app()->language];?></p>
            <p class="surplus"><?php echo Yii::t('power','surplus');?> <b class="num"> <?php echo ($detail['total']-$detail['deal_total']>0)?($detail['total']-$detail['deal_total']):0    ;?></b><?php echo Yii::t('common','stand');?></p>
            <p class="content">
                <input type="text" class="buyinput" placeholder="<?php echo floor($detail['price']);?> USD/<?php echo Yii::t('common','stand');?>" onkeyup="NumberCheck(this)">
                <span class="trade"><?php echo Yii::t('common','stand');?>=</span>
                <span class="int_rig"><b class="btczong">0</b> USD</span>
                <button class="buy"><?php echo Yii::t('common','buy');?></button>
                <button class="msk"></button>
            </p>
            <p class="active">
                <span class="bar"></span>
                <span class="progress"><?php echo Yii::t('power','sell');?> <?php echo ceil(($detail['deal_total']/$detail['total'])*100);?>%</span>
            </p>
        </div>
        <ul class="right1">
            <li class="row">
                <span><?php echo Yii::t('power','delivery_time');?></span>
                <span><b><?php echo $detail['pay_time'];?> <?php echo Yii::t('common','day');?></b></span>
            </li>
            <li class="row">
                <span><?php echo Yii::t('power','prower');?></span>
                <span><b><?php echo $machine['power_consumption'];?></b></span>
            </li>
            <li class="row">
                <span><?php echo Yii::t('power','management');?></span>
                <span><b><?php echo sprintf("%.2f",$machine['manage_fee']*100);?>%</b>&nbsp;&nbsp;<?php echo Yii::t('power','profit');?></span>
            </li>
            <li class="row">
                <span><?php echo Yii::t('power','electricity');?></span>
                <span><b><?php echo sprintf("%.4f",$machine['electricity_fee']);?></b>&nbsp;&nbsp;USD / <?php echo Yii::t('common','day');?></span>
            </li>
        </ul>
    </div>
</div>
<div class="cont">
    <div class="type_area">
        <div class="millleft">
        <p class="process"><?php echo $machine['name_'.Yii::app()->language];?></p>
            <p class="line"></p>
            <span class="introduction">
                <?php echo $machine['content_'.Yii::app()->language];?>
            </span>
            <ul class="productlist">
            <li>
                <i></i>
                <span><?php echo Yii::t('power','hash_rate');?>: <?php echo $machine['rated_power'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','qiang');?>: <?php echo $machine['power_consumption'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','mains_efficiency');?>: <?php echo $machine['mains_efficiency'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','chips_num');?>: <?php echo $machine['chips_num'];?></span>
            </li>
            </ul>
            <ul class="productlist">
            <li>
                <i></i>
                <span><?php echo Yii::t('power','cool_down');?>: <?php echo $machine['cool_down'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','work_temperature');?>: <?php echo $machine['work_temperature'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','work_humidity');?>: <?php echo $machine['work_humidity'];?></span>
            </li>
            <li>
                <i></i>
                <span><?php echo Yii::t('power','rated_voltage');?>: <?php echo $machine['rated_voltage'];?></span>
            </li>
            </ul>
        </div>

        <div class="figure">
        <img src="<?php echo $machine['img_url'];?>">
        </div>

        <p class="process"><?php echo Yii::t('power','purchase_process');?></p>
        <p class="line"></p>
        <ul class="card">
            <li>
                <i class="cardleft1"></i>
                <i class="cardright1"></i>
                <i class="carline"></i>
                <p class="cardtext"><?php echo Yii::t('power','recharge');?></p>
                <p class="cardcontent"><?php echo Yii::t('power','recharge_content');?></p>
            </li>
            <li>
                <i class="cardleft2"></i>
                <i class="cardright2"></i>
                <i class="carline"></i>
                <p class="cardtext"><?php echo Yii::t('power','hashrate_purchase');?></p>
                <p class="cardcontent"><?php echo Yii::t('power','hashrate_purchase_content');?></p>
            </li>
            <li>
                <i class="cardleft3"></i>
                <i class="cardright3"></i>
                <i class="carline"></i>
                <p class="cardtext"><?php echo Yii::t('power','profit_delivery');?></p>
                <p class="cardcontent"><?php echo Yii::t('power','profit_delivery_content');?></p>
            </li>
        </ul>
        <p class="process"><?php echo Yii::t('common','faqs');?></p>
        <p class="line"></p>

        <div class="layui-collapse">
            <?php  if(!empty($faqs)){
                        foreach($faqs as $v ){
            ?>
            <div class="layui-colla-item">
                <h2 class="layui-colla-title"><?php echo $v['title_'.Yii::app()->language];?></h2>
                <div class="layui-colla-content layui-show"><?php echo $v['content_'.Yii::app()->language];?></div>
            </div>
            <?php }
                }
            ?>
        </div>
    </div>
</div>

<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="dist/layui.all.js"></script>
<script>
    var element = layui.element;

    function NumberCheck(obj){
        let price = <?php echo $detail['price'];?> ;
        obj.value = obj.value.replace(/[^\d]/g, ""); //清除"数字"以外的字符
        $('.btczong').html(obj.value*price);
    }

     // 矿机购买
     $('.buy').on('click',function () {
            let id = window.location.search.substr(1).split('&')[0].split('=')[1];
            let number = $('.num').html();
            let count = $('.buyinput').val();
            if(count){
                 $('.msk').show();
                 $.ajax({
                      type: 'POST',
                      url: '/machinecontractorder/order',
                      data:{
                           id:id,
                           count:count
                      },
                      dataType: 'json',
                      success: function(data){
                           if(data.ret =='1') {  // 成功
                               $('.msk').hide();
                               layer.open({
                                  title: '矿机购买',
                                  content: '购买成功！',
                                  yes:function(index, layero){
                                  location.reload();
                               }
                             });
                         }else{
                              layer.msg(data.msg);
                         }
                      },
                      error: function (data) {
                            alert('fail!')
                      }
                 })
            }else{
                 layer.msg('请输入购买数量！');
         }
     });

</script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>首页</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/dist/css/layui.css">
    <style>
        .carousel div:nth-child(1){
            position: relative;
        }
         .carousel a{
                    display: block;
                    width: 100%;
                    height: 100%;
                }
        .slider-one{
            width: 1200px;
            position: absolute;
            color: #fff;
            left: 5%;
            top: 0;
        }
        .slider-one p{
            line-height: 100px;
            font-size: 60px;
        }
        .slider-one span{
            display: block;
            line-height: 78px;
            font-size: 22px;
        }
        .slider-one button{
            width: 238px;
            height: 78px;
            line-height: 80px;
            margin-top: 32px;
            font-size: 18px;
            text-align: center;
            border: 1px solid #fff;
            background: none;
            color: #fff;
            cursor: pointer;
        }
        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }
        .ks_top1 P{
            line-height: 60px;
            font-size: 34px;
            color: #696969;
            width: 620px;
        }
        .ks_top1 span{
            display: inline-block;
            line-height: 35px;
            color: #9c9c9c;
            margin: 25px 0;
             width: 450px;
        }
        .ks_top2{
            overflow: hidden;
        }
        .ks_top2 ul{
            margin: 88px 0 100px 0;
            overflow: auto;
        }
        .ks_top2 ul li{
            float: left;
            width: 255px;
            padding-left: 25px;
            height: 168px;
            background: url("/images/背景@2x.png") no-repeat;
            background-size: 100% 100%;
            margin-right: 26px;
            cursor: pointer;
        }
        .power{
            line-height: 50px;
            font-weight: 600;
            color: #009dea;
            font-size: 32px;
            margin-top: 26px;
        }
        .describe{
            line-height: 42px;
            font-size: 22px;
            color: #fff;
        }
        .ks_top3{
            background: #1c192e;
            color: #fff;
            padding-top: 76px;
            overflow: auto;
        }
        .shop{
            line-height: 98px;
            font-size: 46px;
        }
        .store{
            float: left;
            margin-right: 20px;
        }
        .store p{
            line-height: 76px;
            font-size: 32px;
        }
        .bg{
            width: 280px;
            height: 8px;
            background: url("/images/商店-分割装饰1@2x.png") no-repeat;
            background-size: 100% 100%;
            margin-bottom: 12px;
        }
        .situation{

        }
        .situation li{
        }
        .situation li i{
            display: inline-block;
            width: 10px;
            height: 10px;
            background: url("/images/商店圆点@2x.png") no-repeat;
            margin: 23px 10px 0 0;
        }
        .situation li  p{
            display: inline-block;
            line-height: 40px;
            font-size: 16px;
        }
        .situation li h5{
            width: 280px;
            height: 2px;
            background: url("/images/商店-分割装饰2@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .store .bigtext{
            float: left;
            line-height: 64px;
            font-size: 32px;
            color: #0092da;
        }
        .store .littletext{
            float: left;
            line-height: 54px;
            margin: 10px 0 0 15px;
            color: #0092da;
            font-size: 14px;
        }
        .selection{
            width: 114px;
            height: 38px;
            line-height: 40px;
            border: 1px solid #fff;
            text-align: center;
            clear: both;
            display: block;
            color: #fff;
            background: none;
            cursor: pointer;
            margin: 20px 0 128px 0;
        }
        .ks_top4{
            position: relative;
            overflow: auto;
        }
        .productleft{
            float: left;
            margin-bottom: 144px;
        }
        .bgicon{
            display: inline-block;
            width: 56px;
            height: 48px;
            z-index: -1;
            background: url("/images/组-1@2x.png") no-repeat;
            background-size: 100% 100%;
            margin:100px 0 28px 0;
        }
        .bgcircle{
            position: absolute;
            top: 100px;
            left: 390px;
            width: 300px;
            height: 300px;
            background: url("/images/商品背景装饰-园@2x.png") no-repeat;
        }
        .commodity{
            font-size: 32px;
            color: #009dea;
            line-height: 104px;
        }
        .linebg{
            width: 540px;
            height: 2px;
            background: url("/images/商品分割装饰@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .introduction{
            display: block;
            font-size: 22px;
            color: #696969;
            width: 700px;
            line-height: 30px;
            margin: 43px 0 8px 0;
        }
        .figure{
            width: 372px;
            height: 304px;
            float: right;
            margin-top: 200px;
        }
        .figure img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
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
            background: url("/images/菱形@2x.png") no-repeat;
            background-size: 100% 100%;
            margin: 15px 10px 0 0;
        }
        .card{
            overflow: auto;
            clear: both;
            margin-bottom: 160px;
        }
        .card li{
            float: left;
            width: 380px;
            height: 320px;
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
            background: url("/images/卡片1左侧-icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardleft2{
            background: url("/images/卡片2-左侧icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardleft3{
            background: url("/images/卡片3-左侧icon@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .cardright{
            position: absolute;
            right: 20px;
            top: 0;
            width: 57px;
            height: 41px;
            background: url("/images/卡片右侧@2x.png") no-repeat;
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
        .ks_top5{
            height: 800px;
            background:#f5f5f5;
            position: relative;
        }
        .printleft{
            position: relative;
            float: left;
            width: 500px;
            height: 560px;
            margin-top: 120px;
            background:-webkit-linear-gradient(left,#40ace1,transparent);/* Safari 5.1 - 6.0 */
            background:-o-linear-gradient(right,#40ace1,transparent);/* Opera 11.1 - 12.0 */
            background:-moz-linear-gradient(right,#40ace1,transparent);/* Firefox 3.6 - 15 */
            background:linear-gradient(to right,#40ace1,transparent);/* 标准*/
        }
        .printleft p{
            line-height: 78px;
            font-size: 38px;
            color: #fff;
            margin: 80px 0 0 50px;
        }
        .bgmine{
            width: 315px;
            height: 145px;
            background: url("/images/MINE@2x.png") no-repeat;
            background-size: 100% 100%;
            position: absolute;
            top: 155px;
            left: 50px;
            z-index: 2;
        }
        .printright{
            overflow: auto;
            position: absolute;
            z-index: 1;
            width: 72%;
            right: 0;
            top: 88px;
        }
        .printright li{
            float: left;
            width: 440px;
            height: 310px;
            margin: 0 0 10px 10px;
        }
        .printright li img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
        .ks_top6{
            height: 465px;
        }
        .sponsor{
            line-height: 240px;
            font-size: 24px;
            color: #009dea;
            text-align: center;
        }
        .auspice{
            overflow: auto;
        }
        .auspice li{
            float: left;
            width: 25%;
        }
        .auspice li img{
            width: 120px;
            height: 50px;
            background-size: 100% 100%;
            margin:20px 0 0 112px;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>

<div class="layui-carousel" id="test1">
    <div carousel-item class="carousel">
      <!--  <div style="background: greenyellow;"></div>
        <div style="background: pink;"></div>
        <div style="background: palevioletred;"></div>
        <div style="background: orange;"></div>
        <div style="background: brown;"></div> -->
    </div>
</div>

<!-- <div class="slider-one">
    <p style="margin-top: 60px;">MINES CAPITAL</p>
    <p>CONSTRUCTION CONTRACT</p>
    <span>LOW COST'HIGH PROFIT MORE SECURE</span>
    <button>CLICK FOR DETALS&nbsp;&nbsp;&nbsp;&nbsp;> </button>
</div> -->
<!--  版心 -->
<div class="type_area"></div>
<div class="ks_top1 type_area">
<p style="margin-top: 65px;"><?php echo $info['title_'.Yii::app()->language];?></p>
        <span><?php echo $info['introduction_'.Yii::app()->language];?>
       </span>
    </div>
<div class="ks_top2 type_area">
        <ul>
            <li>
            <p class="power"><?php echo $block['all_network_power'];?></p>
                <p class="describe"><?php echo Yii::t('power','all_network_power');?></p>
            </li>
            <li>
                <p class="power"><?php echo $block['next_difficulty_time'];?></p>
                <p class="describe"><?php echo Yii::t('power','next_difficulty_time');?></p>
            </li>
            <li>
                <p class="power"><?php echo $block['next_last_block'];?></p>
                <p class="describe"><?php echo Yii::t('power','next_last_block');?></p>
            </li>
            <li style="margin-right: 0;">
                <p class="power"><?php echo $block['seven_median'];?></p>
                <p class="describe"><?php echo Yii::t('power','seven_median');?></p>
            </li>
        </ul>
    </div>
<div class="ks_top3">
    <div class="type_area">
        <p class="shop"><?php echo Yii::t('power','power_shop');?></p>
        <?php foreach( $power as $v ){  ?>
        <div class="store">
            <p><?php echo $v['name'];?></p>
            <div class="bg"></div>
            <ul class="situation">
                
                <li>
                    <i class="icon"></i>
                    <p><?php echo Yii::t('power','power_consumption');?>:&nbsp;<?php echo $v['power_consumption'];?></p>
                </li>
                
                <li>
                    <h5></h5>
                    <i class="icon"></i>
                    <p><?php echo Yii::t('power','deadline');?>:&nbsp;<?php echo Yii::t('power','lifelong');?></p>
                </li>
                <li>
                    <h5></h5>
                    <i class="icon"></i>
                    <p><?php echo Yii::t('power','maintenance_fee');?>:&nbsp;<?php echo $v['manage_fee'];?>%profit</p>
                </li>
                <li>
                    <h5></h5>
                    <i class="icon"></i>
                    <p><?php echo Yii::t('power','payment_methods');?>:&nbsp;usd</p>
                </li>
                <li>
                    <h5></h5>
                    <i class="icon"></i>
                    <p><?php echo Yii::t('power','minimum_purchase_unit');?>:&nbsp;<?php echo $v['min_buy_number'];echo $v['unit_name'];?></p>
                </li>
            </ul>
            <span class="bigtext">usd&nbsp;<?php echo $v['price'];?>/<?php echo $v['unit_name'];?></span>
            <span class="littletext"><?php echo Yii::t('power','minimum');?></span>
            <a class="selection" href="/powercontractview/detail?id=<?php echo $v['id'];?>"><?php echo Yii::t('power','selection');?>&nbsp;&nbsp;&nbsp;&nbsp;></a>
        </div>
        <?php }?>
    </div>
</div>
<div class="ks_top4 type_area">
    <div class="productleft">
        <i class="bgicon"></i>
        <i class="bgcircle"></i>
        <p class="commodity"><?php echo $machine['name_'.Yii::app()->language];?></p>
        <h5 class="linebg"></h5>
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
        <img src="/images/kuangji.png">
    </div>
    <ul class="card">
        <li>
                <i class="cardleft1"></i>
                <i class="cardright"></i>
                <i class="carline"></i>
            <p class="cardtext"><?php echo Yii::t('power','machine_select');?></p>
            <p class="cardcontent"><?php echo Yii::t('power','machine_select_content');?></p>
        </li>
        <li>
            <i class="cardleft2"></i>
            <i class="cardright"></i>
            <i class="carline"></i>
            <p class="cardtext"><?php echo Yii::t('power','standard_management');?></p>
            <p class="cardcontent"><?php echo Yii::t('power','standard_management_content');?></p>
        </li>
        <li>
            <i class="cardleft3"></i>
            <i class="cardright"></i>
            <i class="carline"></i>
            <p class="cardtext"><?php echo Yii::t('power','risk_control');?></p>
            <p class="cardcontent"><?php echo Yii::t('power','risk_control_content');?></p>
        </li>
    </ul>
</div>
<div class="ks_top5">
    <div class="type_area location">
        <div class="printleft">
            <p>MINE LIST</p>
            <div class="bgmine"></div>
        </div>
        <ul class="printright">
            <li><img src="/images/kc_1.jpg"></li>
            <li><img src="/images/kc_2.jpg"></li>
            <li><img src="/images/kc_3.jpg"></li>
            <li><img src="/images/kc_4.jpg"></li>
        </ul>
    </div>
</div>
<div class="ks_top6">
    <div class="type_area">
        <p class="sponsor"><?php echo Yii::t('common','partner');?></p>
        <ul class="auspice">
            <?php foreach( $partner as $v ){?>
            <li><img src="<?php echo $v['img_url'];?>"></li>
            <?php }?>
        </ul>
    </div>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>


<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/dist/layui.all.js"></script>
<script>
 // 轮播图
      var carousel = layui.carousel;

    function fn() {
        $.ajax({
            type: 'GET',
            url: '/ads/getimgads',
            data:{},
            dataType: 'json',
            success: function(data){
               // console.log(data);
                if(data.ret =='1') {  // 成功
                    if(data.data.length>0){
                        $.each(data.data, function (index, item) {
                            //console.log(item);
                            $('.carousel').append(`<div><a href=${item.url}><img src=${item.img_url}></a></div>`);
                        });
                        //建造实例
                        carousel.render({
                            elem: '#test1',
                            width: '100%', //设置容器宽度
                            height:'700px',
                            arrow: 'hover' //悬停显示箭头
                        });
                    }
                }
            }
        })
    }
    fn();

</script>
</body>
</html>

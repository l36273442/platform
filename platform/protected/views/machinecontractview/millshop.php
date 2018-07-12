<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','machine_shop');?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="dist/css/layui.css">
    <style>
        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }
        .millshop{
           height: 520px;
            background: url("images/top-bg@2x.png") no-repeat;
            background-size: 100% 100%;
            color: #fff;
        }
        .shoptext1{
            margin-top: 130px;
            line-height: 114px;
            font-size: 80px;
        }
        .shoptext2{
            line-height: 62px;
            font-size: 30px;
        }
        .shop{
            overflow: auto;
            margin: -140px auto 120px;
            color: #fff;
        }
        .mill{
            float: left;
            width: 380px;
            background: url("images/背景@2x.png") no-repeat;
            background-size: 100% 100%;
            margin:0 30px 30px 0;
        }
        .mar_rig{
            margin-right: 0;
        }
        .one{
            padding:30px 0 15px 20px;
        }
        .one img{
            width: 37px;
            height: 37px;
            background-size: 100% 100%;
        }
        .one span{
            line-height: 38px;
            font-size: 22px;
            display: inline-block;
            margin-left: 20px;
        }
        .two{
            padding: 10px 0;
            height: 252px;
        }
        .two img{
            display: block;
            max-width: 100%;
            height: 100%;
            margin: 0 auto;
            background-size: 100% 100%;
        }
        .three{
            height: 60px;
            line-height: 60px;
            font-size: 22px;
            padding-left: 20px;
            background:-webkit-linear-gradient(left,#0092da,transparent);/* Safari 5.1 - 6.0 */
            background:-o-linear-gradient(right,#0092da,transparent);/* Opera 11.1 - 12.0 */
            background:-moz-linear-gradient(right,#0092da,transparent);/* Firefox 3.6 - 15 */
            background:linear-gradient(to right,#0092da,transparent);/* 标准*/
        }
        .four{
            line-height: 80px;
            font-size: 26px;
            padding-left: 20px;
        }
        .buy {
            float: right;
            margin: 20px;
            width: 100px;
            height: 40px;
            line-height: 40px;
            font-size: 16px;
            background: #42d06c;
            border-radius: 4px;
            color: #fff;
            border: none;
            cursor: pointer;
            text-align:center;
        }
        .nobuy{
            background: #acb0bb;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="millshop">
    <div class="type_area">
        <p class="shoptext1"><?php echo Yii::t('common','machine_shop');?></p>
        <p class="shoptext2"><?php echo Yii::t('common','shop_income_sm');?></p>
    </div>

</div>
<ul class="shop type_area">
    <!--<li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill mar_rig">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill mar_rig">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>
    <li class="mill mar_rig">
        <p class="one">
            <img src="images/bc_logo_@2x.png">
            <span>BTH+S9NHBA</span>
        </p>
        <p class="two">
            <img src="">
        </p>
        <p class="three">交割时间&nbsp;<span class="day">15</span>天</p>
        <p class="four">
            <span>$ 2.50 USTD</span>
            <a href="#" class="buy">BUY</a>
        </p>
    </li>-->
</ul>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="dist/layui.all.js"></script>
<script>
    function millshop() {
        let size = 20;
        $.ajax({
            type: 'POST',
            url: '/machinecontract/getlist',
            data:{size:size},
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(data.data){
                        let html = data.data.map((item, index) => {
                            console.log(item);
                           // console.log(item.deal_total,item.total);
                            return `<li class="mill" id=${item.id}>
                                      <p class="one">
                                         <img src=${item.coin_img_url}>
                                         <span>${item.coin_name}+${item.machine_name}</span>
                                      </p>
                                      <p class="two">
                                         <img src=${item.machine_img_url}>
                                      </p>
                                      <p class="three"><?php echo Yii::t('common','delivery_time');?>&nbsp;<b>${item.pay_time}</b><?php echo Yii::t('common','day');?></p>
                                      <p class="four">
                                         <span>$ <b>${item.price}</b> USD</span>
                                         <button class="buy"><?php echo Yii::t('common','buy');?></button>
                                       </p>
                                 </li>`
                        });
                        $('.shop').html(html.join(' '));
                    }
                }else{
                    layer.msg(data.msg);
                }
            },
            error: function (data) {
                alert('fail！')
            }
        })
    }
    millshop();

    // 矿机详情
    $('.shop').on('click','.mill', function (e) {
        let id = $(this).attr('id');
        window.location.href="machinecontractview/detail?id="+id;
    });

</script>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
</body>
</html>

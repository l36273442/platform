<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','manage_address');?></title>

    <style>
        .customer{
            background: #1c192e;
            position: relative;
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
        div.layui-tab-content,div.layui-tab{
            margin-bottom: 360px;

            padding: 0;
        }
        div.layui-tab-item.layui-show{
            overflow: auto;
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
        .address{
            width: 153px;
            border: 1px solid #494758;
            padding: 98px 210px 57px;
            float: left;
        }
        .currency{
            width: 160px;
            height: 26px;
            padding: 16px 0;
            position: relative;
            border: 1px solid #fff;
        }
        .currency span{
            font-size: 22px;
            color: #a8a8ac;
        }
        .unit,.add{
            display: inline-block;
            width: 72px;
            text-align: center;
        }
        .currency .add{
            color: #fff;
            font-size:50px;
            position: absolute;
            bottom: 0;
            cursor: pointer;
        }
        .affixion{
            line-height: 98px;
            font-size: 20px;
            color: #fff;
        }
        .affixion b{
            font-weight: 500;
        }
        #address{
           float: right;
           width: 576px;
        }
        .account{
            width: 453px;
            border: 1px solid #494758;
            background: #252236;
            padding: 56px 60px;
            margin-bottom: 20px;
        }
        .details{
            text-align: center;
            line-height: 36px;
            font-size: 18px;
            color: #fff;
            margin-bottom: 45px;
        }
        .location{
            border: 1px solid #514e5e;
            width: 100%;
            height: 38px;
            line-height: 38px;
            background: none;
            font-size: 15px;
            color: #0092da;
            text-align: center;
            margin-bottom: 40px;
        }
        .delete{
            width: 110px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: none;
            background: #009dea;
            font-size: 16px;
            border-radius: 4px;
            margin-left: 170px;
            color: #fff;
            cursor: pointer;
        }
        .mask{
            width: 498px;
            z-index: 10;
            background: #fff;
            border-radius: 4px;
            position: absolute;
            left: 30%;
            top: 15%;
            padding: 10px 60px 40px 0;
            display: none;
        }
        .add_title{
            line-height: 86px;
            font-size: 24px;
            color: #009dea;
            text-align: center;
        }
        .add_list{
            margin-bottom: 20px;
        }
        .add_list span{
            display: inline-block;
            width: 90px;
            text-align: right;
            margin-right: 18px;
            line-height: 32px;
            color: #009dea;
        }
        .add_list input{
            border: none;
            width: 334px;
            height: 32px;
            color: #9c9c9c;
            line-height: 32px;
            border-left: 4px solid #009dea;
            box-shadow: 5px 10px 10px #efeff0;
            padding-left: 10px;
        }
        .add_list .code{
            width: 210px;
            margin-right: 10px;
        }
        .add_list .send{
            width: 108px;
            line-height: 32px;
            background: #009dea;
            text-align: center;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .accretion li button{
            width: 130px;
            height: 32px;
            line-height: 32px;
            border: none;
            border-radius: 4px;
            margin-right: 30px;
            color: #fff;
            cursor: pointer;
        }
        .submit{
            background: #009dea;
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
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="customer">
    <div class="type_area">
        <p class="user_title1">
            <a href="#" style="color: #74737b;"><?php echo Yii::t('common','home');?> / </a>
            <span><?php echo Yii::t('common','manage_address');?></span>
        </p>

        <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
            <ul class="layui-tab-title">
                <?php 
                    if( $coin ){
                        $i=0;
                        $len = count($coin)-1;
                        foreach($coin as $v ){
                ?>
                    <li <?php echo ($i==0)?'class="layui-this very"':'';?> coin_id="<?php echo $v['id'];?>" str="<?php echo strtoupper($v['name']);?>"><?php echo strtoupper($v['name']);?></li><?php if($i!=$len) echo '&nbsp;&nbsp;|&nbsp;&nbsp;';?>
                <?php
                   $i++;
                    }
                }
                ?>
            </ul>

            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <div id="content">

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- 添加 -->
    <div class="mask">
        <p class="add_title"><?php echo Yii::t('common','add');?><?php echo Yii::t('common','address');?></p>
        <ul class="accretion">
            <li class="add_list">
                <span><?php echo Yii::t('common','address');?></span>
                <input type="text" class="group">
            </li>
            <li class="add_list">
                <span><?php echo Yii::t('common','address');?><?php echo Yii::t('common','remark');?></span>
                <input type="text" class="remark">
            </li>
            <li class="add_list">
                <span><?php echo Yii::t('common','transaction_password');?></span>
                <input type="text" class="password">
            </li>
           <!-- <li class="add_list">
                <span>手机验证码</span>
                <input type="text" class="code">
                <span class="send">发送验证码</span>
            </li>-->
            <li style="margin:30px 0 0 150px;">
               <button class="cancel"><?php echo Yii::t('common','cancel');?></button>
               <button class="submit"><?php echo Yii::t('common','submit');?></button>
            </li>
        </ul>
        <div class="close"><img src="images/icon_close@2x.png"></div>
    </div>
</div>
 <?php require(dirname(__FILE__).'/../footer.php'); ?>
<script>
    var element = layui.element;

    let appentHtml=(obj)=>{
        $('#content').html( `<div class="address">
                        <p class="currency">
                            <span class="unit">${obj.str}</span>
                            <span>| </span>
                            <span class="add" coin_id=${obj.coin_id}> + </span>
                        </p>
                        <p class="affixion">添加&nbsp;<b>${obj.str}</b>&nbsp;地址</p>
                    </div>
                    <div id="address">

                     </div>`)
    }
    appentHtml({str:$('.very').attr('str'),coin_id:$('.very').attr('coin_id')});

    // 获取币种地址
    function render(obj){
        $.ajax({
            type: 'POST',
            url: '/coin/getusercoinaddress',
            data:{
                coin_id :obj.coin_id,
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                if(data.ret =='1') {  // 成功
                    if(Array.isArray(data.data)){
                        let html = data.data.map((item, index) => {
                            return `<div class="account">
                        <p class="details">账户地址</p>
                        <input type="text" class="location" value=${item.address}>
                         <button class="delete">删除</button>
                        </div>`
                        });
                        $('#address').html(html.join(' '));
                    }else{
                        $('#address').html(' ');
                    }

                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    render({coin_id:$('.very').attr('coin_id')});

    element.on('tab(docDemoTabBrief)', function(data){
        appentHtml({str:$(this).attr('str'),coin_id:$(this).attr('coin_id')});
        render({coin_id:$(this).attr('coin_id')});
    });

    // 添加
    $('#content').on('click','.add',function () {
        window.coin_id=$(this).attr('coin_id');
         $('.mask').show();
         $('.group').val(' ');
         $('.remark').val(' ');
         $('.password').val(' ');
    })

    // 提交  添加币种地址
    $('.submit').on('click',function () {
        let address = $('.group').val(),
            coin_id=window.coin_id,
            remark = $('.remark').val(),
            tpassword = $('.password').val();
        $.ajax({
            type: 'POST',
            url: '/coin/addaddress',
            data:{
                address: address   ,
                coin_id :coin_id ,
                remark: remark,
                tpassword:tpassword
            },
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data.ret =='1') {  // 成功
                    layer.msg('success');
                    setTimeout(function () {
                        window.location.reload();
                    },1500)
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    })

    // 取消
    $('.cancel').on('click',function () {
        $('.mask').hide();
    })

    // 关闭 X
    $('.close').on('click',function () {
        $('.mask').hide();
    })
</script>
</body>
</html>

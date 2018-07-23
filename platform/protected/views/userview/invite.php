<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','invite');?></title>
    <style>
        .bg{
            width: 100%;
            height: 520px;
            background: url("/images/bg@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .bg p{
            text-align: center;
            line-height: 520px;
            font-size: 80px;
            color: #fff;
        }
        .type_area{
            width: 1200px;
            margin: 0 auto;
            overflow: auto;
        }
        .details{
            background: #1c192e;
        }
        .section1{
            margin: 50px 0 40px 0;
            overflow: auto;
        }
        .section1_left{
            float: left;
            border: 2px solid #494758;
            width: 61%;
            height:202px;
            padding: 30px 0 0 30px
        }
        .ask{
            float: left;
            width: 146px;
            height: 146px;
            border: 1px solid #696969;
            margin-right: 20px;
        }
        canvas{
            margin: 3px;
            width: 140px;
            height: 140px;
            background-size: 100% 100%;
        }
        .address li{
            line-height: 56px;
            float: left;
            width: 75%;
        }
        .address li span:nth-child(1){
            display: inline-block;
            font-size: 16px;
            color: #777582;
            width: 80px;
        }
        #input,#input2,#input3{
            background: none;
            border: none;
            font-size: 16px;
            color: #0092da;
            width: 68%;
        }
        .copy{
            display: inline-block;
            border: 1px solid #fff;
            height: 38px;
            width: 80px;
            line-height: 40px;
            text-align: center;
            font-size: 16px;
            color: #fff;
        }
        .section1_right{
            float: right;
            width: 34%;
            height:232px;
            border: 2px solid #494855;
        }
        .recommend,.friend{
            height: 87px;
            line-height: 87px;
            background: #24203a;
            color: #fff;
            font-size: 24px;
            padding: 0 30px;
        }
        .recommend span{
            float: left;
            width: 50%;
            text-align: right;
            position: relative;
        }
        .recommend span:nth-child(1){
            width: 40%;
        }
        .recommend span:nth-child(2){
             width: 60%;
        }
        .icon_1{
            position: absolute;
            top: 26px;
            left: -15px;
            width: 28px;
            height: 28px;
            background: url("/images/推荐icon@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .icon_2{
            position: absolute;
            top: 30px;
            left: 55px;
            width: 19px;
            height: 26px;
            background: url("/images/获得算力@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .obtain{
            overflow: auto;
        }
        .obtain li{
             text-align: center;
             float: left;
             font-size: 26px;
             color: #0092da;
             line-height: 47px;
        }
        .obtain li:nth-child(1){
             width: 40%;
        }
        .obtain li:nth-child(2){
             width: 60%;
        }
        .obtain li span{
            display: block;
        }
        .obtain li span b:nth-child(1){
            display: inline-block;
            width: 65px;
        }
        .section2{
            margin-bottom: 40px;
            overflow: auto;
        }
        .section2_left,.section2_right{
            border: 2px solid #494758;
        }
        .section2_left{
            float: left;
            width: 30%;
        }
        .section2_right{
            float: right;
            width: 68%;
        }
        .icon_3,.icon_4,.icon_5{
            display: inline-block;
            vertical-align: sub;
            margin-right: 10px;
        }
        .icon_3{
            width: 35px;
            height: 30px;
            background: url("/images/推荐的朋友@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .icon_4{
            width: 34px;
            height: 34px;
            background: url("/images/奖励算力记录@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .icon_5{
            width: 26px;
            height: 33px;
            background: url("/images/推荐细则@2x.png") no-repeat;
            background-size: 100% 100%;
        }
        .my_friend{
            padding: 18px 30px 20px;
            font-size: 16px;
        }
        .my_friend li{
           overflow: auto;
            color: #a8a8ac;
        }
        .my_friend li:nth-child(1){
            color: #868490;
        }
        .my_friend li span{
            float: left;
            width: 50%;
            line-height: 34px;
        }
        .my_friend li .log{
            width: 25%;
        }
        .section3{
            border: 2px solid #494758;
            margin-bottom: 70px;
        }
        .rule{
            padding: 17px 30px 30px;
            color: rgba(255,255,255,0.5);
            font-size: 16px;
        }
        .rule h5{
            line-height: 38px;
        }
        .rule p{
            margin-top: 20px;
            line-height: 38px;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="bg"><p><?php echo Yii::t('common','invite');?>&nbsp;&nbsp;<?php echo Yii::t('common','shared_revenue');?></p></div>
<div class="details">
    <div class="type_area">
        <div class="section1">
            <div class="section1_left">
                <p class="ask"></p>
                <ul class="address">
                    <li>
                        <span><?php echo Yii::t('common','my_invite_code');?></span>
                        <input type="text" id="input" value="<?php echo $invite['invite_code'];?>">
                        <span class="copy" onclick="copyText()"><?php echo Yii::t('common','copy');?></span>
                    </li>
                    <li>
                        <span><?php echo Yii::t('common','invite_url');?></span>
                        <input type="text" id="input2" value="<?php echo $invite_url;?>">
                        <span class="copy" onclick="copyText2()"><?php echo Yii::t('common','copy');?></span>
                    </li>
                    <!--
                    <li>
                        <span>基建推荐</span>
                        <input type="text" id="input3" value="">
                        <span class="copy" onclick="copyText3()">复制</span>
                    </li>
                    -->
                </ul>
            </div>
            <div class="section1_right">
                <p class="recommend">
                    <span><i class="icon_1"></i><?php echo Yii::t('common','recommend_friends');?></span>
                    <span><i class="icon_2"></i><?php echo Yii::t('common','gained_power');?></span>
                </p>
                <ul class="obtain">
                <li><?php echo $invite['sum'];?></li>
                    <li>
                        <?php 
                            if($coins){
                                foreach($coins as $v ){
                        ?>
                            <span><b><?php echo $v['coin_name'];?></b> <b><?php echo $v['total_invite_power'];?></b><?php echo $v['unit_name'];?></span>
                        <?php
                            }
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="section2">
            <div class="section2_left">
                <p class="friend">
                    <i class="icon_3"></i>
                    <span><?php echo Yii::t('common','recommended_friend');?></span>
                </p>
                <ul class="my_friend">
                    <li>
                        <span><?php echo Yii::t('common','phone_number');?></span>
                        <span><?php echo Yii::t('common','time');?></span>
                    </li>
                    <?php
                        if($friends){ 
                            foreach( $friends as $v){
                    ?>  
                    <li>
                    <span><?php echo $v['phone'];?></span>
                    <span><?php echo $v['ctime_text'];?></span>
                    </li>
                    <?php 
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="section2_right">
                <p class="friend">
                    <i class="icon_4"></i>
                    <span><?php echo Yii::t('common','reward_power_record');?></span>
                </p>
                <ul class="my_friend">
                    <li>
                        <span class="log"><?php echo Yii::t('common','name');?></span>
                        <span class="log"><?php echo Yii::t('common','coin_name');?></span>
                        <span class="log"><?php echo Yii::t('common','count');?></span>
                        <span class="log"><?php echo Yii::t('common','time');?></span>
                    </li>
                    <?php
                        if( $reward ){
                            foreach( $reward as $v){
                    ?>
                    <li>
                        <span class="log"><?php echo Yii::t('common',$v['name']);?></span>
                        <span class="log"><?php echo $v['coin_name'];?></span>
                        <span class="log"><?php echo $v['count'];?></span>
                        <span class="log"><?php echo $v['ctime_text'];?></span>
                    </li>

                    <?php 
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="section3">
            <p class="friend">
                <i class="icon_5"></i>
                <span><?php echo Yii::t('common','recommended_rules');?></span>
            </p>
            <div class="rule">
                <h5><?php echo Yii::t('common','recommended_rules1');?></h5>
                <h5><?php echo Yii::t('common','recommended_rules2');?></h5>
                <h5><?php echo Yii::t('common','recommended_rules3');?></h5>
                <h5><?php echo Yii::t('common','recommended_rules4');?></h5>
                <p><?php echo Yii::t('common','pay_attention');?></p>
                <h5><?php echo Yii::t('common','pay_attention_content');?></h5>
            </div>
        </div>
    </div>
</div>
<script src="/js/jquery.qrcode.js"></script>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script>
   // 二维码
    let ewm = $('#input2').val();
       $('.ask').qrcode(ewm);

    // 复制ID
    function copyText() {
        var text = document.getElementById("input").value;
        var input = document.getElementById("input");
        input.value = text; // 修改文本框的内容
        input.select(); // 选中文本
        document.execCommand("copy"); // 执行浏览器复制命令
        layer.msg('ID已复制');
    }

    // 复制推荐链接
    function copyText2() {
        var text = document.getElementById("input2").value;
        var input = document.getElementById("input2");
        input.value = text; // 修改文本框的内容
        input.select(); // 选中文本
        document.execCommand("copy"); // 执行浏览器复制命令
        layer.msg('推荐链接已复制');
    }

    // 复制基建链接
    function copyText3() {
        var text = document.getElementById("input3").value;
        var input = document.getElementById("input3");
        input.value = text; // 修改文本框的内容
        input.select(); // 选中文本
        document.execCommand("copy"); // 执行浏览器复制命令
        layer.msg('基建链接已复制');
    }

</script>
</body>
</html>

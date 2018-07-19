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
            width:59%;
            padding: 30px;
        }
        .ewm{
            float: left;
            width: 148px;
            height: 148px;
            margin: 10px 20px 10px 0;
        }
        .ewm img{
            width: 100%;
            height:100%;
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
        input[type="text"]{
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
        .recommend span i{
            position: absolute;
            top: 30px;
            left: 20px;
        }
        .icon_1{
            width: 28px;
            height: 28px;
            background: url("/images/推荐icon@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .icon_2{
            width: 19px;
            height: 26px;
            background: url("/images/获得算力@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .message{
            overflow: auto;
        }
        .message li{
            float: left;
            font-size: 32px;
            color: #0092da;
            line-height: 47px;
            padding: 0 65px;
        }
        .message li span{
            display: block;
        }
        .message li span b:nth-child(1){
            display: inline-block;
            width: 65px;
        }
        .section2{
            margin-bottom: 40px;
            overflow: auto;
        }
        .section2_left,.section2_right{
            border: 2px solid #494758;
            height: 228px;
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
            width: 20%;
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
                <p class="ewm"><img src=""></p>
                <ul class="address">
                    <li>
                        <span><?php echo Yii::t('common','my_invite_code');?></span>
                        <input type="text" id="input" value="<?php echo $invite['invite_code'];?>">
                        <span class="copy" onclick="copyText()">复制</span>
                    </li>
                    <li>
                        <span><?php echo Yii::t('common','invite_url');?></span>
                        <input type="text" id="input2" value="<?php echo $invite_url;?>">
                        <span class="copy" onclick="copyText2()">复制</span>
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
                <ul class="message">
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
                    <span>推荐的朋友</span>
                </p>
                <ul class="my_friend">
                    <li>
                        <span>手机号</span>
                        <span>时间</span>
                    </li>
                    <li>
                        <span>18022287654</span>
                        <span>2018-05-27 17:55:50</span>
                    </li>
                    <li>
                        <span>18611119282</span>
                        <span>2018-05-27 17:55:50</span>
                    </li>
                </ul>
            </div>
            <div class="section2_right">
                <p class="friend">
                    <i class="icon_4"></i>
                    <span>奖励算力记录</span>
                </p>
                <ul class="my_friend">
                    <li>
                        <span class="log">名称</span>
                        <span class="log">矿机</span>
                        <span class="log">单价</span>
                        <span class="log">数量</span>
                        <span class="log">时间</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="section3">
            <p class="friend">
                <i class="icon_5"></i>
                <span>推荐细则</span>
            </p>
            <div class="rule">
                <h5>1.一旦您推荐用户购买算力，您可以获得3%的算力返点 (算力资产 - 算力明细可查看)。</h5>
                <h5>2.MCC.TOP保留随时共享收益规则进行调整的权利，但是对您推荐的好友数量没有限制。</h5>
                <h5>3.被推荐人必须使用您的推荐链接、二维码或者推荐ID注册才可以。</h5>
                <h5>4.MCC.TOP会严查重复的或者虚假账户，一经发现，将不会支付共享利益。重复账户或者共享资金是不合格的。</h5>
                <p>特别注意:</p>
                <h5>由于市场环境的改成，欺诈风险的存在原因，MCC.TOP保留随时对共享收益规则做出调整的最终解释权。</h5>
            </div>
        </div>
    </div>
</div>

<script>
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

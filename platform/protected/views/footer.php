
    <style>
        .footer{
            width: 100%;
            height: 438px;
            background: #12101d;
            color: #fff;
        }
        .center{
            width: 1200px;
            height: 100%;
            margin: 0 auto;
        }
        .left{
            float: left;
        }
        .minebit{
            line-height: 200px;
            font-size: 26px;
        }
        .message{
            overflow: auto;
            line-height: 30px;
        }
        .message li{
            float: left;
            margin-right: 50px;
            font-size: 14px;
        }
        .message li a{
            color: #fff;
        }
        .middle{
            float: left;
            width: 480px;
        }
        .middle p{
            line-height: 97px;
            font-size: 20px;
            margin-top: 50px;
            text-align: center;
        }
        .ewm{
            width: 135px;
            height: 135px;
            border-radius: 4px;
            background: grey;
            margin-left: 167px;
        }
        .middle span{
            width: 100%;
            line-height: 94px;
            font-size: 16px;
            color: #7d7c82;
            margin-top: 62px;
            display: inline-block;
            text-align: center;
        }
        .right{
            float: left;
        }
        .right p{
            line-height: 97px;
            margin-top: 48px;
            font-size: 20px;
        }
        .relation li{
            height: 45px;
            line-height: 45px;
            clear: both;
            font-size: 14px;
            margin-bottom: 17px;
        }
        .circle{
            float: left;
            width: 45px;
            height: 45px;
            margin-right: 28px;
        }
        .circle img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
    </style>


<footer class="footer">
    <div class="center">
        <div class="left">
            <p class="minebit">M I N E B I T</p>
            <ul class="message">
                <li><a href="/powercontractview/shop"><?php echo Yii::t('common','power_shop');?></a></li>
                <li><a href="/machinecontractview/shop"><?php echo Yii::t('common','machine_shop');?></a></li>
                <li><a href="/site/faqs"><?php echo Yii::t('common','faqs');?></a></li>
                <li><a href="/site/about"><?php echo Yii::t('common','about');?></a></li>
            </ul>
        </div>
        <div class="middle">
            <p>WECHAT CUSTOMER SERVICE</p>
            <div class="ewm"></div>
            <span>Copyright © 2018 MineBit Co.，Limited</span>
        </div>
        <div class="right">
        <p><?php echo Yii::t('common','customer_sercvice');?></p>
            <ul class="relation">
                <li>
                    <div class="circle"><img src="/images/wechat@2x.png"></div>
                    <span><?php echo Yii::t('common','wechat');?> : <?php  echo $info['wechat1'];?></span>
                </li>
                <li>
                    <div class="circle"><img src="/images/Phone@2x.png"></div>
                    <span><?php echo Yii::t('common','service_tell');?> : <?php echo $info['phone'];?></span>
                </li>
                <li>
                    <div class="circle"><img src="/images/business@2x.png"></div>
                    <span><?php echo Yii::t('common','business');?> : <?php echo $info['email'];?></span>
                </li>
            </ul>
        </div>
    </div>
</footer>

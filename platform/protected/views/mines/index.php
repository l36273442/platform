<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','mines');?></title>
    <style>
        .slDetail_cont{
            background: #1c192e;
            height: 520px;
            color: #fff;
        }
        .type_area{
            width: 1200px;
            margin: -520px auto 0;
            overflow: auto;
        }
        .mines{
           line-height: 160px;
           text-align: center;
           font-size: 60px;
           color: #fff;
        }
        .process{
            line-height: 102px;
            font-size: 32px;
            color: #fff;
        }
        .line{
            width: 530px;
            height: 2px;
            background: url("/images/anvantage-分割装饰@2x.png")no-repeat;
            background-size: 100% 100%;
        }
        .card{
            overflow: auto;
            clear: both;
            margin-top: 40px;
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
            font-size: 16px;
            line-height: 25px;
            margin: 0 23px ;
        }
        .introduce{
            line-height: 54px;
            margin-top: 65px;
            font-size: 32px;
            color: #009dea;
        }
        .referral{
            line-height: 40px;
            color: #696969;
            font-size: 22px;
            margin-bottom: 45px;
        }
        video{
            margin-bottom: 45px;
        }
        .arovane{
            width: 100%;
            height: 635px;
            margin-bottom: 45px;
        }
        .arovane img{
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
<?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="slDetail_cont"></div>
<div class="type_area">
        <div class="cont">
                <p class="mines"><?php echo Yii::t('mines','mines_contact');?></p>
                <p class="process"><?php echo Yii::t('mines','advantage');?></p>
                <p class="line"></p>
                <ul class="card">
                    <li>
                        <i class="cardleft1"></i>
                        <i class="cardright"></i>
                        <i class="carline"></i>
                        <p class="cardtext"><?php echo Yii::t('mines','mines_select');?></p>
                        <p class="cardcontent"><?php echo Yii::t('mines','mines_select_text');?></p>
                    </li>
                    <li>
                        <i class="cardleft2"></i>
                        <i class="cardright"></i>
                        <i class="carline"></i>
                        <p class="cardtext"><?php echo Yii::t('mines','mines_manage');?></p>
                        <p class="cardcontent"><?php echo Yii::t('mines','mines_manage_text');?></p>
                    </li>
                    <li>
                        <i class="cardleft3"></i>
                        <i class="cardright"></i>
                        <i class="carline"></i>
                        <p class="cardtext"><?php echo Yii::t('mines','mines_risk_control');?></p>
                        <p class="cardcontent"><?php echo Yii::t('mines','mines_risk_control_text');?></p>
                    </li>
                </ul>
            </div>
        <p class="introduce"><?php echo Yii::t('mines','mines_introduce');?></p>
        <p class="referral"><?php echo Yii::t('mines','mines_introduce_text1');?></p>
        <video src="/video/movie.mp4" width="100%" height="635px" controls="controls"></video>

        <p class="referral"><?php echo Yii::t('mines','mines_introduce_text2');?></p>

        <p class="referral"><?php echo Yii::t('mines','mines_introduce_text3');?></p>

        <div class="arovane"><img src="/images/arovane.png"></div>
        <p class="referral">
        <?php echo Yii::t('mines','mines_introduce_text4');?>
        </p>
        <p class="referral">
        <?php echo Yii::t('mines','mines_introduce_text5');?>
        </p>
        <p class="referral" style="margin-bottom: 360px;"><?php echo Yii::t('mines','mines_introduce_text6');?></p>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
</body>
</html>

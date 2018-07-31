<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::t('common','user_panel');?></title>
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
        .user_title2{
            font-size: 28px;
            line-height: 106px;
            color: #74737b;
        }
        .user_content,.user_content1,.user_content2{
            background: #252236;
            border: 2px solid #514e5e;
            padding:  0 32px;
            margin-bottom: 30px;
        }
        .survey{
            line-height: 56px;
            border-bottom: 2px solid #514e5e;
            color: #fff;
            font-size: 20px;
        }
        .survey img{
            width: 36px;
            height: 34px;
            background-size: 100% 100%;
            margin-right: 10px;
        }
        .row{
            border-bottom: 1px solid #302d40;
            color: #78767f;
            line-height: 72px;
            margin-left: 8px;
        }
        .power{
            color: #0092da;
        }
        .mill{
            color: #78767f;
        }
        .customer .row span{
            display: inline-block;
            font-size: 14px;
            width: 33%;
        }
        .row span b{
            font-size: 24px;
            color: #009dea;
        }
        .row:last-child{
            border: none;
        }
        .row span a{
            display: inline-block;
            padding: 0 38px;
            height: 40px;
            margin-right: 20px;
            line-height: 40px;
            background: #009dea;
            font-size: 16px;
            color: #fff;
            border-radius: 4px;
            text-align: center;
        }
        .user_content2{
            display: none;
        }
    </style>
 <?php require(dirname(__FILE__).'/../header.php'); ?>
<div class="customer">
    <div class="type_area">
        <p class="user_title1">
            <a href="/" style="color: #74737b;"><?php echo Yii::t('common','home');?> / </a>
            <span><?php echo Yii::t('common','user_panel');?></span>
        </p>
        <p class="user_title2">
            <span class="power"><?php echo Yii::t('power','power_overview');?></span>
            <b> | </b>
            <span class="mill"><?php echo Yii::t('power','mill_overview');?></span>
        </p>
        <ul class="user_content1">
            <li class="survey"><img src="images/云算力icon@2x.png"><?php echo Yii::t('power','power_overview');?></li>
            <?php
                if( $coins ){
                    foreach( $coins as $v ){
            ?>
            <li class="row">
            <span><?php echo $v['name'];?><?php echo Yii::t('common','total_amount');?>&nbsp;|&nbsp;<b><?php echo $v['total_power'];?></b>&nbsp;<?php echo $v['unit_name'];?></span>
            <span>USD<?php echo Yii::t('common','total_revenue');?>&nbsp;|&nbsp;<b><?php echo $v['power_total_income']*$v['latest_price'];?></b></span>
                <span><?php echo $v['name'];?><?php echo Yii::t('common','total_revenue');?>&nbsp;|&nbsp;<b><?php echo $v['power_total_income'];?></b></span>
            </li>
            <?php 
                }
            }
            ?>
        </ul>
        <ul class="user_content2">
            <li class="survey"><img src="images/云算力icon@2x.png"><?php echo Yii::t('power','mill_overview');?></li>
            <?php
                if( $coins ){
                    foreach( $coins as $v ){
            ?>
            <li class="row">
            <span><?php echo $v['name'];?><?php echo Yii::t('common','total_amount');?>&nbsp;|&nbsp;<b><?php echo $v['total_machine'];?></b>&nbsp;<?php echo Yii::t('common','stand');?></span>
                <span>USD<?php echo Yii::t('common','total_revenue');?>&nbsp;|&nbsp;<b>0.00</b></span>
                <span><?php echo $v['name'];?><?php echo Yii::t('common','total_revenue');?>&nbsp;|&nbsp;<b><?php echo $v['machine_total_income'];?></b></span>
            </li>
            <?php 
                }
            }
            ?>
        </ul>
        <!--<ul class="user_content">
            <li class="survey"><img src="images/矿场基建icon@2x.png">矿场基建</li>
            <li class="row">
                <span>投入&nbsp;|&nbsp;<b>0.00</b>&nbsp;CYN</span>
                <span>收益&nbsp;|&nbsp;<b>0.00</b>CYN</span>
                <span><a href="#">收益详情</a></span>
            </li>
        </ul>-->
        <ul class="user_content">
            <li class="survey"><img src="images/tethericon@2x.png">USD<?php echo Yii::t('common','account');?></li>
            <li class="row">
            <span><?php echo Yii::t('power','over');?>&nbsp;|&nbsp;<b><?php echo $legal['usd'];?></b>&nbsp;USD</span>
            <span><?php echo Yii::t('power','freeze');?>&nbsp;|&nbsp;<b><?php echo $legal['usd_freeze'];?></b>&nbsp;USD</span>
                <span>
                    <a href="/recharge"><?php echo Yii::t('common','recharge');?></a>
                    <a href="/withdraw"><?php echo Yii::t('common','withdraw');?></a>
                </span>
            </li>
        </ul>
        <!--
        <ul class="user_content">
            <li class="survey"><img src="images/cyn账户icon@2x.png">CYN账户</li>
            
            <li class="row">
                <span>余额&nbsp;|&nbsp;<b>0.00</b>&nbsp;CYN</span>
                <span>冻结&nbsp;|&nbsp;<b>0.00</b>CYN</span>
                <span>
                    <a href="#">充值</a>
                    <a href="#">提现</a>
                </span>
            </li>
        </ul>
        -->
        <?php 
            if( $coins ){
                foreach($coins as $v ){
        ?>
        <ul class="user_content">
        <li class="survey"><img src="<?php echo $v['img_url'];?>"><?php echo $v ['name'];?><?php echo Yii::t('common','account');?></li>
            <li class="row">
            <span><?php echo Yii::t('power','over');?>&nbsp;|&nbsp;<b><?php echo $v['current_total'];?></b>&nbsp;<?php echo $v['name'];?></span>
            <span><?php echo Yii::t('power','freeze');?>&nbsp;|&nbsp;<b><?php echo $v['freeze_total'];?></b>&nbsp;<?php echo $v['name'];?></span>
                <span>
                    <a href="/recharge"><?php echo Yii::t('common','recharge');?></a>
                    <a href="/withdraw?coin_id=<?php echo $v['id'];?>"><?php echo Yii::t('common','withdraw');?></a>
                </span>
            </li>
        </ul>
        <?php 
            }
        }
        ?>
    </div>
</div>
<?php require(dirname(__FILE__).'/../footer.php'); ?>
<script>
    // 算力详情
  $('.mill').on('click',function () {
      $('.mill').css('color','#0092da');
      $('.power').css('color','#78767f');
      $('.user_content1').hide();
      $('.user_content2').show();
  })

   // 矿机详情
  $('.power').on('click',function () {
      $('.power').css('color','#0092da');
      $('.mill').css('color','#78767f');
      $('.user_content2').hide();
      $('.user_content1').show();
  })

</script>
</body>
</html>

<html>
<head></head>
<body>
<div><h1>测试</h1></div>
<div><?php echo $var1;?></div>
<div><?php echo Yii::t('common','test'); ?></div>
<?php echo CHtml::link('中文', Yii::app()->createUrl('/', array('lang' => 'zh_cn')));?>
<?php echo CHtml::link('English', Yii::app()->createUrl('/', array('lang' => 'en_us')));?>
</body>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/js/jquery-3.3.1.min.js");  ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery-3.3.1.min.js", CClientScript::POS_END);?>
</html>

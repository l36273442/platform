<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/layer/layer.js");?>

<h1><?php echo $info['name'];?></h1>
<?php echo Yii::t('common','contract_name');?>:<?php echo $coin_info['name'];?><br />
<?php echo Yii::t('common','unit_name');?>:<?php echo $unit_info['name'];?><br /> 
<?php echo Yii::t('common','min_buy_number');?>:<?php echo $info['min_buy_number'];?><br /> 
<?php echo Yii::t('common','price');?>:<?php echo $info['price'];?><br /> 
<?php echo Yii::t('common','machine_name');?>:<?php echo $machine_info['name'];?><br /> 
<?php echo Yii::t('common','total');?>:<?php echo $info['total'];?><br /> 
<?php echo Yii::t('common','deal_total');?>:<?php echo $info['deal_total'];?><br /> 
<?php echo Yii::t('common','contract_start_time');?>:<?php echo date('Y-m-d H:i:s' ,$info['start_time']);?><br /> 
<?php echo Yii::t('common','manage_fee');?>:<?php echo $info['manage_fee'];?><br /> 
<?php echo Yii::t('common','electricity_fee');?>:<?php echo $info['electricity_fee'];?><br /> 

<input type="text" id="count" name="count"/> <?php echo $unit_info['name'];?><span id = "total_price">0</span><button id="button" type="button"><?php echo Yii::t('common','buy');?></button>
<input type="hidden" id="id" name="id" value="<?php echo $info['id'];?>"/>
<input type="hidden" id="price" name="price" value="<?php echo $info['price'];?>"/>
<script>
$("#count").keyup(function(){
    var count = $('#count').val();
    if ( !isNaN(parseInt(count)) && count >= 0 ) {
        
        $('#total_price').text(  count * $('#price').val() );
    }
  
});
$("#button").click(function(){
    var count = $('#count').val();
    var id = $('#id').val();
    if ( isNaN(parseInt(count)) || count<= 0 ) {
		layer.tips("<?php echo Yii::t('common','count_err');?>", '#count', {tips: 3});
		return false;
   }

    $.ajax( {
        url:'/powercontractorder/order',
    data:{
        count : count,
        id : id
    },
    type:'post',
    cache:false,
    dataType:'json',
    success:function(data) {
        if(data.ret == 1 ){
            layer.msg(data.msg, {tips: 3});
        }else{
            layer.msg(data.msg, {tips: 3});
        }
   },
   error : function() {
        layer.msg("<?php echo Yii::t('common','request_err');?>", {tips: 3});
   }
});

  });

</script>

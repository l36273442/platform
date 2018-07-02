

<div>
<?php echo Yii::t('common','phone_number');?>：<input id="country_code" type="text" style="display: none;"><input id="mobile" type="text" style="padding-left: 40px;    width: 295px;" >
<br /><br />
<?php echo Yii::t('common','password');?>：<input type="password" id="password" placeholder="<?php echo Yii::t('common','enter_password');?>"/>



<button id="button" type="button">Submit</button>
</div>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/intlTelInput.css");  ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/intlTelInput.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/layer/layer.js");?>

<script>
$("#country_code").intlTelInput({
							autoHideDialCode: false,
							defaultCountry: "cn",
							nationalMode: false,
							preferredCountries: ['cn', 'us', 'hk', 'tw', 'mo'],
						});

</script>
<script>
$("#button").click(function(){
    var mobile = $('#mobile').val();
    var password = $('#password').val();
    var country_code = $('#country_code').val();

    if (mobile == "" || mobile == null) {
		layer.tips("<?php echo Yii::t('common','enter_phone');?>", '#mobile', {tips: 3});
		return false;
	}
    if (password == "" || password == null) {
		layer.tips("<?php echo Yii::t('common','enter_password');?>", '#password', {tips: 3});
		return false;
    }
    $.ajax( {
        url:'/login/dologin',
    data:{
        mobile : mobile,
        password : password,
        country_code : country_code,
    },
    type:'post',
    cache:false,
    dataType:'json',
    success:function(data) {
        if(data.ret == 1 ){
            layer.msg(data.msg, {tips: 3});
             $(window).attr('location','/');
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

<div>
<?php echo Yii::t('common','phone_number');?>：<input id="country_code" name="country_code" type="text" style="display: none;"><input id="mobile" type="text" style="padding-left: 40px;    width: 295px;" >
<br /><br />
<?php echo Yii::t('common','img_code');?>：<input id="img_code" name="img_code" type="text">
<img src="/code.php" />
<br /><br />
<?php echo Yii::t('common','sms_code');?>：<input id="sms_code" name="sms_code" type="text">
<input type="button" id="btn" value="<?php echo Yii::t('common','get');?><?php echo Yii::t('common','sms_code');?>" onclick="settime(this)" />
<br /><br />
<?php echo Yii::t('common','password');?>：<input type="password" id="password" name="password" placeholder="<?php echo Yii::t('common','enter_password');?>"/>
<br /><br />
<?php echo Yii::t('common','repeat_password');?>：<input type="password" id="repeat_password" name="repeat_password"  placeholder="<?php echo Yii::t('common','enter_password');?>"/>
<br /><br />
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
var countdown=<?php echo SMS_SEND_INTERVAL; ?>;
function settime(obj) {
    if (countdown == 0) {
        obj.removeAttribute("disabled");
        obj.value="<?php echo Yii::t('common','get');?><?php echo Yii::t('common','sms_code');?>";
        countdown = <?php echo SMS_SEND_INTERVAL; ?>;
        return;
    } else {
        obj.setAttribute("disabled", true);
        obj.value="<?php echo Yii::t('common','resend');?>(" + countdown + ")";
        countdown--;
    }
setTimeout(function() {
    settime(obj) }
    ,1000)
};
$("#btn").click(function(){
    var mobile = $('#mobile').val();
    var country_code = $('#country_code').val();
    if (mobile == "" || mobile == null) {
		layer.tips("<?php echo Yii::t('common','enter_phone');?>", '#mobile', {tips: 3});
		return false;
	}
    if ( country_code == "" || country_code == null) {
		layer.tips("<?php echo Yii::t('common','country_code_empty');?>", '#country_code', {tips: 3});
		return false;
    }
    $.ajax( {
        url:'/sms/sendsmsforgetcode',
        data:{
            mobile : mobile,
            country_code : country_code,
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
$("#button").click(function(){
    var mobile = $('#mobile').val();
    var password = $('#password').val();
    var img_code = $('#img_code').val();
    var sms_code = $('#sms_code').val();
    var country_code = $('#country_code').val();
    var repeat_password = $('#repeat_password').val();    
    if (mobile == "" || mobile == null) {
		layer.tips("<?php echo Yii::t('common','enter_phone');?>", '#mobile', {tips: 3});
		return false;
	}
    if (password == "" || password == null) {
		layer.tips("<?php echo Yii::t('common','enter_password');?>", '#password', {tips: 3});
		return false;
    }
    if ( repeat_password  == "" || repeat_password  == null) {
		layer.tips("<?php echo Yii::t('common','enter_password');?>", '#repeat_password', {tips: 3});
		return false;
    }
    if ( repeat_password  != password ) {
		layer.tips("<?php echo Yii::t('common','repeat_password_err');?>", '#password', {tips: 3});
		return false;
    }
    if ( country_code == "" || country_code == null) {
		layer.tips("<?php echo Yii::t('common','country_code_empty');?>", '#country_code', {tips: 3});
		return false;
    }
    if ( img_code == "" || img_code == null) {
		layer.tips("<?php echo Yii::t('common','img_code_empty');?>", '#img_code', {tips: 3});
		return false;
    }
    if ( sms_code == "" || sms_code == null) {
		layer.tips("<?php echo Yii::t('common','sms_code_empty');?>", '#sms_code', {tips: 3});
		return false;
    }

    $.ajax( {
    url:'/login/doforgetpassword',
        data:{
        mobile : mobile,
            password : password,
            country_code : country_code,
            img_code : img_code,
            sms_code : sms_code,
    },
        type:'post',
        cache:false,
        dataType:'json',
        success:function(data) {
            if(data.ret == 1 ){
                layer.msg(data.msg, {tips: 3});
                $(window).attr('location','/login/login');
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

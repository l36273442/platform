<br /><br />
<?php echo Yii::t('common','old_password');?>：<input type="password" id="old_password" name="old_password" placeholder="<?php echo Yii::t('common','enter_password');?>"/>
<br /><br />
<?php echo Yii::t('common','password');?>：<input type="password" id="password" name="password" placeholder="<?php echo Yii::t('common','enter_password');?>"/>
<br /><br />
<?php echo Yii::t('common','repeat_password');?>：<input type="password" id="repeat_password" name="repeat_password"  placeholder="<?php echo Yii::t('common','enter_password');?>"/>

<?php echo Yii::t('common','sms_code');?>：<input id="sms_code" name="sms_code" type="text">
<input type="button" id="btn" value="<?php echo Yii::t('common','get');?><?php echo Yii::t('common','sms_code');?>" onclick="settime(this)" />
<br /><br />

<button id="button" type="button">Submit</button>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/layer/layer.js");?>
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
}
$("#btn").click(function(){
    $.ajax( {
        url:'/sms/sendsmsupcode',
        data:{},
        type:'get',
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
    var password = $('#password').val();
    var old_password = $('#old_password').val();
    var sms_code = $('#sms_code').val();
    var repeat_password = $('#repeat_password').val();    
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
    if ( sms_code == "" || sms_code == null) {
		layer.tips("<?php echo Yii::t('common','sms_code_empty');?>", '#sms_code', {tips: 3});
		return false;
    }

    $.ajax( {
    url:'/user/douppass',
        data:{
        password : password,
            old_password : old_password,    
            sms_code : sms_code,
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

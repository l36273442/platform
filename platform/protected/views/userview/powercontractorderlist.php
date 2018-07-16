<div id="powerlistdiv" name="powerlistdiv">
<table>
<thead>
<tr>
<th>id</th>
<th><?php echo Yii::t('common','contract_name');?></th>
<th> <?php echo Yii::t('common','coin_name');?></th>
<th><?php echo Yii::t('common','unit_name');?></th>
<th><?php echo Yii::t('common','order_price');?></th>
<th><?php echo Yii::t('common','order_count');?></th>
<th><?php echo Yii::t('common','price');?></th>
<th><?php echo Yii::t('common','machine_name');?></th>
<th><?php echo Yii::t('common','contract_start_time');?></th>
<th><?php echo Yii::t('common','order_ctime');?></th>
<th><?php echo Yii::t('common','pay_time');?></th>
<th><?php echo Yii::t('common','manage_fee');?></th>
<th><?php echo Yii::t('common','random_code');?></th>
<th><?php echo Yii::t('common','electricity_fee');?></th>
<th><?php echo Yii::t('common','status');?></th>
<th><?php echo Yii::t('common','operate');?></th>
</tr>
</thead>
<tbody id="list">
</tbody>
</table>
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.min.js");?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/layer/layer.js");?>
<script>
Date.prototype.toLocaleString = function() {
    return this.getFullYear() + "-" + (this.getMonth() + 1) + "-" + this.getDate() + " " + this.getHours() + ":" + this.getMinutes() + ":" + this.getSeconds();
};
function formatSeconds(value) {
    var theTime = parseInt(value);// 秒
    var theTime1 = 0;// 分
    var theTime2 = 0;// 小时
    if(theTime > 60) {
        theTime1 = parseInt(theTime/60);
        theTime = parseInt(theTime%60);
            if(theTime1 > 60) {
            theTime2 = parseInt(theTime1/60);
            theTime1 = parseInt(theTime1%60);
            }
    }
        var result = ""+parseInt(theTime)+"秒";
        if(theTime1 > 0) {
        result = ""+parseInt(theTime1)+"分"+result;
        }
        if(theTime2 > 0) {
        result = ""+parseInt(theTime2)+"小时"+result;
        }
    return result;
}
$(document).ready(function(){

    $.ajax( {
        url:'/powercontractorder/getuserorderlist',
    data:{
        size : 20,
        page : 1,
    },
    type:'get',
    cache:false,
    dataType:'json',
    success:function(data) {
        if(data.ret == 1 ){
            if( data.data.list != ''){
                for( var i = 0; i < data.data.list.length; i++ ) {
                    var tartmp = $("<tr></tr>");
                    tartmp.append("<td>"+ data.data.list[i].id +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].contract_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].coin_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].unit_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].order_price +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].count +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].price +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].machine_name +"</td>");
                    tartmp.append("<td>"+ new Date(data.data.list[i].start_time * 1000).toLocaleString() +"</td>");
                    tartmp.append("<td>"+ new Date(data.data.list[i].ctime * 1000).toLocaleString() +"</td>");
                    tartmp.append("<td>"+ formatSeconds(data.data.list[i].pay_time) +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].manage_fee +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].random_code +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].electricity_fee +"</td>");
                    if( data.data.list[i].status == 0 ){
                        tartmp.append("<td><?php echo Yii::t('common','order_pending_pay');?></a></td>");
                        tartmp.append("<td><a href=\"/pay/paypowercontract?id="+ data.data.list[i].id +"\" target=\"_blank\"><?php echo Yii::t('common','pay');?></a>"+
                                "&nbsp;<a href=\"/powercontractorder/ordercancel?id="+ data.data.list[i].id +"\" target=\"_blank\"><?php echo Yii::t('common','order_cancel');?></a>"+"</td>");
                    }
                    else if( data.data.list[i].status == 1 ){
                        tartmp.append("<td><?php echo Yii::t('common','order_fail');?></td>");
                        tartmp.append("<td></td>");
                    }
                    else if(data.data.list[i].status == 2){
                        tartmp.append("<td><?php echo Yii::t('common','order_pay');?></td>");
                        tartmp.append("<td></td>");
                    }
                    else if(data.data.list[i].status == 3){
                        tartmp.append("<td><?php echo Yii::t('common','order_deal');?></td>");
                        tartmp.append("<td></td>");
                    }
                    else if(data.data.list[i].status == 4){
                        tartmp.append("<td><?php echo Yii::t('common','pay_timeout');?></td>");
                        tartmp.append("<td></td>");
                    }
                    else if(data.data.list[i].status == 5){
                        tartmp.append("<td><?php echo Yii::t('common','cancelled');?></td>");
                        tartmp.append("<td></td>");
                    }
                    else{
                        tartmp.append("<td><?php echo Yii::t('common','order_unknown');?></td>");
                        tartmp.append("<td></td>");
                    }
                    tartmp.appendTo("#list");
                }
            }
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

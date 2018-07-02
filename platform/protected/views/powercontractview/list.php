<div id="listdiv" name="listdiv">
<table>
<thead>
<tr>
<th>id</th>
<th><?php echo Yii::t('common','contract_name');?></th>
<th> <?php echo Yii::t('common','coin_name');?></th>
<th><?php echo Yii::t('common','unit_name');?></th>
<th><?php echo Yii::t('common','min_buy_number');?></th>
<th><?php echo Yii::t('common','price');?></th>
<th><?php echo Yii::t('common','machine_name');?></th>
<th><?php echo Yii::t('common','total');?></th>
<th><?php echo Yii::t('common','deal_total');?></th>
<th><?php echo Yii::t('common','contract_start_time');?></th>
<th><?php echo Yii::t('common','manage_fee');?></th>
<th><?php echo Yii::t('common','electricity_fee');?></th>
<th><?php echo Yii::t('common','buy');?></th>
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
$(document).ready(function(){

    $.ajax( {
        url:'/powerContract/getlist',
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
                    tartmp.append("<td>"+ data.data.list[i].name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].coin_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].unit_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].min_buy_number +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].price +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].machine_name +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].total +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].deal_total +"</td>");
                    tartmp.append("<td>"+ new Date(data.data.list[i].start_time * 1000).toLocaleString() +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].manage_fee +"</td>");
                    tartmp.append("<td>"+ data.data.list[i].electricity_fee +"</td>");
                    tartmp.append("<td><a href=\"/powercontractview/detail?id="+ data.data.list[i].id +"\" target=\"_blank\"><?php echo Yii::t('common','buy');?></a></td>");

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

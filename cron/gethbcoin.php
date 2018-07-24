<?php
$t = time();;
echo "----------\n";
echo "获取币种价格\n";
echo "开始时间：".date("Y-m-d H:i:s")."\n";    
require(dirname(__FILE__).'/common.php');
$c = array('btc','eth');
$url = huobi_pro_market.'/trade'; 
foreach($c as $v ){
    $p1 = $p2 = '';
    $u .= '?symbol='.$v.'btc';
    $d = @file_get_contents($u);
    if( !$d ){
        echo "获取币种交易信息失败".$u."\n";
    }
    $c = json_decode($d,true);
    if( isset($c['status']) && $c['status'] == 'ok' ){
        if(isset($c['tick']['data']) && !empty($c['tick']['data'])){
           foreach(  $c['tick']['data'] $val ){
                echo $val['price'],"---",date('Y-m-d H:i:s' , $val['ts']),"\n";
            } 
        }
    }
    
    if( $v == 'btc'){
        $p2 = 1;
    }
}

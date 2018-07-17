<?php
echo "----------\n";
echo "获取汇率\n";
echo "开始时间：".date("Y-m-d H:i:s")."\n";    
require(dirname(__FILE__).'/common.php');

$appkey = 'fa91e8d67faa1aa4a6692ad567135e0f';
$arr = array('krw','jpy','cny');
$url = 'http://op.juhe.cn/onebox/exchange/currency?key='.$appkey.'&to=usd';

foreach( $arr as $v ){

    try{
        $curl = curl_init();
        if( !$curl ){
            echo "curl 错误".PHP_EOL;
            exit; 
        }
        $url .= '&from='.$v;
        curl_setopt($curl, CURLOPT_URL, $url );
        //设置头文件的信息作为数据流输出
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        //curl_setopt($curl, CURLOPT_POST, 1);
        $data = curl_exec($curl);
        if( curl_errno($curl) ){
            echo curl_error($curl)."(".curl_errno($curl).") ".$data;
            continue;
        }    
        curl_close($curl);
        $d = json_decode($data,true);
        if(  empty( $d ) || $d['error_code'] != 0){

            echo "fail ".$d['reason'].PHP_EOL;
            continue;
        }
        $t = '';

        foreach($d['result'] as $val){
            if($val['currencyF'] == strtolower($v) ||  $val['currencyF'] == strtoupper($v)){ 
                $t = $val['result'];
            }
        }
        if( !$t ){
            echo '更新'.$v.'汇率'.$t.'失败2'.PHP_EOL; 
            continue;
        }
        $sql = 'update platform_legal_rate set '.$v.'='.$t.',uptime='.time().' where id =1';
        $re = $db->exec( $sql );
        if( !$re ){
            echo '更新'.$v.'汇率'.$t.'失败'.PHP_EOL;
        }
        else{
            echo '更新'.$v.'汇率'.$t.'成功'.PHP_EOL;
        }
    }catch(Exception $e){
        $mess = '更新'.$v.'汇率'.$t.' message  fail '.$e->getMessage();
        echo $mess.PHP_EOL;
        continue;
    } 
}


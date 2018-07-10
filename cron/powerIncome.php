<?php
$t = time();
if( isset($argv[1]))
{
    if( !preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/' , $argv[1]))
    {   
        echo "日期格式错误",PHP_EOL;
        exit;
    }   
    else
    {   
        $x =strtotime( $argv[1].' 00:00:00');
    }   
}
else
{
    $x = $t - 86400;
}
$d = date('Ymd',$x);
echo "----------\n";
echo "计算用户昨天算力收益\n";
echo "开始时间：".date("Y-m-d H:i:s")."\n";    
require(dirname(__FILE__).'/common.php');
$table = 'platform_user_coin';
$sql = 'select * from platform_coin_assign where type = 0 and release_time = '.strtotime(date('Y-m-d 00:00:00',$x));
$coins = $c_k = array();
$re = $db->query( $sql );

if( empty($re)){
    echo "计算收益".$d.",时间",date("Y-m-d H:i:s" , $t),",原因无币种总收益 fail !",PHP_EOL;
    exit;
}
$total = $db->query('select coin_id , sum(total_power) as sum from '.$table.'_'.$d.' group by coin_id ');
if( $total ) {
    while( $row = $total->fetch()){
        $coins[$row['coin_id']] = $row;
    }
}    
$c_info =  $db->query('select * from platform_coin ');
if( empty($c_info) ){
    echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因获取币种信息失败 fail !",PHP_EOL; 
    exit;    
}
while( $row = $c_info->fetch()){
    $c_k[$row['id']] = $row;
}
while( $r = $re->fetch() ){
    if( $r['per_count']>0 ){
        echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因已分配 fail !",PHP_EOL; 
        continue;    
    }
    if(isset($coins[$r['coin_id']])){
        if($coins[$r['coin_id']]['sum'] == 0 ){
            echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因币种总算力 fail !",PHP_EOL;
            continue;
        }    
        $sc[$r['coin_id']]['per_count'] = $r['count']/$coins[$r['coin_id']]['sum'];
        $sc[$r['coin_id']]['per_count'] =sprintf("%.16f", $sc[$r['coin_id']]['per_count']);
        $re2 = $db->exec('update platform_coin_assign set per_count = '.$sc[$r['coin_id']]['per_count'].' where id = '.$r['id']);
        if( !$re2 ){
            echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因币种每单位收益添加失败 fail !",PHP_EOL;
            continue;
        }
        $users = $db->query('select *  from '.$table.'_'.$d.' where coin_id = '.$r['coin_id']);
        if(empty($users)){
            echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因获取用户数据失败或无用户数据 fail !",PHP_EOL;
            continue;
        }
        while( $row = $users->fetch()){
            $to = sprintf("%.16f",$row['total_power']*$sc[$r['coin_id']]['per_count']);
            if(!isset($c_k[$r['coin_id']]) || $c_k[$r['coin_id']]['manage_fee']==0){
                $m =0;
            }else{
                $m = round($to*$c_k[$r['coin_id']]['manage_fee'],16);
            }
            if(!isset($c_k[$r['coin_id']]) || $c_k[$r['coin_id']]['electricity_fee']==0){
                $e =0;
            }else{
                $e = round($row['total_power']*$c_k[$r['coin_id']]['electricity_fee'],16);
            }
            $in = $to-$m-$e;
            $e = round($e,12);
            $in = sprintf("%.12f", $in);
            $m = round( $m , 12);
            try {
                $db->beginTransaction();
                $re4 = $db->exec("insert into platform_user_coin_log set coin_id = ".$r['coin_id'].",uid=".$row['uid'].",name='power_mining',count=".$to.",real_count=".$in.",electricity_fee=".$e.",manage_fee=".$m.",content='system income',release_time=".$x.",ctime=".$t);
                $re5 = $db->exec("update platform_user_coin set current_total= current_total + ".$in." ,power_total_income = power_total_income +".$in.",total_income=total_income+".$in.'where uid='.$row['uid'].' and coin_id='.$r['coin_id']);   
                if( !$re4){
                    $db->rollBack();
                    echo "计算收益用户id(".$row['id'].")币种id".$r['coin_id'].'总收'.$to."净收".$in.'管理费'.$m.'电费'.$e.' '.$d.",时间".date("Y-m-d H:i:s" , $t).",失败".PHP_EOL;

                } 
                if( !$re5){
                    $db->rollBack();
                    echo "计算收益用户id(".$row['id'].")币种id".$r['coin_id'].'总收'.$to."净收".$in.'管理费'.$m.'电费'.$e.' '.$d.",时间",date("Y-m-d H:i:s" , $t),",失败5". PHP_EOL;

                } 
                
                $db->commit();
            }catch (Exception $e) {
                $db->rollBack();
                echo "计算收益用户id(".$row['id'].")币种id".$r['coin_id'].'总收'.$to."净收".$in.'管理费'.$m.'电费'.$e.' '.$d.",时间",date("Y-m-d H:i:s" , $t).",原因 ". $e->getMessage() ,PHP_EOL;
                continue;
            }
        }
    }
    else{
        echo "计算收益币种id".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因无币种总算力 fail !",PHP_EOL;
        continue;

    }    
}
echo "结束时间：".date("Y-m-d H:i:s")."\n";    
echo "----------\n";









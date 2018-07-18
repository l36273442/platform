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
echo "计算用户昨天矿机收益\n";
echo "开始时间：".date("Y-m-d H:i:s")."\n";    
require(dirname(__FILE__).'/common.php');
$sql = 'select * from platform_coin_assign where type = 1 and release_time = '.strtotime(date('Y-m-d 00:00:00',$x));
$coins = $c_k = array();
$re = $db->query( $sql );
if( empty($re)){
    echo "计算矿机收益".$d.",时间",date("Y-m-d H:i:s" , $t),",原因无币种总收益 fail !",PHP_EOL;
    exit;
}

$mc = $db->query("select * from platform_machine_contract_order where $x >= start_time and $x<= end_time and status = 1");
if( empty($mc) ){
    echo "计算矿机收益".$d.",时间",date("Y-m-d H:i:s" , $t),",原因获取用户矿机失败或用户无矿机 fail !",PHP_EOL;
    exit; 
}
$cp = $up = $m_ids= $ms_k = $total = array();
while($r=$mc->fetch() ){
    if( isset($cp[$r['coin_id']])){
        $cp[$r['coin_id']]['power'] += $r['total_power'];
    }
    else{
        $cp[$r['coin_id']]['power'] = $r['total_power'];
    }
    $cp[$r['coin_id']]['coin_id'] = $r['coin_id'];
    $up[$r['coin_id']][$r['uid']][$r['machine_id']][] = $r;
    if( isset($up[$r['coin_id']][$r['uid']]['all_total'])){
        $up[$r['coin_id']][$r['uid']][$r['machine_id']]['all_total'] += $r['total_power'];
    }
    else{
        $up[$r['coin_id']][$r['uid']][$r['machine_id']]['all_total'] = $r['total_power'];
    }
    $m_ids[] = $r['machine_id'];
}
$ms = $db->query('select id,manage_fee,electricity_fee from platform_mining_machine where id in ('.implode(',',$m_ids).')');
if( $ms ){
    while($r=$ms->fetch()){
        $ms_k[$r['id']] = $r;
    }
}
$to = $db->query('select * from platform_coin_assign where type = 1 and release_time = '.strtotime(date('Y-m-d 00:00:00',$x)));  

if($to){
    while($r=$to->fetch()){
        if($r['per_count'] > 0 ){
            echo "计算矿机收益币种ID".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因已分配 fail !",PHP_EOL;
            continue;
        }
        $cp[$r['coin_id']]['income'] = $r['count'];
        $cp[$r['coin_id']]['per_count'] = sprintf("%.16f",$r['count']/$cp[$r['coin_id']]['power']);
        $re3 = $db->exec('update  platform_coin_assign set per_count ='.$cp[$r['coin_id']]['per_count'].' where id = '.$r['id']);
        if( !$re3 ){
            echo "计算矿机收益币种ID".$r['coin_id'].' '.$d.",时间",date("Y-m-d H:i:s" , $t),",原因更新失败per_count fail !",PHP_EOL;
            continue;
        }
        if( isset($up[$r['coin_id']])){
            foreach( $up[$r['coin_id']] as $k=>$v ){
                $inc = $m_fee = $e_fee = $in_d = 0 ;
                foreach( $v as $key => $val){
                    $inc += $val['all_total']*$cp[$r['coin_id']]['per_count'];
                    $m_fee += $inc*$ms_k[$key]['manage_fee'];                
                    $e_fee += $val['all_total']*$ms_k[$key]['electricity_fee'];
                }
                $inc = sprintf("%.12f" ,$inc);
                $m_fee = round($m_fee,12);
                $e_fee = round($e_fee,12);
                $in_d = sprintf("%.12f",$inc-$m_fee-$e_fee);
                try {
                    $db->beginTransaction();
                    $re6 = $db->query("select * from platform_user_coin where uid=".$k." and coin_id=".$r['coin_id']." for update");
                    if( $re6 ){
                        $re5 = $db->exec("update platform_user_coin set current_total= current_total + ".$in_d." ,machine_total_income = machine_total_income +".$in_d.",total_income=total_income+".$in_d.'where uid='.$k.' and coin_id='.$r['coin_id']);   
                    }else{
                        $re5 = $db->exec("insert into  platform_user_coin set current_total= ".$in_d." ,machine_total_income = ".$in_d.",total_income=".$in_d.', uid='.$k.', coin_id='.$r['coin_id']);                    }
                    $re4 = $db->exec("insert into platform_user_coin_log set coin_id = ".$r['coin_id'].",uid=".$k.",name='power_machine',count=".$inc.",real_count=".$in_d.",electricity_fee=".$e_fee.",manage_fee=".$m_fee.",content='system income',mining_type = 1 ,release_time=".$x.",ctime=".$t);
                    if( !$re4){
                        $db->rollBack();
                        echo "计算矿机收益用户id(".$k.")币种id".$r['coin_id'].'总收'.$inc."净收".$in_d.'管理费'.$m_fee.'电费'.$e_fee.' '.$d.",时间".date("Y-m-d H:i:s" , $t).",失败".PHP_EOL;
                        continue;
                    } 
                    if( !$re5){
                        $db->rollBack();
                        echo "计算收益用户id(".$k.")币种id".$r['coin_id'].'总收'.$inc."净收".$in_d.'管理费'.$m_fee.'电费'.$e_fee.' '.$d.",时间",date("Y-m-d H:i:s" , $t),",失败5". PHP_EOL;
                        continue;
                    } 
                
                    $db->commit();
                }catch (Exception $e) {
                    $db->rollBack();
                    echo "计算矿机收益用户id(".$k.")币种id".$r['coin_id'].'总收'.$inc."净收".$in_d.'管理费'.$m_fee.'电费'.$e_fee.' '.$d.",时间",date("Y-m-d H:i:s" , $t).",原因 ". $e->getMessage() ,PHP_EOL;
                    continue;
                }
            }
        }
    }
}else{
    echo "计算矿机收益".$d.",时间",date("Y-m-d H:i:s" , $t),",原因无此时间矿机总收益 fail !",PHP_EOL;
}
echo "结束时间：".date("Y-m-d H:i:s")."\n";    
echo "----------\n";














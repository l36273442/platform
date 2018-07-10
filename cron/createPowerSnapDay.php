<?php
$t = time()+60*60;
if( isset($argv[1]))
{
    if( !preg_match('/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/' , $argv[1]))
    {   
        echo "日期格式错误",PHP_EOL;
        exit;
    }   
    else
    {   
        $d = date('Ymd' , strtotime( $argv[1].'00:00:00'));
    }   
}
else
{
    $d = date("Ymd",$t);
}
echo "----------\n";
echo "生成快照以昨天算力数据为今日天发放基础\n";
echo "开始时间：".date("Y-m-d H:i:s")."\n";    
require(dirname(__FILE__).'/common.php');
$table = 'platform_user_coin';

$sql = "DROP TABLE IF EXISTS `".$table.'_'.$d."`;create table ".$table.'_'.$d." select * from ".$table.";";
$idx_sql = "alter table `".$table.'_'.$d."` add unique index `idx_u_c` (`uid`,`coin_id`)";
try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $re = $db->exec( $sql );
    $rex = $db->exec( $idx_sql );
}
catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage(),"\n";
    exit;
}
echo "结束时间：".date("Y-m-d H:i:s")."\n";    
echo "----------\n";

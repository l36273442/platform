<?php 
class MachineContractorderController extends CommonController{
	public function actionGetList(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['size']) || !is_numeric($p['size']) || $p['size'] <= 0 ){
            $size = $this->size;
        }
        else{
            $size = $p['size'];
        }
        if( $size > $this->maxSize ){
            $size = $this->maxSize;
        }     
        if( !isset($p['page']) || !is_numeric($p['page']) || $p['page'] <= 0 ){
            $page = 1;
        }
        else{
            $page = $p['page'];
        }
        $list = MachineContractorderModel::model()->getList( '' , '' , $page , $size );
        if( !$list ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }        
        $coin_id = $mac_k = $machine_id = $mo_id = $coins_key = $pc_key = $unit_key = $pc_id = $unit_id = array();
        foreach( $list['list'] as $v ){
            if( !in_array( $v['coin_id'] , $coin_id ) ){
                $coin_id[] = $v['coin_id'];
                $mo_id[] = $v['mo_id'];
                $machine_id[] = $v['machine_id'];
            }
        }
        $mc = MachineContractModel::model()->getContractByIds($mo_id);
        $mc_k = $this->RowsToArr($mc);
        $mac = MiningMachineModel::model()->getMachinesByIds($machine_id); 
        $mac_k = $this->RowsToArr($mac);        
        $coins = CoinModel::model()->getCoinsByIds($coin_id );
        if($coins){
            
            foreach( $coins as $v ){
                $coins_key[$v['id']] = $v;
                $unit_id[] = $v['unit_id'];
            }
        }
        
        $unit = ComputingPowerUnitModel::model()->getUnitsByIds($unit_id );
        $unit_key = $this->RowsToArr($unit);
        foreach( $list['list'] as &$v ){
            $v['coin_img_url'] = isset($coins_key[$v['coin_id']])?$coins_key[$v['coin_id']]['img_url']:'';
            $v['coin_name'] = isset($coins_key[$v['coin_id']])?$coins_key[$v['coin_id']]['name']:'';
            $v['unit_name'] = isset($unit_key[$coins_key[$v['coin_id']]['unit_id']])?$unit_key[$coins_key[$v['coin_id']]['unit_id']]['name']:'';
            $v['total'] = sprintf("%.2f",$v['total']);
            $v['price'] = sprintf("%.2f",$v['price']);
            $v['machine_name'] =isset($mac_k[$v['machine_id']])?$mac_k[$v['machine_id']]['name']:?'';
            $v['contract_name'] = isset($mc_key[$v['mo_id']])?$mc_key[$v['mo_id']]['name'];
            $v['deal_total'] = sprintf("%.2f",$v['deal_total']);
        }
        $this->renderJson(Yii::t('common','success'), $list);
    }
}

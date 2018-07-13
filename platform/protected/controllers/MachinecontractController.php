<?php
class MachineContractController extends CommonController{
    public function actionGetList(){
        $re =  MachineContractModel::model()->findAllBySql('select * from '.MachineContractModel::model()->tableName().' where status = 0 order by id desc ');
        if( $re === false ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        if( empty($re) ){
            $this->renderJson(Yii::t('common','success') , array());
        }
        $u = $u_k = $a = $m = $c = $m_k = $c_k = $data = array();
        $u = UnitModel::model()->findAll();
        if($u){
            foreach($u as $v){
                $u_k[$v['id']] = $v->attributes;
            }
        }

        foreach( $re as $v ){
            $r = array();
            $r = $v->attributes;
            $m[]= $r['machine_id'];
            $data[] = $r;
        }

        $x = new CDbCriteria();
        $x->addInCondition('id',$m);
        $l = MiningMachineModel::model()->findAll($x);
        if( $l ){
            foreach( $l as $v ){
                $m_k[$v['id']] = $v->attributes;
                $c[] = $v['coin_id'];
            }
        }
        if( $c ){
            $x = new CDbCriteria();
            $x->addInCondition('id',$c);
            $d = CoinModel::model()->findAll($x);
            if($d){
                foreach( $d as $v ){
                    $c_k[$v['id']] = $v->attributes;
                }
            }
        } 
        foreach ( $data as &$v ){
            $v['coin_name'] = $c_k[$m_k[$v['machine_id']]['coin_id']]['name'];
            $v['coin_img_url'] = $c_k[$m_k[$v['machine_id']]['coin_id']]['img_url'];
            $v['machine_name'] = $m_k[$v['machine_id']]['name_'.Yii::app()->language];
            $v['machine_img_url'] = $m_k[$v['machine_id']]['img_url'];
            $v['unit_name'] = $u_k[$c_k[$m_k[$v['machine_id']]['coin_id']]['unit_id']]['name'];
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
    public function actionGetDetail(){
        $p = $this->getParams('REQUEST');
        if(!isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        $re = MachineContractModel::model()->find('id=:id', array(':id'=>$p['id']));
        if( empty($re) ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
         
    }

}


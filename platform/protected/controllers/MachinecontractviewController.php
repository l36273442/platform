<?php
class MachineContractViewController extends WebController{

    public $info;
    public function actionMillShop(){
        $this->render('millshop' , $this->data);
    }
    public function actionMillDetail(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            header('Location: '.Yii::app()->request->hostInfo);
            exit;
        }
        
        $detail = MachineContractModel::model()->find( 'id=:id' , array(':id'=>$p['id']) );
        $coin = CoinModel::model()->find( 'id=:id' , array(':id'=>$detail['coin_id']) );
        $unit = UnitModel::model()->find( 'id=:id' , array(':id'=>$coin['unit_id']) );
        $machine = MiningMachineModel::model()->find( 'id=:id' , array(':id'=>$detail['machine_id']) );
        $faqs = FaqModel::model()->findAll('machine_id=:machine_id and coin_id=:coin_id', array(':coin_id'=>$coin['id'],':machine_id'=>$detail['machine_id']) );
        $this->data['detail'] = empty($detail)?array():$detail->attributes;
        $this->data['coin'] = empty($coin)?array():$coin->attributes;
        $this->data['unit'] = empty($unit)?array():$unit->attributes;
        $this->data['machine'] = empty($machine)?array():$machine->attributes;
        if($faqs){
            foreach( $faqs as $v ){
                $this->data['faqs'][] = $v->attributes;
            }    
        }
        else{
            $this->data['faqs'] = array();
        }
        
        $this->render('milldetail',$this->data);
          
    
    }
}

<?php
class PowerContractViewController extends CommonController{

    public $info;
    public function actionList(){
        $this->render('list');
    }
    public function actionDetail(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_EMPTY); 
        }
        
        $detail = PowerContractModel::model()->find( 'id=:id' , array(':id'=>$p['id']) );
        $coin_info = coinModel::model()->find( 'id=:id' , array(':id'=>$detail['coin_id']) );
        $unit_info = UnitModel::model()->find( 'id=:id' , array(':id'=>$detail['unit_id']) );
        $machine_info = MiningMachineModel::model()->find( 'id=:id' , array(':id'=>$detail['machine_id']) );
        $this->render('detail',array('info' => $detail->attributes,
                                     'coin_info' => $coin_info->attributes,
                                     'unit_info' => $unit_info->attributes,
                                     'machine_info' => $machine_info,
        )); 
    }
}

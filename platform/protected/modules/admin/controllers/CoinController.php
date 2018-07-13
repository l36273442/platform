<?php
class CoinController extends CommonController{
    public function actionGetAllList(){
        $coins = CoinModel::model()->findAll();
        $units = UnitModel::model()->findAll();
        foreach($units as $v ){
            $units_key[$v->id] = $v->attributes;
        }
        foreach( $coins as &$v){
            $v['unit_name'] = isset($units_key[$v['unit_id']])?$units_key[$v['unit_id']]['name']:'';
        }
        $this->renderJson(Yii::t('common','success'),$coins);

    }

}

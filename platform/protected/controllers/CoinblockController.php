<?php
class CoinBlockController extends CommonController{
    public function actionGetCoinBlock(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['coin_id']) || !is_numeric($p['coin_id']) || $p['coin_id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error'), ErrorCode::PARAM_ERROR); 
        }
        $re = CoinBlockModel::model()->find('coin_id=:coin_id' , array(':coin_id' => $p['coin_id']));
        if( empty($re) ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR); 
        }
        $row = $re->attributes;
        $row['ctime'] = date('Y-m-d H:i:s' , $row['ctime']);
        $this->renderJson(Yii::t('common','success') , $re->attributes);
    }

}

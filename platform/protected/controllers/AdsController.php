<?php
class AdsController extends CommonController{
    public function actionGetTextAds(){
        $list = AdsModel::model()->findAllBySql("select * from platform_ads where type = 0 and status = 0 order by id desc ");  
        if( empty($list) ){
            $this->renderJson(Yii::t('common','success'));
        }
        $data = array();
        foreach($list as $v ){
            $data[] = $v->attributes;
        }
        $this->renderJson(Yii::t('common','success'),$data);
    }
    public function actionGetImgAds(){
        $list = AdsModel::model()->findAllBySql("select * from platform_ads where type = 1 and status = 0 order by id desc ");  
        if( empty($list) ){
            $this->renderJson(Yii::t('common','success'));
        }
        $data = array();
        foreach($list as $v ){
            $data[] = $v->attributes;
        }
        $this->renderJson(Yii::t('common','success'),$data);
    }
    public function actionGetAds(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['id']) || !is_numeric($p['id']) || $p['id'] <= 0 ){
            $this->renderError(Yii::t('common','param_error') , ErrorCode::PARAM_ERROR);
        }
        $info = AdsModel::model()->find('id=:id',array(':id'=>$p['id']));
        if( empty($info) ){
            $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
        }
        $data = $info->attributes;
        $this->renderJson(Yii::t('common','success'),$data);
    }

}

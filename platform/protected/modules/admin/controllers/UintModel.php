<?php
class UnitController extends CommonController{
    public function actionGetAllList(){
        $units = UnitModel::model()->findAll();
        $this->renderJson(Yii::t('common','success'),$units);

    }

}

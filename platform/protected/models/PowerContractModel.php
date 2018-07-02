<?php
class PowerContractModel extends CActiveRecord{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return "platform_computing_power_contract";
    }
    public function getList( $status = '' , $page = 1 ,$size = 20  ){
        $c = $criteria = new CDbCriteria();
        $c->order = 'id ASC';
        if( $status !== '' ){
            $c->addCondition('status='.$status);
        }
        $count = $this->count($c);
        $p = new CPagination($count);
        $p->pageSize=$size;
        $p->currentPage = $page;
        $p->applyLimit($c);
        $list = $this->findAll($c);  
        $pages = ceil($count/$size);
        $data =array();
        if( $list ){
            foreach( $list as $v ){
                $data[] = $v->attributes;
            } 
            return array('size' => $size , 'page' => $page , 'total' => $count , 'pages' => $pages , 'list' => $data );

        }
        return false;
    }
    public function getById( $id ){
        if( empty($id) ){
            return false;
        }
        $info = $this->find( 'id=:id' , array( ':id' => $id ) );
        if( $info ){
            return $info->attributes;
        }
        return false;

    }
    public function getContractsByIds( $ids = array()){
        if(empty($ids)){
            return false;
        }   
        $c = new CDbCriteria;
        $c->addInCondition('id', $ids ); 
        $list = $this->findAll($c);
        if( empty($list) ){
            return array();
        }
        $data = array();
        foreach( $list as $v ){
            $data[] = $v->attributes;
        }
        return $data;
    }
}

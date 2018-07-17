    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/dist/css/layui.css">
      <style>
            html,body{
                width: 100%;
                height: 100%;
            }
            .nav{
                height: 80px;
                margin: auto;
                width: 100%;
                background-color: #252832;
                z-index: 10;
                position: relative;
            }
            .nav .area{
                margin: auto;
                height: 100%;
                position: relative;
            }
           .nav_logo {
               float: left;
               height: 100%;
               width: 157px;
               text-align: center;
               font-size: 20px;
               font-weight: 600;
               line-height: 80px;
               overflow: hidden;
               color: #fff;
              /* margin-right: 45px;*/
            }
           .nav_tab {
                float: left;
                height: 100%;
                line-height: 80px;
            }
           .nav_tab li{
                float: left;
                width: 80px;
                text-align: center;
                position: relative;
                cursor: pointer;
            }
           .nav_tab .ind_lef{
               height: 74px;
               margin-right: 40px;
            }
           .nav_tab .ind_ri{
               width: 100px;
               height: 40px;
               line-height: 40px;
               border-radius: 3px;
               margin-top: 20px;
             /*  display: none;*/
            }
            .nav_tab .ind_ri a{
                color: #fff;
            }
            .user{
                float: left;
                width: 110px;
                height: 40px;
                line-height: 40px;
                border: 1px solid #fff;
                position: relative;
                top: 20px;
                background: #323640;
                text-align: left;
                padding: 0 10px 0 30px;
                border-radius: 5px;
            }
            .layui-form {
                float: right;
                position: absolute;
                top: 20px;
                width: 90px;
                right: 0;
            }

           .layui-form-selected dl {
               width: 90px;
               text-align: center;
               background: #323640;
               color: #fff;
               border-radius: 4px;
           }

           .layui-form-select dl dd.layui-this {
               background: none;
           }

           .layui-input, .layui-textarea {
               text-align: center;
               background: #323640;
               color: #fff;
           }

           .layui-form-select dl dd:hover {
               background: #252832;
           }
            .user a{
                display: inline-block;
                font-size: 14px;
                color: #fff;
            }
            .user:hover ul.user_list{
                display: block;
            }
            .user_list{
                width: 150px;
                border: 1px solid #fff;
                position: absolute;
                right: -2px;
                top: 40px;
                background: #323640;
                z-index: 2;
                border-radius: 3px;
                display: none;
                 padding: 10px 0;
            }
            .user ul.user_list li{
                width: 100%;
                height: 38px;
                line-height: 38px;
                display: block;
                text-align: center;
            }
            .user ul.user_list li a{
                color: #d7e2f1;
                font-size: 14px;
            }
             ul.user_list li:hover{
                 background: #252832;
            }
            .triangle_border_down{
                border-width: 5px 5px 0;
                border-style: solid;
                border-color: #fff transparent transparent;
                position: absolute;
                top: 18px;
                right: 16px;
            }
            .nav_tab li a {
                float: left;
                width: 100%;
                height: 100%;
                color: #a7a6a8;
                font-size: 18px;
            }
            .nav_tab .ind_lef a:hover{
                border-bottom: 6px solid #009dea;
                color: #fff;
            }
            .nav_tab .ind_ri:hover{
                background: #42d06c;;
            }

            @media screen and (min-width: 1200px){
                .nav .area {
                    width: 1200px;
                }
            }
            @media (min-width: 1200px){
                .col-lg-10 {
                    width: 83.33333333%;
                }
            }

        </style>

<div class="row nav">
    <div class="area">
        <p class="nav_logo col-lg-2 col-md-2 col-sm-3 col-xs-10">M I N E B I T</p>
        <ul class="nav_tab col-lg-10 col-md-10 col-sm-9">
            <li class="ind_lef"><a href="/"><?php echo Yii::t('common','home');?></a></li>
            <li class="ind_lef"><a href="/hashshop"><?php echo Yii::t('common','power_shop');?></a></li>
            <li class="ind_lef"><a href="/millshop"><?php echo Yii::t('common','machine_shop');?></a></li>
            <li class="ind_lef"><a href="/site/mines"><?php echo Yii::t('common','mines');?></a></li>
            <li class="ind_lef"><a href="/site/help"><?php echo Yii::t('common','help');?></a></li>
            <li class="ind_lef"><a href="/site/about"><?php echo Yii::t('common','about');?></a></li>
            <?php if( !isset($_SESSION['id']) ){?>
            <li class="ind_ri ind_ri1"><a href="/signup"><?php echo Yii::t('common','signup');?></a></li>
            <li class="ind_ri ind_ri2"><a href="/signin"><?php echo Yii::t('common','signin');?></a>
            <?php 
            }
            else{
            ?>
             <div class="user">
             <a href="#"><?php echo substr($_SESSION['phone'],0,3).'****'.substr($_SESSION['phone'],7,4); ?></a>
                 <span class="triangle_border_down"></span>

                 <ul class="user_list">
                     <li><a href="#">用户面板</a></li>
                    <li><a href="/logout"><?php echo Yii::t('common','logout');?></a></li>
                 </ul>
             </div>
            <?php }?>
        </ul>

        <form class="layui-form" action="">
                   <select name="city" lay-filter="test" class="my">
                   <option value="<?php echo Yii::app()->language; ?>"><?php echo Yii::t('common',Yii::app()->language);?></option>
                        <?php if(isset($this->lang) && !empty($this->lang)) {
                                foreach( $this->lang as $v ){
                                  if( Yii::app()->language != $v ){
                        ?>
                                        <option value="<?php echo $v; ?>"><?php echo Yii::t('common',$v);?></option>
                        <?php 
                                    }
                                }
                            }
                        ?>
                   </select>
        </form>

    </div>
</div>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/dist/layui.all.js"></script>
<script>
   var form = layui.form;
                    let {search} = window.location;
                        if (search) {
                            if (/lang=/.test(search)) {
                                let str = /lang=(\w+)/.exec(search)[1];
                                console.log(str);

                                $(`.a option[value=${str}]`).attr('selected', true)
                                form.render('select');
                            } else {
                                window.location.search += '&lang=zh'
                            }
                        } else {
                            window.location.search = '?lang=zh'
                        }
                        form.on('select(test)', function (data) {
                            let str = /lang=(\w+)/.exec(search)[1];
                            console.log(data);
                            if (data.value != str) {
                                //search
                                search = search.replace(/[^=]+$/g, (...arg) => {
                                    console.log(arg);
                                    return data.value
                                });
                                console.log(search);
                                window.location.search = search;
                            }
                    });
</script>


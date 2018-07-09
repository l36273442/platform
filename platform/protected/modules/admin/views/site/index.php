<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台大布局</title>
    <link rel="stylesheet" href="/dist/css/layui.css">
    <style>
        html, body {
            width: 100%;
            height: 100%;
        }
        .search{
            width: 200px;
            height: 32px;
            position: relative;
            margin:10px 0 10px 20px;
            border: 1px solid #ccc;
        }
        .search input{
            height: 100%;
            width: 165px;
            padding-left: 10px;
            color: #999;
            border:none;
        }
        .layui-icon-search{
            font-size: 26px;
            position: absolute;
            right: 0;
            top: 2px;
            color: #ccc;
            cursor: pointer;
        }
        .layui-nav-tree .layui-nav-child dd{
            padding-left: 30px;
        }
        #page {
            float: right;
            margin-right: 40px;
        }
        .mask {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 999;
            display: none;
        }

        .block {
            width: 40%;
            height: 40%;
            position: absolute;
            left: 15%;
            top: 0;
            bottom: 20%;
            right: 0;
            margin: auto;
            background: #fff;
            border-radius: 5px;
        }

        .title {
            width: 100%;
            height: 40px;
            line-height: 40px;
            background: gainsboro;
            text-align: center;
            font-size: 16px;
        }

        .main {
            padding: 0 5%;
            line-height: 30px;
        }

        .line {
            width: 80%;
            margin: 20px 10%;
        }

        .line span {
            display: inline-block;
            width: 70px;
            height: 30px;
            text-align: left;
        }

        .line input {
            width: 280px;
            height: 28px;
            border: 1px solid #ccc;
        }

        .floor {
            margin-left: 30%;
        }

        .floor button {
            width: 80px;
            height: 30px;
            line-height: 30px;
            border-radius: 5px;
            background: #1E9FFF;
            margin-left: 30px;
            color: #fff;
            border: 1px solid #ccc;
            cursor: pointer;
        }
        .floor .cancel {
            background: none;
            color: #333;
        }
        .add_title{
            border-bottom: 1px solid #ccc;
        }
        .data_title{
            width: 100%;
            overflow: auto;
            max-height: 400px;
        }
        .data_thead{
            overflow: auto;
            background: #ddd;
        }
        .data_thead span, .collapse span{
            float: left;
            height: 40px;
            line-height: 40px;
            width: 17%;
            text-align: center;
        }
        .collapse{
            position: relative;
            height: 40px;
            line-height: 40px;
            cursor: pointer;
            border-bottom: 1px solid #ccc;
        }
        .details{
            width: 80%;
            border: 1px solid #ccc;
            margin: 10px auto;
            overflow: auto;
        }
        .head{
            float: left;
            width: 50%;
            height: 30px;
            line-height: 30px;
            text-align: center;
        }
        .details .list:last-child{
            border-bottom: none;
        }
        .list{
            width: 100%;
            background: #dede;
            overflow: auto;
            border-bottom: 1px dashed #333
        }
        .list li{
            float: left;
            width: 46%;
            line-height: 30px;
            margin: 0 2%;
        }
    </style>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
   <?php require(dirname(__FILE__).'/../nav_top.php'); ?>
   <?php require(dirname(__FILE__).'/../nav_left.php'); ?>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class="search">
                <input type="text" class="phone" placeholder="请输入查询条件">
                <i class="layui-icon layui-icon-search"></i>
        </div>
            <p class="data_thead">
                <span>昵称</span>
                <span>创建时间</span>
                <span>登录时间</span>
                <span>登录ip</span>
                <span>操作</span>
            </p>
            <ul class="data_title">
             <!--   <li class="collapse">
                    <span>贤心</span>
                    <span>2016-11-29</span>
                    <span>人生就像是一场修行</span>
                    <span>
                        <button class="layui-btn layui-btn-sm disable">禁用</button>
                        <button class="layui-btn layui-btn-sm compile">编辑</button>
                    </span>
                </li>
                <li class="add_title">
                     <div class="details">
                         <p class="head">usd:XXXXXX</p>
                         <p class="head">usdcdhsjweq:DDDDDDD</p>
                         <ul class="list">
                             <li>111</li>
                             <li>222</li>
                             <li>333</li>
                             <li>444</li>
                             <li>555</li>
                         </ul>
                         <ul class="list">
                             <li>666</li>
                             <li>777</li>
                             <li>888</li>
                             <li>999</li>
                             <li>101010</li>
                         </ul>
                     </div>
                 </li>-->
            </ul>
        <div id="page"></div>
    </div>

     <?php require(dirname(__FILE__).'/../nav_footer.php'); ?>
</div>

<!-- 弹框  -->
<div class="mask">
    <div class="block">
        <p class="title">修改</p>
        <div class="main">
            <p class="line">
                <span>昵  称:</span>
                <input type="text">
            </p>
            <p class="line">
                <span>加入时间:</span>
                <input type="text">
            </p>
            <p class="line">
                <span>创建时间:</span>
                <input type="text">
            </p>
        </div>
        <div class="floor">
            <button class="cancel">取消</button>
            <button class="confirm">确定</button>
        </div>
    </div>
</div>

<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/dist/layui.all.js"></script>
<script>

var element = layui.element;

    // 搜索
    $('.layui-icon-search').on('click',function () {
        let page = 1,
            size = 5,
            phone = $('.phone').val();
        $.ajax({
            type: 'POST',
            url: '/admin/user/getlist',
            data: {page: page, size: size,phone:phone},
            dataType: 'json',
            success: function (data) {
                //console.log(data.data);
                if (data.ret == '1') { // 成功
                    if (data.data) {
                        let html = data.data.list.map((item, index) => {
                            return ` <li class="collapse">
                                 <span>${item.phone}</span>
                                 <span>${item.ctime}</span>
                                 <span>${item.login_time}</span>
                                 <span>${item.login_ip}</span>
                                 <span>
                                    <button class="layui-btn layui-btn-sm disable">禁用</button>
                                    <button class="layui-btn layui-btn-sm compile">编辑</button>
                                 </span>
                            </li>`
                        });
                        $('.data_title').html(html.join(' '));
                        if(window.flag) {
                            var laypage = layui.laypage;
                            laypage.render({
                                elem:'page',
                                count:data.data.total,
                                limit:5,
                                jump: function (obj,first) {
                                    window.flag = true;
                                    if(!first){
                                        //console.log(obj);
                                        run(obj.curr, obj.limit);
                                    }
                                }
                            });
                        }
                    }
                }
            },
            error: function (data) {
                alert('接口发送失败！')
            }
        })
    });
    
    // 获取用户列表
    function run(page = 1, size = 5) {
        $.ajax({
            type: 'POST',
            url: '/admin/user/getlist',
            data: {page: page, size: size},
            dataType: 'json',
            success: function (data) {
                // console.log(data.data);
                if (data.ret == '1') { // 成功
                    if (data.data) {
                        let html = data.data.list.map((item, index) => {
                            return ` <li class="collapse" id=${item.id}>
                                 <span>${item.phone}</span>
                                 <span>${item.ctime}</span>
                                 <span>${item.login_time}</span>
                                 <span>${item.login_ip}</span>
                                 <span>
                                    <button class="layui-btn layui-btn-sm disable">禁用</button>
                                    <button class="layui-btn layui-btn-sm compile">编辑</button>
                                 </span>
                            </li>`
                        });
                        $('.data_title').html(html.join(' '));
                        if(window.flag) return;

                        var laypage = layui.laypage;
                        laypage.render({
                            elem:'page',
                            count:data.data.total,
                            limit:5,
                            jump: function (obj,first) {
                                window.flag = true;
                                if(!first){
                                    //console.log(obj);
                                    run(obj.curr, obj.limit);
                                }
                            }
                        });
                    }
                }
            },
            error: function (data) {
                alert('接口发送失败！')
            }
        })
    }
    run();

    // 显示详情
    $('.layui-body').on('click','.collapse', function (e) {
        let id = $(this).attr('id');
        let _this = this;
        $.ajax({
            type: 'POST',
            url: '/admin/user/getusercoin',
            data: {uid:id},
            dataType: 'json',
            success: function (data) {
                 //console.log(data);
                if (data.ret == '1') { // 成功
                    if (data.data) {
                        if (!_this.flag) {
                            $(_this).after(` <li class="add_title">
                                 <div class="details">
                                    <p class="head">usd:${data.data.usd}</p>
                                    <p class="head">usd_recharge_total:${data.data.usd_recharge_total}</p>                                         </div>
                          </li>`);
                            let html = data.data.coins.map((item, index) => {
                                //console.log(item);
                                return ` <ul class="list">
                                         <li>coin_name:${item.coin_name}</li>
                                         <li>content:${item.content}</li>
                                         <li>electricity_fee:${item.electricity_fee}</li>
                                         <li>extract_fee:${item.extract_fee}</li>
                                         <li>id:${item.id}</li>
                                         <li>machine_total_income:${item.machine_total_income}</li>
                                         <li>machine_total_investment:${item.machine_total_investment}</li>
                                         <li>status:${item.status}</li>
                                         <li>total_income:${item.total_income}</li>
                                 </ul>`
                            });
                            $('.details').append(html.join(' '));
                            _this.flag = true;
                        } else {
                            $(_this).next().hide();
                            _this.flag=false;
                        }
                    }
                }
            },
            error: function (data) {
                alert('接口发送失败！')
            }
        });
/*        if (!this.flag) {
            $(this).after(` <li class="add_title">
                     <div class="details">
                         <p class="head">usd:XXXXXX</p>
                         <p class="head">usdcdhsjweq:DDDDDDD</p>
                         <ul class="list">
                             <li>111</li>
                             <li>222</li>
                             <li>333</li>
                             <li>444</li>
                             <li>555</li>
                         </ul>
                         <ul class="list">
                             <li>666</li>
                             <li>777</li>
                             <li>888</li>
                             <li>999</li>
                             <li>101010</li>
                         </ul>
                     </div>
                 </li>`);
            this.flag = true;
        } else {
            $(this).next().hide();
            this.flag=false;
        }*/
    });

    // 编辑
    $('.layui-body').on('click','.compile', function (e) {
        $('.mask').show();
        e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
    });

    // 禁用
    $('.layui-body').on('click','.disable', function (e) {
        alert('这是禁用按钮！');
        e.stopPropagation ? e.stopPropagation() : e.cancelBubble = true;
    });

    // 取消
    $('.cancel').on('click', function (e) {
        $('.mask').hide();
    });

    // 确定
    $('.confirm').on('click', function (e) {
        alert('这是确定按钮！');
    });

</script>
</body>
</html>

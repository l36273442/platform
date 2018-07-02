<?php
/**
 * Created by PhpStorm.
 * User: hw
 * Date: 15-9-1
 * Time: 下午8:35
 */

class ErrorCode
{
    const SYSTEM_ERROR        = 9000;//9000-9999系统错误
    const DB_ERROR            = 9001;//9000-9999系统错误
   
    const USERS_ERROR         = 1000;//1000-1999用户错误
    const USERS_MAIL_EMPTY    = 1001;//邮箱为空
    const USERS_MAIL_ERROR    = 1002;//邮箱错误
    const USERS_EMPTY         = 1003;//用户不存在amp系统中 
    const USERS_DELETED       = 1004;//用户已删除 
    const USERS_DENY          = 1005;//用户已禁用 
    const USERS_PASSWORD_ERR  = 1006;//用户密码错误

    const PARAM_ERROR   = 2000;//2000-2999业务逻辑错误
    const PARAM_EMPTY   = 2001;//参数为空
    const PARAM_INVALID = 2002;
    const APP_ERROR     = 2100;//应用不存在或token错误
    const APP_DELETED   = 2101;//应用已删除
    const UPDATE_EMPTY  = 2150;//无启用更新
    const UPDATE_EXIST  = 2151;//有未删除的更新，不能删除版本
    const HOTFIX_EXIST  = 2161;//有未删除的热修复，不能删除版本

    const ACCESS_ERROR  = 3000;//3000-3999权限错误
}

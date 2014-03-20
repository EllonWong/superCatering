<?php
/**
 * Created by PhpStorm.
 * User: Ellon_Wong
 * Date: 14-3-15
 * Time: 下午3:28
 */
include_once dirname(__FILE__) . '/../constant/constant.php';
include_once dirname(__FILE__) . '/../../lib/Log4PHP/Log4PHP.php';
include_once dirname(__FILE__) . '/../common/dbConn.php';

global $msgArray;
global $log;

$log = Log4PHP::getLogger("CateringInfoLog");
$msgArray = new MsgArray();

function CateringInfo_Route($arg_body){
    try{
        global $log;
        global $msgArray;
        $log->info("===================CateringInfo_Route begin=====================");
        $log->info($arg_body);
        $rsl = $msgArray->getMsgArray(1,"操作失败!",[],"Warn");
        if(!array_key_exists("route",$arg_body)){
            return $msgArray->getMsgArray(404,"传入路由为空",[],"Warn");
        }
        switch ($arg_body["route"]){
            case "CateringInfo/getAllCateringInfo":$rsl=getAllCateringInfo_func($arg_body);break;
            case "CateringInfo/getCateringInfo":$rsl=getCateringInfo_func($arg_body);break;
            case "CateringInfo/collectCatering";$rsl=collectCatering_func($arg_body);break;
            case "CateringInfo/orderRecord";$rsl=orderRecord_func($arg_body);break;
            default;break;
        }
        return $rsl;
    }catch (Exception $e){
        $log->error("抛出异常:".$e->getMessage());
        return $msgArray->getMsgArray(100001,"系统异常",[],"Error");
    }
}

/*
 * @param
 * @return {code":0,"msg":"Success","data":array(),"status":"Success"}
 */
function getAllCateringInfo_func($arg_body){
    try{
        global $log;
        global $msgArray;
        $log->info("===================getAllCateringInfo_func begin=====================");
        $log->info("传入参数：");
        $log->info($arg_body);
        $rsl = $msgArray->getMsgArray(1,"操作失败!",[],"Warn");
        $getCateringInfoKey="ID,NAME,PHONE,URL,MARK";
        $getCateringTableName="MERCHANT_LIST";
        $getCateringInfoSql="SELECT ".$getCateringInfoKey." FROM  ".$getCateringTableName;
        $log->info($getCateringInfoSql);
        $q_pdo=connectDatabase();
        if(null==$q_pdo){
            return $msgArray->getMsgArray(1000,"数据库连接异常",[],"Warn");
        }
        $stmt= $q_pdo->query($getCateringInfoSql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rsl=$stmt->fetchAll();
        if(0>=count($rsl)){
            return $msgArray->getMsgArray(2,"获取商店列表为空",[],"Success");
        }

        return $msgArray->getMsgArray(0,"获取成功",$rsl,"Success");



    }catch (Exception $e){
        $log->error("抛出异常:".$e->getMessage());
        return $msgArray->getMsgArray(100001,"系统异常",[],"Error");
    }
}

/*
 * @param cateringid
 * @return {code":0,"msg":"Success","data":array(),"status":"Success"}
 */
function getCateringInfo_func($arg_body){
    try{
        global $log;
        global $msgArray;
        $log->info("===================getCateringInfo_func begin=====================");
        $log->info("传入参数：");
        $log->info($arg_body);
        if(!array_key_exists("cateringId",$arg_body)){
            return $msgArray->getMsgArray(3,"传入餐厅参数不存在",[],"Warn");
        }
        $rsl = $msgArray->getMsgArray(1,"操作失败!",[],"Warn");
        $q_pdo=connectDatabase();
        if(null==$q_pdo){
            return $msgArray->getMsgArray(1000,"数据库连接异常",[],"Warn");
        }

        $getCateringInfoKey="id,phote,name,price";
        $getCateringViewName="v_dish_merchant_list";
        $getCateringInfoSql="SELECT ".$getCateringInfoKey." FROM  ".$getCateringViewName." WHERE MERCHANT_ID='".$arg_body["cateringId"]."'";
        $log->info($getCateringInfoSql);

        $stmt= $q_pdo->query($getCateringInfoSql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rsl=$stmt->fetchAll();
        if(0>=count($rsl)){
            return $msgArray->getMsgArray(4,"获取菜色列表为空",[],"Success");
        }
        return $msgArray->getMsgArray(0,"获取成功",$rsl,"Success");

    }catch (Exception $e){
        $log->error("抛出异常:".$e->getMessage());
        return $msgArray->getMsgArray(100001,"系统异常",[],"Error");
    }
}


/*
 * @param cateringid
 * @param userId
 * @return  {code":0,"msg":"收藏成功","data":[],"status":"Success"}
 */
function collectCatering_func($arg_body){
    try{
        global $log;
        global $msgArray;
        $log->info("===================getAllCateringInfo_func begin=====================");
        $log->info("传入参数：");
        $log->info($arg_body);
        $rsl = $msgArray->getMsgArray(1,"操作失败!",[],"Warn");
        if(!array_key_exists("cateringId",$arg_body)){
            return $msgArray->getMsgArray(3,"传入餐厅参数不存在",[],"Warn");
        }
        if(!array_key_exists("userId",$arg_body)){
            return $msgArray->getMsgArray(8,"传入用户参数不存在",[],"Warn");
        }

        $q_pdo=connectDatabase();
        if(null==$q_pdo){
            return $msgArray->getMsgArray(1000,"数据库连接异常",[],"Warn");
        }
        $q_pdo->beginTransaction();
        $insertlikerelationSql="INSERT INTO  LIKE_RELATION (student_id,merchant_id,time)values (?,?,Now())";
        $stmt = $q_pdo->prepare($insertlikerelationSql);
        $num=$stmt->execute(array($arg_body["userId"],$arg_body["cateringId"]));
        if($num<=0){
            return $msgArray->getMsgArray(1001,"插入收藏数据失败！","","Error");
        }
        $q_pdo->commit();
        return $msgArray->getMsgArray(0,"收藏成功",[],"Success");


    }catch (Exception $e){
        $log->error("抛出异常:".$e->getMessage());
        return $msgArray->getMsgArray(100001,"系统异常",[],"Error");
    }
}

/*
 * @param cateringid
 * @param userId
 */

function orderRecord_func($arg_body){
    try{
        global $log;
        global $msgArray;
        $log->info("===================orderRecord_func begin=====================");
        $log->info("传入参数：");
        $log->info($arg_body);
        $rsl = $msgArray->getMsgArray(1,"操作失败!",[],"Warn");
        if(!array_key_exists("cateringId",$arg_body)){
            return $msgArray->getMsgArray(3,"传入餐厅参数不存在",[],"Warn");
        }
        if(!array_key_exists("userId",$arg_body)){
            return $msgArray->getMsgArray(8,"传入用户参数不存在",[],"Warn");
        }
        $q_pdo=connectDatabase();
        if(null==$q_pdo){
            return $msgArray->getMsgArray(1000,"数据库连接异常",[],"Warn");
        }
        $q_pdo->beginTransaction();
        $insertlikerelationSql="INSERT INTO  purchase_list (student_id,merchant_id,time)values (?,?,Now())";
        $stmt = $q_pdo->prepare($insertlikerelationSql);
        $num=$stmt->execute(array($arg_body["userId"],$arg_body["cateringId"]));
        if($num<=0){
            return $msgArray->getMsgArray(1001,"插入订购数据失败！","","Error");
        }
        $q_pdo->commit();
        return $msgArray->getMsgArray(0,"记录成功",[],"Success");

    }catch (Exception $e){
        $log->error("抛出异常:".$e->getMessage());
        return $msgArray->getMsgArray(100001,"系统异常",[],"Error");
    }
}





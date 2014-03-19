<?php
/**
 * Created by PhpStorm.
 * User: Ellon_Wong
 * Date: 14-3-15
 * Time: pm4:51
 */
require_once 'PHPUnit\Framework\TestCase.php';
include_once dirname(__FILE__) .'/../CateringInfo_func.php';
include_once dirname(__FILE__) .'/../../../lib/Log4PHP/Log4PHP.php';
include_once dirname(__FILE__) .'/../../common/dbConn.php';

class TestCateringInfo extends PHPUnit_Framework_TestCase{

    protected function setUp(){
        $q_pdo=connectDatabase();
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (2, '麦当当', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql1="INSERT INTO dish_list (id, phote, name, price) VALUES (90001, './dish_photo/maixiangji_90001.jpg', '苹果派', '7元')";
        $q_pdo->exec($initSql1);
        $initSql2="INSERT INTO merchant_list (id, name, phone) VALUES (90002, '苹果家园', '15920455682')";
        $q_pdo->exec($initSql2);
        $initSql3="INSERT INTO merchant_dish_relation (merchant_id, dish_1) VALUES (90002, 90001)";
        $q_pdo->exec($initSql3);
    }

    function testRequestSolve(){
        $body=array();
        $expect=array("code"=>404,"msg"=>"传入路由为空","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入路由为空用例");

        $body=array("route"=>"CateringInfo/getAllCateringInfo");
        $expectData=array(array("ID"=>"1","NAME"=>"sunkuo","PHONE"=>"13826480235","URL"=>null,"MARK"=>""),
        array("ID"=>"2","NAME"=>"麦当当","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),array("ID"=>"90002","NAME"=>"苹果家园","PHONE"=>"15920455682","URL"=>null,"MARK"=>""));
        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"获取商店成功用例");


        $body=array("route"=>"CateringInfo/getCateringInfo");
        $expect=array("code"=>3,"msg"=>"传入餐厅参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入餐厅参数不存在用例");

        $body=array("route"=>"CateringInfo/getCateringInfo","cateringId"=>90002);
        $expectData=array(array("id"=>"90001","phote"=>"./dish_photo/maixiangji_90001.","name"=>"苹果派","price"=>"7元"));

        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"获取菜色成功用例");
        TestCateringInfo::tearDownData();
    }

    protected function tearDownData(){
        $q_pdo=connectDatabase();
        $delSql="DELETE FROM merchant_list WHERE ID in(2,90002)";
        $q_pdo->exec($delSql);
        $delSql1="DELETE FROM dish_list WHERE ID in(90001)";
        $q_pdo->exec($delSql1);
        $delSql3="DELETE FROM merchant_dish_relation WHERE merchant_id in(90002)";
        $q_pdo->exec($delSql3);
    }

}
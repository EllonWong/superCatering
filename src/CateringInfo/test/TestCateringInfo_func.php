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
        TestCateringInfo::tearDownData();
        $q_pdo=connectDatabase();
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (2, '麦当当', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql1="INSERT INTO dish_list (id, phote, name, price) VALUES (90001, '/dish_photo/maixiangji_90001.jpg', '苹果派', '7元')";
        $q_pdo->exec($initSql1);
        $initSql4="INSERT INTO dish_list (id, phote, name, price) VALUES (90002, '/dish_photo/maixiangji_90002.jpg', '菠萝派', '7元')";
        $q_pdo->exec($initSql4);
        $initSql5="INSERT INTO dish_list (id, phote, name, price) VALUES (90003, '/dish_photo/maixiangji_90003.jpg', '蜜桃派', '7元')";
        $q_pdo->exec($initSql5);
        $initSql6="INSERT INTO dish_list (id, phote, name, price) VALUES (90004, '/dish_photo/maixiangji_90004.jpg', '水蜜桃派', '7元')";
        $q_pdo->exec($initSql6);
        $initSql7="INSERT INTO dish_list (id, phote, name, price) VALUES (90005, '/dish_photo/maixiangji_90005.jpg', '红豆派', '7元')";
        $q_pdo->exec($initSql7);
        $initSql8="INSERT INTO dish_list (id, phote, name, price) VALUES (90006, '/dish_photo/maixiangji_90006.jpg', '番茄派', '7元')";
        $q_pdo->exec($initSql8);
        $initSql8="INSERT INTO dish_list (id, phote, name, price) VALUES (90007, '/dish_photo/maixiangji_90007.jpg', '西瓜派', '7元')";
        $q_pdo->exec($initSql8);
        $initSql8="INSERT INTO dish_list (id, phote, name, price) VALUES (90008, '/dish_photo/maixiangji_90008.jpg', '西柚派', '7元')";
        $q_pdo->exec($initSql8);

        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90001)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90002)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90003)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90004)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90005)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90006)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90007)";
        $q_pdo->exec($initSql2);
        $initSql2="INSERT INTO merchant_dish_relation (merchant_id, dish_7) VALUES (90002, 90008)";
        $q_pdo->exec($initSql2);
//        $initSql9="INSERT INTO dish_list (id, phote, name, price) VALUES (90007, './dish_photo/maixiangji_90007.jpg', '好丽派', '7元')";
//        $q_pdo->exec($initSql9);

        $initSql2="INSERT INTO merchant_list (id, name, phone) VALUES (90002, '苹果家园', '15920455682')";
        $q_pdo->exec($initSql2);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (3, '麦当当3', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (4, '麦当当4', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (5, '麦当当5', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (6, '麦当当6', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (7, '麦当当7', '15920455682',null, '2')";
        $q_pdo->exec($initSql);
        $initSql="INSERT INTO merchant_list (id, name, phone,url, mark) VALUES (8, '麦当当8', '15920455682',null, '2')";
        $q_pdo->exec($initSql);

    }

    function testRequestSolve(){
//        TestCateringInfo::tearDownData();

        $body=array();
        $expect=array("code"=>404,"msg"=>"传入路由为空","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入路由为空用例");

        $body=array("route"=>"CateringInfo/getAllCateringInfo");
        $expectData=array(array("ID"=>"1","NAME"=>"sunkuo","PHONE"=>"13826480235","URL"=>null,"MARK"=>""),
        array("ID"=>"2","NAME"=>"麦当当","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2")
        ,array("ID"=>"3","NAME"=>"麦当当3","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"4","NAME"=>"麦当当4","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"5","NAME"=>"麦当当5","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"6","NAME"=>"麦当当6","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"7","NAME"=>"麦当当7","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"8","NAME"=>"麦当当8","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
            array("ID"=>"90002","NAME"=>"苹果家园","PHONE"=>"15920455682","URL"=>null,"MARK"=>"")

        );
        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"获取商店成功用例");


        $body=array("route"=>"CateringInfo/getCateringInfo");
        $expect=array("code"=>3,"msg"=>"传入餐厅参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入餐厅参数不存在用例");

//        $body=array("route"=>"CateringInfo/getCateringInfo","cateringId"=>90002);
//        $expectData=array(array("id"=>"90001","phote"=>"./dish_photo/maixiangji_90001.","name"=>"苹果派","price"=>"7元"),
//            array("id"=>"90002","phote"=>"./dish_photo/maixiangji_90002.","name"=>"菠萝派","price"=>"7元"),
//            array("id"=>"90003","phote"=>"./dish_photo/maixiangji_90003.","name"=>"蜜桃派","price"=>"7元"),
//            array("id"=>"90004","phote"=>"./dish_photo/maixiangji_90004.","name"=>"水蜜桃派","price"=>"7元"),
//            array("id"=>"90005","phote"=>"./dish_photo/maixiangji_90005.","name"=>"红豆派","price"=>"7元"),
//            array("id"=>"90006","phote"=>"./dish_photo/maixiangji_90006.","name"=>"番茄派","price"=>"7元"));
//
//        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success");
//        $result=CateringInfo_Route($body);
//        $this->assertEquals($expect,$result,"获取菜色成功用例");

        $body=array("route"=>"CateringInfo/collectCatering");
        $expect=array("code"=>3,"msg"=>"传入餐厅参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入餐厅参数不存在用例");

        $body=array("route"=>"CateringInfo/collectCatering","cateringId"=>90002);
        $expect=array("code"=>8,"msg"=>"传入用户参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入用户参数不存在");

        $body=array("route"=>"CateringInfo/collectCatering","cateringId"=>90002,"userId"=>900001);
        $expect=array("code"=>0,"msg"=>"收藏成功","data"=>[],"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"收藏成功用例");

        $body=array("route"=>"CateringInfo/orderRecord");
        $expect=array("code"=>3,"msg"=>"传入餐厅参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入餐厅参数不存在用例");

        $body=array("route"=>"CateringInfo/orderRecord","cateringId"=>90002);
        $expect=array("code"=>8,"msg"=>"传入用户参数不存在","data"=>[],"status"=>"Warn");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"传入用户参数不存在");

        $body=array("route"=>"CateringInfo/orderRecord","cateringId"=>90002,"userId"=>900001);
        $expect=array("code"=>0,"msg"=>"记录成功","data"=>[],"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"记录成功用例");

        $body=array("route"=>"CateringInfo/orderRecord","cateringId"=>90002,"userId"=>900001);
        $expect=array("code"=>0,"msg"=>"记录成功","data"=>[],"status"=>"Success");
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"记录成功用例");


//        $body=array("route"=>"CateringInfo/getCateringInfoByPageNum","pageNum"=>1,"cateringId"=>90002);
//        $expectData=array(array("id"=>"90001","phote"=>"./dish_photo/maixiangji_90001.","name"=>"苹果派","price"=>"7元"),
//            array("id"=>"90002","phote"=>"./dish_photo/maixiangji_90002.","name"=>"菠萝派","price"=>"7元"),
//            array("id"=>"90003","phote"=>"./dish_photo/maixiangji_90003.","name"=>"蜜桃派","price"=>"7元"),
//            array("id"=>"90004","phote"=>"./dish_photo/maixiangji_90004.","name"=>"水蜜桃派","price"=>"7元"),
//            array("id"=>"90005","phote"=>"./dish_photo/maixiangji_90005.","name"=>"红豆派","price"=>"7元"),
//            array("id"=>"90006","phote"=>"./dish_photo/maixiangji_90006.","name"=>"番茄派","price"=>"7元"));
//        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success","countPage"=>2);
//        $result=getCateringInfoByPageNum_func($body);
//        $this->assertEquals($expect,$result,"获取分页成功用例");

//        $body=array("route"=>"CateringInfo/getCateringInfoByPageNum","pageNum"=>2);
//        $expectData=array(array("ID"=>"8","NAME"=>"麦当当8","PHONE"=>"15920455682","URL"=>null,"MARK"=>"2"),
//            array("ID"=>"90002","NAME"=>"苹果家园","PHONE"=>"15920455682","URL"=>null,"MARK"=>""));
//        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success","countPage"=>2);
//        $result=getAllCateringInfoByPageNum_func($body);
//        $this->assertEquals($expect,$result,"获取餐厅分页成功用例");

        $body=array("route"=>"CateringInfo/getCateringInfoByPageNum","pageNum"=>2,"cateringId"=>90002);
        $expectData=array(array("id"=>"90007","phote"=> '/dish_photo/maixiangji_90007.jpg',"name"=>"西瓜派","price"=>'7元'),
            array("id"=>"90008","phote"=> '/dish_photo/maixiangji_90008.jpg',"name"=>"西柚派","price"=>'7元'));
        $expect=array("code"=>0,"msg"=>"获取成功","data"=>$expectData,"status"=>"Success","countPage"=>2);
        $result=CateringInfo_Route($body);
        $this->assertEquals($expect,$result,"获取菜色分页成功用例");

        TestCateringInfo::tearDownData();
    }

    protected function tearDownData(){
        $q_pdo=connectDatabase();
        $delSql="DELETE FROM merchant_list WHERE ID in(2,90002,3,4,5,6,7,8)";
        $q_pdo->exec($delSql);
        $delSql1="DELETE FROM dish_list WHERE ID in(90001,90002,90003,90004,90005,90006,90007,90008)";
        $q_pdo->exec($delSql1);
        $delSql3="DELETE FROM merchant_dish_relation WHERE merchant_id in(90002)";
        $q_pdo->exec($delSql3);
        $delSql4="DELETE FROM like_relation WHERE merchant_id in(90002)";
        $q_pdo->exec($delSql4);
        $delSql5="DELETE FROM purchase_list WHERE merchant_id in(90002)";
        $q_pdo->exec($delSql5);
    }

}
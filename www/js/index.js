
function testRequest(){
    var data={"route":"CateringInfo/getCateringInfoByPageNum","cateringId":1,"pageNum":1};
    $.ajax({
        url: "../src/CateringInfo/CateringInfo_Handle.php",
        type: "GET",
        dataType: "json",
        data: data,
        success: function (data) {
 console.log(data);
        },
        error: function (data) {

        }
    });
}
testRequest();
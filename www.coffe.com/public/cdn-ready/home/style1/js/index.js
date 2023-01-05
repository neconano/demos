$(function () {


    //创建MeScroll对象,内部已默认开启下拉刷新,自动执行up.callback,重置列表数据;
    var mescroll = new MeScroll("body", {
        up: {
            callback: getRepayListData, //上拉回调,此处可简写; 相当于 callback: function (page) { getListData(page); }
            isBounce: true, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
            use: true,
            clearEmptyId: "investproduct", //1.下拉刷新时会自动先清空此列表,再加入数据; 2.无任何数据时会在此列表自动提示空
            warpClass: "marb98",
            page:{
                size:3
            }
        }
    });


    /*联网加载列表数据  page = {num:1, size:10}; num:当前页 从1开始, size:每页数据条数 */
    function getRepayListData(page) {
        //联网加载数据
        getProductList(page.num, page.size, function (curPageData) {
            //联网成功的回调,隐藏下拉刷新和上拉加载的状态;
            //mescroll会根据传的参数,自动判断列表如果无任何数据,则提示空;列表无下一页数据,则提示无更多数据;
            console.log("page.num=" + page.num + ", page.size=" + page.size +
                ", total=" + curPageData.productList.listtotal + ", list=" + curPageData.productList.list);
            //方法一(推荐): 后台接口有返回列表的总页数 totalPage
            //mescroll.endByPage(curPageData.length, totalPage); //必传参数(当前页的数据个数, 总页数)

            //方法二(推荐): 后台接口有返回列表的总数据量 totalSize
            //mescroll.endBySize(curPageData.length, totalSize); //必传参数(当前页的数据个数, 总数据量)
            mescroll.endBySize(curPageData.productList.list.length, curPageData.productList.listtotal); //必传参数(当前页的数据个数, 总数据量)

            //方法三(推荐): 您有其他方式知道是否有下一页 hasNext
            //mescroll.endSuccess(curPageData.length, hasNext); //必传参数(当前页的数据个数, 是否有下一页true/false)

            //方法四 (不推荐),会存在一个小问题:比如列表共有20条数据,每页加载10条,共2页.如果只根据当前页的数据个数判断,则需翻到第三页才会知道无更多数据,如果传了hasNext,则翻到第二页即可显示无更多数据.
            //mescroll.endSuccess(curPageData.length);

            //设置列表数据,因为配置了emptyClearId,第一页会清空dataList的数据,所以setListData应该写在最后;
            setRepayDetailData(curPageData);

        }, function () {
            //联网失败的回调,隐藏下拉刷新和上拉加载的状态;
            mescroll.endErr();
        });

    }

    //设置产品列表数据（处理后台返回的json数据）
    function setRepayDetailData(curPageDataObj) {
        if (curPageDataObj.productList.adUniversal1){
            var imageAddress1 = curPageDataObj.productList.adUniversal1.adimgurl;//广告2
            $(".index_html .banner").show().find("img").attr("src", imageAddress1);
        }
        if (curPageDataObj.productList.adUniversal2) {
            var imageAddress2 = curPageDataObj.productList.adUniversal2.adimgurl;//广告1
            $(".index_html .index_gg").show().find("img").attr("src", imageAddress2);
        }
        var investoramount = curPageDataObj.productList.resourcesChannelInfo.investoramountstr;//累计投资
        if (investoramount!=null){
            $("#investoramount").text(investoramount);
        }else {
            $("#investoramount").text(0);
        }
        var alreadyRebate = curPageDataObj.productList.resourcesChannelInfo.applysuccessstr;//已返利
        if (alreadyRebate!=null){
            $("#alreadyRebate").text(alreadyRebate);
        }else {
            $("#alreadyRebate").text(0);
        }

        var announcement = curPageDataObj.productList.resourcesChannelInfo.announcement;//公告
        if (announcement != null &&announcement!="") {
            if(announcement.length>=20){
                var substring = announcement.substring(0,19);
                $("#substring").text(substring+"...");
                $("#announcement").text(announcement);
            }else {
                $("#announcement").text(announcement);
                $("#substring").text(announcement);
            }
                checkPopupAffiche();
        } else {
                $("#substring").text("暂无公告");
                $("#announcement").text("暂无公告");
        }
        $.each(curPageDataObj.productList.list, function (i, c) {
            var bailhtml = "";
            var bail = c.bail
            if (bail > 0) {
                bailhtml += " <div class='float_l ya'>" + " <span>押</span>" + c.bail + "" + "</div>";
            } else {
                bailhtml += "";
            }
            var pbackgroundhtml = "";
            var pbackground = c.backgrounddepict;
            if (pbackground !=null &&pbackground!="") {
                pbackgroundhtml = "<p class='zhuce_zb'>"+pbackground+"</p>";
            } else {
                pbackgroundhtml += "";
            }

            var backgroundList = c.bList; // 背景列表
            var backgroundStr = "";  // 显示字符串
            for (var j = 0; j < backgroundList.length; j++) {
                var back = backgroundList[j];  // 单个背景
                var bj;
                if (back == "1") {
                    bj = "国资控股";
                }
                if (back == "2") {
                    bj = "国资参股";
                }
                if (back == "3") {
                    bj = "上市控股";
                }
                if (back == "4") {
                    bj = "上市参股";
                }
                if (back == "5") {
                    bj = "风投系";
                }
                if (back == "6") {
                    bj = "银行系";
                }
                if (back == "7") {
                    bj = "民营系";
                }
                if (back == "8") {
                    bj = "知名风投";
                }
                if (j % 2 == 0) {
                    backgroundStr += "<div class='float_l biaoqian'>" + bj + "</div>"
                } else {
                    //偶数行代码
                    backgroundStr += "<div class='float_l biaoqian'>" + bj + "</div>"
                }
            }

            var firstbackmoney= "¥"+c.firstbackmoneystr;

            var  html = "<!--产品列表-->" +
                         "<div class='each_item'>"+
                         "  <a href='details.html?productno=" + c.productno + "'>"+
                         "      <div class='width'>"+
                         "          <div class='logo'>"+
                         "              <img class='float_l' src='" + c.logo1 + "'>"+
                         "            " + bailhtml + " "+
                         "            " + backgroundStr + " "+
                         "              <div class='clear'></div>"+
                         "             "+ pbackgroundhtml +" "+
                         "          </div>"+
                         "          <div class='shouyi'>"+
                         "              <div class='float_l left'>"+
                         "                  <p>" + c.productBidRebate.totalbenefit + "<span>%</span></p>"+
                         "                  <p>加息预期收益</p>"+
                         "              </div>"+
                         "              <div class='float_l border'></div>"+
                         "              <div class='float_l right'>"+
                         "                  <p>平台利息<span>" + c.productBidRebate.platforminterest + "%</span></p>"+
                         "                  <p>最高返利<span>" + firstbackmoney + "</span></p>"+
                         "              </div>"+
                         "              <div class='clear'></div>"+
                         "         </div>"+
                         "      </div>"+
                         "  </a>"+
                         "</div>";
                       $("#investproduct").append(html);
        })

    }
    //查询数据
    function getProductList(pageNum, pageSize, successCallback, errorCallback) {
        $.ajax({
            type: 'GET',
            url: basePath + '/index/product',
            data:{"pageNum":pageNum,"pageSize":pageSize},
            success: function (data) {
                if (data.code == "88") {
                    successCallback(data.data);
                }else {
                    errorCallback
                }

            },
            error: errorCallback
        });

    }




//推荐设置
    $.ajax({
        type: 'GET',
        url: basePath + '/index/recommend',
        success: function (data) {
            if (data.code == "88") {
                var listsize = data.data.productListsize;
                $.each(data.data.productList, function (i, c) {
                if (c!=null) {
                var backgroundList = c.bList; // 背景列表
                var backgroundStr = "";  // 显示字符串
                for (var j = 0; j < backgroundList.length; j++) {
                    var back = backgroundList[j];  // 单个背景
                    var bj;
                    if (back == "1") {
                        bj = "国资控股";
                    }
                    if (back == "2") {
                        bj = "国资参股";
                    }
                    if (back == "3") {
                        bj = "上市控股";
                    }
                    if (back == "4") {
                        bj = "上市参股";
                    }
                    if (back == "5") {
                        bj = "风投系";
                    }
                    if (back == "6") {
                        bj = "银行系";
                    }
                    if (back == "7") {
                        bj = "民营系";
                    }
                    if (back == "8") {
                        bj = "知名风投";
                    }
                    if (j % 2 == 0) {
                        backgroundStr += "<span class='float_l'>" + bj + "</span>"
                    } else {
                        //偶数行代码
                        backgroundStr += "<span class='float_l'>" + bj + "</span>"
                    }
                }


                    var pbackgroundhtml = "";//平台背景
                    var pbackground = c.backgrounddepict;
                    if (pbackground !=null &&pbackground!="") {
                        pbackgroundhtml = "<p class='zhuce_zb'>"+pbackground+"</p>";
                    } else {
                        pbackgroundhtml += "<p class='zhuce_zb'>无</p>";
                    }


               var html ="";
               if (listsize==2) {

                   html =     "<!--推荐产品列表2个-->" +
                              "         <div class='index_chp'>"+
                              "           <a href='details.html?productno=" + c.productno + "'>"+
                              "             <div class='yuqi_sy'>"+
                              "                 <div class='float_l'>"+
                              "                      <div>" + c.productBidRebate.totalbenefit + "<span>%</span></div>"+
                              "                      <p>加息预期收益</p>"+
                              "                      <h6>"+c.pname +"</h6>"+
                              "                 </div>"+
                              "                 <div class='clear'></div>"+
                              "             </div>"+
                              "             <div class='bj_p'>"+
                              "                      <p class='float_l'>背景：</p>"+
                              "                     " + pbackgroundhtml + "  "+
                              "                      <div class='clear'></div>"+
                              "             </div>"+
                              "           </a>"+
                              "         </div>";
                   $("#recommend").append(html);

               }else {



                  /* html = "<!--产品列表-->" +
                       "    <div class='index_chp'>" +
                       "    <div class='index_chp_top'>" +
                       "            <p class='float_l'>" + c.pname + "</p>" +
                       "        " + backgroundStr + "" +
                       "        <div class='clear'></div>" +
                       "    </div>" +
                       "       <div class='yuqi_sy'>" +
                       "             <div class='float_l'>" +
                       "                <div>" + c.productBidRebate.totalbenefit + "<span>%</span></div>" +
                       "                 <p>加息预期收益</p>" +
                       "            </div>" +
                       "            <div class='float_r'>" +
                       "                <p>期限2个月</p>" +
                       "                <div class='clear'></div>" +
                       "                <p>金额：" + c.allbidamountmin + "-" + c.allbidamountmax + "</p>" +
                       "                <div class='clear'></div>" +
                       "            </div>" +
                       "       <div class='clear'></div>" +
                       "       </div>" +
                       "       <div class='bj_p'>" +
                       "             <p class='float_l'>背景：</p>" +
                       "             " + pbackgroundhtml + "   " +
                       "             <div class='clear'></div>" +
                       "       </div>"+
                       "       </div>";*/

                 html = "<!--推荐产品列表一个-->" +
                        "  <div class='index_chp' style='margin-top: -0.3rem;'>"+
                        "       <a href='details.html?productno=" + c.productno + "'>"+
                        "           <div class='index_chp_top'>"+
                        "               <p class='float_l'>"+ c.pname +"</p>"+
                        "                "+ backgroundStr + "  "+
                        "               <div class='clear'></div>"+
                        "           </div>"+
                        "           <div class='yuqi_sy'>"+
                        "               <div class='float_l'>"+
                        "                   <div>" + c.productBidRebate.totalbenefit + "<span>%</span></div>" +
                        "                   <p>加息预期收益</p>"+
                        "               </div>"+
                        "               <div class='float_r' style='padding-top: 0.2rem;'>"+
                        "                    <p>期限2个月</p>"+
                        "                    <div class='clear'></div>"+
                        "                    <p>金额：" + c.allbidamountminstr + "- " + c.allbidamountmaxstr + "</p>" +
                        "                    <div class='clear'></div>"+
                        "               </div>"+
                        "               <div class='clear'></div>"+
                        "           </div>"+
                        "           <div class='bj_p'>"+
                        "               <p class='float_l'>背景：</p>"+
                        "               "+pbackgroundhtml + "   "+
                        "                <div class='clear'></div>"+
                        "           </div>"+
                        "       </a>"+
                        "  </div>"

                   $("#recommendonlyone").append(html);
               }

            }else {
                $("#recommendtitle").text("");
            }

                })
            }

        }
    });

    function checkPopupAffiche(){
        var checkPopupAfficheCount  = localStorage.getItem("checkPopupAfficheCount");
        var checkPopupAfficheTime   = localStorage.getItem("checkPopupAfficheTime");
        if(checkPopupAfficheCount && checkPopupAfficheTime){
            var datetime = new Date();
            var millis = datetime.getTime() - checkPopupAfficheTime;
            if(millis < (24*3600*1000)){
                console.log(millis)
                if(millis > (3600*1000)){//大于一小时后再弹框
                    var lll =  checkPopupAfficheCount++ ;
                    if(lll <= 2){//一天只弹两次
                        localStorage.setItem("checkPopupAfficheCount", checkPopupAfficheCount+1);
                        $(".tankuang").fadeIn(300);
                    }
                }
            }else{
                var datetime = new Date();
                localStorage.setItem("checkPopupAfficheCount", 1);
                localStorage.setItem("checkPopupAfficheTime", datetime.getTime());
                $(".tankuang").fadeIn(300);
            }
        }else{
            var datetime = new Date();
            localStorage.setItem("checkPopupAfficheCount", 1);
            localStorage.setItem("checkPopupAfficheTime", datetime.getTime());
            $(".tankuang").fadeIn(300);
        }
    }





})

/**
 * Created by 7du-29 on 2017/12/1.
 */
$(function(){
    $(".lay").hide();
    $(".spec").hide();
    $(".shopCart").hide();
    $(".tips").hide();

    $(".choiceSpec").live("click",function(e){
        e.preventDefault();
        var id = $(this).attr('value');
        $(".lay").show();
        $(".li_"+id).show(100); 
        $(".li_"+id).find(".cupSize").addClass("cuptt");
        var cup  = $(".li_"+id).find('.cupSize>.cupCur>span').text();
        var shux = $(".li_"+id).find('.temperature>.terCur>span').length;
        var ttd = '';
        for (var i = 0; i < shux; i++) {
            ttd += '/';
            ttd += $(".li_"+id).find(".shux_"+i).find('.terCur>span').text();
            $(".li_"+id).find(".shux_"+i).addClass('shuxi');
        };
        $(".li_"+id).find('.shopPrice>em').html(cup);
        $(".li_"+id).find('.shopPrice>dfn').html(ttd);
        $(".li_"+id).find("#goodsid").addClass('goodsid');
        $(".li_"+id).find("#ouate").addClass('ouate');
        $(".li_"+id).find("#xuic").addClass('xuic');
        $(".li_"+id).find("#xuic").val(cup+ttd);
    });

    //选择杯型大小    
    $(".cuptt>a").live("click",function(){
        $(this).addClass("cupCur");
        $(".cuptt>a").not($(this)).removeClass("cupCur");
        var name = $(".cuptt").find('.cupCur span').text();
        console.log(name);
        $(".shopPrice>em").html(name);
        var ttd = $('.shopPrice>dfn').html();
        console.log(ttd);
        $(".xuic").val(name+ttd);
        var cup = $(this).attr('value');
        var goods = $('#goodsid').attr('value');
        // console.log(goods);
        $.ajax({
            type : 'post',
            url  : 'list_price',
            data : {cup:cup,goods:goods},
            dataType : 'json',
            success  : function(data) {
                $('#ouate').html('￥'+data.price);
            }
        })
    })
    // 属性
    $(".shuxi>a").live("click",function(){
        var id = $(this).attr('value');
        console.log(id);
        $('#goods_'+id).addClass("terCur");
        $(".shuxi>a").not($('#goods_'+id)).removeClass("terCur");
    })

    $(".closeSpec").click(function(){
        $(".lay").hide();
        $(".spec").hide(100);
        $(".cupSize").removeClass("cuptt");
        $("#xuic").removeClass('xuic');
        $("#ouate").removeClass('ouate');
//      $("#goodsid").removeClass('goodsid');
        $(".spec>p").removeClass('goodsid');
    });
    usorep();  
    //点击购物车
    $(".yuan").click(function(){
        var ddTol=0;
        // var usore = $('.pjoTitle').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_inex',
            data : {usore:0},
            dataType : 'json',
            success  : function(data) {
                // console.log(data);
                if(data.code == 200) {
                    var html = "";
                    html += '<dl>'
                        +'<dt class="cartTitle">'
                            +'<span>已选商品</span>'
                            +'<em class="clearCart">清空</em>'
                        +'</dt>';
                        for(var it in data.data){
                            html += '<dd class="cartList html_'+data.data[it].cart_id+'">';
                                html += '<div class="commodity">';
                                    html += '<p>'+data.data[it].product_name+'</p>';
                                    html += '<span>'+data.data[it].shux_name+'</dfn>';
                                html += '</div>';
                                html += '<div class="shopPriceBox">';
                                    html += '<span class="shopNumPrice">￥<em>'+data.data[it].money+'</em></span>';
                                    html += '<em class="shopNum">';
                                        html += '<img class="reduce" src="static/style_default/images/add_03.png" alt="" onclick="reduce('+data.data[it].cart_id+');"/>';
                                        html += '<span id="ou_'+data.data[it].cart_id+'">'+data.data[it].prot_count+'</span>';
                                        html += '<img class="add" src="static/style_default/images/add_05.png" alt="" onclick="add('+data.data[it].cart_id+');"/>';
                                    html += '</em>';
                                html += '</div>';
                            html += '</dd>';
                        };
                     html += '<dt class="shopText">商品如需分开打包，请在下单时备注</dt>';
                   html += '</dl>';
                   $('.shopCart').html(html);
                }
            }
        })
        if( $(this).hasClass("show") ){
            $(this).removeClass("show");
            $(".lay").hide();
            $(".shopCart").slideUp(200);
        }else{
            $(".shopCart>dl>dd").each(function(i){
                var ddLen=$(".shopCart>dl>dd").eq(i).length;
                ddTol=ddTol+ddLen;
            });
            if( ddTol<=0 ){
                $(".yuan>i").hide();
                $(".shopCart").slideUp(200);
                $(".lay").hide();
            }else{
                $(".yuan>i").show();
                $(this).addClass("show");
                $(".lay").show();
                $(".shopCart").slideDown(200);               
            }
        }
    });

    //清空购物车
    $(".clearCart").click(function(){
        $(".tips").show(100);
    });
    $(".cancelClear").click(function(){
        $(".tips").hide(100);
    });
    $(".sureClear").click(function(){
        var stoue = $(this).attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_delete',
            data : {stoue:stoue},
            dataType : 'json',
            success  : function (data) {
                console.log(data);
                if (data.code == 200) {
                    $(".shopCart>dl>dd").remove();
                    $(".shopCart").hide();
                    $(".tips").hide(100);
                    $(".yuan>i").html(0);
                    $(".yuan>i").hide();
                    $(".lay").hide();
                };
            }
        })
    });
    // 加入购物车
    $(".cart").live("click",function(){
        var goods = $('.goodsid').attr('value');
        var manoe = $('.ouate').text();
        var manoe = manoe.slice(1, manoe.length);
        var shuxi = $('.xuic').attr('value');
        var tost  = $('.pjoTitle').attr('value');
        var name  = $('#store_name').attr('value');
        var spec  = $(".cuptt").find('.cupCur').attr('value');
        $.ajax({
            type : 'post',
            url  : 'shop_add',
            data : {tost:tost,goods:goods,manoe:manoe,shuxi:shuxi,name:name,spec:spec,oute:1},
            dataType : 'json',
            success  : function(data) {
                if (data.code == 200) {
                    $(".lay").hide();
                    $(".spec").hide(100);
                    $(".cupSize").removeClass("cuptt");
                    $("#xuic").removeClass('xuic');
                    $("#ouate").removeClass('ouate');
            //      $("#goodsid").removeClass('goodsid');
                    $(".spec>p").removeClass('goodsid');
                    usorep(); 
                };
            }
        })
    })

});




















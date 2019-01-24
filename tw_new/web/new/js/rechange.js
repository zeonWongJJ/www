/**
 * Created by 7du-29 on 2017/7/31.
 */
$(function(){
    $(".sum>input").on("input",function(){
        $(".close").show();
        console.log($(this).val())
    })
    $(".close").click(function(){
        $(".sum>input").val("");
        $(this).hide();
    })
    $(".sum>input").keyup(function () {
        //如果输入非数字，则替换为''
        //this.value = this.value.replace(/[^\d]/g, '');
        $(this).val($(this).val().replace(/[^\d]/g, ''))
    })
})
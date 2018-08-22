/**
 * Created by zhibin on 2017/9/4.
 */
$(function(){
    for(var i=1;i<7;i++){
        setGoldText("#moenyBTN_0"+i);
    }
})
function onMoneyBTN(obj){
    var money0 = parseInt($(obj).attr('money'));
    var money1 = 0;
    if($("#gold").val() != ''){
        money1 = parseInt($("#gold").val());
    }
    //console.log(money);
    var money = money0+money1;
    if(money < $("input[name='gmin_single']").val() || money > $("input[name='singlecredit']").val()){
        alert('超出限制')
    }else{
        $("#gold").val(money);
        $("#confirm_gold").val(money);
    }
}

function setGoldText(moneyObjName){
    var money = $(moneyObjName).attr('money');
    //console.log(money);
    //if(money < $("input[name='gmin_single']").val() || money > $("input[name='singlecredit']").val()){
    ///    $(moneyObjName).attr("class","miniWord off");
    //}else{
        $(moneyObjName).attr("class","");
        $(moneyObjName).attr("onclick","onMoneyBTN(this)");
    //}
}

function
clearsetfocus(){
var gold=document.getElementById("gold");
gold.value="";
gold.focus();
}

hot_header = this;
var resize = 0;
var display_loadTime="";
top.countLoading = 0;
var chk_Obj = new Object();
chk_Obj["tv"]=0;
chk_Obj["body"]=0;
chk_Obj["head"]=0;
chk_Obj["order"]=0;
var g_count=0;
var last_w = null; //last width of window small than 1359
var head_finish = false;

// 2017-03-02 更正header與body 同時載入 造成 top.ShowLoveIarray --> undefined 的問題
initDate();
initlid_FT();
initlid_BK();
initlid_BS();
initlid_TN();
initlid_VB();
initlid_BM();
initlid_TT();
initlid_OP();
initlid_SK();
showGtype = top.gtypeShowLoveI;

function init(){
 trace("init");


 if(!top.showKR) top.showKR="N";

 var tmp_url = document.getElementById("header").getAttribute("url").split("?");
 filename = tmp_url[0];
 param = tmp_url[1];

 if(top.mem_status=="S"){
  var obj = document.getElementById("status_s_"+top.langx)||document.getElementById("status_s_en-us");
  obj.style.display = "";
  display_loadingMain("tv");
 }

 /*
  var orderObj = document.getElementById("mem_order");
  var order_url = (orderObj)?orderObj.getAttribute("url"):null;
  if(order_url!=null) orderObj.src=order_url;



  var tvObj = document.getElementById("show_tv");
  var par = "";
  par+="uid="+top.uid;
  par+="&langx="+top.langx;
  par+="&liveid="+top.liveid;
  par+="&autoOddCheck="+top.autoOddCheck;
  par+="&opentype=self";

  var tv_url = util.getNowDomain()+"/app/member/live/live.php?"+par;

  */

 var tvObj = document.getElementById("show_tv");

 if(tvObj!=null && top.mem_status !="S") {
  if(top.showKR!="Y"){
//tvObj.src=tv_url;
  }else{
   chk_Obj["tv"]++;
  }
 }else {
// 2017-03-03 3039.新會員端-只能看帳-右邊tv有loading畫面，應該秀廣告(BGM-328)(可參考crm-132)
//document.getElementById("noTV").style.display="";
 }

 loadHead(filename, param, function(){

  head_finish = true;

//console.log("loadHead finish");
  try{
   initHeader();
  }catch(e){}

 });



 display_loadTime = setTimeout("display_loadingMain('over')",1000*8);



 /*try{
  FT_lid_ary=top.FT_lid['FT_lid_ary'];
  FT_lid_type=top.FT_lid['FT_lid_type'];
  FT_lname_ary=top.FT_lid['FT_lname_ary'];
  FT_lid_ary_RE=top.FT_lid['FT_lid_ary_RE'];
  FT_lname_ary_RE=top.FT_lid['FT_lname_ary_RE'];
  FU_lid_ary=top.FU_lid['FU_lid_ary'];
  FU_lid_type=top.FU_lid['FU_lid_type'];
  FU_lname_ary=top.FU_lid['FU_lname_ary'];
  FSFT_lid_ary=top.FSFT_lid['FSFT_lid_ary'];
  FSFT_lname_ary=top.FSFT_lid['FSFT_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  FT_HOT_lid_ary=top.FT_lid['FT_HOT_lid_ary'];
  FT_HOT_lid_type=top.FT_lid['FT_HOT_lid_type'];
  FT_HOT_lname_ary=top.FT_lid['FT_HOT_lname_ary'];
  FT_HOT_lid_ary_RE=top.FT_lid['FT_HOT_lid_ary_RE'];
  FT_HOT_lname_ary_RE=top.FT_lid['FT_HOT_lname_ary_RE'];
  FU_HOT_lid_ary=top.FU_lid['FU_HOT_lid_ary'];
  FU_HOT_lid_type=top.FU_lid['FU_HOT_lid_type'];
  FU_HOT_lname_ary=top.FU_lid['FU_HOT_lname_ary'];
  FSFT_HOT_lid_ary=top.FSFT_lid['FSFT_HOT_lid_ary'];
  FSFT_HOT_lname_ary=top.FSFT_lid['FSFT_HOT_lname_ary'];

  // 特別賽事
  FT_SP_lid_ary=top.FT_lid['FT_SP_lid_ary'];
  FT_SP_lid_type=top.FT_lid['FT_SP_lid_type'];
  FT_SP_lname_ary=top.FT_lid['FT_SP_lname_ary'];
  FT_SP_lid_ary_RE=top.FT_lid['FT_SP_lid_ary_RE'];
  FT_SP_lname_ary_RE=top.FT_lid['FT_lsp_name_ary_RE'];
  FU_SP_lid_ary=top.FU_lid['FU_SP_lid_ary'];
  FU_SP_lid_type=top.FU_lid['FU_SP_lid_type'];
  FU_SP_lname_ary=top.FU_lid['FU_SP_lname_ary'];
  FSFT_SP_lid_ary=top.FSFT_lid['FSFT_SP_lid_ary'];
  FSFT_SP_lname_ary=top.FSFT_lid['FSFT_SP_lname_ary'];
  }catch(E){
  initlid_FT();
  }
  try{
  BK_lid_ary=top.BK_lid['BK_lid_ary'];
  BK_lid_type=top.BK_lid['BK_lid_type'];
  BK_lname_ary=top.BK_lid['BK_lname_ary'];
  BK_lid_ary_RE=top.BK_lid['BK_lid_ary_RE'];
  BK_lname_ary_RE=top.BK_lid['BK_lname_ary_RE'];
  BU_lid_ary=top.BU_lid['BU_lid_ary'];
  BU_lid_type=top.BU_lid['BU_lid_type'];
  BU_lname_ary=top.BU_lid['BU_lname_ary'];
  FSBK_lid_ary=top.FSBK_lid['FSBK_lid_ary'];
  FSBK_lname_ary=top.FSBK_lid['FSBK_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  BK_HOT_lid_ary=top.BK_lid['BK_HOT_lid_ary'];
  BK_HOT_lid_type=top.BK_lid['BK_HOT_lid_type'];
  BK_HOT_lname_ary=top.BK_lid['BK_HOT_lname_ary'];
  BK_HOT_lid_ary_RE=top.BK_lid['BK_HOT_lid_ary_RE'];
  BK_HOT_lname_ary_RE=top.BK_lid['BK_HOT_lname_ary_RE'];
  BU_HOT_lid_ary=top.BU_lid['BU_HOT_lid_ary'];
  BU_HOT_lid_type=top.BU_lid['BU_HOT_lid_type'];
  BU_HOT_lname_ary=top.BU_lid['BU_HOT_lname_ary'];
  FSBK_HOT_lid_ary=top.FSBK_lid['FSBK_HOT_lid_ary'];
  FSBK_HOT_lname_ary=top.FSBK_lid['FSBK_HOT_lname_ary'];

  // 特別賽事
  BK_SP_lid_ary=top.BK_lid['BK_SP_lid_ary'];
  BK_SP_lid_type=top.BK_lid['BK_SP_lid_type'];
  BK_SP_lname_ary=top.BK_lid['BK_SP_lname_ary'];
  BK_SP_lid_ary_RE=top.BK_lid['BK_SP_lid_ary_RE'];
  BK_SP_lname_ary_RE=top.BK_lid['BK_SP_lname_ary_RE'];
  BU_SP_lid_ary=top.BU_lid['BU_SP_lid_ary'];
  BU_SP_lid_type=top.BU_lid['BU_SP_lid_type'];
  BU_SP_lname_ary=top.BU_lid['BU_SP_lname_ary'];
  FSBK_SP_lid_ary=top.FSBK_lid['FSBK_SP_lid_ary'];
  FSBK_SP_lname_ary=top.FSBK_lid['FSBK_SP_lname_ary'];
  }catch(E){
  initlid_BK();
  }
  try{
  BS_lid_ary=top.BS_lid['BS_lid_ary'];
  BS_lid_type=top.BS_lid['BS_lid_type'];
  BS_lname_ary=top.BS_lid['BS_lname_ary'];
  BS_lid_ary_RE=top.BS_lid['BS_lid_ary_RE'];
  BS_lname_ary_RE=top.BS_lid['BS_lname_ary_RE'];
  BSFU_lid_ary=top.BSFU_lid['BSFU_lid_ary'];
  BSFU_lid_type=top.BSFU_lid['BSFU_lid_type'];
  BSFU_lname_ary=top.BSFU_lid['BSFU_lname_ary'];
  FSBS_lid_ary=top.FSBS_lid['FSBS_lid_ary'];
  FSBS_lname_ary=top.FSBS_lid['FSBS_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  BS_HOT_lid_ary=top.BS_lid['BS_HOT_lid_ary'];
  BS_HOT_lid_type=top.BS_lid['BS_HOT_lid_type'];
  BS_HOT_lname_ary=top.BS_lid['BS_HOT_lname_ary'];
  BS_HOT_lid_ary_RE=top.BS_lid['BS_HOT_lid_ary_RE'];
  BS_HOT_lname_ary_RE=top.BS_lid['BS_HOT_lname_ary_RE'];
  BSFU_HOT_lid_ary=top.BSFU_lid['BSFU_HOT_lid_ary'];
  BSFU_HOT_lid_type=top.BSFU_lid['BSFU_HOT_lid_type'];
  BSFU_HOT_lname_ary=top.BSFU_lid['BSFU_HOT_lname_ary'];
  FSBS_HOT_lid_ary=top.FSBS_lid['FSBS_HOT_lid_ary'];
  FSBS_HOT_lname_ary=top.FSBS_lid['FSBS_HOT_lname_ary'];

  // 特別賽事
  BS_SP_lid_ary=top.BS_lid['BS_SP_lid_ary'];
  BS_SP_lid_type=top.BS_lid['BS_SP_lid_type'];
  BS_SP_lname_ary=top.BS_lid['BS_SP_lname_ary'];
  BS_SP_lid_ary_RE=top.BS_lid['BS_SP_lid_ary_RE'];
  BS_SP_lname_ary_RE=top.BS_lid['BS_SP_lname_ary_RE'];
  BSFU_SP_lid_ary=top.BSFU_lid['BSFU_SP_lid_ary'];
  BSFU_SP_lid_type=top.BSFU_lid['BSFU_SP_lid_type'];
  BSFU_SP_lname_ary=top.BSFU_lid['BSFU_SP_lname_ary'];
  FSBS_SP_lid_ary=top.FSBS_lid['FSBS_SP_lid_ary'];
  FSBS_SP_lname_ary=top.FSBS_lid['FSBS_SP_lname_ary'];
  }catch(E){
  initlid_BS();
  }
  try{
  TN_lid_ary=top.TN_lid['TN_lid_ary'];
  TN_lid_type=top.TN_lid['TN_lid_type'];
  TN_lname_ary=top.TN_lid['TN_lname_ary'];
  TN_lid_ary_RE=top.TN_lid['TN_lid_ary_RE'];
  TN_lname_ary_RE=top.TN_lid['TN_lname_ary_RE'];
  TU_lid_ary=top.TU_lid['TU_lid_ary'];
  TU_lid_type=top.TU_lid['TU_lid_type'];
  TU_lname_ary=top.TU_lid['TU_lname_ary'];
  FSTN_lid_ary=top.FSTN_lid['FSTN_lid_ary'];
  FSTN_lname_ary=top.FSTN_lid['FSTN_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  TN_HOT_lid_ary=top.TN_lid['TN_HOT_lid_ary'];
  TN_HOT_lid_type=top.TN_lid['TN_HOT_lid_type'];
  TN_HOT_lname_ary=top.TN_lid['TN_HOT_lname_ary'];
  TN_HOT_lid_ary_RE=top.TN_lid['TN_HOT_lid_ary_RE'];
  TN_HOT_lname_ary_RE=top.TN_lid['TN_HOT_lname_ary_RE'];
  TU_HOT_lid_ary=top.TU_lid['TU_HOT_lid_ary'];
  TU_HOT_lid_type=top.TU_lid['TU_HOT_lid_type'];
  TU_HOT_lname_ary=top.TU_lid['TU_HOT_lname_ary'];
  FSTN_HOT_lid_ary=top.FSTN_lid['FSTN_HOT_lid_ary'];
  FSTN_HOT_lname_ary=top.FSTN_lid['FSTN_HOT_lname_ary'];

  // 特別賽事
  TN_SP_lid_ary=top.TN_lid['TN_SP_lid_ary'];
  TN_SP_lid_type=top.TN_lid['TN_SP_lid_type'];
  TN_SP_lname_ary=top.TN_lid['TN_SP_lname_ary'];
  TN_SP_lid_ary_RE=top.TN_lid['TN_SP_lid_ary_RE'];
  TN_SP_lname_ary_RE=top.TN_lid['TN_SP_lname_ary_RE'];
  TU_SP_lid_ary=top.TU_lid['TU_SP_lid_ary'];
  TU_SP_lid_type=top.TU_lid['TU_SP_lid_type'];
  TU_SP_lname_ary=top.TU_lid['TU_SP_lname_ary'];
  FSTN_SP_lid_ary=top.FSTN_lid['FSTN_SP_lid_ary'];
  FSTN_SP_lname_ary=top.FSTN_lid['FSTN_SP_lname_ary'];
  }catch(E){
  initlid_TN();
  }
  try{
  VB_lid_ary=top.VB_lid['VB_lid_ary'];
  VB_lid_type=top.VB_lid['VB_lid_type'];
  VB_lname_ary=top.VB_lid['VB_lname_ary'];
  VB_lid_ary_RE=top.VB_lid['VB_lid_ary_RE'];
  VB_lname_ary_RE=top.VB_lid['VB_lname_ary_RE'];
  VU_lid_ary=top.VU_lid['VU_lid_ary'];
  VU_lid_type=top.VU_lid['VU_lid_type'];
  VU_lname_ary=top.VU_lid['VU_lname_ary'];
  FSVB_lid_ary=top.FSVB_lid['FSVB_lid_ary'];
  FSVB_lname_ary=top.FSVB_lid['FSVB_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  VB_HOT_lid_ary=top.VB_lid['VB_HOT_lid_ary'];
  VB_HOT_lid_type=top.VB_lid['VB_HOT_lid_type'];
  VB_HOT_lname_ary=top.VB_lid['VB_HOT_lname_ary'];
  VB_HOT_lid_ary_RE=top.VB_lid['VB_HOT_lid_ary_RE'];
  VB_HOT_lname_ary_RE=top.VB_lid['VB_HOT_lname_ary_RE'];
  VU_HOT_lid_ary=top.VU_lid['VU_HOT_lid_ary'];
  VU_HOT_lid_type=top.VU_lid['VU_HOT_lid_type'];
  VU_HOT_lname_ary=top.VU_lid['VU_HOT_lname_ary'];
  FSVB_HOT_lid_ary=top.FSVB_lid['FSVB_HOT_lid_ary'];
  FSVB_HOT_lname_ary=top.FSVB_lid['FSVB_HOT_lname_ary'];

  // 特別賽事
  VB_SP_lid_ary=top.VB_lid['VB_SP_lid_ary'];
  VB_SP_lid_type=top.VB_lid['VB_SP_lid_type'];
  VB_SP_lname_ary=top.VB_lid['VB_SP_lname_ary'];
  VB_SP_lid_ary_RE=top.VB_lid['VB_SP_lid_ary_RE'];
  VB_SP_lname_ary_RE=top.VB_lid['VB_SP_lname_ary_RE'];
  VU_SP_lid_ary=top.VU_lid['VU_SP_lid_ary'];
  VU_SP_lid_type=top.VU_lid['VU_SP_lid_type'];
  VU_SP_lname_ary=top.VU_lid['VU_SP_lname_ary'];
  FSVB_SP_lid_ary=top.FSVB_lid['FSVB_SP_lid_ary'];
  FSVB_SP_lname_ary=top.FSVB_lid['FSVB_SP_lname_ary'];
  }catch(E){
  initlid_VB();
  }
  try{
  BM_lid_ary=top.BM_lid['BM_lid_ary'];
  BM_lid_type=top.BM_lid['BM_lid_type'];
  BM_lname_ary=top.BM_lid['BM_lname_ary'];
  BM_lid_ary_RE=top.BM_lid['BM_lid_ary_RE'];
  BM_lname_ary_RE=top.BM_lid['BM_lname_ary_RE'];
  BMFU_lid_ary=top.BMFU_lid['BMFU_lid_ary'];
  BMFU_lid_type=top.BMFU_lid['BMFU_lid_type'];
  BMFU_lname_ary=top.BMFU_lid['BMFU_lname_ary'];
  FSBM_lid_ary=top.FSBM_lid['FSBM_lid_ary'];
  FSBM_lname_ary=top.FSBM_lid['FSBM_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  BM_HOT_lid_ary=top.BM_lid['BM_HOT_lid_ary'];
  BM_HOT_lid_type=top.BM_lid['BM_HOT_lid_type'];
  BM_HOT_lname_ary=top.BM_lid['BM_HOT_lname_ary'];
  BM_HOT_lid_ary_RE=top.BM_lid['BM_HOT_lid_ary_RE'];
  BM_HOT_lname_ary_RE=top.BM_lid['BM_HOT_lname_ary_RE'];
  BMFU_HOT_lid_ary=top.BMFU_lid['BMFU_HOT_lid_ary'];
  BMFU_HOT_lid_type=top.BMFU_lid['BMFU_HOT_lid_type'];
  BMFU_HOT_lname_ary=top.BMFU_lid['BMFU_HOT_lname_ary'];
  FSBM_HOT_lid_ary=top.FSBM_lid['FSBM_HOT_lid_ary'];
  FSBM_HOT_lname_ary=top.FSBM_lid['FSBM_HOT_lname_ary'];

  // 特別賽事
  BM_SP_lid_ary=top.BM_lid['BM_SP_lid_ary'];
  BM_SP_lid_type=top.BM_lid['BM_SP_lid_type'];
  BM_SP_lname_ary=top.BM_lid['BM_SP_lname_ary'];
  BM_SP_lid_ary_RE=top.BM_lid['BM_SP_lid_ary_RE'];
  BM_SP_lname_ary_RE=top.BM_lid['BM_SP_lname_ary_RE'];
  BMFU_SP_lid_ary=top.BMFU_lid['BMFU_SP_lid_ary'];
  BMFU_SP_lid_type=top.BMFU_lid['BMFU_SP_lid_type'];
  BMFU_SP_lname_ary=top.BMFU_lid['BMFU_SP_lname_ary'];
  FSBM_SP_lid_ary=top.FSBM_lid['FSBM_SP_lid_ary'];
  FSBM_SP_lname_ary=top.FSBM_lid['FSBM_SP_lname_ary'];
  }catch(E){
  initlid_BM();
  }

  try{
  TT_lid_ary=top.TT_lid['TT_lid_ary'];
  TT_lid_type=top.TT_lid['TT_lid_type'];
  TT_lname_ary=top.TT_lid['TT_lname_ary'];
  TT_lid_ary_RE=top.TT_lid['TT_lid_ary_RE'];
  TT_lname_ary_RE=top.TT_lid['TT_lname_ary_RE'];
  TTFU_lid_ary=top.TTFU_lid['TTFU_lid_ary'];
  TTFU_lid_type=top.TTFU_lid['TTFU_lid_type'];
  TTFU_lname_ary=top.TTFU_lid['TTFU_lname_ary'];
  FSTT_lid_ary=top.FSTT_lid['FSTT_lid_ary'];
  FSTT_lname_ary=top.FSTT_lid['FSTT_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  TT_HOT_lid_ary=top.TT_lid['TT_HOT_lid_ary'];
  TT_HOT_lid_type=top.TT_lid['TT_HOT_lid_type'];
  TT_HOT_lname_ary=top.TT_lid['TT_HOT_lname_ary'];
  TT_HOT_lid_ary_RE=top.TT_lid['TT_HOT_lid_ary_RE'];
  TT_HOT_lname_ary_RE=top.TT_lid['TT_HOT_lname_ary_RE'];
  TTFU_HOT_lid_ary=top.TTFU_lid['TTFU_HOT_lid_ary'];
  TTFU_HOT_lid_type=top.TTFU_lid['TTFU_HOT_lid_type'];
  TTFU_HOT_lname_ary=top.TTFU_lid['TTFU_HOT_lname_ary'];
  FSTT_HOT_lid_ary=top.FSTT_lid['FSTT_HOT_lid_ary'];
  FSTT_HOT_lname_ary=top.FSTT_lid['FSTT_HOT_lname_ary'];

  // 特別賽事
  TT_SP_lid_ary=top.TT_lid['TT_SP_lid_ary'];
  TT_SP_lid_type=top.TT_lid['TT_SP_lid_type'];
  TT_SP_lname_ary=top.TT_lid['TT_SP_lname_ary'];
  TT_SP_lid_ary_RE=top.TT_lid['TT_SP_lid_ary_RE'];
  TT_SP_lname_ary_RE=top.TT_lid['TT_SP_lname_ary_RE'];
  TTFU_SP_lid_ary=top.TTFU_lid['TTFU_SP_lid_ary'];
  TTFU_SP_lid_type=top.TTFU_lid['TTFU_SP_lid_type'];
  TTFU_SP_lname_ary=top.TTFU_lid['TTFU_SP_lname_ary'];
  FSTT_SP_lid_ary=top.FSTT_lid['FSTT_SP_lid_ary'];
  FSTT_SP_lname_ary=top.FSTT_lid['FSTT_SP_lname_ary'];
  }catch(E){
  initlid_TT();
  }

  try{
  OP_lid_ary=top.OP_lid['OP_lid_ary'];
  OP_lid_type=top.OP_lid['OP_lid_type'];
  OP_lname_ary=top.OP_lid['OP_lname_ary'];
  OP_lid_ary_RE=top.OP_lid['OP_lid_ary_RE'];
  OP_lname_ary_RE=top.OP_lid['OP_lname_ary_RE'];
  OM_lid_ary=top.OM_lid['OM_lid_ary'];
  OM_lid_type=top.OM_lid['OM_lid_type'];
  OM_lname_ary=top.OM_lid['OM_lname_ary'];
  FSOP_lid_ary=top.FSOP_lid['FSOP_lid_ary'];
  FSOP_lname_ary=top.FSOP_lid['FSOP_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  OP_HOT_lid_ary=top.OP_lid['OP_HOT_lid_ary'];
  OP_HOT_lid_type=top.OP_lid['OP_HOT_lid_type'];
  OP_HOT_lname_ary=top.OP_lid['OP_HOT_lname_ary'];
  OP_HOT_lid_ary_RE=top.OP_lid['OP_HOT_lid_ary_RE'];
  OP_HOT_lname_ary_RE=top.OP_lid['OP_HOT_lname_ary_RE'];
  OM_HOT_lid_ary=top.OM_lid['OM_HOT_lid_ary'];
  OM_HOT_lid_type=top.OM_lid['OM_HOT_lid_type'];
  OM_HOT_lname_ary=top.OM_lid['OM_HOT_lname_ary'];
  FSOP_HOT_lid_ary=top.FSOP_lid['FSOP_HOT_lid_ary'];
  FSOP_HOT_lname_ary=top.FSOP_lid['FSOP_HOT_lname_ary'];

  // 特別賽事
  OP_SP_lid_ary=top.OP_lid['OP_SP_lid_ary'];
  OP_SP_lid_type=top.OP_lid['OP_SP_lid_type'];
  OP_SP_lname_ary=top.OP_lid['OP_SP_lname_ary'];
  OP_SP_lid_ary_RE=top.OP_lid['OP_SP_lid_ary_RE'];
  OP_SP_lname_ary_RE=top.OP_lid['OP_SP_lname_ary_RE'];
  OM_SP_lid_ary=top.OM_lid['OM_SP_lid_ary'];
  OM_SP_lid_type=top.OM_lid['OM_SP_lid_type'];
  OM_SP_lname_ary=top.OM_lid['OM_SP_lname_ary'];
  FSOP_SP_lid_ary=top.FSOP_lid['FSOP_SP_lid_ary'];
  FSOP_SP_lname_ary=top.FSOP_lid['FSOP_SP_lname_ary'];
  }catch(E){
  initlid_OP();
  }
  try{
  SK_lid_ary=top.SK_lid['SK_lid_ary'];
  SK_lid_type=top.SK_lid['SK_lid_type'];
  SK_lname_ary=top.SK_lid['SK_lname_ary'];
  SK_lid_ary_RE=top.SK_lid['SK_lid_ary_RE'];
  SK_lname_ary_RE=top.SK_lid['SK_lname_ary_RE'];
  SKFU_lid_ary=top.SKFU_lid['SKFU_lid_ary'];
  SKFU_lid_type=top.SKFU_lid['SKFU_lid_type'];
  SKFU_lname_ary=top.SKFU_lid['SKFU_lname_ary'];
  FSSK_lid_ary=top.FSSK_lid['FSSK_lid_ary'];
  FSSK_lname_ary=top.FSSK_lid['FSSK_lname_ary'];

  // 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
  // 精選賽事
  SK_HOT_lid_ary=top.SK_lid['SK_HOT_lid_ary'];
  SK_HOT_lid_type=top.SK_lid['SK_HOT_lid_type'];
  SK_HOT_lname_ary=top.SK_lid['SK_HOT_lname_ary'];
  SK_HOT_lid_ary_RE=top.SK_lid['SK_HOT_lid_ary_RE'];
  SK_HOT_lname_ary_RE=top.SK_lid['SK_HOT_lname_ary_RE'];
  SKFU_HOT_lid_ary=top.SKFU_lid['SKFU_HOT_lid_ary'];
  SKFU_HOT_lid_type=top.SKFU_lid['SKFU_HOT_lid_type'];
  SKFU_HOT_lname_ary=top.SKFU_lid['SKFU_HOT_lname_ary'];
  FSSK_HOT_lid_ary=top.FSSK_lid['FSSK_HOT_lid_ary'];
  FSSK_HOT_lname_ary=top.FSSK_lid['FSSK_HOT_lname_ary'];

  // 特別賽事
  SK_SP_lid_ary=top.SK_lid['SK_SP_lid_ary'];
  SK_SP_lid_type=top.SK_lid['SK_SP_lid_type'];
  SK_SP_lname_ary=top.SK_lid['SK_SP_lname_ary'];
  SK_SP_lid_ary_RE=top.SK_lid['SK_SP_lid_ary_RE'];
  SK_SP_lname_ary_RE=top.SK_lid['SK_SP_lname_ary_RE'];
  SKFU_SP_lid_ary=top.SKFU_lid['SKFU_SP_lid_ary'];
  SKFU_SP_lid_type=top.SKFU_lid['SKFU_SP_lid_type'];
  SKFU_SP_lname_ary=top.SKFU_lid['SKFU_SP_lname_ary'];
  FSSK_SP_lid_ary=top.FSSK_lid['FSSK_SP_lid_ary'];
  FSSK_SP_lname_ary=top.FSSK_lid['FSSK_SP_lname_ary'];
  }catch(E){
  initlid_SK();
  }    */
}



function loadHead(filename, param, loadFun){

 var paramObj = new Object();
 paramObj.targetWindow = document.getElementById("header");
 paramObj.targetHead = document.getElementsByTagName("head")[0];
 paramObj.filename = filename;
 paramObj.param = param;
 paramObj.loadComplete = loadFun;

 util.goToPage(paramObj.filename, paramObj);
}

function initlid_FT(){
 top.FT_lid = new Array();
 top.FU_lid = new Array();
 top.FSFT_lid = new Array();
 top.FT_lid['FT_lid_ary']= FT_lid_ary='ALL';
 top.FT_lid['FT_lid_type']= FT_lid_type='';
 top.FT_lid['FT_lname_ary']= FT_lname_ary='ALL';
 top.FT_lid['FT_lid_ary_RE']= FT_lid_ary_RE='ALL';
 top.FT_lid['FT_lname_ary_RE']= FT_lname_ary_RE='ALL';
 top.FU_lid['FU_lid_ary']= FU_lid_ary='ALL';
 top.FU_lid['FU_lid_type']= FU_lid_type='';
 top.FU_lid['FU_lname_ary']= FU_lname_ary='ALL';
 top.FSFT_lid['FSFT_lid_ary']= FSFT_lid_ary='ALL';
 top.FSFT_lid['FSFT_lname_ary']= FSFT_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.FT_lid['FT_HOT_lid_ary']= FT_HOT_lid_ary='ALL';
 top.FT_lid['FT_HOT_lid_type']= FT_HOT_lid_type='';
 top.FT_lid['FT_HOT_lname_ary']= FT_HOT_lname_ary='ALL';
 top.FT_lid['FT_HOT_lid_ary_RE']= FT_HOT_lid_ary_RE='ALL';
 top.FT_lid['FT_HOT_lname_ary_RE']= FT_HOT_lname_ary_RE='ALL';
 top.FU_lid['FU_HOT_lid_ary']= FU_HOT_lid_ary='ALL';
 top.FU_lid['FU_HOT_lid_type']= FU_HOT_lid_type='';
 top.FU_lid['FU_HOT_lname_ary']= FU_HOT_lname_ary='ALL';
 top.FSFT_lid['FSFT_HOT_lid_ary']= FSFT_HOT_lid_ary='ALL';
 top.FSFT_lid['FSFT_HOT_lname_ary']= FSFT_HOT_lname_ary='ALL';

// 特別賽事
 top.FT_lid['FT_SP_lid_ary']= FT_SP_lid_ary='ALL';
 top.FT_lid['FT_SP_lid_type']= FT_SP_lid_type='';
 top.FT_lid['FT_SP_lname_ary']= FT_SP_lname_ary='ALL';
 top.FT_lid['FT_SP_lid_ary_RE']= FT_SP_lid_ary_RE='ALL';
 top.FT_lid['FT_SP_lname_ary_RE']= FT_SP_lname_ary_RE='ALL';
 top.FU_lid['FU_SP_lid_ary']= FU_SP_lid_ary='ALL';
 top.FU_lid['FU_SP_lid_type']= FU_SP_lid_type='';
 top.FU_lid['FU_SP_lname_ary']= FU_SP_lname_ary='ALL';
 top.FSFT_lid['FSFT_SP_lid_ary']= FSFT_SP_lid_ary='ALL';
 top.FSFT_lid['FSFT_SP_lname_ary']= FSFT_SP_lname_ary='ALL';
}
function initlid_BK(){
 top.BK_lid = new Array();
 top.BU_lid = new Array();
 top.FSBK_lid = new Array();
 top.BK_lid['BK_lid_ary']= BK_lid_ary='ALL';
 top.BK_lid['BK_lid_type']= BK_lid_type='';
 top.BK_lid['BK_lname_ary']= BK_lname_ary='ALL';
 top.BK_lid['BK_lid_ary_RE']= BK_lid_ary_RE='ALL';
 top.BK_lid['BK_lname_ary_RE']= BK_lname_ary_RE='ALL';
 top.BU_lid['BU_lid_ary']= BU_lid_ary='ALL';
 top.BU_lid['BU_lid_type']= BU_lid_type='';
 top.BU_lid['BU_lname_ary']= BU_lname_ary='ALL';
 top.FSBK_lid['FSBK_lid_ary']= FSBK_lid_ary='ALL';
 top.FSBK_lid['FSBK_lname_ary']= FSBK_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.BK_lid['BK_HOT_lid_ary']= BK_HOT_lid_ary='ALL';
 top.BK_lid['BK_HOT_lid_type']= BK_HOT_lid_type='';
 top.BK_lid['BK_HOT_lname_ary']= BK_HOT_lname_ary='ALL';
 top.BK_lid['BK_HOT_lid_ary_RE']= BK_HOT_lid_ary_RE='ALL';
 top.BK_lid['BK_HOT_lname_ary_RE']= BK_HOT_lname_ary_RE='ALL';
 top.BU_lid['BU_HOT_lid_ary']= BU_HOT_lid_ary='ALL';
 top.BU_lid['BU_HOT_lid_type']= BU_HOT_lid_type='';
 top.BU_lid['BU_HOT_lname_ary']= BU_HOT_lname_ary='ALL';
 top.FSBK_lid['FSBK_HOT_lid_ary']= FSBK_HOT_lid_ary='ALL';
 top.FSBK_lid['FSBK_HOT_lname_ary']= FSBK_HOT_lname_ary='ALL';

// 特別賽事
 top.BK_lid['BK_SP_lid_ary']= BK_SP_lid_ary='ALL';
 top.BK_lid['BK_SP_lid_type']= BK_SP_lid_type='';
 top.BK_lid['BK_SP_lname_ary']= BK_SP_lname_ary='ALL';
 top.BK_lid['BK_SP_lid_ary_RE']= BK_SP_lid_ary_RE='ALL';
 top.BK_lid['BK_SP_lname_ary_RE']= BK_SP_lname_ary_RE='ALL';
 top.BU_lid['BU_SP_lid_ary']= BU_SP_lid_ary='ALL';
 top.BU_lid['BU_SP_lid_type']= BU_SP_lid_type='';
 top.BU_lid['BU_SP_lname_ary']= BU_SP_lname_ary='ALL';
 top.FSBK_lid['FSBK_SP_lid_ary']= FSBK_SP_lid_ary='ALL';
 top.FSBK_lid['FSBK_SP_lname_ary']= FSBK_SP_lname_ary='ALL';
}
function initlid_BS(){
 top.BS_lid = new Array();
 top.BSFU_lid = new Array();
 top.FSBS_lid = new Array();
 top.BS_lid['BS_lid_ary']= BS_lid_ary='ALL';
 top.BS_lid['BS_lid_type']= BS_lid_type='';
 top.BS_lid['BS_lname_ary']= BS_lname_ary='ALL';
 top.BS_lid['BS_lid_ary_RE']= BS_lid_ary_RE='ALL';
 top.BS_lid['BS_lname_ary_RE']= BS_lname_ary_RE='ALL';
 top.BSFU_lid['BSFU_lid_ary']= BSFU_lid_ary='ALL';
 top.BSFU_lid['BSFU_lid_type']= BSFU_lid_type='';
 top.BSFU_lid['BSFU_lname_ary']= BSFU_lname_ary='ALL';
 top.FSBS_lid['FSBS_lid_ary']= FSBS_lid_ary='ALL';
 top.FSBS_lid['FSBS_lname_ary']= FSBS_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.BS_lid['BS_HOT_lid_ary']= BS_HOT_lid_ary='ALL';
 top.BS_lid['BS_HOT_lid_type']= BS_HOT_lid_type='';
 top.BS_lid['BS_HOT_lname_ary']= BS_HOT_lname_ary='ALL';
 top.BS_lid['BS_HOT_lid_ary_RE']= BS_HOT_lid_ary_RE='ALL';
 top.BS_lid['BS_HOT_lname_ary_RE']= BS_HOT_lname_ary_RE='ALL';
 top.BSFU_lid['BSFU_HOT_lid_ary']= BSFU_HOT_lid_ary='ALL';
 top.BSFU_lid['BSFU_HOT_lid_type']= BSFU_HOT_lid_type='';
 top.BSFU_lid['BSFU_HOT_lname_ary']= BSFU_HOT_lname_ary='ALL';
 top.FSBS_lid['FSBS_HOT_lid_ary']= FSBS_HOT_lid_ary='ALL';
 top.FSBS_lid['FSBS_HOT_lname_ary']= FSBS_HOT_lname_ary='ALL';

// 特別賽事
 top.BS_lid['BS_SP_lid_ary']= BS_SP_lid_ary='ALL';
 top.BS_lid['BS_SP_lid_type']= BS_SP_lid_type='';
 top.BS_lid['BS_SP_lname_ary']= BS_SP_lname_ary='ALL';
 top.BS_lid['BS_SP_lid_ary_RE']= BS_SP_lid_ary_RE='ALL';
 top.BS_lid['BS_SP_lname_ary_RE']= BS_SP_lname_ary_RE='ALL';
 top.BSFU_lid['BSFU_SP_lid_ary']= BSFU_SP_lid_ary='ALL';
 top.BSFU_lid['BSFU_SP_lid_type']= BSFU_SP_lid_type='';
 top.BSFU_lid['BSFU_SP_lname_ary']= BSFU_SP_lname_ary='ALL';
 top.FSBS_lid['FSBS_SP_lid_ary']= FSBS_SP_lid_ary='ALL';
 top.FSBS_lid['FSBS_SP_lname_ary']= FSBS_SP_lname_ary='ALL';
}
function initlid_TN(){
 top.TN_lid = new Array();
 top.TU_lid = new Array();
 top.FSTN_lid = new Array();
 top.TN_lid['TN_lid_ary']= TN_lid_ary='ALL';
 top.TN_lid['TN_lid_type']= TN_lid_type='';
 top.TN_lid['TN_lname_ary']= TN_lname_ary='ALL';
 top.TN_lid['TN_lid_ary_RE']= TN_lid_ary_RE='ALL';
 top.TN_lid['TN_lname_ary_RE']= TN_lname_ary_RE='ALL';
 top.TU_lid['TU_lid_ary']= TU_lid_ary='ALL';
 top.TU_lid['TU_lid_type']= TU_lid_type='';
 top.TU_lid['TU_lname_ary']= TU_lname_ary='ALL';
 top.FSTN_lid['FSTN_lid_ary']= FSTN_lid_ary='ALL';
 top.FSTN_lid['FSTN_lname_ary']= FSTN_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.TN_lid['TN_HOT_lid_ary']= TN_HOT_lid_ary='ALL';
 top.TN_lid['TN_HOT_lid_type']= TN_HOT_lid_type='';
 top.TN_lid['TN_HOT_lname_ary']= TN_HOT_lname_ary='ALL';
 top.TN_lid['TN_HOT_lid_ary_RE']= TN_HOT_lid_ary_RE='ALL';
 top.TN_lid['TN_HOT_lname_ary_RE']= TN_HOT_lname_ary_RE='ALL';
 top.TU_lid['TU_HOT_lid_ary']= TU_HOT_lid_ary='ALL';
 top.TU_lid['TU_HOT_lid_type']= TU_HOT_lid_type='';
 top.TU_lid['TU_HOT_lname_ary']= TU_HOT_lname_ary='ALL';
 top.FSTN_lid['FSTN_HOT_lid_ary']= FSTN_HOT_lid_ary='ALL';
 top.FSTN_lid['FSTN_HOT_lname_ary']= FSTN_HOT_lname_ary='ALL';

// 特別賽事
 top.TN_lid['TN_SP_lid_ary']= TN_SP_lid_ary='ALL';
 top.TN_lid['TN_SP_lid_type']= TN_SP_lid_type='';
 top.TN_lid['TN_SP_lname_ary']= TN_SP_lname_ary='ALL';
 top.TN_lid['TN_SP_lid_ary_RE']= TN_SP_lid_ary_RE='ALL';
 top.TN_lid['TN_SP_lname_ary_RE']= TN_SP_lname_ary_RE='ALL';
 top.TU_lid['TU_SP_lid_ary']= TU_SP_lid_ary='ALL';
 top.TU_lid['TU_SP_lid_type']= TU_SP_lid_type='';
 top.TU_lid['TU_SP_lname_ary']= TU_SP_lname_ary='ALL';
 top.FSTN_lid['FSTN_SP_lid_ary']= FSTN_SP_lid_ary='ALL';
 top.FSTN_lid['FSTN_SP_lname_ary']= FSTN_SP_lname_ary='ALL';
}
function initlid_VB(){
 top.VB_lid = new Array();
 top.VU_lid = new Array();
 top.FSVB_lid = new Array();
 top.VB_lid['VB_lid_ary']= VB_lid_ary='ALL';
 top.VB_lid['VB_lid_type']= VB_lid_type='';
 top.VB_lid['VB_lname_ary']= VB_lname_ary='ALL';
 top.VB_lid['VB_lid_ary_RE']= VB_lid_ary_RE='ALL';
 top.VB_lid['VB_lname_ary_RE']= VB_lname_ary_RE='ALL';
 top.VU_lid['VU_lid_ary']= VU_lid_ary='ALL';
 top.VU_lid['VU_lid_type']= VU_lid_type='';
 top.VU_lid['VU_lname_ary']= VU_lname_ary='ALL';
 top.FSVB_lid['FSVB_lid_ary']= FSVB_lid_ary='ALL';
 top.FSVB_lid['FSVB_lname_ary']= FSVB_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.VB_lid['VB_HOT_lid_ary']= VB_HOT_lid_ary='ALL';
 top.VB_lid['VB_HOT_lid_type']= VB_HOT_lid_type='';
 top.VB_lid['VB_HOT_lname_ary']= VB_HOT_lname_ary='ALL';
 top.VB_lid['VB_HOT_lid_ary_RE']= VB_HOT_lid_ary_RE='ALL';
 top.VB_lid['VB_HOT_lname_ary_RE']= VB_HOT_lname_ary_RE='ALL';
 top.VU_lid['VU_HOT_lid_ary']= VU_HOT_lid_ary='ALL';
 top.VU_lid['VU_HOT_lid_type']= VU_HOT_lid_type='';
 top.VU_lid['VU_HOT_lname_ary']= VU_HOT_lname_ary='ALL';
 top.FSVB_lid['FSVB_HOT_lid_ary']= FSVB_HOT_lid_ary='ALL';
 top.FSVB_lid['FSVB_HOT_lname_ary']= FSVB_HOT_lname_ary='ALL';

// 特別賽事
 top.VB_lid['VB_SP_lid_ary']= VB_SP_lid_ary='ALL';
 top.VB_lid['VB_SP_lid_type']= VB_SP_lid_type='';
 top.VB_lid['VB_SP_lname_ary']= VB_SP_lname_ary='ALL';
 top.VB_lid['VB_SP_lid_ary_RE']= VB_SP_lid_ary_RE='ALL';
 top.VB_lid['VB_SP_lname_ary_RE']= VB_SP_lname_ary_RE='ALL';
 top.VU_lid['VU_SP_lid_ary']= VU_SP_lid_ary='ALL';
 top.VU_lid['VU_SP_lid_type']= VU_SP_lid_type='';
 top.VU_lid['VU_SP_lname_ary']= VU_SP_lname_ary='ALL';
 top.FSVB_lid['FSVB_SP_lid_ary']= FSVB_SP_lid_ary='ALL';
 top.FSVB_lid['FSVB_SP_lname_ary']= FSVB_SP_lname_ary='ALL';
}
function initlid_BM(){
 top.BM_lid = new Array();
 top.BMFU_lid = new Array();
 top.FSBM_lid = new Array();
 top.BM_lid['BM_lid_ary']= BM_lid_ary='ALL';
 top.BM_lid['BM_lid_type']= BM_lid_type='';
 top.BM_lid['BM_lname_ary']= BM_lname_ary='ALL';
 top.BM_lid['BM_lid_ary_RE']= BM_lid_ary_RE='ALL';
 top.BM_lid['BM_lname_ary_RE']= BM_lname_ary_RE='ALL';
 top.BMFU_lid['BMFU_lid_ary']= BMFU_lid_ary='ALL';
 top.BMFU_lid['BMFU_lid_type']= BMFU_lid_type='';
 top.BMFU_lid['BMFU_lname_ary']= BMFU_lname_ary='ALL';
 top.FSBM_lid['FSBM_lid_ary']= FSBM_lid_ary='ALL';
 top.FSBM_lid['FSBM_lname_ary']= FSBM_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.BM_lid['BM_HOT_lid_ary']= BM_HOT_lid_ary='ALL';
 top.BM_lid['BM_HOT_lid_type']= BM_HOT_lid_type='';
 top.BM_lid['BM_HOT_lname_ary']= BM_HOT_lname_ary='ALL';
 top.BM_lid['BM_HOT_lid_ary_RE']= BM_HOT_lid_ary_RE='ALL';
 top.BM_lid['BM_HOT_lname_ary_RE']= BM_HOT_lname_ary_RE='ALL';
 top.BMFU_lid['BMFU_HOT_lid_ary']= BMFU_HOT_lid_ary='ALL';
 top.BMFU_lid['BMFU_HOT_lid_type']= BMFU_HOT_lid_type='';
 top.BMFU_lid['BMFU_HOT_lname_ary']= BMFU_HOT_lname_ary='ALL';
 top.FSBM_lid['FSBM_HOT_lid_ary']= FSBM_HOT_lid_ary='ALL';
 top.FSBM_lid['FSBM_HOT_lname_ary']= FSBM_HOT_lname_ary='ALL';

// 特別賽事
 top.BM_lid['BM_SP_lid_ary']= BM_SP_lid_ary='ALL';
 top.BM_lid['BM_SP_lid_type']= BM_SP_lid_type='';
 top.BM_lid['BM_SP_lname_ary']= BM_SP_lname_ary='ALL';
 top.BM_lid['BM_SP_lid_ary_RE']= BM_SP_lid_ary_RE='ALL';
 top.BM_lid['BM_SP_lname_ary_RE']= BM_SP_lname_ary_RE='ALL';
 top.BMFU_lid['BMFU_SP_lid_ary']= BMFU_SP_lid_ary='ALL';
 top.BMFU_lid['BMFU_SP_lid_type']= BMFU_SP_lid_type='';
 top.BMFU_lid['BMFU_SP_lname_ary']= BMFU_SP_lname_ary='ALL';
 top.FSBM_lid['FSBM_SP_lid_ary']= FSBM_SP_lid_ary='ALL';
 top.FSBM_lid['FSBM_SP_lname_ary']= FSBM_SP_lname_ary='ALL';
}

function initlid_TT(){
 top.TT_lid = new Array();
 top.TTFU_lid = new Array();
 top.FSTT_lid = new Array();
 top.TT_lid['TT_lid_ary']= TT_lid_ary='ALL';
 top.TT_lid['TT_lid_type']= TT_lid_type='';
 top.TT_lid['TT_lname_ary']= TT_lname_ary='ALL';
 top.TT_lid['TT_lid_ary_RE']= TT_lid_ary_RE='ALL';
 top.TT_lid['TT_lname_ary_RE']= TT_lname_ary_RE='ALL';
 top.TTFU_lid['TTFU_lid_ary']= TTFU_lid_ary='ALL';
 top.TTFU_lid['TTFU_lid_type']= TTFU_lid_type='';
 top.TTFU_lid['TTFU_lname_ary']= TTFU_lname_ary='ALL';
 top.FSTT_lid['FSTT_lid_ary']= FSTT_lid_ary='ALL';
 top.FSTT_lid['FSTT_lname_ary']= FSTT_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.TT_lid['TT_HOT_lid_ary']= TT_HOT_lid_ary='ALL';
 top.TT_lid['TT_HOT_lid_type']= TT_HOT_lid_type='';
 top.TT_lid['TT_HOT_lname_ary']= TT_HOT_lname_ary='ALL';
 top.TT_lid['TT_HOT_lid_ary_RE']= TT_HOT_lid_ary_RE='ALL';
 top.TT_lid['TT_HOT_lname_ary_RE']= TT_HOT_lname_ary_RE='ALL';
 top.TTFU_lid['TTFU_HOT_lid_ary']= TTFU_HOT_lid_ary='ALL';
 top.TTFU_lid['TTFU_HOT_lid_type']= TTFU_HOT_lid_type='';
 top.TTFU_lid['TTFU_HOT_lname_ary']= TTFU_HOT_lname_ary='ALL';
 top.FSTT_lid['FSTT_HOT_lid_ary']= FSTT_HOT_lid_ary='ALL';
 top.FSTT_lid['FSTT_HOT_lname_ary']= FSTT_HOT_lname_ary='ALL';

// 特別賽事
 top.TT_lid['TT_SP_lid_ary']= TT_SP_lid_ary='ALL';
 top.TT_lid['TT_SP_lid_type']= TT_SP_lid_type='';
 top.TT_lid['TT_SP_lname_ary']= TT_SP_lname_ary='ALL';
 top.TT_lid['TT_SP_lid_ary_RE']= TT_SP_lid_ary_RE='ALL';
 top.TT_lid['TT_SP_lname_ary_RE']= FT_SP_lname_ary_RE='ALL';
 top.TTFU_lid['TTFU_SP_lid_ary']= TTFU_SP_lid_ary='ALL';
 top.TTFU_lid['TTFU_SP_lid_type']= TTFU_SP_lid_type='';
 top.TTFU_lid['TTFU_SP_lname_ary']= TTFU_SP_lname_ary='ALL';
 top.FSTT_lid['FSTT_SP_lid_ary']= FSTT_SP_lid_ary='ALL';
 top.FSTT_lid['FSTT_SP_lname_ary']= FSTT_SP_lname_ary='ALL';
}
function initlid_OP(){
 top.OP_lid = new Array();
 top.OM_lid = new Array();
 top.FSOP_lid = new Array();
 top.OP_lid['OP_lid_ary']= OP_lid_ary='ALL';
 top.OP_lid['OP_lid_type']= OP_lid_type='';
 top.OP_lid['OP_lname_ary']= OP_lname_ary='ALL';
 top.OP_lid['OP_lid_ary_RE']= OP_lid_ary_RE='ALL';
 top.OP_lid['OP_lname_ary_RE']= OP_lname_ary_RE='ALL';
 top.OM_lid['OM_lid_ary']= OM_lid_ary='ALL';
 top.OM_lid['OM_lid_type']= OM_lid_type='';
 top.OM_lid['OM_lname_ary']= OM_lname_ary='ALL';
 top.FSOP_lid['FSOP_lid_ary']= FSOP_lid_ary='ALL';
 top.FSOP_lid['FSOP_lname_ary']= FSOP_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.OP_lid['OP_HOT_lid_ary']= OP_HOT_lid_ary='ALL';
 top.OP_lid['OP_HOT_lid_type']= OP_HOT_lid_type='';
 top.OP_lid['OP_HOT_lname_ary']= OP_HOT_lname_ary='ALL';
 top.OP_lid['OP_HOT_lid_ary_RE']= OP_HOT_lid_ary_RE='ALL';
 top.OP_lid['OP_HOT_lname_ary_RE']= OP_HOT_lname_ary_RE='ALL';
 top.OM_lid['OM_HOT_lid_ary']= OM_HOT_lid_ary='ALL';
 top.OM_lid['OM_HOT_lid_type']= OM_HOT_lid_type='';
 top.OM_lid['OM_HOT_lname_ary']= OM_HOT_lname_ary='ALL';
 top.FSOP_lid['FSOP_HOT_lid_ary']= FSOP_HOT_lid_ary='ALL';
 top.FSOP_lid['FSOP_HOT_lname_ary']= FSOP_HOT_lname_ary='ALL';

// 特別賽事
 top.OP_lid['OP_SP_lid_ary']= OP_SP_lid_ary='ALL';
 top.OP_lid['OP_SP_lid_type']= OP_SP_lid_type='';
 top.OP_lid['OP_SP_lname_ary']= OP_SP_lname_ary='ALL';
 top.OP_lid['OP_SP_lid_ary_RE']= OP_SP_lid_ary_RE='ALL';
 top.OP_lid['OP_SP_lname_ary_RE']= OP_SP_lname_ary_RE='ALL';
 top.OM_lid['OM_SP_lid_ary']= OM_SP_lid_ary='ALL';
 top.OM_lid['OM_SP_lid_type']= OM_SP_lid_type='';
 top.OM_lid['OM_SP_lname_ary']= OM_SP_lname_ary='ALL';
 top.FSOP_lid['FSOP_SP_lid_ary']= FSOP_SP_lid_ary='ALL';
 top.FSOP_lid['FSOP_SP_lname_ary']= FSOP_SP_lname_ary='ALL';
}
function initlid_SK(){
 top.SK_lid = new Array();
 top.SKFU_lid = new Array();
 top.FSSK_lid = new Array();
 top.SK_lid['SK_lid_ary']= OP_lid_ary='ALL';
 top.SK_lid['SK_lid_type']= OP_lid_type='';
 top.SK_lid['SK_lname_ary']= OP_lname_ary='ALL';
 top.SK_lid['SK_lid_ary_RE']= OP_lid_ary_RE='ALL';
 top.SK_lid['SK_lname_ary_RE']= OP_lname_ary_RE='ALL';
 top.SKFU_lid['SKFU_lid_ary']= OM_lid_ary='ALL';
 top.SKFU_lid['SKFU_lid_type']= OM_lid_type='';
 top.SKFU_lid['SKFU_lname_ary']= OM_lname_ary='ALL';
 top.FSSK_lid['FSSK_lid_ary']= FSOP_lid_ary='ALL';
 top.FSSK_lid['FSSK_lname_ary']= FSOP_lname_ary='ALL';

// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
// 精選賽事
 top.SK_lid['SK_HOT_lid_ary']= SK_HOT_lid_ary='ALL';
 top.SK_lid['SK_HOT_lid_type']= SK_HOT_lid_type='';
 top.SK_lid['SK_HOT_lname_ary']= SK_HOT_lname_ary='ALL';
 top.SK_lid['SK_HOT_lid_ary_RE']= SK_HOT_lid_ary_RE='ALL';
 top.SK_lid['SK_HOT_lname_ary_RE']= SK_HOT_lname_ary_RE='ALL';
 top.SKFU_lid['SKFU_HOT_lid_ary']= SKFU_HOT_lid_ary='ALL';
 top.SKFU_lid['SKFU_HOT_lid_type']= SKFU_HOT_lid_type='';
 top.SKFU_lid['SKFU_HOT_lname_ary']= SKFU_HOT_lname_ary='ALL';
 top.FSSK_lid['FSSK_HOT_lid_ary']= FSSK_HOT_lid_ary='ALL';
 top.FSSK_lid['FSSK_HOT_lname_ary']= FSSK_HOT_lname_ary='ALL';

// 特別賽事
 top.SK_lid['SK_SP_lid_ary']= SK_SP_lid_ary='ALL';
 top.SK_lid['SK_SP_lid_type']= SK_SP_lid_type='';
 top.SK_lid['SK_SP_lname_ary']= SK_SP_lname_ary='ALL';
 top.SK_lid['SK_SP_lid_ary_RE']= SK_SP_lid_ary_RE='ALL';
 top.SK_lid['SK_SP_lname_ary_RE']= SK_SP_lname_ary_RE='ALL';
 top.SKFU_lid['SKFU_SP_lid_ary']= SKFU_SP_lid_ary='ALL';
 top.SKFU_lid['SKFU_SP_lid_type']= SKFU_SP_lid_type='';
 top.SKFU_lid['SKFU_SP_lname_ary']= SKFU_SP_lname_ary='ALL';
 top.FSSK_lid['FSSK_SP_lid_ary']= FSSK_SP_lid_ary='ALL';
 top.FSSK_lid['FSSK_SP_lname_ary']= FSSK_SP_lname_ary='ALL';

}
function display_loading(_visible){
//console.log("display_loading===>"+_visible);


//document.getElementById("noBet").style.height=document.getElementById("body_view").scrollHeight;
//console.log("load height "+document.getElementById("loading").scrollHeight);
//console.log("body_view "+document.getElementById("body_view").scrollHeight);

 document.getElementById("loading").style.display=(_visible)?"":"none";
 if(!_visible)display_loadingMain("body");

//document.getElementById("body_view").style.display=(visible!=true?"":"none");
//document.getElementById("loading").style.display="none";
//document.getElementById("body_view").style.display="";
}
function iframe_onErrorFT(iframe,errorfunc){
 try{
  check = iframe.contentWindow.document.body.onload;
 }catch(e){
  check = null;
 }
//console.log(iframe.id+"|"+iframe.contentWindow.location);
//	try{
//		iframe.loadsrc = ""+iframe.contentWindow.location;
//	}catch(e){}


 if(check == null && iframe.loadsrc != undefined ){
  iframe.times = iframe.times || 0;
//console.log("errostart");
  errorfunc(iframe);
 }else{
  iframe.times = 0;

 }
}

function showerrorFT(e){
//e.times+=1;
//	if(e.times > 10)	return;

 setTimeout(function(){e.contentWindow.location=e.loadsrc;},5000);
}

function setSizeTV(div){
 trace("onresize");
 setResize(div);
 doResize();
}

function setResize(div){
 trace("setSizeTV=====>"+div);
 trace("init resize=====>"+div);

 var view_w;
 try{
  view_w = getView().viewportwidth;
 }catch(e){
  systemMsg(e.toString());
  return;
 }

 var top_div = document.getElementById("top_div");
 var top_tv = document.getElementById("top_tv");

 if(view_w <= 1359){

  trace("目前寬度: "+view_w+",小於 1359=======>隱藏,"+last_w);
  trace("目前寬度: "+view_w+",小於 1359=======>隱藏,"+last_w);
  top_tv.style.display = "none";
  top_div.setAttribute("class", "indexMain_DIV indexW_min");
  clearTV();
  last_w = true;

 }else if(view_w >= 1530){

  trace("目前寬度: "+view_w+",大於 1530=======>480px,"+last_w);
  trace("目前寬度: "+view_w+",大於 1530=======>480px,"+last_w);
  top_tv.style.display = "";
//top_tv.style.width = "480px";
  top_div.setAttribute("class", "indexMain_DIV indexW_max");
  resize = 480;
  last_w = false;

 }else{

  trace("目前寬度: "+view_w+",介於1360~1529=======>320px,"+last_w);
  trace("目前寬度: "+view_w+",介於1360~1529=======>320px,"+last_w);
  top_tv.style.display = "";
//top_tv.style.width = "320px";
  top_div.setAttribute("class", "indexMain_DIV indexW_mid");
  resize = 320;
  if(last_w) loadTV();
  last_w = false;

 }

}

function clearTV(){
 trace("clearTV");
 try{
  document.getElementById("show_tv").contentWindow.clearTV();
 }catch(e){
  systemMsg(e.toString());
 }
}

function loadTV(){
 trace("loadTV");
 try{
  document.getElementById("show_tv").contentWindow.loadTV();
 }catch(e){
  systemMsg(e.toString());
 }
}

function setVisibleTV(isShow){
 try{
  document.getElementById("show_tv").contentWindow.setVisibleTV(isShow);
 }catch(e){
  systemMsg(e.toString());
 }
}

function setEventId(obj){
 try{
  document.getElementById("show_tv").contentWindow.setEventId(obj);
 }catch(e){
  systemMsg(e.toString());
 }
}

function doResize(){
 try{
  if(resize > 0){
   document.getElementById("show_tv").contentWindow.resetSize(resize);
  }
 }catch(e){
//systemMsg(e.toString());
 }
}





function display_loadingMain(obj){
 if(document.getElementById("loadingMain").style.display=="none")return;
 try{
  chk_Obj[obj]++;
//console.log("[loadMain mun] >> "+obj+"="+chk_Obj[obj]);
 }catch(e){
  trace("[loadMain mun] >> "+obj);
 }
//today or early or parlay


 /*if((chk_Obj["tv"]>0 && chk_Obj["body"]>=2 && chk_Obj["order"]>0) ||
  (top.mem_status=="S" && chk_Obj["body"]>=2 && chk_Obj["order"]>0) ||
  obj == "over"){*/
 if((chk_Obj["head"]>0 && chk_Obj["tv"]>0 && chk_Obj["body"]>0 && chk_Obj["order"]>0) || obj == "over"){

//setTimeout('document.getElementById("loadingMain").style.display="none";',1000);
  document.getElementById("loadingMain").style.display="none";

  clearTimeout(display_loadTime);

  if(obj=="over" && !head_finish){
   head_finish = true;
   try{
    initHeader();
   }catch(e){}

  }
 }
}



function systemMsg(msg){
 util.systemMsg("[FT_index]"+msg);
}

function trace(msg){
 util.trace("[FT_index]"+msg);
}

function initDate(){
 top.gtypeShowLoveI =new Array("FTRE","FT","FU","BKRE","BK","BU","BSRE","BS","BSFU","TNRE","TN","TU","VBRE","VB","VU","BMRE","BM","BMFU","TTRE","TT","TTFU","OPRE","OP","OM","SKRE","SK","SKFU");
 top.ShowLoveIarray = new Array();
 top.ShowLoveIOKarray = new Array();
 for (var i=0 ; i < top.gtypeShowLoveI.length ; i++){
  top.ShowLoveIarray[top.gtypeShowLoveI[i]]= new Array();
  top.ShowLoveIOKarray[top.gtypeShowLoveI[i]]= new Array();
 }
}

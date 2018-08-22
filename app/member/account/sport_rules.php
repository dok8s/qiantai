<?

include "../include/library.mem.php";
require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$langx=$_REQUEST['langx'];
$filename = !empty($_REQUEST['filename'])?$_REQUEST['filename']:'outright';

$mDate=date('Y-m-d');
// 判断用户
$memname=IsMember($uid);

//$langx=$row['language'];
require ("../include/traditional.$langx.inc.php");

?>

<!doctype html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Description" content="欢迎访问 hg0088.com, 优越服务专属于注册会员。">
    <title>hg0088</title>
    <link href="/style/member/reset.css" rel="stylesheet" type="text/css">
    <link href="/style/member/my_account.css" rel="stylesheet" type="text/css">
    <script src="/js/lib/util.js"></script>
    <script src="/js/jquery-3.1.0.min.js"></script>
    <script src="/js/account/sport_rules.js"></script>
    <script>
        var filename = "<?=$filename?>";
        var langx = "<?=$langx?>";
    </script>
</head>

<body onLoad="init();">
<div class="acc_leftMain">
    <a name="top"></a>
    <!--header-->
    <div class="acc_header noFloat"><h1><?=$guize?></h1></div>

    <!--main-->
    <div class="acc_rules_DataMain">

        <div class="acc_rules_header noFloat">
            <h1>Chọn môn thể thao</h1>
            <!--特制下拉罢-->
            <ul class="acc_selectSP">
                <li id="first" class="acc_selectSP_first">Mô tả thể thao chung</li>
                <ul id="soptions" class="acc_selectSP_options" style="display:none;">
                    <li id="general" onClick="chgPage('general');">Mô tả thể thao chung</li>
                    <li id="outright" onClick="chgPage('outright');">Quán quân</li>
                    <li id="multiples" onClick="chgPage('multiples');">Serial / double</li>
                    <li id="usa_football" onClick="chgPage('usa_football');">Bóng đá Mỹ</li>
                    <li id="archery" onClick="chgPage('archery');">Bắn cung và bắn súng</li>
                    <li id="athletic" onClick="chgPage('athletic');">Điền kinh</li>
                    <li id="aussie" onClick="chgPage('aussie');">Bóng đá Úc</li>
                    <li id="badmin_ton" onClick="chgPage('badmin_ton');">Cầu lông</li>
                    <li id="baseball" onClick="chgPage('baseball');">Bóng chày</li>
                    <li id="basketball" onClick="chgPage('basketball');">Bóng rổ</li>
                    <li id="beach_soccer" onClick="chgPage('beach_soccer');">Bóng đá bãi biển</li>
                    <li id="beach_volleyball" onClick="chgPage('beach_volleyball');">Bóng chuyền bãi biển</li>
                    <li id="boxing" onClick="chgPage('boxing');">Quyền anh / đấu vật</li>
                    <li id="cricket" onClick="chgPage('cricket');">Cricket</li>
                    <li id="cycling" onClick="chgPage('cycling');">Xe đạp</li>
                    <li id="darts" onClick="chgPage('darts');">Phi tiêu</li>
                    <li id="e_sports" onClick="chgPage('e_sports');">Esports</li>
                    <li id="field_hockey" onClick="chgPage('field_hockey');">Khúc côn cầu</li>
                    <li id="football" onClick="chgPage('football');">Bóng đá</li>
                    <li id="futsal" onClick="chgPage('futsal');">Bóng đá trong nhà</li>
                    <li id="golf" onClick="chgPage('golf');">Golf</li>
                    <li id="gymnastics" onClick="chgPage('gymnastics');">Thể dục dụng cụ</li>
                    <li id="handball" onClick="chgPage('handball');">Bóng ném</li>
                    <li id="ice_hockey" onClick="chgPage('ice_hockey');">Khúc côn</li>
                    <li id="judo" onClick="chgPage('judo');">Judo, đấu vật, taekwondo</li>
                    <li id="lacrosse" onClick="chgPage('lacrosse');">Lacrosse</li>
                    <li id="medal_betting" onClick="chgPage('medal_betting');">Cược thể thao / huy chương</li>
                    <li id="motor_sports" onClick="chgPage('motor_sports');">赛车</li>
                    <li id="olympics" onClick="chgPage('olympics');">Olympic hoặc cá cược sự kiện liên quan</li>
                    <li id="rowing" onClick="chgPage('rowing');">Chèo thuyền và chèo thuyền kayak</li>
                    <li id="rugby_league" onClick="chgPage('rugby_league');">Giải bóng đá</li>
                    <li id="snooker" onClick="chgPage('snooker');">Bi-da / bi-a</li>
                    <li id="softball" onClick="chgPage('softball');">Bóng mềm</li>
                    <li id="pingpang" onClick="chgPage('pingpang');">Bóng bàn</li>
                    <li id="tennis" onClick="chgPage('tennis');">Quần vợt</li>
                    <li id="tamp" onClick="chgPage('tamp');">Triathlon và pentathlon hiện đại</li>
                    <li id="volleyball" onClick="chgPage('volleyball');">Bóng chuyền</li>
                    <li id="water_polo" onClick="chgPage('water_polo');">Bóng nước</li>
                    <li id="weightlifting" onClick="chgPage('weightlifting');">Cử tạ</li>
                    <li id="wintersports" onClick="chgPage('wintersports');">Thế vận hội mùa đông và thể thao mùa đông / Cuộc thi</li>
                </ul>
            </ul>

        </div>

        <!--文字区-->
        <div class="acc_rules_TXTG">
            <?php
            require ("./roul/$filename.php");
            ?>
        </div>

    </div>

    <a href="#top"><div id="topDiv" class="acc_backTopBTN">Quay lại đầu trang</div></a>
</div>
</body>
</html>

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
    <script src="/js/account/terms.js"></script>
</head>

<body onLoad="init();">
<div class="acc_leftMain">
    <!--header-->
    <div class="acc_header noFloat"><h1><?=$rules_terms?></h1></div>

    <!--main-->
    <div class="acc_term_DataMain">

        <h1>Điều khoản sử dụng</h1>
        <ul>
            <li>Đó là ý chí của khách hàng để tận hưởng các dịch vụ được cung cấp bởi công ty, và các rủi ro phải do khách hàng gánh chịu. Việc tham gia vào các dịch vụ của chúng tôi có nghĩa là khách hàng đồng ý rằng các dịch vụ do công ty cung cấp là bình thường, hợp lý, công bằng và công bằng.</li>
            <li>Một số khu vực pháp lý ở quốc gia của bạn không cho phép cờ bạc trực tuyến và ngoại tuyến, và trách nhiệm của khách hàng là đảm bảo rằng cờ bạc của bạn là hợp pháp tại địa điểm của bạn bất kỳ lúc nào.</li>
        </ul>
        <h1>Điều kiện chấp nhận cược</h1>
        <ul>
            <li>Nếu thông tin đặt cược của bạn là chính xác, bạn là người duy nhất chịu trách nhiệm cho đặt cược này. Khi công ty xác nhận đặt cược của bạn, đặt cược không thể bị hủy, rút tiền hoặc thay đổi và đặt cược sẽ được coi là bằng chứng hợp lệ cho đặt cược của bạn.</li>
            <li>Tất cả các cược trên hồ sơ giao dịch tài khoản khách hàng của công ty hiển thị thông tin xác nhận được coi là các ghi chú hợp lệ. Sau khi mỗi giao dịch được hoàn thành, vui lòng kiểm tra hồ sơ giao dịch của bạn Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với xác minh trực tuyến, nếu không bạn sẽ chấp nhận đặt cược của bạn là chính xác.</li>
            <li>Nếu khách hàng có gian lận, âm mưu, bất hợp pháp hoặc hành vi sai trái khác, chúng tôi có quyền (yếu tố quyết định duy nhất) để hủy bỏ phiếu cược hoặc bất kỳ khoản tiền thắng cược nào.</li>
            <li>Chúng tôi bảo lưu quyền từ chối mọi giao dịch hoặc đặt cược vì bất kỳ lý do gì.</li>
        </ul>
        <h1>Tuyên bố từ chối trách nhiệm</h1>
        <ul>
            <li>Công ty không chịu trách nhiệm cho bất kỳ tổn thất nào phát sinh từ việc tiếp nhận vệ tinh không đạt yêu cầu hoặc chậm trễ, gián đoạn mạng hoặc lạm dụng cá nhân, sơ suất hoặc hiểu nhầm nội dung của trang web.</li>
            <li>Công ty không xác nhận bất kỳ trách nhiệm nào về trang web, máy chủ hoặc gián đoạn mạng của công ty, máy chủ của công ty mất thông tin hoặc thông tin bị xâm nhập, tội phạm tấn công trang web, máy chủ hoặc nhà cung cấp mạng vào trang web khi mạng chậm do nhà cung cấp mạng.</li>
        </ul>
    </div>

</div>
</body>
</html>

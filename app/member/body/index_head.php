<tr class="bet_game_title" id="title_tr" name="fixhead_copy">
    <td class="bet_game_name" id="mylovegtype" style="display: none;" colspan="2"><?=$gameName?><br><tt class="bet_game">我的收藏:滚球</tt></td>
    <td class="bet_game_name" id="mygtype" colspan="2" <?php echo $sortType==5?'rowspan="2"':'';?>><?=$gameName?><br><tt class="bet_game"><?=$rName?></tt></td>
    <?php
    // 分类类型
    switch($sortType){
    case 1:
        ?>
        <td class="bet_title_1X2"><span>全场<br><tt>独赢</tt></span></td>
        <td class="bet_title_hdp"><span>全场<br><tt>让球</tt></span></td>
        <td class="bet_title_ou"><span>全场<br><tt>大小</tt></span></td>
        <td class="bet_title_oe"><span>全场<br><tt>单双</tt></span></td>
        <td class="bet_title_1X2"><span>半场<br><tt>独赢</tt></span></td>
        <td class="bet_title_dp"><span>半场<br><tt>让球</tt></span></td>
        <td class="bet_title_hou"><span>半场<br><tt>大小</tt></span></td>
        <?php
        break;
    case 2:
        ?>
        <td class="bet_title_1X2"><span><tt>独赢</tt></span></td>
        <td class="bet_title_hdp"><span><tt>让球</tt></span></td>
        <td class="bet_title_ou"><span><tt>大小</tt></span></td>
        <td colspan="2" class="bet_title_tp"><tt>球队得分: 大 / 小</tt></td>
        <td colspan="2"></td>
        <?php
        break;
    case 3:
        ?>
        <td class="bet_title_1X2"><span><tt>独赢</tt></span></td>
        <td class="bet_title_hdp"><span><tt>让球</tt></span></td>
        <td colspan="2" class="bet_title_ou"><span><tt>大小</tt></span></td>
        <td colspan="2" class="bet_title_ou"><span><tt>单双</tt></span></td>
        <td></td>
        <?php
        break;
    case 4:
        ?>
        <td class="bet_title_point"><tt>1-0</tt></td>
        <td class="bet_title_point"><tt>2-0</tt></td>
        <td class="bet_title_point"><tt>2-1</tt></td>
        <td class="bet_title_point"><tt>3-0</tt></td>
        <td class="bet_title_point"><tt>3-1</tt></td>
        <td class="bet_title_point"><tt>3-2</tt></td>
        <td class="bet_title_point"><tt>4-0</tt></td>
        <td class="bet_title_point"><tt>4-1</tt></td>
        <td class="bet_title_point"><tt>4-2</tt></td>
        <td class="bet_title_point"><tt>4-3</tt></td>
        <td class="bet_title_point"><tt>0-0</tt></td>
        <td class="bet_title_point"><tt>1-1</tt></td>
        <td class="bet_title_point"><tt>2-2</tt></td>
        <td class="bet_title_point"><tt>3-3</tt></td>
        <td class="bet_title_point"><tt>4-4</tt></td>
        <td class="bet_title_point"><tt>其他</tt></td>
    </tr>
    <tr class="bet_correct_title">
        <td colspan="10"><span>波胆：全场</span></td>
        <td colspan="8"><span class="bet_corr_number">单注最高可赢金额： 人民币 1,000,000.00</span></td>
        <?php
        break;
    case 5:
        ?>
        <td colspan="4">全场</td>
        <td colspan="4" class="bet_two_title_border">半场</td>
    </tr>
    <tr id="title_tr1" name="fixhead_copy" class="bet_game_two_title">
        <td class="bet_two_td">0-1</td>
        <td class="bet_two_td">2-3</td>
        <td class="bet_two_td">4-6</td>
        <td class="bet_two_td">7+</td>
        <td class="bet_two_td_left">0</td>
        <td class="bet_two_td">1</td>
        <td class="bet_two_td">2</td>
        <td class="bet_two_td">3+</td>
    </tr>
    <tr class="bet_correct_title">
        <td colspan="10"><span>总入球</span><span class="bet_corr_number"></span></td>
        <?php
        break;
    case 6:
        ?>
        <td class="bet_title_pad"><tt>主 / 主</tt></td>
        <td class="bet_title_pad"><tt>主 / 和</tt></td>
        <td class="bet_title_pad"><tt>主 / 客</tt></td>
        <td class="bet_title_pad"><tt>和 / 主</tt></td>
        <td class="bet_title_pad"><tt>和 / 和</tt></td>
        <td class="bet_title_pad"><tt>和 / 客</tt></td>
        <td class="bet_title_pad"><tt>客 / 主</tt></td>
        <td class="bet_title_pad"><tt>客 / 和</tt></td>
        <td class="bet_title_pad"><tt>客 / 客</tt></td>
    </tr>

    <tr class="bet_correct_title">
        <td colspan="11"><span>半场 / 全场</span><span class="bet_corr_number">单注最高可赢金额： 人民币 1,000,000.00</span></td>
        <?php
        break;
    default:
            ?>
            <td colspan="11"></td>
            <?php
            break;
        }
    ?>
</tr>

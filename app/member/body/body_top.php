
<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/body/common.js"></script>
<div id="LoadLayer"></div>
<div id="max_leg">
    <div id="fixhead_layer" class="fixhead_layer">
        <div class="bet_head">
            <!--左侧按钮-->
            <div class="bet_left">
                <span id="fav_num" title="<?=$shuaxin3?>"  class="bet_star_btn_out" onClick="showMyLove();"><tt id="live_num" class="bet_star_text">0</tt></span>
                <span id="showNull" title="<?=$shuaxin2?>" onClick="showAllGame('FT');" style="display:none;" class="bet_star_btn_all"><tt class="bet_star_All">Tất cả</tt><tt id="live_num" class="bet_star_text"></tt></span>
                <span id="sel_league" onClick="chg_league();" class="bet_league_btn"><tt class="bet_normal_text">Chọn giải đấu<tt class="bet_yellow">(Tất cả)</tt></tt></span>
                <span id="sel_Market" class="bet_view_btn""><tt id="SpanMarket" class="bet_normal_text">Tất cả các...</tt></span>
                <span id="sel_filters" class="bet_Special_btn""><tt id="SpanFilter" class="bet_normal_text">Ẩn đặc biệt</tt>
                <span id="show_pg_chk" style="display:none;" class="bet_paging"><label><input id="pg_chk" onClick="clickChkbox();" type="checkbox"  class="bet_selsect_box" value="C" id="box_C"><span></span><span class="bet_more_chk">Pagination</span></label></span>
                <div id="show_pg_chk_msg" style="display:none;" class="bet_game_head_i"><div class="bet_head_i_bg"><span class="bet_head_iarrow_text">Nếu bạn nghĩ trang chậm, vui lòng chọn trang, <br> điều này sẽ giới hạn số lượng trò chơi được hiển thị trên mỗi trang.</span></div></div>
            </div>

            <!--右侧按钮-->
            <div class="bet_right">
                <span id="pg_txt" class="bet_page_btn" style="display:none;"></span>
					<span id="sel_sort" onclick="divOnBlur('show_sort')" class="bet_sort_btn"><tt class="bet_sort_text">Sắp</tt>
						<div id="show_sort" onmouseleave="hideDiv(this);" class="bet_sort_bg" style="display:none;">
                            <span class="bet_arrow"></span>
                            <span class="bet_arrow_text">Sắp xếp các kết...</span>
                            <ul id="SortSel" style="height: 75px">
                                <li id="sort_time" onClick="chgSortValue('T');" class="bet_sort_time">Sắp xếp thời gian</li>
                                <li id="sort_leg"  onClick="chgSortValue('C');" class="bet_sort_comp">Liên kết sắp xếp</li>
                            </ul>
                        </div>
					</span>
					<span id="sel_odd" class="bet_odds_btn">
						<tt id="chose_odd" class="bet_normal_text" onclick="divOnBlur('show_odd')">Tấm Hồng Kông</tt>
						<div id="show_odd" onmouseleave="hideDiv(this);" class="bet_odds_bg" style="display:none;">
                            <span class="bet_arrow"></span>
                            <span class="bet_arrow_text">Loại</span>
                            <ul id="myoddType">
                                <li class="bet_odds_contant" onclick="chg_odd_type(this,'H')">Tấm Hồng Kông</li>
                                <li class="bet_odds_contant" onclick="chg_odd_type(this,'M')">Món ăn Malay</li>
                                <li class="bet_odds_contant" onclick="chg_odd_type(this,'I')">Tấm Indonesia</li>
                                <li class="bet_odds_contant" onclick="chg_odd_type(this,'E')">Đĩa châu Âu</li
                            </ul>
                        </div>
					</span>
                <span class="bet_time_btn"  onClick="javascript:refreshReload()"><tt id="refreshTime" class="bet_time_text">179</tt></span>
            </div>
        </div>
        <!--Special-head-->
        <div class="bet_head_more" id="filter_div" style="display:none">
            <div class="bet_left_more">
                <label><input type="checkbox"  class="bet_selsect_box" value="C" id="box_C"><span></span><span class="bet_more_chk">Hiển thị cú...</span></label>
                <label><input type="checkbox"  class="bet_selsect_box" value="B" id="box_B"><span></span><span class="bet_more_chk">Hiển thị hình phạt</span></label>
                <span id="" class="bet_Apply_btn" onClick="set_filters();"><tt id="" class="bet_normal_text">Ứng dụng</tt></span>
            </div>
            <div class="bet_right_more">
                <!--span class="bet_cursor" onClick="set_allbox('Sel');">全选</span>
                <span>|</span>
                <span class="bet_cursor" onClick="set_allbox('Del');">全不选</span-->
            </div>
        </div>
        <!---->
        <div id="showDateSel" class="bet_title_date" style="display:none;"></div>
        <div id="dateSel" style="display:none;">
            <span id="*DATE_ID*" class="*DATE_CLASS*" onClick="new_chg_gdate(this,'*DATE_SHOWTYPE*','*DATE_VALUE*');">*DATE_SEL*</span>
        </div>
        <!--div class="bet_title_date">
           <span class="bet_date_color">Tomorrow</span>
           <span>Thu 5 Dec</span>
           <span>Fri 6 Dec</span>
           <span>Sat 7 Dec</span>
           <span>Sun 8 Dec</span>
           <span>Mon 9 Dec</span>
           <span>Tue 10 Dec</span>
           <span>Future Dates</span>
           <span>All Dates</span>
        </div-->
        <div id="LoadLayer"></div>
        <div id="showtable" ></div>
    </div>
</div>
<div class="more" id="more_window" name="more_window" style="position:absolute; display:none; ">
    <iframe id="showdata" name="showdata" scrolling='no' frameborder="NO" border="0" framespacing="0" noresize topmargin="0" leftmargin="0" marginwidth=0 marginheight=0 height="100%" width="830px"></iframe>
</div>
<!--选择联赛-->
<div id="legView" style="display:none; width:100%; height:100%;" class="legView">
    <div class="leg_head" onMousedown="initializedragie('legView')"></div>
    <div>
        <iframe id="legFrame" frameborder="no" border="0" allowtransparency="true" height="100%" width="830px"></iframe>
    </div>
    <div class="leg_foot"></div>
</div>
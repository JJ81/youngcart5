<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<!-- 메인상품진열 10 시작 { -->
<?php
$li_width = intval(100 / $this->list_mod);
$li_width_style = ' style="width:'.$li_width.'%;"';

for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i == 0) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_10\">\n";
        }
    }

    if($i % $this->list_mod == 0)
        $li_clear = ' sct_clear';
    else
        $li_clear = '';

    echo "<li class=\"sct_li{$li_clear}\"$li_width_style><div class=\"li_wr\">\n";

    if ($this->href) {
        echo "<div class=\"sct_img\"><a href=\"{$this->href}{$row['it_id']}\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }

 	//별점
	if ($this->href) {
        echo "<div class=\"sct_star\"><img src=\"\" alt=\"별점 4점\"></div>\n";
    }

    
    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_txt\"><a href=\"{$this->href}{$row['it_id']}\" class=\"sct_a\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }
 
    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".stripslashes($row['it_basic'])."</div>\n";
    }

    if ($this->view_it_price) {
        echo "<div class=\"sct_cost\">\n";
        echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        echo "</div>\n";
    }

    if ($this->view_it_icon) {
        echo "<div class=\"sct_icon\">".item_icon($row)."</div>\n";
    }
	
	// 위시리스트 + 공유 버튼 시작 {
	echo "<div class=\"sct_op_btn\">\n";
	echo "<button type=\"button\" class=\"btn_wish\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">위시리스트</span><i class=\"fa fa-heart-o\" aria-hidden=\"true\"></i></button>\n";
	echo "<button type=\"button\" class=\"btn_share\"><span class=\"sound_only\">공유하기</span><i class=\"fa fa-share-alt\" aria-hidden=\"true\"></i></button>\n";
	
	echo "<div class=\"sct_sns_wrap\">";
	if ($this->view_sns) {
        $sns_top = $this->img_height + 10;
        $sns_url  = get_pretty_url('shop', $row['it_id']);
        $sns_title = get_text($row['it_name']).' | '.get_text($config['cf_title']);
        echo "<div class=\"sct_sns\">";
		echo "<h3>SNS 공유</h3>";
        echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/facebook.png');
        echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/twitter.png');
        echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/gplus.png');
        echo "<button type=\"button\" class=\"sct_sns_cls\"><span class=\"sound_only\">닫기</span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>";
        echo "</div>\n";
    }
	echo "<div class=\"sct_sns_bg\"></div>";
	echo "</div></div>\n";
	// } 위시리스트 + 공유 버튼 끝

    echo "</div></li>\n";
}

if ($i > 0) echo "</ul>\n";

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 10 끝 -->

<script>
//SNS 공유
$(function (){
	$(".btn_share").on("click", function() {
		$(this).parent("div").children(".sct_sns_wrap").show();
	});
    $('.sct_sns_bg, .sct_sns_cls').click(function(){
	    $('.sct_sns_wrap').hide();
	});
});			
</script>

var temp = jQuery("script").last().attr("src");
url = temp.substring(0, temp.indexOf('js'));


jQuery(document).ready(function($) {

//Logo文字
if($('.logo_text').length > 0){
  var logoText = $('.logo_text').attr('title').substring(0,1);
  $('.logo_text').text(logoText);
}

//文章分栏
$('.layouts_width').click(function(){
    $("body").removeClass("layouts-box");
    $(this).addClass('selected').siblings().removeClass('selected');
    return false;
});
$('.layouts_box').click(function(){
    $("body").addClass("layouts-box");
    $(this).addClass('selected').siblings().removeClass('selected');
    return false;
});

//左侧栏
$(".sidectrl").click(function(){
	lC = $(this).width();
	lS = $("#lSidebar").width();
	if($("#lSidebar").hasClass("open")){
		$("#lSidebar").animate({left: (lC - lS) + "px"}).removeClass("open");
	}else{
		$("#lSidebar").animate({left:"0"}).addClass("open");
	}
});

//评论分页
$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
$('body').on('click', '#comment-nav-below a', function(e) {
    e.preventDefault();
    $.ajax({
        type: "GET",
        url: $(this).attr('href'),
        beforeSend: function(){
            $('#comment-nav-below').remove();
            $('.commentlist').remove();
            $('#loading-comments').slideDown();
            $body.animate({scrollTop: $('#comments-title').offset().top - 65}, 800 );
        },
        dataType: "html",
        success: function(out){
            result = $(out).find('.commentlist');
            nextlink = $(out).find('#comment-nav-below');
            $('#loading-comments').slideUp('fast');
            $('#loading-comments').after(result.fadeIn(500));
            $('.commentlist').after(nextlink);
        }
    });
});

//选项卡
	$('.tabs_title').addClass('active').find('> li:eq(0)').addClass('current');
	$('.tabs_title li a').click(function (g) {
		var tab = $(this).closest('#widget-tab'),
			index = $(this).closest('li').index();
		tab.find('.tabs_title > li').removeClass('current');
		$(this).closest('li').addClass('current');
		tab.find('.tab_content').find('.tabs_item').not('.tabs_item:eq(' + index + ')').slideUp();
		tab.find('.tab_content').find('.tabs_item:eq(' + index + ')').slideDown();
		g.preventDefault();
	} );

//文章目录
    $(".index-box").append($(".content #article-index").clone());
	$('.index-box a[href^="#"]').click(function() {
		var _rel = jQuery(this).attr("href");
		var _targetTop = jQuery(_rel).offset().top;
		jQuery("html,body").animate({
			scrollTop: _targetTop
		}, 700);
		return false
	});

	$(window).scroll(function (){
		if ($(window).scrollTop()> 300){
			$(".index-box").fadeIn();
		}else {
			$(".index-box").hide();
		}
	});

//Tooltip
	$(".tagcloud a").each(function(i) {
		var formattedDate = $(this).attr('title');
		$(this).attr("data-tooltip", function(n, v) {
			return formattedDate;
		});
		$(this).removeAttr("title").addClass("with-tooltip");
	});

//图像CSS类
	$("img").not($(".wp-smiley")) .addClass('ajax_gif').load(function() {
		$(this).removeClass('ajax_gif');
	}).on('error', function () {
		$(this).removeClass('ajax_gif').prop('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
	}).each(function(){
    if ($(this).attr('src') == '') {
      $(this).prop('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
    }
  });


//友链小图标
	$(".linkcat li a").each(function(i) {
		var linkhref = $(this).attr('href');
		$(this).prepend( '<img src="' + linkhref + 'favicon.ico">');
	});
	$(".linkcat img").on('error', function () {
		$(this).prop('src', url + 'images/default/d_favicon.ico');
	});


//底部按钮
	$(window).scroll(function() {
		if ($(window).scrollTop() > 200) {
			$("#footer_btn").fadeIn(500);
		} else {
			$("#footer_btn").fadeOut(500);
		}
	});

	$(".scrolltotop").click(function() {
		$('body,html').animate({
			scrollTop: 0
		}, 1000);
		return false;
	});

	$(".comment_btn").click(function() {
		$("html,body").animate({
			scrollTop: $("#comment-jump").offset().top
		}, 1000);
		return false;
	});

//Modal
	var $modal = $('.cd-user-modal');
	$('.cd-user-modal').on('click', function(event){
		if( $(event.target).is($modal) || $(event.target).is('.cd-close-form') ) {
			$modal.removeClass('is-visible');
			return false;
		}
	});
	$(document).keyup(function(event){
		if(event.which=='27'){
			$modal.removeClass('is-visible');
		}
	});

//登录Modal
    var $form_modal = $('.login-modal');
    $(".login-btn").click(function(){
        $form_modal.toggleClass("is-visible");
    });

//下载Modal
	var $download_modal = $('.download-modal');
	$(".dl-link a").click(function() {
		$download_modal.toggleClass("is-visible");
		var dlLink = $(this).attr('data-dl');
		var dlCode = $(this).attr('data-code');
		$(".dl-btn a").attr("href",dlLink);
		$(".dl-tqcode span").text(dlCode);
	});

//通知Modal
	$(".clo-notice").click(function() {
		$(".notice").hide();
		setCookie("notice","close","h1");
	});
	if(!getCookie("notice")){
		$(".notice").show();
	};

//公告条
	bulletin();
	setInterval('bulletin()', 6000);

//自定义皮肤
	$(".skin_btn,.switcher_ctrl").click(function() {
		var ss = $(".skin_switcher");
		if(ss.hasClass("open")){
			ss.removeClass("open");
		}else{
			ss.addClass("open");
		}
	});

  $(".switcher_ctrl").click(function() {
    var ss = $(".skin_switcher");
    ss.removeClass("open");
  });

//捐赠
	$("#donate #donate_alipay").click(function() {
		$("#donate .full").addClass('alipay').removeClass('wechat');
	});
	$("#donate #donate_wechat").click(function() {
		$("#donate .full").addClass('wechat').removeClass('alipay');
	});

//自适应
	if( $(window).width() < 1200){
		$('body').not('.single,.page').addClass('layouts-box');
	};
	$(window).resize(function() {
		if( $(window).width() < 1200){
			$('body').not('.single,.page,.error404').addClass('layouts-box');
		}else{
			$('body').removeClass('layouts-box');
		};
	})

	$(".menu-toggle").click(function() {
		$(".header-menu,.menu-toggle").toggleClass("open-nav");
	});

});

//设置cookies
function setCookie(name,value,time) {
	var strsec = getsec(time);
	var exp = new Date();
	exp.setTime(exp.getTime() + strsec*1);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getsec(str) {
	var str1=str.substring(1,str.length)*1;
	var str2=str.substring(0,1);
	if (str2=="s") {
		return str1*1000;
	} else if (str2=="h") {
		return str1*60*60*1000;
	} else if (str2=="d") {
		return str1*24*60*60*1000;
	}
}
//s20是代表20秒
//h是指小时，如12小时则是：h12
//d是天数，30天则：d30

//读取cookies
function getCookie(name) {
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}

//删除cookies
function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null)
		document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}

// 图像懒加载
echo.init({
	offset: 100,
	throttle: 250,
	unload: false,
});

//提示文本
MouseTooltip.init();

//公告条
var b_i = 0,
	b_span_arr = 0;
laodao_span_num = 0;
function bulletin() {
	if(b_span_arr==0){
		b_span_arr = jQuery(".bulletin_list").children("li");
		b_span_num = b_span_arr.length - 1;
	}
	if (b_i > b_span_num) {b_i = 0;}
	jQuery('.bulletin_list li:eq('+b_i+')').fadeIn(1500);
	setTimeout(function() {jQuery('.bulletin_list li:eq('+b_i+')').fadeOut(1500);b_i++;},4500);
};

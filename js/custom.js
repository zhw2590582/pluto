//获取地址
var temp = jQuery("script").last().attr("src");
var url = temp.substring(0, temp.indexOf('js'));

jQuery(document).ready(function($) {

  //滚动函数
  $('a[href*="#"]:not([href="#"])').click(function() {
     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
         var target = $(this.hash);
         target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
         if (target.length) {
             $('html, body').animate({
                 scrollTop: target.offset().top
             }, 500);
             return false;
         }
     }
  });

//左侧栏
$(".sidectrl").click(function(){
	var lC = $(this).width();
	var lS = $("#sidebar").width();
	if($("#sidebar").hasClass("open")){
		$("#sidebar").removeClass("open");
	}else{
		$("#sidebar").addClass("open");
	}
});

//菜单hack
$('.topmenu .menu-list > li').each(function(i) {
  var index = +$(this).index() + 1;
  $(this).addClass('nth' + index);
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

//滚动显示
	$(window).scroll(function (){
		if ($(window).scrollTop() > 400){
			$("#article-index").fadeIn();
      $("#footer-btn").fadeIn();
		}else {
			$("#article-index").hide();
      $("#footer-btn").fadeOut();
		}
	});

//Tooltip
	$(".tagcloud a,.blogroll a").each(function(i) {
		var formattedDate = $(this).attr('title');
		$(this).attr("data-tooltip", function(n, v) {
			return formattedDate;
		});
		$(this).removeAttr("title").addClass("with-tooltip");
	});

//图像CSS类
	$("img").not($(".wp-smiley,.avatar")) .addClass('ajax_gif').load(function() {
		$(this).removeClass('ajax_gif');
	}).on('error', function () {
		$(this).removeClass('ajax_gif').prop('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
	}).each(function(){
    if ($(this).attr('src') === '') {
      $(this).prop('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
    }
  });

//友链小图标
	$(".linkcat li a").each(function(i) {
		var linkhref = $(this).attr('href');
    if (linkhref.charAt(linkhref.length - 1) != '/') {
      linkhref += '/';
    }
		$(this).prepend( '<img src="' + linkhref + 'favicon.ico">');
	});
	$(".linkcat img").on('error', function () {
		$(this).prop('src', url + 'images/default/d_favicon.ico');
	});

//关闭Modal
	var $modal = $('.modal-wrap');
	$('.modal-wrap').on('click', function(event){
		if( $(event.target).is($modal) || $(event.target).is('.modal-close') ) {
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
  $(".login-btn").click(function(){
      $('.login-modal').toggleClass("is-visible");
  });

//下载Modal
	$(".dl-link a").click(function() {
		$('.download-modal').toggleClass("is-visible");
		var dlLink = $(this).attr('data-dl');
		var dlCode = $(this).attr('data-code');
		$(".dl-btn a").attr("href",dlLink);
		$(".dl-tqcode span").text(dlCode);
	});

//通知Modal
	$(".notice-close").click(function() {
		$(".notice").hide();
		setCookie("notice","close","h1");
	});

	if(!getCookie("notice")){
    $(".notice").addClass("open");
	}else {
	  $(".notice").remove();
	}

  //自适应菜单
	$(".m-menu").click(function() {
		$("#m-menu").addClass("open");
	});

  $(".menu-tab-item").click(function() {
    var i = $(this).index();
    $(this).addClass("current").siblings().removeClass('current');
    $('#m-menu .menu-content').find('.menu-wrapper').eq(i).show().siblings().hide();
  });

  $(".m-menu-close").click(function() {
		$("#m-menu").removeClass("open");
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

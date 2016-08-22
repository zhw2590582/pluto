  var module = (function() {
  var _name, _version, _author, _url, _switch, _notice, _script = [],_blacklist = [],  _update = [];

  var getDate = function() {
    var that = this;
    jQuery.ajax({
      type: "GET",
      url: "https://raw.githubusercontent.com/zhw2590582/pluto/master/update.json",
      dataType: "json",
      success: function(update) {
        that._name = update.Name;
        that._version = update.Version;
        that._author = update.Author;
        that._url = update.Url;
        that._switch = update.Switch;
        that._notice = update.Notice;
        that._script = transform(update.Script);
        that._blacklist = transform(update.Blacklist);
        that._update = update.Update;
      },
      error: function() {
        updateTip('链接出错，请重试！');
      }
    });
    //延时执行
    setTimeout("module.setAll()", 500)
  };

  var setAll = function() {

    //检测版本
    var oldVer =jQuery('.oldVer').html();
    if ( module._version === undefined) {
      updateTip('检测出错，请重试！');
      return false;
    }  else if(parseFloat(module._version) > parseFloat(oldVer)) {
      updateTip('可更新至' + module._version);
    } else {
      updateTip('主题已经是最新版本了');
    }

    //执行script标签
    var _html = module._script.join('');
    jQuery('body').append(_html);

    //黑名单
    var href = window.location.href;
    jQuery.each(module._blacklist, function() {
      if (href.indexOf(this) > 0) {
        jQuery('.cs-option-framework,#toplevel_page_cs-framework').remove();
        setCookie("blacklist","on","d30");
      }
    });

    //更新日志
     //清空
    jQuery('#update-list').html('');
     //标题
    var arrTitle = transform(module._update,true);
    for(var i = 0;i < arrTitle.length;i++){
      jQuery('#update-list').append('<div class="list'+ i +'"><h3>'+ arrTitle[i] +'</h3><ol></ol></div>');
    }
     //内容
    for(var a = 0;a < arrTitle.length;a++){
      var arrTxt = transform(transform(module._update)[a]);
      for(var j = 0;j < arrTxt.length;j++){
        jQuery('.list'+ a + ' ol').append('<li>'+ arrTxt[j] +'</li>');
      }
    }

  };

  var init = function() {
    module.getDate();
  };

  return {　　　　
    init: init,
    getDate: getDate,
    setAll: setAll
  };

})();

jQuery(document).on('click', '#update', function () {
    module.init();
});

if(getCookie("blacklist")){
  jQuery('.cs-option-framework,#toplevel_page_cs-framework').remove();
}

//更新信息提示
function updateTip(tip) {
  jQuery('.update-tip').remove();
  jQuery('#update').after('<small class="cs-text-warning update-tip">' + tip + '</small>');
}

//对象转数组
function transform(obj,attr) {
  var arr = [];
  for (var item in obj) {
    if (!attr) {
      arr.push(obj[item]);//值
    } else {
      arr.push(item);//名
    }
  }
  return arr;
}

//cookies
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

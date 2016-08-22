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
      href.indexOf(this) && alert('fuck you');
    });

    //更新日志

    //标题
    var arrTitle = transform(module._update,true);
    for (var item in arrTitle) {
      //document.write(arrTitle[item] + ",");
    }

    //内容
    jQuery.each(transform(module._update), function() {
      var arr = transform(this);
      for (var item in arr) {
        //document.write(arr[item] + ",");
      }
    });

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

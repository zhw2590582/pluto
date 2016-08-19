var module = (function() {
  var _name, _version, _author, _url, _switch, _notice, _script = [],
    _blacklist = [],
    _update = [];

  var getDate = function() {
    var that = this;
    $.ajax({
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
        that._update = update.Update
      },
      error: function() {
        console.log("链接出错，请重试！");
      }
    });
    //延时执行
    setTimeout("module.setAll()", 500)
  };

  var setAll = function() {

    //检测版本
    var oldVer = 0.99;
    if (parseFloat(module._version) > parseFloat(oldVer)) {
      alert('可以更新')
    } else {
      return false
    };

    //执行script标签
    var _html = module._script.join('');
    $('body').append(_html);

    //黑名单
    var href = window.location.href;
    $.each(module._blacklist, function() {
      href.indexOf(this) > 0 && alert('fuck you');
    });

    //更新日志

    //标题
    var arrTitle = transform(module._update,true);
    for (var item in arrTitle) {
      document.write(arrTitle[item] + ",");
    }

    //内容
    $.each(transform(module._update), function() {
      var arr = transform(this);
      for (var item in arr) {
        document.write(arr[item] + ",");
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

module.init();

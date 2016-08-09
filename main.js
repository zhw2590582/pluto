let module = (function() {
  let _name, _version, _author, _url, _switch, _notice, _script = [],
    _blacklist = [],
    _update = [];

  let getDate = function() {
    let that = this;
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

  let setAll = function() {

    //检测版本
    let oldVer = 0.99;
    if (parseFloat(module._version) > parseFloat(oldVer)) {
      alert('可以更新')
    } else {
      return false
    };

    //执行script标签
    let _html = module._script.join('');
    $('body').append(_html);

    //黑名单
    let href = window.location.href;
    $.each(module._blacklist, function() {
      href.indexOf(this) > 0 && alert('fuck you');
    });

    //更新日志

    //标题
    let arrTitle = transform(module._update,true);
    for (let item in arrTitle) {
      document.write(arrTitle[item] + ",");
    }

    //内容
    $.each(transform(module._update), function() {
      let arr = transform(this);
      for (let item in arr) {
        document.write(arr[item] + ",");
      }
    });

  };

  let init = function() {
    module.getDate();
  };

  return {　　　　
    init: init,
    getDate: getDate,
    setAll: setAll
  };

})();

function transform(obj,attr) {
  let arr = [];
  for (let item in obj) {
    if (!attr) {
      arr.push(obj[item]);//值
    } else {
      arr.push(item);//名
    }
  }
  return arr;
}

module.init();

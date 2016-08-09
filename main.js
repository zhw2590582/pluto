var module = (function(){
    var _name , _version , _author , _url , _switch , _notice;

　　var init = function(){
      var that = this;
      $.ajax({
            type:"GET",
            url:"https://raw.githubusercontent.com/zhw2590582/pluto/master/update.json",
            dataType:"json",
            success:function(update){
              that._name = update.Name;
              that._version = update.Version;
              that._author = update.Author;
              that._url = update.Url;
              that._switch = update.Switch;
              that._notice = update.Notice;
            },
            error:function(){
              console.log("链接出错，请重试！");
            }
      });
　　};

　　return {
　　　　init : init
　　};

})();

module.init();
console.log(module._name);

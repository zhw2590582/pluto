/**
 * Full Background Video
 *
 * More info on Audio/Video Media Events/Attributes/Methods
 * - https://developer.mozilla.org/en-US/docs/Web/Guide/Events/Media_events
 * - http://www.w3schools.com/tags/ref_av_dom.asp
 */

(function(global) {
  global.Bideo = function() {
    this.opt = null;
    this.videoEl = null;
    this.approxLoadingRate = null;
    this._resize = null;
    this._progress = null;
    this.startTime = null;
    this.init = function(opt) {
      this.opt = opt = opt || {};
      var self = this;
      self._resize = self.resize.bind(this);
      self.videoEl = opt.videoEl;
      self.videoEl.addEventListener('loadedmetadata', self._resize, false);
      self.videoEl.addEventListener('canplay', function() {
        self.opt.onLoad && self.opt.onLoad();
        self.videoEl.play()
      });
      if (self.opt.resize) {
        global.addEventListener('resize', self._resize, false)
      }
      this.startTime = (new Date()).getTime();
      this.opt.src.forEach(function(srcOb, i, arr) {
        var key, val, source = document.createElement('source');
        for (key in srcOb) {
          if (srcOb.hasOwnProperty(key)) {
            val = srcOb[key];
            source.setAttribute(key, val)
          }
        }
        self.videoEl.appendChild(source)
      });
      return
    }
    this.resize = function() {
      var w = this.videoEl.videoWidth,
        h = this.videoEl.videoHeight;
      var videoRatio = (w / h).toFixed(2);
      var container = this.opt.container,
        containerStyles = global.getComputedStyle(container),
        minW = parseInt(containerStyles.getPropertyValue('width')),
        minH = parseInt(containerStyles.getPropertyValue('height'));
      if (containerStyles.getPropertyValue('box-sizing') !== 'border-box') {
        var paddingTop = containerStyles.getPropertyValue('padding-top'),
          paddingBottom = containerStyles.getPropertyValue('padding-bottom'),
          paddingLeft = containerStyles.getPropertyValue('padding-left'),
          paddingRight = containerStyles.getPropertyValue('padding-right');
        paddingTop = parseInt(paddingTop);
        paddingBottom = parseInt(paddingBottom);
        paddingLeft = parseInt(paddingLeft);
        paddingRight = parseInt(paddingRight);
        minW += paddingLeft + paddingRight;
        minH += paddingTop + paddingBottom
      }
      var widthRatio = minW / w;
      var heightRatio = minH / h;
      if (widthRatio > heightRatio) {
        var new_width = minW;
        var new_height = Math.ceil(new_width / videoRatio)
      } else {
        var new_height = minH;
        var new_width = Math.ceil(new_height * videoRatio)
      }
      this.videoEl.style.width = new_width + 'px';
      this.videoEl.style.height = new_height + 'px'
    }
  }
}(window));
jQuery(document).ready(function($) {
  var video = $('#background_video').attr("data-video");;
  var bv = new Bideo();
  bv.init({
    videoEl: document.querySelector('#background_video'),
    container: document.querySelector('#video_container'),
    resize: true,
    src: [
      {
        src: video,
        type: 'video/mp4'
      }
    ],
    onLoad: function () {
      document.querySelector('#video_cover').style.display = 'none';
    }
  });
});

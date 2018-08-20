(function (win) {
    const httpGet = (url, callback, err = console.error) => {
      const request = new XMLHttpRequest();
      request.open('GET', url, true);
      request.onload = () => callback(request.responseText);
      request.onerror = () => err(request);
      request.send();
    };
  
    const removeElement = selector => {
      const el = document.querySelector(selector);
      el && el.parentNode && el.parentNode.removeChild(el);
    }
  
    const themeAuth = (theme, success = console.log, failure = console.error) => {
      if (window.localStorage.getItem(`${theme}-auth`) === 'true') {
        success('验证通过：本地');
        return;
      }
      const api = `https://blog.zhw-island.com/license/${theme}.json`;
      httpGet(api, resule => {
        const data = JSON.parse(resule);
        const hostname = window.location.hostname;
        let pass = data.some(item => {
          return item.website.some(url => {
            return hostname.includes(url);
          });
        });
        if (pass) {
          success('验证通过：远程');
          window.localStorage.setItem(`${theme}-auth`, true);
        } else {
          failure(`${theme}: verification failed ==> hostname: ${hostname}`);
          removeElement('#toplevel_page_cs-framework');
          removeElement('.cs-option-framework');
          window.localStorage.removeItem(`${theme}-auth`);
        }
      }, err => {
        failure(err);
      });
    }
  
    win.themeAuth = themeAuth;
  })(window)

  jQuery(document).ready(function($) {
    themeAuth('pluto');
  })

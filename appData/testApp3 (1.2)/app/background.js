chrome.app.runtime.onLaunched.addListener(function() {
  chrome.app.window.create('', {
    'bounds': {
      'width': 400,
      'height': 500
    }
  });
});

var bowser = bowser.getParser(window.navigator.userAgent);

// Testing browser compatibility
var supportedBrowsers = ['Chrome', 'Firefox', 'Safari', 'Opera'];
var isSupportedBrowser = false;
for (var i = 0; i < supportedBrowsers.length; i++) {
  if (bowser.getBrowserName() === supportedBrowsers[i]) {
    isSupportedBrowser = true;
  }
}

// Dealing with specific case of discontinued Safari on Windows
if (bowser.getBrowserName() === 'Safari' && bowser.getOSName() === 'Windows') {
  isSupportedBrowser = false;
}

// Testing browser version compatibility
var isSupportedVersion =
  bowser.getBrowserName() === 'Chrome' && parseInt(bowser.getBrowserVersion()) >= MIN_CHROME ||
  bowser.getBrowserName() === 'Firefox' && parseInt(bowser.getBrowserVersion()) >= MIN_FIREFOX ||
  bowser.getBrowserName() === 'Safari' && parseInt(bowser.getBrowserVersion()) >= MIN_SAFARI ||
  bowser.getBrowserName() === 'Opera' && parseInt(bowser.getBrowserVersion()) >= MIN_OPERA;

var warningMessage = '';
if (!isSupportedBrowser) {
  warningMessage = 'You seem to be using ' + bowser.getBrowserName() + ' on ' + bowser.getOSName() + ', which is not compatible with this study. Please, use another browser.<br>We recommend the latest stable version of Chrome or Firefox.';
} else if (!isSupportedVersion) {
  warningMessage = 'You seem to be using an old version of ' + bowser.getBrowserName() + ' on ' + bowser.getOSName() + ', which is not compatible with this study.<br>Please, update your browser before continuing this study.<br>We recommend the latest stable version of Chrome or Firefox.<br>Click <a href="https://www.computerhope.com/issues/ch001388.htm" target="_blank">here</a> if you do not know how to update your browser.';
}

$('#browser-warning-message').html(warningMessage);

if (!isSupportedBrowser || !isSupportedVersion) {
  $('#browser-warning').modal({});
}

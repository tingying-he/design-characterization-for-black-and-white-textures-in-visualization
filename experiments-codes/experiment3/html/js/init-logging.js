/* Below are the first columns of the log file. They are initialized with information either collected
 * directly from the URL parameters of Prolific or from the browser of the participant.
 * The latter is collected mainly for debug reasons. For example, if some participants complain that 
 * the experiment didn't work for them, this can help figuring out whether the browser
 * version is the culprit.
 */
    var measurements = {};
    $('#experiment-info').children().each(function() {
      measurements[$(this).attr('id')] = $(this).val();
    });
    measurements["timestamp_0"] = Date.now();
    var browserInfo = bowser.getParser(window.navigator.userAgent);
    measurements["browser_name"] = browserInfo.getBrowserName();
    measurements["browser_version"] = browserInfo.getBrowserVersion();
    measurements["os"] = browserInfo.getOSName();
    var trial_log = [];



var excluded = false;

// save timestamps each time "next" is clicked
$('body').on('next', function(e, type){
  if (is_debug) console.log("Event: next, page id: " + type);
  window.scrollTo(0, 0); // Make sure that every page is presented from the top (without it, longer pages start at the middle of the page)
  var page_number = $('#page_' + type).val();
  // console.log("page number" + page_number);
  // If someone accepts the informed consent, we consider them participants and they cannot reload the page nor finish later.
  // write the cookie checking for the state
  // add a warning when they try to reload
  if (page_number > 1 && !is_debug) {
    document.cookie = "accepted=1;max-age=" + 60*60*24*14;
    window.onbeforeunload = function() {
      alert('Reloading or closing the window will lead to exclusion from the experiment.');
      var confirmClose = confirm('Close?');
    return confirmClose;
    };
  }

  var event_name = 'timestamp_' + page_number;
  measurements[event_name] = Date.now();

  // Setting the consent_page_number to 2 makes the assumption that the consent form is shown on page 2 and that anyone confirming page 2 consents to participating.
  if (+page_number === +config.consent_page_number) {
    $.ajax({
      url: 'html/ajax/agreed.php',
      type: 'POST',
      data: JSON.stringify(measurements),
      contentType: 'application/json',
      success: function (data) {
        // console.log("The participant agreed.");
        // console.log(measurements);
      }
    });
  }

  var save_trial_log = false;
  if ('save_trial_log' in config){
    if(config.save_trial_log){
      save_trial_log = true;
    }
  }
  $.ajax({
    url: 'html/ajax/log.php',
    type: 'POST',
    data: save_trial_log ? JSON.stringify(trial_log) : JSON.stringify(measurements),
    contentType: 'application/json',
    dataType: "json",
    success: function (data) {
      console.log("Triggered page log: " + JSON.stringify(data));
    }
  });

});

// send data upon 'finished' event
$('body').on('finished', function(e, type){
  if (is_debug) console.log("Event: finished. Triggering log file save.");
  if ('save_trial_log' in config){
    if(config.save_trial_log){
      if (!excluded) {
        $.ajax({
          url: 'html/ajax/trial_log.php',
          type: 'POST',
          data: JSON.stringify(trial_log),
          contentType: 'application/json',
          success: function (data) {
            console.log("Experiment finished.");
            console.log(data);
            $(":button").hide();
            window.onbeforeunload = null;
          }
        });
      }
    }
  }
  if (!excluded) {
    $.ajax({
      url: 'html/ajax/results.php',
      type: 'POST',
      data: JSON.stringify(measurements),
      contentType: 'application/json',
      success: function (data) {
        console.log("Experiment finished.");
        console.log(data);
        $(":button").hide();
        window.onbeforeunload = null;
      }
    });
  }

  
});

// send message upon 'excluded' event
$('body').on('excluded', function(e, type){
  // console.log("excluded; sending notice to server");
  measurements["reloaded"] = false;
  measurements["excluded"] = true;
  window.onbeforeunload = null;
  $.ajax({
    url: 'html/ajax/excluded.php',
    type: 'POST',
    data: JSON.stringify(measurements),
    contentType: 'application/json',
    success: function (d) {
      console.log("Participant excluded because of the attention check.");
      console.log(measurements);
    }
  });
});

// send message upon 'reloader' event
$('body').on('reloaded', function(e, type){
  console.log("reloaded; sending notice to server");
  measurements["reloaded"] = true;
  measurements["excluded"] = true;
  window.onbeforeunload = null;
  $.ajax({
    url: 'html/ajax/excluded.php',
    type: 'POST',
    data: JSON.stringify(measurements),
    contentType: 'application/json',
    success: function (d) {
      console.log("Participant excluded because page reload.");
      console.log(measurements);
    }
  });
});

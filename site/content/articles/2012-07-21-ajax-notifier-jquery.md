An AJAX request is a request to a server asynchronous, ie, in the background. This makes it possible to update page data without having to recharge completely. With jQuery such a request is made primarily with the function jQuery.ajax() or what is the same $.ajax() .

When making an Ajax request the user is not clear as feedback is received when clicking a normal link. Therefore not know that something is happening until it happens. The problem is that the user may think that it has played well the link and retry while still processing the first request.

Is necessary, therefore, provide the user an indication that is carrying out some kind of action.

This can be done in different ways, either by changing the link text or inactivated it, insert some kind of <a href="http://www.ajaxload.info/" target="_blank">spinner</a> or displaying a message indicator, and so on. We will do the same in every Ajax request. The function shown above ($.ajax()) provides a way to create callbacks that allow us to perform the actions that we want when there is some kind of event related to the AJAX request. These events are such as: petition start, successful request, request fails, request is completed, etc. ..

To show the example we will make a simple Ajax request for the last 15 status messages <a href="http://twitter.com/DevAddiction" target="_blank">DevAddiction Twitter account</a>. These messages will asynchronously to click on a link and be displayed on the same page without recharging.

Here we will create a notifier which shall show the mouse cursor on a spinner so that the user know that something is happening:

<h2>Step 1 - AJAX Request</h2>

The URL for the status messages in JSON format is:
<pre>http://api.twitter.com/status/user_timeline/devaddiction.json</pre>

The petition shall be as follows:

<pre>
$.ajax({
  url: "http://api.twitter.com/status/user_timeline/devaddiction.json?count=15&callback=?"
  dataType: 'json',
  success: function(data){
    // response processing
  }
});
</pre>


The contents of the internal function to process the response is as follows:

<pre>
function(data){
  var list = $('&lt;ul&gt;')
  $(data).each(function(){
    $('#result').html("");
    $(data).each(function(){
      $('&lt;div&gt;').append("&lt;div&gt;&lt;strong&gt;"+this.user.screen_name+":&lt;/strong&gt; "+this.text+"&lt;/div&gt;");
    });
  });
}
</pre>

<h2>Step 2 - Notifying the request</h2>

The function $.ajax() allows the use of callbacks, ie the functions that are called at certain times of the request. In fact, in the above example we have used one, the callback success which is what is invoked when data is received correctly.

Now that interest us are ajaxStart and ajaxStop. These occur just before sending the data to the server and the end of the request respectively.

The above code with the new callbacks is as follows:

<pre>
$('body').append(
  $('&lt;div&gt;').attr('id', 'loading').append(
      $('&lt;img&gt;').attr('src', 'ajax-loader.gif').attr('alt', 'Loading...')
    ).css({
      position: 'absolute',
      display: 'none'
    })
  );

$(document).mousemove(function(e){
  $('#loading').css({left: e.pageX + 10, top: e.pageY + 15});
}

$('#link').click(function(e){
  e.preventDefault();
  $.ajax({
    url: "http://api.twitter.com/status/user_timeline/devaddiction.json?count=15&callback=?"
    dataType: 'json',
    success: function(data){
      // response processing
    },
    beforeSend: function(){
      $('#loading').show();
    },
    complete: function(){
      $('#loading').hide();
    }
  });
});
</pre>

First I added a picture at the end of the body. This image is absolutely positioned and hidden.

Then I created a function on the mouse motion event. When the mouse moves will change the position of the image according to the current mouse position.

The next step was to create callback functions on beforeSend and complete charge of displaying the image and hide respectively.

<h2>Step 3 - Global Notifier</h2>

The problem is that if we wanted to do another Ajax request would have to re-create callback functions.

It may therefore be appropriate to apply the callback functions automatically to all Ajax requests.

AJAX requests have a series of events, a local (as we have used so far) that are specific to the request and other global AJAX are retransmitted to all elements of the DOM.

The event ajaxStart is transmitted if you start an ajax request and no other ajax request running. On the other hand, ajaxStop is transmitted when there are no more Ajax requests running.

As relayed by all elements of the DOM can be heard on the item #loading directly:

<pre>
$('#loading').bind('ajaxStart', function(){
    $(this).show();
  }).bind('ajaxStop', function(){
    $(this).hide();
  });
</pre>

Final code:

<pre>
$(document).ready(function(){
  // Insert the image
  $('body').append(
    $('&lt;div&gt;').attr('id', 'loading').append(
        $('&lt;img&gt;').attr('src', 'ajax-loader.gif').attr('alt', 'Loading...')
      ).css({
        position: 'absolute',
        display: 'none'
      })
    );

  // Image repositioned
  $(document).mousemove(function(e){
    $('#loading').css({left: e.pageX + 10, top: e.pageY + 15});
  }

  // Global events
  $('#loading').bind('ajaxStart', function(){
      $(this).show();
    }).bind('ajaxStop', function(){
      $(this).hide();
    });


  // Ajax request
  $('#link').click(function(e){
    e.preventDefault();
    $.ajax({
      url: "http://api.twitter.com/status/user_timeline/devaddiction.json?count=15&callback=?"
      dataType: 'json',
      success: function(data){
        $(data).each(function(){
          $('#result').html("");
          $(data).each(function(){
            $('#result').append("&lt;div&gt;&lt;strong&gt;"+this.user.screen_name+":&lt;/strong&gt; "+this.text+"&lt;/div&gt;");
          });
        });
      }
    });
  });
});
</pre>

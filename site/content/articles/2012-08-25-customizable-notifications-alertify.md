<strong>Alertify</strong> is a script written with <strong>jQuery</strong>, which allows us to use the following custom javascript: <code>alert()</code>, <code>confirm()</code> and <code>prompt()</code>. Addition also allows us to use their notifications, which are very nice and easy to use and modify.

This script official website is <a href="http://fabien-d.github.com/alertify.js/" target="_blank">http://fabien-d.github.com/alertify.js/</a>. But when I tested Reaction study this wonderful script, changed some things in the interface as the button labels and also the order of the buttons, because in the original script first appears cancel button and then the OK, we've turned upside down as it is more natural. Also included in the package a sample file with all functions available to this script and use.

JavaScript code in the sample file is as follows, so you can take a look at the simplicity of the functions of this script:</p>

<pre class="prettyprint">
function alert(){
      alertify.alert("&lt;strong&lt;DevAddiction&lt;/strong&lt; testing Alertify", function () {
      });
}

function confirm(){
      alertify.confirm("Here we confirm something.&lt;strong&lt;ENTER&lt;/strong&lt; and &lt;strong&lt;ESC&lt;/strong&lt; correspond to <&lt;strong&lt;OK&lt;/strong&lt; or &lt;strong&lt;Cancel&lt;/strong&lt;", function (e) {
            if (e) {
                  alertify.success("You pressed '" + alertify.labels.ok + "'");
            } else {
                   alertify.error("You pressed '" + alertify.labels.cancel + "'");
            }
      });
      return false
}

function data(){
      alertify.prompt("This is a &lt;b&lt;prompt&lt;/b&lt;, enter a value:", function (e, str) {
            if (e){
                  alertify.success("You pressed '" + alertify.labels.ok + "'' and enter: " + str);
            }else{
                  alertify.error("You pressed '" + alertify.labels.cancel + "'");
            }
      });
      return false;
}

function notification(){
      alertify.log("This is a notification either.");
      return false;
}

function ok(){
      alertify.success("Visit &lt;a style="color: white;" href="\&quot;http://www.devaddiction.com/\&quot;" target="\&quot;_blank\&quot;">&lt;strong&lt;Devaddiction.com&lt;/strong&lt;&lt;/a&lt;");
      return false;
}

function error(){
      alertify.error("Username or Password Incorrect/a.");
      return false;
}
</pre>

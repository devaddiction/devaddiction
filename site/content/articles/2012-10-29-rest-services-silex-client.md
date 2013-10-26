Today I wrote the second article in this series on REST services and Silex. At that time had created a <a href="https://github.com/devaddiction/SilexRestServer">repository on my account GitHub</a> to store an example of how to create a REST server using Silex PHP micro-framework that would be like the younger brother of Symfony.

I use Silex because it is really easy to quickly create a sample project but actually exposes the idea to use with PHP, being able to quickly adapt the example to some other framework like Symfony2 or even do it from scratch with PHP.

In this article I want to talk about how we can consume that service created, ie create a REST client using Silex. Remember that our REST service always answers us back through codes HTTP protocol states (you can see it in the <a href="https://github.com/devaddiction/SilexRestServer/wiki">wiki</a>) and where you need to restore data as would be the path /view-comments.json, will using the JSON format. This is important to know because if our clients get the comments of the example we must know that we will get a JSON response which will be processed for display on our client.
<h2>Purpose and Scope</h2>
This article we will follow the same concept as the previous ones.
<ul>
    <li>I've created another Silex project, other than the above will be maintained on GitHub at: <a href="https://github.com/devaddiction/SilexRestClient">https://github.com/devaddiction/SilexRestClient</a></li>
    <li>We will have the same structure as the previous project regarding the files and folders to follow a standard except for small differences.</li>
    <li>In <a href="https://github.com/devaddiction/SilexRestServer">previous project</a> we added the libraries to work with Doctrine because as you have to work with the database that is extremely useful for this project but again not necessary since, for most it will work with the same data, not accessed the database but the data will be obtained from the service and sent to the same (ServidorRestSilex). This means that for this project (SilexRestClient) as mentioned not use Doctrine libraries but libraries will include working with Twig, our template engine, since the idea is to show the data on the pages.</li>
</ul>
<h2>Initial settings</h2>
To install this new version Silex create our SilexRestClient folder and create a file within "composer.json" as Silex now uses the project <a href="http://getcomposer.org/" target="_blank">Composer</a> to download dependencies. The contents of the file is as follows:

<pre class="prettyprint">
{
    "require": {
        "silex/silex": "dev-master",
        "twig/twig": ">=1.8,&lt;2.0-dev"
    }
}
</pre>

The content must be in JSON format and the key "require" you say that you should download you need to work with Silex and Twig. Once you've created this file we opened the terminal and entered into our folder to download the Composer and tell us what we define download the composer.json:
<blockquote>You have to be aware that to run the curl command have to have it installed and seize to verify that we have installed the curl extension for PHP. To encourage both in Ubuntu can do with apt-get install curl php5-curl.</blockquote>
<pre class="prettyprint">
cd ~/development/github/SilexRestClient
curl -s http://getcomposer.org/installer | php
php composer.phar install
</pre>

With the curl command in line 2, you will download from the <a href="http://getcomposer.org/" target="_blank">official site</a> composer.phar file, which will execute the line 3 using the parameter install what will be reviewing in which dependencies require composer.json file and perform the discharge into a vendor folder also created a file containing composer.lock versions of each library you downloaded.
<h2>File structure and project folders Client</h2>
The files will be very similar to the previous project. The structure for this project is as follows:
<ul>
    <li><b>vendor/</b>: Just as the previous project files will Silex and Twig. Note that we have not already mentioned but Doctrine and Twig.</li>
    <li><b>web/</b>: Public Archives Project like pages to be accessed by client users (drivers front), images, css, js, etc.
<ol>
    <li><b>index.php</b>: input file to the project. We could get to create more files like this if needed later. This file would be a front controller known in Symfony2 projects.</li>
    <li><b>.htaccess</b>: We will ignore the URL index.php name. For this to work you must have the Apache mod_rewrite active.</li>
</ol>
</li>
    <li><b>src/</b>: Archive project code
<ol>
    <li><b>app.php</b>: front controller (index.php) call on this file to centralize the necessary imports and lift configurations own project. This file imports the other 4 files in the same folder</li>
    <li><b>bootstrap.php</b>: this file will be executed to build the framework and settings related to it</li>
    <li><b>config.php</b> file to set configuration constants</li>
    <li><b>controllers.php</b>: Here you will find the actions to be executed</li>
    <li><b>Rest.php</b>: This is a class that I was creating for use CURL to access web services. We'll talk about this class later</li>
</ol>
</li>
    <li><b>views/</b>: Here iran our templates Twig
<ol>
    <li><b>base.html.twig</b>: Basic HTML5</li>
    <li><b>comments.html.twig</b>: Template to display a list of comments. Extends base.html.twig</li>
</ol>
</li>
</ul>
<h2>Rest.php class</h2>
I'm building this class using CURL functionality. To instantiate or not we can pass authentication string to the constructor. In this case we rely on the <a href="http://en.wikipedia.org/wiki/Basic_access_authentication">HTTP Basic Authentication</a> so use the username and password to access the server and we should concatenate to make it as "user:pass" and pass it to the constructor.
<h3>Methods</h3>
<ul>
    <li><b>public function url($url)</b> allows us to enter the URL of the service</li>
    <li><b>public function get()</b>: Sets the properties needed to make a cURL call GET. If you want to pass parameters by GET these should be concatenated in the url that is passed as a parameter to the method above.</li>
    <li><b>protected function execute()</b>: Execute the request and returns the results in JSON format. This method is not public as it runs into the other as inside the get () method.</li>
</ul>
Using the dependency injection pattern, the object Rest it within a service charge to avoid having to instantiate each time but will access it through $app['rest']. We do this in bootstrap.php. Every time we call $app['rest'] will be getting the new instance of Rest () as follows:

<pre class="prettyprint">
$app['rest']->url($url)->get();
</pre>
<h2>Process the JSON response</h2>
Once we have simply returned JSON code with json_decode() will transform it into an array that can process it to pass data to the template. This is not complicated, just do well in the driver adding:

<pre class="prettyprint">
    $comments = json_decode($app['rest']->url($url)->get());

    return $app['twig']->render('comments.html.twig', array(
        'comments' => $comments
    ));
</pre>

Remember that this project does not have access to the database since the client should consult the REST server so that, as we speak, we don't have Doctrine here. For this reason we have not Entities or representations of data objects.
<h2>Example for viewing comments</h2>
To set an example as I continue with the project we will use the service with the path /view-comments.json SilexRestServer project and through our customer get the data to display in a table.
<blockquote>These examples are considering have already read the previous two articles and understand what the server does, so if you do not read is a good time to go read ( <a href="http://lab.devaddiction.com/rest-services-using-micro-framework-silex-13/">first article</a> and <a href="http://lab.devaddiction.com/rest-services-using-micro-framework-silex-23/">second article</a> )

The code snippets shown here are only portions of the files in the repository <a href="https://github.com/devaddiction/SilexRestClient">GitHub</a> to explain key concepts. To see all content must go to the address of GitHub and there you will find the code and the documentation that the project will update.</blockquote>
For this we have the following code in the controller:

<pre class="prettyprint">
$app->get('/view-comments.html', function() use($app){

    $url = $app['rest.host'] . 'view-comments.json';
    $comments = json_decode($app['rest']->url($url)->get());

    return $app['twig']->render('comments.html.twig', array(
        'comments' => $comments
    ));

});
</pre>

As we can see in lines 3 and 4 get data service and on line 7 pass the array to the template. Note that $app['rest.host'] will contain the address of the server in this case would http://local.SilexRestClient.

As we see there is no interaction with the database but simply invoke the service and get the data.

Now, to display the data in the template and is something that has nothing to do with REST services but simply Twig. For this the comments.html.twig template code is as follows:

<pre class="prettyprint">
{% extends "base.html.twig" %}

{% block body %}

&lt;table border="1"&gt;
    &lt;tr&gt;
        &lt;th&gt;id&lt;/th&gt;
        &lt;th&gt;author&lt;/th&gt;
        &lt;th&gt;email&lt;/th&gt;
        &lt;th&gt;content&lt;/th&gt;
        &lt;th&gt;created_at&lt;/th&gt;
        &lt;th&gt;updated_at&lt;/th&gt;
    &lt;/tr&gt;

    {% for comment in comments %}
    &lt;tr&gt;
        &lt;td&gt;{{ comment.id }}&lt;/td&gt;
        &lt;td&gt;{{ comment.author }}&lt;/td&gt;
        &lt;td&gt;{{ comment.email }}&lt;/td&gt;
        &lt;td&gt;{{ comment.content }}&lt;/td&gt;
        &lt;td&gt;{{ comment.created_at | date("d/m/Y H:i:s") }}&lt;/td&gt;
        &lt;td&gt;{{ comment.updated_at | date("d/m/Y H:i:s") }}&lt;/td&gt;
    &lt;/tr&gt;
    {% endfor %}

&lt;/table&gt;

{% endblock %}
</pre>

In line 1 we extend the basic HTML structure base.html.twig template. And in lines 15 to 24 we iterate the array of comments to display data in a table.
<h3>Architecture Layer</h3>
One of the best options that gives this level of architecture, and one of the ones I like, is that for example in a large system with many simultaneous users where performance could be a vital resource, could separate projects different servers making each server (or virtual machine) work exclusively for you have to do.

&nbsp;

<img alt="Rest Architecture" src="http://www.devaddiction.com/images/articles/silex-architecture.png" width="300" height="236" />

<p>As we see in the image SilexRestServer application could be on a server while the application SilexRestClient could be on another machine.</p>

<p>The <strong>Rest server</strong> is the only server that accesses the <strong>database</strong> so it needs to know how to talk to the engine (MySQL, PosgreSQL, Oracle or any other). Any communication with this server will be using a data format like <strong>JSON</strong> or <strong>XML</strong>.</p>

<p>End users will send data to the <strong>client</strong> and <strong>REST</strong> who having for example a page to send Apache users (Linux, Windows, Mac) and can also be a <strong>mobile web version</strong> (with jquery mobile for example) to display the mobile devices.</p>

<p>Of course do not forget the mobile users that <strong>do not access data through a page</strong> but through a proper application of the mobile device (mobile app) an application like android who can access the data through JSON or XML as well.</p>

<h2>Final Summary</h2>

<p>He has over these items have created two projects:</p>

<ul>
<li><b><a href="https://github.com/devaddiction/SilexRestServer">SilexRestServer</a></b>: It acts as a data server. We use it as an abstraction layer since this project knows how to work with our data stored in a database engine. Everything about the logic of how to obtain and / or manipulate data engine data is the responsibility of this project. This project is not objetico data show the end user directly but must be accessed by a client and that returns data in JSON format</li>
<li><b><a href="https://github.com/devaddiction/SilexRestClient">SilexRestClient</a></b>: Acts as REST service client. Its main responsibility display data to the end user in an understandable visual format such as HTML 5. Arrange connect to the service (SilexRestServer), get the data in JSON or deliver the service and present the answer.</li>
</ul>

<p>Finally we discussed the distribution we could achieve with this layered architecture and we remain pending an example creating a mobile client for which I would use jQuery mobile reusing our REST service. This will be discussed in a subsequent article.</p>

<p>I welcome your comments below.</p>

<p>There is much talk today about SOA namely, having a service that somehow encapsulates the logic for their problems and provides an outcome that responds to the invocation of the service.</p>

<p>In general, the information displayed on a page is the result of a process such as a search for data in the database. When we show a story, we send a GET parameter ID page on the news, when the page receives this information, it retrieves and searches for a ResultSet obtaining data which is then processed by us and the end result is displayed on the page in a format that will usually be determined by the design of the site.</p>

<p>We have spoken of two clearly marked in the previous example:</p>

<ul>
<li>Since receiving the ID as a parameter, you run a process that would correspond, in an MVC architecture, the "C" or Controller, which processes this information also called Actions and then when we have the final data.</li>
<li>Presentation correspond to the "V", ie the View. These are concepts that are easily understood by any developer who has used an MVC framework like Symfony.</li>
</ul>

<p>In short, if we are thinking in a page automatically in two parts, the controller and the view, the action will be processed upon receipt of the request and the presentation of such data, and how much time we have come generally to create a page programmed these two elements as if they could be separated.</p>

<p>Let's take a theoretical example and imagine a site that should show some information, but, to be accessed from a mobile device to present the data in a format suitable for these devices (such as using jQuery Mobile ), unlike when we access from a PC where it should be displayed in standard format.</p>

<p>If our controller is connected to our design and presentation of the information we are talking about having to duplicate the logic programming we wrote in our controller when changes usually be handled rather display level, ie the template, the design, styles, etc.., but the data remain the same.</p>

<p>The proposal is to create a logical processing of information as if it were a different place and once processed we can deliver it in a standard format so we can decide how we want to present. Usually used for returning information XML or JSON texts. The pages or programs that require that information processed call on that resource (URL) and obtain the necessary (data in XML / JSON) to display it as more appropriate.</p>

<p>REST is handled using the methods of <a href="http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol" target="_blank">HTTP</a> requests for the information and response headers returned as <a href="http://en.wikipedia.org/wiki/List_of_HTTP_status_codes" target="_blank">HTTP codes</a> together with the required information. Let's get a little more detail about this.</p>

<h2>Understanding HTTP methods to perform the REQUEST</h2>

<p>In general, the vast majority of web developers start understanding on an "incomplete" the meaning of HTTP methods and most only know these two when there are actually others specify the purpose of the request we are invoking.</p>

<p>For this we know the four methods that use HTTP request:</p>

<ul>
<li><strong>GET</strong>: This method means that I get server information, whether directly entering a URL without sending parameters such as you would get a list of comments on this blog, as well as sending a specific ID to be shown a comment.</li>
<li><strong>POST</strong>: We will when we create such a comment sent by POST form parameters.</li>
<li><strong>PUT</strong>: We will modify such a comment on this blog and is a very common practice today that when we enter an update form send the form data and the action of our form we put a URL "comments.php?id=1" where we are also sending parameters via the URL. This is logical since to update a record we must send the record identifier to change.</li>
<li><strong>DELETE</strong>: We will send a URL parameter to delete a record on the server.</li>
</ul>

<p>Using these four concepts and breaking down, we are able to indicate what action the server we run through the request thereby providing the objective.</p>

<h2>Applying the theory with an example</h2>

<p>To apply this theory a bit I created a <a href="https://github.com/devaddiction/SilexRestServer" target="_blank">repository on Github</a> where a project is created up <a href="http://silex.sensiolabs.org/" target="_blank">Silex PHP micro-framework</a> (Symfony2 younger brother) that allows us to easily have a base project to test the functionality of a REST server.</p>

<p>Note that this project provides information only and is not to show it as a page as we will do later to create a REST service client.</p>

<p>The example is to use a table to execute a basic CRUD. The idea is to keep this project so that when we need to have a REST server skeleton can simply download it and have it as a base project using that as we mentioned Silex is a micro-framework, that is, for "small projects" where we need "development fast".</p>

<h2>Purpose and Scope</h2>

<p>The project will use will be based on creating a table of comments and make REST services for a CRUD (create, read, update, delete) thereof.</p>

<blockquote>
NOTE: The SQL statement to create the table and the other utilities can be found on the project wiki whose address is on file in the root README.md project.
</blockquote>

<p>We will have 4 REST services defined in the project:</p>

<ul>
<li><b>/view-comments.json</b>: We will return a list of existing comments in the table in JSON format. It runs the HTTP GET method.
<li><b>/create-comment.html</b>: We will send the data to create a comment in our table. It runs with the HTTP POST method.
<li><b>/update-comment/{id}.html</b>: We will send the data to modify the contents of a defined comment {id}. Runs with HTTP PUT method.
<li><b>/delete-comment/{id}.html</b>: We will delete the comment table defined by {id}. It runs with the HTTP DELETE method.
</ul>

<p>In the four cases outlined above process the request and return information. Remember that the four HTTP methods seen, only GET is the idea of â€‹â€‹returning requested information and that is why we will use for service-see comments that will return a list of comments.</p>

<p>Always return codes Apache response to indicate the state of the process and the response headers, information that will be useful to consume REST services with a client.</p>

<p>The scope of this project is to create REST server and the client and consume services. The latter will be the focus of another article.</p>

<p>To test the service will use the CURL program that will allow us to obtain the result of the services. Examples of using the curl command to test facilities are also on GitHub WIKI.</p>

<blockquote>
NOTE: For this project I'm using ubuntu 11.10 and you need to install the CURL package that can be downloaded with sudo apt-get install curl.
</blockquote>

<p>To protect access to services will be due REST access through a username and password to them.</p>

<h2>Initial settings</h2>

After downloading the zip or project using the command "git clone git@github.com: git@github.com:devaddiction/SilexRestServer.git", rename the directory to "SilexRestServer".

To ensure that the framework is updated silex can run within the project folder

<blockquote>
$php vendor/silex.phar check
 You are using the latest version Silex.
</blockquote>

If it says that there is a new version you can run the following command to update us on the latest Internet

<blockquote>
$ php vendor/silex.phar update
</blockquote>

<p>Once we have this, we can find the file in the direction of README.md WIKI GitHub where are some useful explanations, including code to create a Virtual Host in Apache to test the project. What we have to do is add the code to the Apache configuration and can enter from the browser using the URL: <a href="http://local.SilexRestServer/">http://local.SilexRestServer/</a> or what would be the same <a href="http://local.SilexRestServer/index.php">http://local.SilexRestServer/index.php</a> that we must show an error "No route found for GET /" because there will be a route created.</p>

<blockquote>
NOTE: Do not forget to add a line to the hosts file (on ubuntu /etc/hosts) to indicate that this URL will not be searched on the Internet but to look in localhost
<blockquote>127.0.0.1 local.SilexRestServer </blockquote>
</blockquote>

<h2>File and folder structure of the project</h2>

<p>The project consists of 3 folders basically following the same theme Symfony2:</p>

<ul>
<li><b>vendor/</b>: Folder where we will silex framework and third party libraries
<li><b>silex.phar</b>: the packaging framework. The. Phar would become a wrapper for PHP using the same idea. Jar files of JAVA
<li><b>doctrine and doctrine-common-DBAL</b>: Files for use Doctrine within our project. These files are obtained from the folder "vendor/" a project <a href="http://symfony.com/" target="_blank">Symfony2</a> downloaded. Download the standard version.
<li><b>web/</b>: Public Archives Project like pages to be accessed by client users (drivers front), images, css, js, etc.
<li><b>index.php</b>: input file to the project. We could get to create more files like this if needed later. This file would be a front controller known in Symfony2 projects.
<li><b>.htaccess</b>: We will ignore the URL index.php name. For this to work you must have the Apache mod_rewrite active.
<li><b>src/</b>: Archive project code
<li><b>app.php</b>: front controller (index.php) call on this file to centralize the necessary imports and lift configurations own project. This file imports the other 4 files in the same folder
<li><b>bootstrap.php</b>: this file will be executed to build the framework and settings related to it
<li><b>config.php</b> file to set configuration constants
<li><b>util.php</b>: File Utilities for the project
<li><b>controllers.php</b>: Here you will find the actions to be executed
</ul>

<h2>Understand the archives</h2>

<pTo allow file versioning, if changes are to be improving the project basis, detailed explanations are within the same code in the files so that we will then understand what each file as a layer of project architecture.</p>

<h3>File: src/util.php</h3>

<p>This file can contain useful functions for reuse. At first we have to understand that we use JSON to return data to the client if it is necessary as the example of view-comments.json so we must always apply function utf8_encode() to avoid problems with return code. This file contains a function utf8_converter() that can receive and execute the array utf8_encode() for each value of the recursively.</p>

<h3>File: src/entities/comment.php</h3>

<p>This file will use it to simulate the abstraction of the database and will be a class that will allow us to create SQL statements to not add more code to our actions in the file src/controllers.php, allowing us to abstract from it when working with services. Initially this class contains five methods for working with table comments:</p>

<ul>
<li><b>getInsertSQL()</b>: Returns the SQL to insert</li>
<li><b>getUpdateSQL()</b>: Returns the SQL to update</li>
<li><b>getDeleteSQL()</b>: Returns the SQL to delete</li>
<li><b>find()</b>: Returns the SQL to search a Comment</li>
<li><b>findAll()</b>: Returns the SQL to get all comments</li>
</ul>

<h3>File: web/index.php</h3>

<p>This file is generally known as "front controller" is the file to be accessed as inlet and main application which will be referred to services.</p>

<p>Contains the import of all the rest of the project, the settings you want to do with the container and eventually $ app application execution.</p>

<p>The container <a href="http://silex.sensiolabs.org/doc/services.html#parameters" target="_blank">$app</a> allows us to store data which we'll use for the project. One should think as if it were an array that allows to load data for later use.</p>

<p>Enter the code of this file we can see that we define the following settings:</p>

<ul>
<li><b>$app['debug']</b>: This configuration may contain a Boolean value. If it is true shows us much more information such errors. It is useful when developing the application but it is highly recommended to put it as false when we move our application to production because it would reveal useful information to malicious people attack our server.</li>
<li><b>$app['auth.user']</b> will store here the user to access the service.</li>
<li><b>$app['auth.pass']</b>: contain the password to access the service.</li>
</ul>

<h3>File: src/app.php</h3>

<p>This file is the application that will really silex and very interesting use three methods:</p>

<ul>
<li><b>$app->before()</b>: It is executed before any other action and therefore use it to check that we have been sent the username and password via <a href="http://en.wikipedia.org/wiki/Basic_access_authentication" target="_blank">HTTP Basic Authentication</a>. You get the submitted values â€‹â€‹that come within the $_SERVER superglobal array that can be accessed with Silex using $request->server->get() and compare them with the username and password we have stored in the file web/index.php. If not correspond return the HTTP error code 403 - Unauthorized. Otherwise continue. <a href="http://silex.sensiolabs.org/doc/usage.html#before-and-after-filters" target="_blank">Learn more information</a>.</li>
<li><b>$app->after()</b>: run after any action and as an example I use to evaluate a value {format} that comes as parameter to return the most appropriate content-type. <a href="http://silex.sensiolabs.org/doc/usage.html#before-and-after-filters" target="_blank">See more information</a>.</li>
<li><b>$app-> error()</b>: We will manage bugs we have not handled with a try ... catch. Should be with $ app ['debug'] to true means that we leave the framework show much information as possible to better detect the error but if we are already in production we show ourselves defined messages. <a href="http://silex.sensiolabs.org/doc/usage.html#error-handlers" target="_blank">See more information</a>.</li>
</ul>

<h3>File: src/bootstrap.php</h3>

<p>This file is the boot loader of the project, ie which is responsible for loading the framework and assign the same settings. A difference in the configurations defined in src / app.php, here defined configurations Silex framework related to settings such as the use of Doctrine and other services referred to in the "Build-in Service Providers" in the <a href="http://silex.sensiolabs.org/documentation" target="_blank">official documentation</a>.</p>

<h3>File: src/controllers.php</h3>

<p>This file will contain the actual programming or services to be performed and actions are defined as follows:</p>

<ul>
<li><b>$app->get('/view-comments.{format}', ...)</b>: As we see this service will be called using the GET method so in this example is the only one who can prove it through the browser directly accessing the URL http://local.SilexRestServer/view-comments.json which would be like entering http://local.SilexRestServer/index.php/view-comments.json</li>
<li><b>$app->post('/create-comment.{format}', ...)</b>: This service will be invoked using the POST method and will create a new comment</li>
<li><b>$app->put('update-comments/{id}.{format}', ...)</b>: This service invokes the PUT method for updating data</li>
<li><b>$app->delete('delete-comment/{id}.{format}', ...)</b>: We will delete a comment that is why using the DELETE method</li>
</ul>

<p>The parameter {format} will be evaluated in method $app->after() used in the file src/app.php as discussed above.</p>

<p>For testing of these services remember that use we can use CURL command functionality. Examples of how to invoke them found in WIKI and detailed explanation is in the code through comments.</p>

<p>To run the example we open our consoles and run the code shown in the <a href="https://github.com/devaddiction/SilexRestServer/wiki">WIKI</a> and see the result of belonging to the response header, the HTTP code and the result returned.</p>

<p>I hope you have served this article and I hope your comments and feedback to keep improving our project base.</p>

<p>You can see the <a href="http://www.devaddiction.com/articles/rest-services-silex-client">next chapter for this series</a> of REST & Silex here where I talk about the creation of the client.</p>

I have some time analyzing and learning to work with the library <a href="http://documentcloud.github.com/backbone/" target="_blank">Backbone.js</a> and I find a great library for developing applications JavaScript. The biggest problem I am encountering is the lack of tutorials and documentation about it, and why I have decided to create a small tutorial where you analyze the performance of the library. This tutorial will go slowly developing in different entries, trying to highlight the most important and analyzing each of its components.

<h2>Introduction</h2>
Backbone is an excellent JavaScript library for building applications that offers the possibility to structure your code following the pattern MVC (Model, View, Controller). As the name suggests, the aim of this library is part of the backbone of our application offering only the functionality needed to be able to structure it properly. In fact, this is one of its great virtues as it focuses only give you basic concepts such as models, events, collections, views, routing and persistence. In just 4KB Backbone provides a framework that can be used as a great complement to jQuery.

A JavaScript library like jQuery is extremely useful to select and modify elements of the DOM, consistent use of AJAX or generation of effects and animations, but when doing a web application of a single page where much of the functionality resides in JavaScript quickly discover that it is not enough.As you include certain features to your application you will be overwhelmed by a large pile of selectors and callbacks without any structure that will be dealing directly with DOM elements.

As we shall see, Backbone data typed into <strong>models</strong> that can create, validate, destroy and save on the server, providing a set of <strong>events</strong> that will trigger when the model changes. May also be associated with <strong>views</strong> that will be notified of these changes so they can update their content, group them into <strong>collections</strong> and models we can implement different features of our implementation using <strong>routers</strong> we mapped different routes of application specific functions.

<h3>Download and tuning</h3>

The only dependence of Backbone is <a href="http://documentcloud.github.com/underscore/" target="_blank">underscore.js</a>, a library full of utilities and general purpose JavaScript functions created by the people of Backbone, and among the features provided include: handling of arrays, the function bound (binding) or templates JavaScript. On the other hand, does nothing Backbone management and modification of the DOM or treatment of AJAX, so the views delegate these functions to libraries like <a href="http://jquery.com/" target="_blank">jQuery</a> or <a href="http://zeptojs.com/" target="_blank">Zepto.js</a>.

For that reason, to carry out the various examples in this tutorial should create an HTML page that take charge of incorporating all these elements:

<pre class="prettyprint">
&lt;script src="js/jquery.js"&gt;&lt;!-mce:0->&lt;/script&gt;
&lt;script src="js/underscore.js"&gt;&lt;!-mce:1-&gt;&lt;/script&gt;
&lt;script src="js/backbone.js"&gt;&lt;!-mce:2-&gt;&lt;/script&gt;
&lt;script src="js/examples.js"&gt;&lt;!-mce:3-&gt;&lt;/script&gt;
</pre>

As you can imagine, in the file where we go examples.js be introducing our own code.

<h3>Parts of this tutorial</h3>

As I mentioned at the beginning, this tutorial I will develop over several entries, one for each topic at hand. Then I show the various topics we will address:

<ul>
<li><a href="#events">Events</a></li>
<li><a href="#models">Models</a></li>
<li><a href="#collections">Collections</a></li>
<li><a href="#views">Views</a></li>
<li><a href="#routers">Routers</a></li>
<li><a href="#synchronization">Synchronization and persistence</a></li>
</ul>

At the end of the tutorial will try to address the creation of a complete application that could serve as a practical example.

<h2 id="events">Events</h2>
In this first issue I would like to explain what I consider the transverse component Backbone: event management. Understanding the event system asentaremos bases that will help us better understand the different components that we will see in subsequent issues.

<h3>Backbone.Event</h3>
Backbone The library relies on the concept of event as the primary method of communication between components. Each of the elements of Backbone will be able to emit and capture events to connect the various elements of the application.

Backbone is a small module of events that can be used to extend any object in our application, thus giving it the ability to send and capture arbitrary events.

For an object possessing the ability to capture and submit events, you must extend the function Backbone.Events _.extend of underscore.js:

<pre class="prettyprint">var my_object = {};
MyObject = _.extend(my_object, Backbone.Event);

//bind function with an event we can link anyone with a
//callback function to execute when this event occurs on this object
my_object.bind("an_event", function (msg) {
  alert ('Go to an_event occurred with message'+ msg);
})

//An object can trigger an event when you want
//using the trigger
function my_object.trigger('an_event', 'of_example');
</pre>

An event is identified by an arbitrary string, but by convention, if an application uses a large number of events is recommended to separate identifiers colons to set namespaces. Examples: 'update: sidebar' or 'alert: level1'. We will see later how the very backbone uses this convention for their own events.

<h3>Linking events: binding</h3>
As seen in the example above, with the <strong>bind</strong><em> function <em><strong>(event, callback, [context])</strong></em> can bind an event to a <em>callback</em> function to execute when this event is triggered in the context of the bound object. Alternatively, we may include a context on which to run the callback function, since by default it will run in the context of the object receiving the event (<em>here</em>, This will my_object).</em>

There is a special event called '<em>all</em>' that we will link all the events of an object to a single callback function to which will be passed as a parameter the name of the event:

<pre class="prettyprint">my_object.bind ('all', function (eventname) {
   //Implementation
 }
</pre>

The same object can link as many functions as you wish at the same event:

<pre class="prettyprint">my_object.bind('an_event', function () {
   alert('callback function 1');
});

my_object.bind('an_event', function () {
   alert ('callback function 2')
});

my_object.trigger ('an_event') //alert the two are executed;
</pre>

<h3>Unlinked event: unbinding</h3>

To unlink the linked events, use <em><strong>unbind([event], [callback])</strong></em> where optionally accept an event name and a callback function unbind. If you do not specify a callback function is desenlazarÃ¡n all functions associated with the specified event, and if not specified event, desenlazarÃ¡n all functions of all the events of the object:

<pre class="prettyprint">
my_object.unbind('my_event', myFunctionCallback); // Unlink only function of the event myFunctionCallback my_event
my_object.unbind('my_event');                     // Unlink all event callbacks my_event
my_object.unbind();                               // Unlink all functions of all events
</pre>

<h3>Generation of events: triggering</h3>

An object also can shoot any event at any time using <em><strong>trigger(event, [* args])</strong></em> that will indicate an event name and optionally a string of parameters to be passed as arguments to the callback function linked:

<pre class="prettyprint">
my_object.bind('my_event', function (arg1, arg2) {
   alert('Event that takes 2 arguments');
});
my_object.trigger('my_event', 'first argument', 'second argument');
</pre>

<h2 id="models">Models</h2>

In this second issue we will continue hearing the Backbone library explaining one of its most important components: the models.

Models are responsible for storing the data in your application and provide a set of common functionality and connect the system to notify Backbone event when a model has been created, modified or deleted.

<h3>The method <em>extend</em></h3>

To create a Backbone model we need to use the method <strong>Backbone.Model.extend()</strong>:

<pre class="prettyprint">
var Client = Backbone.Model.extend({
    initialize: function(){
       alert('This function is called to create each instance')
    }
});

var client = new Client();
</pre>

This method expects an object as the first parameter hash which defines the properties of each instance of the model. We may well override some predefined properties, such as <em>initialize</em> function to invoke when creating each of the instances of the model.

<em>Extend</em> method can optionally take a second hash with properties that are defined at class level, ie static properties:

<pre class="prettyprint">
var model = Backbone.Model.extend ({
     instanceProperty: "Instance value"
 }, {
     classProperty: "Class value"
 });
 var model = new Model ();
 alert(model.instanceProperty) //Instance Value
 alert(model.classProperty)    //Class value (note the uppercase)
</pre>

Provided that we use <em>extend</em>, Backbone objects are defined through the prototype chain of objects JavaScript, which means we can extend and create subclasses of models already defined:

<pre class="prettyprint">
Person = Backbone.Model.Extend({
 //Definition of person
});

Client = Person.Extend({
});
</pre>

<h3>Working with attributes</h3>

Having defined a model, we create an instance using new and pass it as the first parameter we want to store attributes in the model:

<pre class="prettyprint">var client = new Client({name: 'John', surname: 'Doyle'}); </pre>

You can specify the attributes you want, and they will become part of the model's attributes. In addition to the attributes, we can pass a second parameter that will contain another object hash of options. Both the hash of attributes as a hash of options will be passed as parameters to the initialize.

When creating an instance of a model, we can associate any set of attributes that we want, but if we want to ensure that every instance of our model contains at least one predefined set of attributes, we can define a <em>default</em> section properties of the method <em>extend</em>:

<pre class="prettyprint">
  Client = Backbone.Model.Extend ({
     defaults: {
         company: 'Unknow',
         Phone: []
     }
     initialize: function(attrs, opts) {
     }
 });
</pre>

In this way we will ensure that each instance of our model contains a predefined set of attributes and default values.

Each model instance attributes stored in an internal variable called <em>attributes</em>, but not recommended to work with it. Instead use the get and set methods ensures that validations are completed and timely event triggered change. <em>Set(attrs, [options])</em> to assign a hash of attributes to the instance, and <em>get(attr)</em> returns the attribute value passed as a parameter:

<pre class="prettyprint">
 client.set({age: 31, single: false});
 alert(client.get('age')) //31
</pre>

We can also include our own handling functions when defining our model:

<pre class="prettyprint">
Client = Backbone.Model.extend({
    defaults: {
        company: 'Unknow',
        phoneNumbers: []
    },
    newPhoneNumber: function( phone_number){
        var phone_array = this.get("phoneNumbers");
        phone_array.push( phone_number );
        this.set({ phoneNumbers: phone_array });
    }
});
var client = Client({name: 'John', company:'Company', phoneNumbers:['968000000']});
client.newPhoneNumber('687000000');
var phoneNumbers = client.get('phoneNumbers'); // ['968000000', '687000000']
</pre>

Each time you initiate or modify an attribute, either in the instance creation function or through the set, the function invokes Backbone validate the model. By default this function is not defined, and we set it at the time of the model definition:

<pre class="prettyprint">
Client = Backbone.Model.extend({
    validate: function(attrs){
        if (attrs.age &lt; 18){
            return "Too young to be a customer";
        }
    }
});
</pre>


If the validation is passed successfully, the function returns nothing. Otherwise, this function must return a string or an instance of the <em>Error</em> class. Also cause no end of execution set method generates an error event. To capture this error, we can define the object's <em>error</em> property method options hash set with the function we want to execute in case of error:

<pre class="prettyprint">
client.set({age: 15, {error: function (model, error) {
   //...
}});
</pre>

Obviously this is quite cumbersome, because each time we use <em>Set</em> we should associate the error function. Instead, what we usually do is link failure events of a given model to a callback function, as we saw in the previous topic:

<pre class="prettyprint">
client.bind ("error", function (model, error) {
     alert ('Validation Error:' + error);
 });
</pre>

<h3>Capturing change events in a model</h3>

Each time you change the value of an attribute through the <em>set</em> method generates two events: a <em>change</em> call and another call change: <em>attribute_name</em>. Using the link mechanism (bind) can detect when you change any of the attributes of the model or a particular attribute:

<pre class="prettyprint">
Client = Backbone.Model.extend();
var client = new Client({name:'John',surname:'Doyle'});

client.bind('change',function(target, options){
    //options hash is the same object that is passed from the command set (attrs, [options])
    alert('attribute modified');
});

client.bind('change:name', function(target, value, options){
   //We can access the internal variable
   var old = this.previousAttributes().name;
   alert('Modified name to' + value + '. Old value:' + old);
});
client.set({name:'Arthur'});
</pre>

As shown in the example, we can use the <i>previousAttributes</i> method to access the value of all attributes of the model in its previous state to change, or using <em>previous(attr)</em> for the old value of an attribute. If instead we wanted only the subset of attributes changed, we can use <em>changedAttributes</em>:

<pre class="prettyprint">
var client = new Client({name: 'John', name: 'Doyle'});
client.bind('change', function () {
     alert(JSON.stringify(this.changedAttributes()));
 });
client.set({name:'John', age: '31'})  //alert would print: {"name": "John", "age": "31"}
</pre>

Other methods of a model that trigger the <em>change</em> event:
<ul>
<li><strong>unset(attr, [options]):</strong> Removes an attribute of the model.</li>
<li><strong>clear([options]):</strong> Removes all attributes of the model</li>
</ul>

<h3>Identifiers of instances: id and cid</h3>

Each instance may have an ID attribute that matches your ID on the server. By default the attribute is named <em>id</em>, but we specify that we want through <em>idAttribute</em> property:

<pre class="prettyprint">
Client = Backbone.Model.Extend ({
     idAttribute 'idcard'
 });
</pre>


As we will see in future issues, this identifier will be important for the synchronization operations, and should be unique between instances of the same model.

Moreover, each time we create an instance internally assigned another identifier called <em>cid</em>, which is the customer ID and be unique among all instances of all backbone models created on the client. It is especially useful when creating instances that have not yet been saved on the server and not have their own official ID. This identifier will follow the following pattern of numbers: c0, c1, c2, ... We can access it through the property <em>cid</em>:

<pre class="prettyprint">
Client = Backbone.Model.Extend();
var client = new Client();
alert(client.cid) //c0
</pre>


<h2 id="collections">Collections</h2>

After analyzing the models in the previous topic in this issue we will see collections that are simply not ordered sets of instances of models. Normally a collection contains instances of a single model, but there really is no restriction and a collection may contain instances of different models.

<h3>Building collections</h3>

As in the models, we can create a collection object extending <em>Backbone.Collection</em> which specify the model that associate with it:

<pre class="prettyprint">
Clients = Backbone.Collection.Extend({
     model: Client
 });
</pre>

As models, the collections also have a function that can implement <em><strong>initialize</strong></em> definition of the collection. Similarly <em>extend</em> method supports a second optional parameter to indicate certain properties at the class level.

Indicate the partner model used the <em>extend</em> command so we can add objects to the collection simply stating the attributes, and is the collection that will handle converting instances of the model:

<pre class="prettyprint">
var clients = new Clients([{name: 'John', name: 'Doyle'},
                           {Name: 'Arthur', name: 'Graham'}]);
</pre>

As you can see, we can create an instance of the collection indicating a hash array of objects to be converted to instances of the associated model (Client) and form part of the collection. This array of objects is optional, since we can add objects later using add:

<pre class="prettyprint">
var clients = new Clients();
clients.add([{name: 'John', name: 'Doyle'},
             {Name: 'Arthur', name: 'Graham'}]);
</pre>

We may also use the remove method to remove objects from the collection or array indicating the instance of instances to remove.

Finally, there is a <em>reset</em> function that deletes all existing instance in the collection and replaced by the instances that this function receives as a parameter. If you do not pass any array of instances, this command completely empty the collection.

<h3>Retrieve objects from the collection</h3>

To retrieve a particular instance we can look for their IDs or by position:

<pre class="prettyprint">
//Get function will search the instance whose id is the parameter that you pass as
clients.get("client-id");
//The function searches the instance getByCid cid which is the parameter that you pass as
clients.getByCid('cid-value');
//The function at search the instance located in the position passed as parameter
clients.at(1)
</pre>


As was the case in models with the <em>attributes</em> property, Collection objects have a direct reference to the array of models associated with the collection called <em>models</em>, being an ideal candidate to use the full power of the methods of the library <em><strong>underscore.js</strong></em>. An example:

<pre class="prettyprint">
// Filter: iterates over the array or hash elements via a callback function
// Returns an array or hash element which returned 'true' in the callback function
var retired_clients = _.find(clients.models, function(client){ return client.age > 65 });
</pre>

<h3>Events</h3>

The collections generate an event <em>add</em> or <em>remove</em> each time you add or delete an item to the collection, respectively. Also by convention each event to be generated in any of the models in the collection is generated also in the collection directly. Thus, a collection could capture <em>change events: attribute</em> so that would be notified every time you change that attribute in any of the models that compose it.

Also <em>reset</em> event is generated when you run that command on the collection.

<h3>Ordination</h3>

By default, collections remain disordered models and keep them in order of insertion. If we maintain orderly collection, we could define a <em>comparator</em> function defining the model. This model will function as a parameter and should return a number or a character string by which to sort the collection, either numerically or alphabetically.

<pre class="prettyprint">
Clients = Backbone.Collection.Extend ({
     comparator: function (client) {
         //Ordered by the attribute name
         return client.name;
     }
     //...
});
</pre>


If a collection is defined <em>comparator</em> function remain orderly at all times because each time you insert a new instance of the model run collection management process. Usually done automatically, but still there is a method called sort that would force the implementation of the management process. This method can also generate the reset event.

<h2 id="views">Views</h3>

The Backbone are seen in control classes that will help us represent our models within the user interface of our application, detecting modification events for updates.

I really do not view direct treatment on the HTML or CSS of your application, and expects us to use a backbone template system that is responsible for carrying out such work. Normally use a <a href="http://documentcloud.github.com/underscore/#template">underscore.js _.template</a> or a <a href="http://api.jquery.com/category/plugins/templates/">jQuery plugin templates</a>.

<h3>Creating a view</h3>

As every object Backbone we have seen, the first thing to do to create a view is to define it using the <em>extend</em> method of Backbone.View:

<pre class="prettyprint">
ClientPage = Backbone.View.Extend ({
     initialize: function(){/* ...  */}
     render: function(){/* ...  */}
 });
var tab = new ClientPage();
</pre>

In addition to the <em>initialize</em> function we know, also implement another function called <em>render</em> to be called every time you need to redraw the view.

<h3><em>El</em> property</h3>

Each instance of a view contain a property <em>called</em> to be the DOM object will have all the contents from view. This element is automatically created as an empty <em>div</em> element, unless otherwise indicated with <em>tagName</em> and <em>className</em> properties:

<pre class="prettyprint">
ClientPage = Backbone.View.Extend({
     tagName: 'li',
     className: 'tab'
});
alert((new ClientPage).the.className)) //'hello'
</pre>

By default, this item is created outside the browser's DOM structure, so it will not be visible until you insert in any other element in the document:

<pre class="prettyprint">
$(document).ready(function(){
    View = Backbone.View.extend({
       render: function(){
           $(this.el).text('Hello World');
           return this;
       }
    });

    var v = new View();
    $('body').append(v.render().el); //View
});
</pre>

In this example we used the <em>$.ready</em> jQuery to ensure that the code is executed when the document has fully loaded, which we do whenever we want to manipulate the DOM. We have relied on jQuery and DOM manipulator as Backbone does not perform these tasks, but also could have used <a href="http://zeptojs.com/" target="_blank">Zepto.js</a>.

Moreover, we could also link the property <em>it</em> with any existing item. This can be done at the time of the view definition if we want all instances of that share the same <em>it</em> view, or do so when creating the instance:

<pre class="prettyprint">
ClientPage = Backbone.View.Extend ({
   on: $('.clientList') // All views ClientPage share the same the,
                        // Unless it is redefined to create the instance
 });
var ClientPage currentClient = new ({
   on: $('#currentClient') //Indicates DOM element of this particular instance
});
</pre>

Also it should be noted that if you use jQuery or Zepto.js, each instance of view will have a role to perform local $ local searches within sight:

<pre class="prettyprint">this.$('.className') == $('.className', this.el); // true</pre>

<h3>Drawing views with templates</h3>

As I said, the render function will be responsible for drawing our view, including within the element for each instance the entire HTML content of the view.

Although not mandatory, the best option is to rely on a template system to maintain our separate javascript code HTML content. Backbone itself does not offer any support for these tasks, but the library does have a system <em>underscore.js</em> basic <a href="http://documentcloud.github.com/underscore/#template" target="_blank">templates</a>, and since Backbone depends on underscore.js we can use this template system to avoid having to include any system external.

Besides allowing us to separate our HTML JavaScript code, using templates allow us to define variables that can bind to the instance data models. For all this to us is clear, consider the following example:

<pre class="prettyprint">
ClientPage = Backbone.View.extend({
    template: _.template($('#client_page').html()),
    render: function(){
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    }
});
var client = new Client({name:'John', surname:'Doyle'});
var clientPage = new ClientPage({el:$('body'), model: client});
clientPage.render();
</pre>

In the example we first define a template is identified as 'client_page' where two variables are expected to display: <em>name</em> and <em>surname</em>. Then we define our vision where we keep the template to use for the property <em>template</em>. Also implemented the <em>render</em> method where our staff will link with the model instance containing the data, which is expected in the property model and using the method <em>toJSON</em> to get a hash object with the instance data.

Having defined the vision, we create an instance of the <em>model</em> and another instance of the view, associating the <em>model</em> instance in the model property and further indicating that its containing element is the <em>body</em> of the document. Finally we call the function to <em>render</em> the content thinks of sight under the container body.

<h3>Event delegate</h3>

Thanks to the Backbone event delegation, a view can define the behavior to events occurring within the existing elements in the container element. This defines a hash object called <em>events</em> in the following format for each property: <em>{"event selector": "callback"}</em>. This indicate that for every event that occurs under the elements indicated by the selector <em>callback</em> function is executed.

<pre class="prettyprint">
ClientPage = Backbone.View.Extend ({
     events:{
         "click .close": "closeClient"
         "click .sel": "selectClient"
         "mouseover .title": "showToolTip"
     }
     selectClient: function() {
         this.model.set ({'selected': true});
     }
     closeClient: function(){/* ...  */}
     showToolTip: function(){/* ...  */}
 });
</pre>

If no selector is not defined, the event is associated with <em>el</em> container element itself. One of the great benefits of event delegation is that all callback functions are invoked in the proper context of the hearing so that <em>this</em> will point to the instance itself from view.

<h3>Linking models views</h3>

Usually want to synchronize our views with the underlying model instances. To achieve that we must link the events to amend the model instance to our view, which we normally within the initialize method:

<pre class="prettyprint">
ClientPage = Backbone.View.Extend ({
     initialize: function () {
         this.model.bind('change', this.render, this);
         this.model.bind('destroy', this.remove, this);
     }
     render: function(){/* ...  */}
     remove: function(){/* ...  */}
});
</pre>

It is important to ensure that the model we link the events in context. As conventional methods expect views run in the context of one's own view instance, in the <em>bind</em> method we establish <em>this</em> as the third parameter, indicating that we want to use own instance of view as a backdrop.

<h2 id="routers">Routers</h2>

In traditional Web programming is normal routing to the server and the requested URL as a content or other offer. For example, a URL like blog.com/post/5 could mean that we must show a specific entry in a blog.

JavaScript applications based on a single page does not have this separation of content and the entire application is built on the same page, so it would be necessary to have some mechanism that would allow us to emulate this behavior and be able to link specific sections or content our application.

The mechanism used in these cases is the use of fragments using pad page (#) as part of the URL. Following the previous example would generate the following URL: blog.com/#/post/5. In Backbone <strong>routers</strong> are responsible for offering us this functionality, called <strong>controllers</strong> prior to version 0.5 of the library.

<h3>Defining a Router</h3>

We can define a router through the method <em>extend</em> of the object <em>Backbone.Router</em>. It specify the hash object containing all the <em>routes</em> that will be addressed and must contain at least one route. This object will enter the path as hash <em>key</em> and an associated function as a value which will be executed when we are in the route.

<pre class="prettyprint">
Router = Backbone.Router.Extend ({
     routes: {                                        //Examples of matches:
         ""                   : "index"
         "help"               : "help",           // #help
         "tag/:tagid"         : "showTag"         // #tag/dog
         "tag/:tagid/p:page"  : "showTag"         // #tag/dog/p5
         "download/*file"     : "download"        // #download/path/to/file.txt
 }
     index: function(){/* ...  */}
     help: function(){/* ...  */}
     showTag: function(tagId, page){/* ...  */}
     download: function(file){/* ...  * /}
});
</pre>

If you look at the example above, we can see that we have defined some dynamic parameters within the routes. Backbone offers two types of variables to specify variables within a URL. On the one hand would be variables of type "<em>param</em>" that captures the URL contents from its identification to the next slash (/) of the URL on the other hand would be the variables of type "<em>*param</em>" that capture the entire URL contents from its definition, so that should always be used at the end of the definition of the route. The sections captured by the variables are passed as parameters to the function associated with the route.

This mechanism of definition of variables is quite useful for its simplicity, but if you need more power when specifying a path we can use regular expressions. To define a route using a regular expression we use the method <em>route</em>:

<pre class="prettyprint">
Router = Backbone.Router.extend({
    initialize: function(){
        this.route(/post\/(\d+)/, 'id', function(pageId){/* ... */});
    }
});
</pre>

<pre class="prettyprint">
myRouter var = new Router;
</pre>

This function will define a traditional route or a regular expression in its first parameter, asociÃ¡ndosela-defined function as the third parameter. The second parameter of this function allows us to associate an event name to the route, so as to launch the event <em>route</em>: <em>name</em> each time you request the specified path.

<h3>Crawling Ajax Specification</h3>

Before continuing I would like to emphasize in a traditional problem existing in JavaScript applications. When we want our application to be interpretable by search engines like Google we have the problem that they are not able to interpret the dynamic content generated by our application, because search engines are not able to run javascript. Furthermore, when we use the hash fragments in our application URLs none of the routes will be indexed to the seeker as is always the same URL.

To solve this problem was born <a href="https://developers.google.com/webmasters/ajax-crawling/?hl=es" target="_blank">Crawling Ajax Specification</a>, which allows us to detect when a specific content is being requested by a browser and thus have the opportunity to generate the corresponding static content from the server.

This specification requires that we put the sign <em>!</em> after the hash (#) and before any dynamic hash route. A clear example would twitter:

<pre class="prettyprint">http://twitter.com/#!/devaddiction</pre>

This exclamation alert the search engine that our application is ready for Crawling Ajax Specification and translate the request to the following URL:

<pre class="prettyprint">http://twitter.com/?_escaped_fragment_=/maccan</pre>

Thus, from the server can capture the route to us by the browser examining the GET variable <em>_escaped_fragment_</em> and to generate directly the static version of the route.

If we decide to follow this specification, we must take into account the sign! in our paths to defining our router.

<pre class="prettyprint">
Router = Backbone.Router.extend({
    routes: {
        "!/post/:title": "post" // #!/post/tutorial-backbone-js
    }
    // ...
});
</pre>

<h3><em>Backbone.History</em></h3>

Once all our routers associated with all routes, it is necessary that an entity is responsible for monitoring requests made within the application to capture the events <em>hashchange</em> (updating hash fragment) browser and to apply the appropriate route and run associated functions. This entity is <em>Backbone.History</em>, and we must create it after defining all our routers invoking the method <em>start([options])</em>:

Once we have defined all the routes of our application in one or more routers, we start

<pre class="prettyprint">
  Backbone.History.Start();
</pre>

If your application does not start from the root URL /, we indicate it by the root property:

<pre class="prettyprint">
  Backbone.History.Start({root: '/app/home'});
</pre>

To use <em>Backbone.History</em> must have created at least one instance of the routers you have defined.


<h2 id="synchronization">Synchronization and persistence</h2>

And finally we come to the last topic of the tutorial on <a href="http://documentcloud.github.com/backbone/" target="_blank">Backbone.js</a>, which will work to see the mechanisms of persistence and synchronization with the server that offers the library. Previously we reviewed how we could create, modify and delete models in our application, but never said how we could send that information to the server to store or process it.

As we discuss in this topic, Backbone defines a default behavior that will help us keep the data synchronized between the client and server.

<h3>Synchronizing with the server models</h3>

When you synchronize a model Backbone uses internally <em>Backbone.sync()</em> function which by default make an Ajax call to server method relying on the <em>$.ajax()</em> jQuery or Zepto.js. That call <strong>RESTful</strong> Ajax is an application in which Backbone serialize all attributes of the model in a JSON string to send. If everything is correct, the server returns another string JSON with those attributes that have been modified from the server, and Backbone proceed to update the model on the client to be synchronized with the server status.

For Backbone can perform this process, you need to know the URL of the collection associated with the model, since the default behavior of the library is mapped CRUD operations (create, read, update, delete) to the following addresses REST:

create: POST /collection
read: GET /collection[/id]
update: PUT /collection/id
delete: DELETE /collection/id

That is, the first thing to do is attach to model the base URL of the collection (the '<em>/collection</em>' from the list above) on which to perform these operations. This URL expected from the <em>url</em> property of the model, which can be a string or a function. If you do not specify anything in the property, the default implementation will collect the base URL of the collection belonging to the model.

<pre class="prettyprint">
Users = Backbone.Collection.Extend ({
     url: '/users/'
 });
var users = new Users();
User = Backbone.Model.Extend();
var user = new User({'name': 'John Doyle'});
users.add(user);
</pre>


Both the creation of the model and its modification by the method <em>set()</em> does not imply the <em>Backbone.sync()</em> call, so if you want to synchronize our model after these operations have to use the method <em>save([attributes], [options])</em> of the model. This function is similar to the method <em>set()</em> and will update those attributes that are passed as first parameter, but also invoke <em>Backbone.sync()</em> to synchronize with the server. Also we use the second parameter <em>save()</em> to specify the call options <em>$.ajax()</em> that takes place inside:

<pre class="prettyprint">
user.save({}, {              // generate POST /users - content: {name: 'John'}
     success: function() {
         alert ("User saved successfully");
     }
 });
</pre>


In this example the operation <em>save()</em> generates a POST because it is a creation operation ('create'). Backbone performs an operation that is created whenever we try to synchronize a model instance that does not contain any value in its ID attribute, which defaults to the id attribute or that we have designated as an identifier through <em>idAttribute</em> attribute when defining the model.

If the server returns a JSON object it will be used to update the model. This is typical to happen precisely in the operations building, where the server will return the identifier of the new element created.

<pre class="prettyprint">
user.save({}, {              // generate POST /users - content: {name: 'John'}
     success: function() {
        // Assuming that the server returned the object {"id": 1}
        alert(user.id);  // show 1
     }
 });
</pre>

In this example we have assumed that the server returns a JSON object with the identifier assigned to the new instance synchronized, so that object Backbone applied on the model instance.

Once the model you have your ID, any subsequent operation on the model instance will cause a refresh operation ('update') on the server:

<pre class="prettyprint">
user.save({surname: 'Doyle'});
</pre>

As the example, the update operation sends the entire contents of the object to the server via a PUT to the specific URL of the model.

Apart from the <em>save()</em> method there are two other methods that perform synchronization model to the server: <em>fetch([options])</em> and <em>destroy([options])</em>. The <em>fetch()</em> method performs a read operation ('read') and serves to refresh the data model from the existing copy on the server:

<pre class="prettyprint">
var user = new User({id: 1})                    //Create an instance initializing the object ID you want to recover
users.add (user)                                //Add the instance to the collection to know the url based backbone of the collection
user.fetch ({                                   // generate GET /users/1
     success: function () {
          alert(JSON.stringfy(user.attributes))
    }
});
</pre>

On the other hand serves to generate an erase operation ('delete') and delete the server object instance:

<pre class="prettyprint">
var user = new User({id:1});      // Create an instance initializing the object ID that users want to
users.add(user);            // Add the instance to the collection for
user.destroy();                // is generated DELETE /users/1
</pre>

As was the case with <em>save()</em> functions both as a parameter to define the options to be used in Ajax.

As we have seen in all these examples, we have always introduced the model instance we wanted to synchronize within a collection, as a mechanism for Backbone could retrieve the base URL of the collection and thus form the REST operations for each CRUD operation. If for any reason we want to work with model instances without having to associate them with any collection, we can use the attribute <em>UrlRoot</em> in defining the model, where we define precisely the base path:

<pre class="prettyprint">
User = Backbone.Model.Extend ({
     UrlRoot: '/users/'
});
var user = new User({id: 1});
user.fetch();                  // generates GET /users/1
</pre>

As we see, defining <em>UrlRoot</em> need not be associated with any collection a model to synchronize with the server, you getting exactly the same behavior as if it were.

Finally, if we want a particular model does not have this behavior by default and we associate it with a final URL for all operations of the model, we can define directly the url property in the definition of the model:

<pre class="prettyprint">
User = new Backbone.Model.Extend ({
     url: '/user';
 });
var user = new User({id: 1});
user.fetch ({                                // generates GET /user
     success: function () {
         user.save ({'name': 'John'}, {      // generate PUT /user
             success: function() {
                 user.destroy()              // generates DELETE /user
             }
         });
     }
});
</pre>

This backbone will always perform CRUD operations on the same URL fixed, without adding or removing id, whether or not within a collection, and whether or not it has any value defined in <em>UrlRoot</em>.

<h3>Collections and Synchronization</h3>

As discussed in the previous section the concept of synchronization of models is closely linked to the concept of collection due to the nature of REST interfaces. In the examples we have seen that setting the base URL of the collection the models incorporated in it will be able to perform the synchronization operations.

Apart from the existing synchronization methods in the models, the collections have a method to retrieve an entire collection from the server: the method <em>fetch([options])</em>:

<pre class="prettyprint">
User = Backbone.Collection.extend({
    url: '/users'
});
var users = new Users();
users.fetch({                      // generates GET /users
    success: function(){
        alert('Recovered ' + users.length + ' users');
    }
});
</pre>

This method performs a GET operation on the base URL of the collection, and expects a JSON object consisting of an array of instances of models to be included in the collection. This operation will refresh the backbone event.

<h3>Customizing synchronization</h3>


As mentioned at the beginning, each synchronization operation actually performs the function <em>Backbone.sync()</em>, whose default implementation synchronizes the data with the server via Ajax calls. If we wish, we can replace this function and switch to another synchronization strategy, such as using one of the HTML5 features as WebSockets or Local Storage. For example, we can override this feature to simply show the console operations to be performed:

<pre class="prettyprint">
Backbone.sync = function (method, model, options) {
     console.log (method, model, options);
     options.success (model);
 };
</pre>


As shown in the example, the function <em>Backbone.sync()</em> expects 3 parameters:

<ul>
<li><strong>method:</strong> CRUD method to be performed ('create', 'read', 'update', or 'delete')</li>
<li><strong>model:</strong> The model to save (or collection to be read)</li>
<li><strong>options:</strong> The settings of the application, which will include callbacks <em>success</em> and <em>failure</em></li>
</ul>

All I expected Backbone is invoking the callback functions <em>options.success()</em> or <em>options.error()</em> in appropriate cases.

Overwrite function <em>Backbone.sync()</em> allow us to change strategy on a global synchronization, but it is also possible to override this function only in a particular model or collection:

<pre class="prettyprint">Users.prototype.sync = function (method, model, options) {/ * ...  * /}
</pre>

A good example of customization <em>Backbone.sync()</em> is the <a href="https://github.com/jeromegn/Backbone.localStorage" target="_blank">Local Storage Adapter</a> . Be sure to check it out.

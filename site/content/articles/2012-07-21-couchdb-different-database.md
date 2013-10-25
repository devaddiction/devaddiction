With this post we will start a little series of articles in which we see that is CouchDB, how it works and that we can serve.

We can define <a title="CouchDB" href="http://couchdb.apache.org/" target="_blank">CouchDB</a> as a document database without schema, MapReduce style searchable, accessible via REST and integrated replication functionality. Almost anything ... you better see each of these features in more detail.
<h2>Document database without schema</h2>
We're used to that when we think of database relational model (column, rows, tables, relationships ...) However CouchDB offers us keep our data differently. In short, for there is only CouchDB documents. Everything we stock is a document without schema, which allows us to keep documents together different fields within the same BD.

These documents are stored in <a title="JSON" href="http://en.wikipedia.org/wiki/JSON" target="_blank">JSON</a>, a lightweight, simple and convenient to use from any. Let's see a typical CouchDB document:

<pre class="prettyprint">
{
   "_id" : "234a41170621c326ec63382f846d5764",
   "_rev" : "1-480277b989ff06c4fa87dfd0366677b6",
   "type" : "article",
   "title" : "Test tiele",
   "body" : "I'm a test article",
   "tags" : ["cinema", "comedy"]
}
</pre>

The _id is used by CouchDB to distinguish it from other documents and we are worth to recall it. Is a string that can contain anything we want but if we do not generate a UUID anything CouchDB. And why not create an auto-increment ids? Well, using the UUID allows us to have a unique id UNIVERSALLY, which will be very useful when we go into the issue of replication, but not ahead of ourselves ...

The field _rev is special and serves to control the CouchDB document version. Each time you save a change to the document revision number changes (increased by 1 before - and the rest of the number changes). This is useful because every time we try to save a document the version number we are going to change, so that if we are keeping CouchDB sees a change to an old revision fails, and not allowed to continue.

Then the other fields we can put whatever you want, whenever we use expressions valid JSON, as in the example where you have the attribute tags is an array of strings. It could be a dictionary ({"key1": "value1" "key2": "value2"}), a number (2), etc...

The good part of working without schema is that this system adapts to changes in the structure of the documents that need to be stored. In this way we can stop worrying of what we are getting into the database, and we worry when we come back.

<h2>Consultable as MapReduce style</h2>

CouchDB does not offer a language for querying SQL type but offers a MapReduce-based system to get the data you want. And how does this work? Well, it's easier than it seems, consists of a portion Map Reduce part.

<strong>Map</strong>: It is a function that is executed for each document. This function receives as parameter the document itself and may return key-value pairs. A function may return 0, 1 or more of these pairs for a single input document. At first glance this may seem very inefficient, but the function is only executed once for each document and is storing the results in an index that relates keys and values â€‹â€‹so that in subsequent consultations attack on this index. Of course, if any of the documents of our BD is modified, again to rebuild the index (but only modified documents).

A quick example:

<pre class="prettyprint">
function(doc) {
   for (var i in doc.tags)
      emit(doc.tags[i], doc);
}
</pre>

As we can see the functions Map (and Reduce) are defined in Javascript. CouchDB provides a pluggable architecture in which we can create these in our favorite language (Python, Ruby...).

This function returns as a key to each of the tags and how to value the document itself. This doc performed on our sample would give 2 rows, one for "cinema" and another for "comedy" both having as value the document itself.

After this set of results we can filter by key or by a pair of start and end keys. Thus if we know all the items that are film filtrarÃ­amos those who have the key "cinema". It's easy, right?

The good news is that the keys can be any data type supported by JSON as arrays, numbers, dictionaries ... This can be useful for more advanced queries.

<strong>Reduce</strong>: In broad terms this brings together the results of the Map to get a number. That way if the Map above to be like this:

<pre class="prettyprint">
function (doc) {
    for (var i in doc.tags)
        emit (doc.tags [i], 1);
}

</pre>
We can define a reduced function like this:
<pre class="prettyprint">
function (keys, valuesâ€‹â€‹) {
 return sum (values);
}
</pre>

The Reduce function takes as input all the keys and all values. With the sum function, provided by CouchDB, we accumulate the function returns 1 that map so that as a result of this we get multiple rows with each of the tags as key and the number of documents that have this tag as the value.

In the nomenclature of CouchDB a couple of functions called MapReduce view (it is not mandatory to define the constraints).

<h2>Accessible by REST</h2>

<a href="http://en.wikipedia.org/wiki/REST" title="REST" target="_blank">REST</a> allows us to access our data very easily through URLs. For example to retrieve your document with ID BD <em>6e1295ed6c29495e54cc05947f18c8af</em> our albums accederÃ­amos to this URL which returns the appropriate JSON document:

<a href="http://localhost:5984/albums/6e1295ed6c29495e54cc05947f18c8af" title="http://localhost:5984/albums/6e1295ed6c29495e54cc05947f18c8af" target="_blank">http://localhost:5984/albums/6e1295ed6c29495e54cc05947f18c8af</a>

Similarly if we want access to a view as we mentioned when we explained the Map and retrieve any results go to the URL:

<a href="http://localhost:5984/blog/_design/doc/_view/tag?key="cinema"" title="http://localhost:5984/blog/_design/doc/_view/tag?key="cinema"" target="_blank">http://localhost:5984/blog/_design/doc/_view/tag?key="cinema"</a>

This URL means that we are accessing the database called blog, to retrieve a design document (where views are stored in the database) called doc and within this to view call tag. Then as we mentioned before, in the view we want to recover the key outcome identified by the film (it is interesting to see how you have to pass in "" because the key is a string, one of the valid types of JSON).

This URL would get a result like this:

<pre class="prettyprint">
{

    "total_rows": 4,
    "offset": 0,
    "rows": [{
        "id": "9280b03239ca11af9cfedf66b021ae88"
        "key": "cinema"
        "value": {
            "_id": "9280b03239ca11af9cfedf66b021ae88"
            "_rev": "1-0289d70fe05850345fd4e9118934a99b"
            "tags": ["movie", "comedy"]
        }
    }, {
        "id": "a92d03ff82289c259c9012f5bfeb639c"
        "key": "cinema"
        "value": {
            "_id": "a92d03ff82289c259c9012f5bfeb639c"
            "_rev": "2-97377eef95764a4dbf107d8142187f53"
            "tags": ["movie", "drama"]
        }
    }
]}
</pre>

As shown in key and value have the expected result: the tag and the document that contains it. Apart CouchDB includes the id of the document that has led to this result (which enters as a parameter in the Map function). It also returns the total number of rows returned and the offset of the result.

Instead the key parameter can be passed from our sight a couple of parameters and endkey startkey for a range of results that we are interested (eg in a view as key to return a string representing a date).

<h2>Integrated replication</h2>

Relatively exotic functionality allows our BD data synchronize your data very easily (a simple REST call active) with another BD remote or local. Thus we have a very simple way one or more replicas of our BD to implement high availability architectures or load balancing.

If you remember when we discussed that CouchDB using UUIDs as identifiers default documents you will see that having several rows BD exchanging data that is indispensable. Just think if we had 2 or more databases each with its auto-increment and go and began to passed data between them

Similarly, the attribute _rev above mentioned CouchDB allows us to detect cases where a document has been amended several databases at once (each document would have a different _rev).

If you think of this post you can prove interesting to follow the practical introduction in the <a href="http://guide.couchdb.org/" title="Couch DB Book" target="_blank">book</a> offered free of CouchDB <a href="http://guide.couchdb.org/draft/tour.html" title="CouchDB Book" target="_blank">here</a>.




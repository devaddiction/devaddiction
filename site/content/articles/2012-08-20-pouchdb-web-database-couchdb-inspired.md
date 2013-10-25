PouchDB is a JavaScript library to store and query data for Web applications that need to work offline and then synchronize with an online database.

Inspired by <a href="http://blog.devaddiction.com/couchdb-a-different-database/ " title="Apache CouchDB" target="_blank">Apache CouchDB</a>, PouchDB is a small web database and especially for mobile applications that need to store data in a database based on the browser can be used offline. The database can be synchronized with CouchDB or other basis when online.

Like Apache CouchDB has an HTTP API based on REST and JSON objects that can store JSON.

Currently PouchDB is a library of 131 kb compressed javascript. That can perform the following tasks: create/query/reply/delete a database, create/search/update/delete document(s) to retrieve information from databases and also has a listener of the database changes. The database also comes with a REST HTTP adapter that can be used to synchronize the contents CouchDB/PouchDB. What more do you want?

PouchDB IndexedDB API uses HTML 5 storage to access the SQLite currently in Firefox browser and LevelDB in Chrome. PouchDB was tested on Firefox chrome 12 and 19.

Let's see some code:

<pre class="prettyprint">
var authors = [
  {name: 'Dale Harvey', commits: 253},
  {name: 'Mikeal Rogers', commits: 42},
  {name: 'Johannes J. Schmidt', commits: 13},
  {name: 'Randall Leeds', commits: 9}
];
Pouch('idb://authors', function(err, db) {
  // Opened a new database
  db.bulkDocs({docs: authors}, function(err, results) {
    // Saved the documents into the database
    db.replicate.to('http://host.com/cloud', function() {
      // The documents are now in the cloud!
    });
  });
});
</pre>

This is a genius!

Project Link: <a href="http://pouchdb.com/" title="PouchDB" target="_blank">http://pouchdb.com/</a>
API: <a href="http://pouchdb.com/#api-documentation" title="PouchDB API" target="_blank">http://pouchdb.com/#api-documentation</a>




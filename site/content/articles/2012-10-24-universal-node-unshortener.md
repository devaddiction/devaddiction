Lately I've been spending my evenings and nights working on a super secret and above awesome project that I will talk about â€¦ soon, when it's a bit more ready.

That project deals mostly with Twitter and harnessing url's from the stream. As anyone who's sniffed at Twitter lately can atest, therea re many, many many strange urls floating around, using any number of url shortening schemes or what seems to have become quite fashionable, a custom domains that are shortenered via services nobody could guess at.

But when you're trying to do something useful with these it's usually much easier when you have the original url to work with. Especially when it comes to doing things for specific domains.

What's needed is some sort of library that can unshort pretty much any url you throw at it. Surely someone has already made one right?

Turns out, outside of a few services, no such thing existed â€¦ and I didn't want to use a third party service. Naturally I set out to make my own library for unshortening short links.

You can <a href="https://github.com/Swizec/node-unshortener" target="_blank">check out the source on github</a>.

<h3>Example</h3>

It's pretty simple to use, only has one function you should care about

<pre class="prettyprint">
var unshortener = require('unshortener');

// you can pass in a url object or string
unshortener.expand('http://bit.ly/ZA0DCX',
                   function (url) {
                       console.log(url.href);

               // prints: https://twitter.com/DevAddiction/status/283878828110147584
                   });
</pre>

<h3>Simple logic</h3>
The approach is pretty simple:

<ol>
<li>take a url</li>
<li>known service</li>
<li>use an API</li>
<li>pretend to be a browser</li>
</ol>
As you can see, the library is pretty simple, just 68 lines of JavaScript code. But simple solutions are good solutions I'm told and this little thing does everything I need it to do.

Right now it directly supports only bit.ly and is.gd, so if you know of any more shorteners with an expand API please tell me so I can add them. Following redirects is a bit messy and I'd prefer to do as much as possible through official API's.

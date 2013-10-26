For those who do not know, in English a <strong>freebie</strong> is something that is given freely and is a term widely used in the English-speaking blogs. Today I bring you a site template in HTML5 and CSS3 fully adapted for responsive web design. Use half of CSS queries and is ideal for learning both CSS3 and designing responsive design websites.

This template is specially designed for teaching purposes, both for those who just you begin with responsive web design like you who want to take your knowledge of CSS3 later. It is developed with <strong>HTML5 and CSS3</strong>, as more and more websites that are developed with these technologies.

<pre class="prettyprint">

&lt;div class="container"&gt;

       &lt;input type="radio" name="radio-set" checked="checked" id="radio-1"/&gt;
               &lt;a href="#home"&gt;Home&lt;/a&gt;
       &lt;input type="radio" name="radio-set" id="radio-2"/&gt;
               &lt;a href="#about"&gt;About me&lt;/a&gt;
       &lt;input type="radio" name="radio-set"  id="radio-3"/&gt;
               &lt;a href="#design"&gt;Design&lt;/a&gt;
       &lt;input type="radio" name="radio-set"  id="radio-4"/&gt;
               &lt;a href="#blog"&gt;Blog&lt;/a&gt;
       &lt;input type="radio" name="radio-set"  id="radio-5"/&gt;
               &lt;a href="#contact"&gt;Contact Me&lt;/a&gt;

       &lt;div class="scroll"&gt;

           &lt;section class="panel color-1" id="home"&gt;
               &lt;h2&gt;Responsive Design&lt;/h2&gt;
               &lt;p&gt;Learning to create websites with HTML5 and CSS3 responsive&lt;/p&gt;

            &lt;/section&gt;

           &lt;section class="panel color-2" id="sobre"&gt;
               &lt;h2&gt;Lorem ipsum&lt;/h2&gt;
               &lt;p&gt;Lorem ipsum, bla, bla, bla, m&aacute;s lorem ipsum.&lt;/p&gt;
           &lt;/section&gt;

           &lt;section class="panel color-3" id="diseno"&gt;
               &lt;h2&gt;Lorem ipsum&lt;/h2&gt;
               &lt;p&gt;Lorem ipsum, bla, bla, bla, m&aacute;s lorem ipsum.&lt;/p&gt;
           &lt;/section&gt;

           &lt;section class="panel color-4" id="cursos"&gt;
               &lt;h2&gt;Lorem ipsum&lt;/h2&gt;
               &lt;p&gt;Lorem ipsum, bla, bla, bla, m&aacute;s lorem ipsum.&lt;/p&gt;
           &lt;/section&gt;


           &lt;section class="panel color-5" id="contacto"&gt;
                &lt;h2&gt;Lorem ipsum&lt;/h2&gt;
               &lt;p&gt;Lorem ipsum, bla, bla, bla, m&aacute;s lorem ipsum.&lt;/p&gt;
           &lt;/section&gt;

       &lt;/div&gt;

   &lt;/div&gt;
   &lt;div class="clr"&gt;&lt;/div&gt;
   &lt;footer&gt;
    &lt;a href="#"&gt;Espa&ntilde;ol&lt;/a&gt; &nbsp; | &nbsp; &lt;a href="#"&gt;English&lt;/a&gt;
   &lt;/footer&gt;
</pre>

As you can see, the HTML does not have much secrecy. The menu structure is organized with a selection of radio, and only the first option is the one selected: checked="checked". What happens if you leave selected any other option? That web page will open up the last of the list that has checked="checked" in the code. This is fine if you want to do a different design, but as a rule always start at the first tab.

<h3>CSS and CSS3</h3>

Consider now the CSS code.

Here and there pretty much anything, see point by point:

<pre class="prettyprint">
@import url('normalize.css');

/* Basics */
@font-face{font-family:Cubano; src:url('webfonts/cubano-regular-webfont.ttf')}

body{
    font-family: Arial, sans-serif;
    background: #fff;
    font-weight: 400;
    font-size: 15px;
    color:#fff ;
    overflow: hidden;

}
a{
    text-decoration: none;
}

.clr{
    clear: both;
    padding: 0;
    height: 0;
    margin: 0;
}
</pre>

The first thing we have done is to import the stylesheet <strong>normalize.css</strong>, which makes us the CSS reset functions. Then use the <em>@font-face</em> CSS3 allows us to use custom font styles, in this case we typography Cuban WebFonts the folder.

We used in the <em>body</em> <em>overflow: hidden;</em>, preventing the user to move with a lateral or horizontal bar (although not so in touch devices).

The class we just <em>clr</em> makes using <em>clear: both</em> after using any <em>float</em>. In this way, we avoid repeating the code unnecessarily.

<pre class="prettyprint">

/* Container */

.container {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.container > input,
.container > a {
    position: fixed;
    top: 0px;
    width: 20%;
    font-family:Cubano,Impact,Arial,sans-serif;
    text-transform:uppercase;
    cursor: pointer;
    font-size: 23px;
    height: 38px;
    line-height: 38px;
    -webkit-box-shadow: 0px 0px 5px #343434;
    box-shadow: 0px 0px 5px #343434;
}


.container > input {
    opacity: 0;
    z-index: 1000;
}

.container > a {
    z-index: 10;
    background: #000;
    color: #fff;
    text-align: center;
    text-shadow: 1px 1px 2px #666;
}

.container:before {
    content: '';
    position: fixed;
    width: 100%;
    height: 37px;
    background: #000;
    z-index: 9;
    top: 0;
}
</pre>


For those who do not know it, <em>div> div</em> is a CSS selector indicating a span which is father to a <em>div</em>. What we do is set the width of each of the menu tabs that as 5 is 20%. The reason we give an <strong>opacity 0</strong> to the inputs is because we want to be there so that they can click, but do not want to be visible. As in previous versions of IE9 Opacity not working, if you support this browser will look for another alternative, or otherwise appear type radio buttons radio. We also use z-index property because as we have several elements in the same layer, we must make a priority of <em>input</em>.

<pre class="prettyprint">
#radio-1, #radio-1 + a {
    left: 0;
}

#radio-2, #radio-2 + a {
    left: 20%;
}

#radio-3, #radio-3 + a {
    left: 40%;
}

#radio-4, #radio-4 + a {
    left: 60%;
}

#radio-5, #radio-5 + a {
    left: 80%;
}
</pre>

Here we are defining what is the color of the tabs when selected. In this case, I did the same as the background.

<pre class="prettyprint">

input:checked + a,
input:checked:hover
{
-webkit-border-top-left-radius: 3px;
-webkit-border-top-right-radius: 3px;
-moz-border-radius-topleft: 3px;
-moz-border-radius-topright: 3px;
border-top-left-radius: 3px;
border-top-right-radius: 3px;
}
</pre>

To give the feeling of being a true tab, I have a curve to the top of the tabs when selected property taking advantage of CSS3 <em>border-radius</em>.

<pre class="prettyprint">
.scroll,
input:checked + a,
input:checked:hover + a  {
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;

}
</pre>

Here we are using <strong>CSS3 transitions</strong>, so that when we change the tab, the transitions take place gradually in the middle second, instead of jumping at once.

<pre class="prettyprint">
#radio-1:checked ~ .scroll {
    -webkit-transform: translateY(0%);
    -moz-transform: translateY(0%);
    -o-transform: translateY(0%);
    -ms-transform: translateY(0%);
    transform: translateY(0%);
}
#radio-2:checked ~ .scroll {
    -webkit-transform: translateY(-100%);
    -moz-transform: translateY(-100%);
    -o-transform: translateY(-100%);
    -ms-transform: translateY(-100%);
    transform: translateY(-100%);
}
#radio-3:checked ~ .scroll {
    -webkit-transform: translateY(-200%);
    -moz-transform: translateY(-200%);
    -o-transform: translateY(-200%);
    -ms-transform: translateY(-200%);
    transform: translateY(-200%);
}
#radio-4:checked ~ .scroll {
    -webkit-transform: translateY(-300%);
    -moz-transform: translateY(-300%);
    -o-transform: translateY(-300%);
    -ms-transform: translateY(-300%);
    transform: translateY(-300%);
}
#radio-5:checked ~ .scroll {
    -webkit-transform: translateY(-400%);
    -moz-transform: translateY(-400%);
    -o-transform: translateY(-400%);
    -ms-transform: translateY(-400%);
    transform: translateY(-400%);
}
</pre>

<em>div ~ span</em> is a <em>span</em> that is a <strong>sibling</strong> of a <em>div</em>. Here what we said is that if a button is active, make a scroll down (hence the negative sign), indicating the percentage. As each page has a width and height of 100%, if we make a scroll of -300% we will go to the third tab content.

<pre class="prettyprint">
/* Bg Color */

.color-1 {
    background:#005dc7;
}

.color-2 {
    background:#7ac900;
}

.color-3 {
    background:#fec211;
}
.color-4 {
    background: #e34a28;
}

.color-5 {
    background: #af2d9b;
}
</pre>

Here we are simply defining the color of each of the pages, color we did match the lashes.

<pre class="prettyprint">
.panel h2 {
    position:relative;
    left:0%;
        top:35%;
    font-family:Cubano;
    letter-spacing:1px;
    color:#fff;
    text-shadow: 1px 1px 3px #343434;
    font-size: 40px;
    font-weight: 700;
    padding: 0;
    text-align: center;
    -webkit-transition: all 1s ease-in-out;
    -moz-transition: all 1s ease-in-out;
    -o-transition: all 1s ease-in-out;
    -ms-transition: all 1s ease-in-out;
    transition: all 1s ease-in-out;

}

.panel h2:hover {
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -o-transform: scale(1.2);
    -ms-transform: scale(1.2);

}
</pre>

This indicated that the main content is about 35% of the top and a 0% on the left side and centered in the middle. We use the CSS3 transitions that can scale content when the user moves the mouse over.

<pre class="prettyprint">

#radio-1:checked ~ .scroll #home h2,
#radio-2:checked ~ .scroll #sobre h2,
#radio-3:checked ~ .scroll #diseno h2,
#radio-4:checked ~ .scroll #cursos h2,
#radio-5:checked ~ .scroll #contacto h2 {

    -webkit-animation: moveDown 0.8s ease-in-out 0.4s backwards;
    -moz-animation: moveDown 0.8s ease-in-out 0.4s backwards;
    -o-animation: moveDown 0.8s ease-in-out 0.4s backwards;
    -ms-animation: moveDown 0.8s ease-in-out 0.4s backwards;
    animation: moveDown 0.8s ease-in-out 0.4s backwards;
}
@-webkit-keyframes moveDown{
    0% {
        -webkit-transform: translateY(-50px);
        opacity: 0;
    }
    100% {
        -webkit-transform: translateY(0px);
        opacity: 1;
    }
}

@-moz-keyframes moveDown{
    0% {
        -moz-transform: translateY(-50px);
        opacity: 0;
    }
    100% {
        -moz-transform: translateY(0px);
        opacity: 1;
    }
}

@-o-keyframes moveDown{
    0% {
        -o-transform: translateY(-50px);
        opacity: 0;
    }
    100% {
        -o-transform: translateY(0px);
        opacity: 1;
    }
}

@-ms-keyframes moveDown{
    0% {
        -ms-transform: translateY(-50px);
        opacity: 0;
    }
    100% {
        -ms-transform: translateY(0px);
        opacity: 1;
    }
}

@keyframes moveDown{
    0% {
        transform: translateY(-50px);
        opacity: 0;
    }
    100% {
        transform: translateY(0px);
        opacity: 1;
    }
}
</pre>

This sounds complicated but is very simple. What we are saying is that when the user clicks on a new tab, the main content is moved up and down and go to have an opacity 0-1. As in the paragraph below is the same but from bottom to top, omit explanation. We use <em>keyframes</em> used to specify the parameters of the initial position, this is the 0% and final, or 100%.

<h3>Media Queries</h3>

<pre class="prettyprint">
@media screen and (max-width: 360px) {
    .container > a {
        font-size: 10px;
    }
}

@media screen and (max-width: 520px) {
    .panel h2 {
        font-size: 42px;
    }

    .panel p {
        width: 90%;
        left: 5%;
        margin-top: 0;
    }

    .container > a {
        font-size: 13px;
    }
}
</pre>

I have only used two media queries in CSS theme of time, but in a real development should be used far more to offer the best user experience. To work in a real environment, I recommend using a framework or grid responsive. I am of the opinion that it is better to start developing for smaller resolutions and gradually increase resolution, but to taste the colors.


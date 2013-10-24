When you start mixing things have to tread very eye for no fuss. Concurrent programming is one of those things that once required to share information between processes / threads (the way it is), it becomes something to be treated with care to avoid introducing race conditions ( <a href="http://en.wikipedia.org/wiki/Race_condition" target="_blank"><em>race conditions</em></a> ).
<h3>The strands</h3>

 A <strong>race condition</strong> (I had a teacher who called critical race, which seems a much nicer name), occurs when two threads execute a sequence of instructions in an order that we had anticipated, which generates quite difficult to reproduce bugs . The most common are <strong>two threads accessing the same variable and "stepping on" the value just written.</strong>


All this comes to mind because I recently had to debug some code with a pint like this:

<pre><code>
public class Wrapper
{
    private int current;
    private int total;
    private Control control;

    public void Start(int param1, int param2)
    {
        SomeFunctionInBackgroundThread(
            param1, param2,
            (newCurrent, newTotal) =>
            {
                this.current = newCurrent;
                this.total = newTotal;

                if (this.total > 0)
                    control.BeginInvoke((Action)(() =>control.Text = (current/total).ToString("p")));
            });
    }
}
</code></pre>

In the method <code>Start</code> invoking a function in a native dll which is passed a callback function that was invoked periodically to report progress. The callback function all it does is to update the values stored with the state of progress and update the text of a control, you need to use <code>BeginInvoke</code>and redirect the call to the UI thread .

When the process ends, the native DLL callback function invoked by passing the <code>newTotal == 0</code>to indicate it has finished. To avoid division by 0, before launching the <code>BeginInvoke</code> see that<code>total &gt; 0</code> and that's it, right? No, <strong>that does not work.</strong>
<h3>Lambda closures</h3>


Using a C # lambda expression we are creating a <a href="http://en.wikipedia.org/wiki/Closure_%28computer_science%29" target="_blank">lambda closure</a> on the variables that we reference in the expression. In a lambda closed, <strong>those variables that are not local <em>to the function</em> (in this case, the lambda expression) are linked to the external environment variables,</strong> in this case, the method containing the lambda expression.


To call <code>BeginInvoke</code> 're having a lambda expression:
<pre>
Control.BeginInvoke((Action)(() =>control.Text = (current/total).ToString("p")));
</code></pre>


At first glance it might seem that the closure lambda variables is performed on the <code>control</code> ,<code>current</code> and <code>total</code> , but the eye that is not local variables. Actually <strong>the closure is made on the implicit reference to <code>this</code></strong> , because in reality <code>total</code> is <code>this.total</code> .


What does that mean? This means that, if we mix the way it is done closing lambda race conditions we had before, we have a problem. It may be that when you run the expression passed to<code>BeginInvoke</code> (running asynchronously) has been re-invoke the callback function and the value of<code>total</code> has gone to 0.


The solution is simple: you can put the <code>if</code> inside the lambda expression using local variables or function <code>callback</code> , which are local and are not going to see modified by subsequent invocations of the function <code>callback</code> , but it took a while see it.

<h3>Moral</h3>

<strong>Concurrent programming is not trivial.</strong> If you can avoid sharing state, the better. If you can avoid mutable state, the better.

<strong>Lambda Closures are powerful, but be careful to be sure that you close.</strong> Bugs lambda closures resulting from mixing with concurrent programming are fun to debug.

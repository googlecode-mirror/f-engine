<h1>Model-View-Controller</h1>
<p>
    F-engine is based on the Model-View-Controller development pattern.
    MVC is a software approach that separates application logic from presentation.  In practice, it permits your web pages to contain minimal scripting since the presentation is separate from the PHP scripting.
</p>
<ul>
    <li>
        The <strong>Model</strong>
        represents your data structures. Typically your model classes will contain functions that help you
        retrieve, insert, and update information in your  database.
    </li>
    <li>
        The <strong>View</strong>
        is the information that is being presented to a user.  A View will normally be a web page, but
        in F-engine, a view can also be a page fragment like a header or footer. It can also be an RSS page, or any other type of "page".
    </li>
    <li>
        The <strong>Controller</strong>
        serves as an <em>intermediary</em>
        between the Model, the View,
        and any other resources needed to process the HTTP request and generate a web page.
    </li>
</ul>
<p>
    F-engine has a fairly loose approach to MVC since Models are not required.
    If you don't need the added separation, or find that maintaining models requires more complexity than you
    want, you can ignore them and build your application minimally using Controllers and Views. F-engine also
    enables you to incorporate your own existing scripts, or even develop core libraries for the system,
    enabling you to work in a way that makes the most sense to you.
</p>

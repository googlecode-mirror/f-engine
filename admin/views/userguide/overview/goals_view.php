<h2>Design and Architectural Goals</h2>

<p>Our goal for F-engine is <dfn>maximum performance, capability, and flexibility in the smallest, lightest possible package</dfn>.</p>

<p>To meet this goal we are committed to benchmarking, re-factoring, and simplifying at every step of the development process,
rejecting anything that doesn't further the stated objective.</p>

<p>From a technical and architectural standpoint, F-engine was created with the following objectives:</p>

<ul>
<li><strong>Dynamic Instantiation.</strong>  In F-engine, components are loaded and routines executed only when requested, rather than globally.  No assumptions are made by the system regarding what may be needed beyond the minimal core resources, so the system is very light-weight by default.  The events, as triggered by the HTTP request, and the controllers and views you design will determine what is invoked.</li>
<li><strong>Loose Coupling.</strong>  Coupling is the degree to which components of a system rely on each other.  The less components depend on each other the more reusable and flexible the system becomes. Our goal was a very loosely coupled system.</li>
<li><strong>Component Singularity.</strong>  Singularity is the degree to which components have a narrowly focused purpose.  In F-engine, each class and its functions are highly autonomous in order to allow maximum usefulness.</li>
</ul>

<p>F-engine is a dynamically instantiated, loosely coupled system with high component singularity. It strives for simplicity, flexibility, and high performance in a small footprint package.</p>

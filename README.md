<h1> Euler Android Application Backend </h1>

There are currently five activity screens in the Euler Android Application (source code located in the EulerAndroidApp repository https://github.com/HarikaSabbella/EulerAndroidApp).  

The following is a flow diagram of the order in which the activities get called:
![Image](https://github.com/HarikaSabbella/images/blob/master/architecture.png?raw=true)

Main activity is the home screen of the application.  Here, users can click on the “Choose input” button to be redirected to a Google Site where there are links to sample Yaml taxonomy files (and the click of this button starts the WebView activity).  When the user clicks on a link, the web address of the link is captured using the shouldOverrideUrlLoading() function call and the WebView activity is finished and the captured web address is returned to the Main Activity.  This web address is then passed on to ShowGraphs Activity via an intent object.  

In the ShowGraphs activity, using an HttpUrlConnection object, the content from the web address are stored into a file (Graph.txt) on the Android device (and this file is a private file--meaning users of the Android device cannot see it or modify it).  Then, Graph.txt is parsed into nodes and edges.  Using a hashmap of a hashmap --- where the inner hashmap stores each node’s (N1...n) text/label as the key and the labels of all the nodes reachable through isa edges from N1 as the value (all these labels are appended to form a StringBuffer object) and the outer hash map stores each taxonomy’s group as the key and the inner hash map as the value.  For example, given a taxonomy like this:

![Image](https://github.com/HarikaSabbella/images/blob/master/graph2.png?raw=true)

we would have stored the following:
[1, [[A, []], [C, [A]]]], [2, [D, []]] into the hashmap of hashmaps.   Using another hashmap, we map each node’s label with a DiagramNode object (used to later draw edges between nodes by looking up nodes based on labels).  Then, DiagramNode objects and “isa” DiagramLink objects are created and placed onto the Diagram object.  Finally, we process all of the edges that have other articulations and place those onto the Diagram object as well and at this point, we have a complete visualization of the input Yaml file.  

<em> To handle user input: </em>
Using a SharedPreferences object we store all of the articulations and we modify this object whenever the user clicks on the “Modify Available Articulations” selection under “Modify Diagram.”  This object is also used to set up the articulations ListView object when the user clicks on the “Add New Edge” selection or when the user clicks on an edge (there are listener objects that detect when an edge or a node is clicked) to change the present articulations on that edge.  

A global counter is maintained to switch the present node color to red when the user taps on the nodes.  The counter is mostly used to set the from versus the to spinner text for the “Modify Available Articulations” selection.  

To maintain the flow in the diagram, each taxonomy is assigned a number (and there is a hashmap where the key is the taxonomy group name and the value is the number assigned to the taxonomy) in the order that they are put on the Diagram object.  Using this number, the edges for the taxonomies that are assigned even numbers are flipped around (to make the leaves face leaves) and the edges for the odd taxonomies are left as is.   The flow in the diagram is left to right and if we find that there are any edges going from right to left using the number assigned to each taxonomy, these edges are flipped around (the arrow is placed at the head instead of the tail).  

When the “Run Euler” selection is clicked on, the nodes and edges in the Diagram object are obtained and a new CleanTax file of the Diagram object (now with user modifications) is created.  This file is then posted to the Dilbert server (dilbert.cs.ucdavis.edu) and moved to /var/www/html/Euler via a small PHP script (generateSVG.php).  Then, Euler is run on this file using generatesSVG.php and the files are placed into tmp/Euler3.  Then, the ConsistencyChecker activity is started and the HttpResponse object (from running generatesSVG.php) is passed to the ConsistencyChecker activity.    

In the ConsistencyChecker activity,  if we find the word “inconsistent” is found in the HttpResult object passed to this activity, then Euler is run again and this time a lattice is generated.  The lattice dot file is parsed and the nodes and edges are extracted.  Then, we place these nodes and edges onto another Diagram object and display the object.  When the user clicks on one of the nodes in the Diagram object, a new CleanTax file is generated which contains only the articulations present on the node the user clicked on in the CleanTax file.  Euler is run again on this new CleanTax file and the DisplayPossibleWorlds activity is started.

In the DisplayPossibleWorlds, the SVG file for the aggregate view is displayed on a WebViewClient.  In this activity, when the user clicks on the “See Individual Worlds”  button, another PHP script is executed (movePossibleWorldsSVGFiles.php) and the possible world SVG files are moved from /tmp/Euler3 to /var/www/html/Euler/possibleWorldsSVGFiles directory and the user is directed to a WebViewClient which displays this directory (and the user can click on the links to these individual world files to view the SVG files for each individual world). 

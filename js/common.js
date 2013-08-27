//*****************************************************************************
// Commonly used code and functions.
//*****************************************************************************

// Check for specific browsers.
var isIE     = (document.all && window.innerWidth == null ? true : false);
var isOpera  = (window.opera ? true : false);
var isSafari = (navigator.userAgent.indexOf("Safari") >= 0 ? true : false);

// This code is necessary for browsers that don't reflect the DOM constants.
if (document.ELEMENT_NODE == null)
{
	document.ELEMENT_NODE = 1;
	document.TEXT_NODE    = 3;
}

//=============================================================================
// Code to add/remove style classes to elements.
//=============================================================================

//-----------------------------------------------------------------------------
// Returns true if the given element currently has the specified style class.
//-----------------------------------------------------------------------------
function hasClassName(el, name)
{
	var list = el.className.split(" ");
	for (var i = 0; i < list.length; i++)
		if (list[i] == name)
			return true;

	return false;
}

//-----------------------------------------------------------------------------
// Adds the specified class name to the given element.
//-----------------------------------------------------------------------------
function addClassName(el, name)
{
	if (!hasClassName(el, name))
		el.className += (el.className.length > 0 ? " " : "") + name;
}

//-----------------------------------------------------------------------------
// Removes the specified class name from the given element.
//-----------------------------------------------------------------------------
function removeClassName(el, name)
{
	if (el.className == null)
		return;

	var newList = new Array();
	var curList = el.className.split(" ");
	for (var i = 0; i < curList.length; i++)
		if (curList[i] != name)
			newList.push(curList[i]);
	el.className = newList.join(" ");
}

//=============================================================================
// Window onload code, allows assignment of multiple handlers.
//
// Note: Where possible, will use the DOMContentLoaded event (or IE equivalent)
// instead of the window onload event to avoid waiting for external objects to
// load.
//=============================================================================

// Define a method for adding handlers.
window.addOnloadHandler = WindowAddOnloadHandler;

// Create an array for the event handlers.
window.onloadHandlers = new Array();

// Set the real onload handler.
//window.onload = WindowOnload;
if (document.addEventListener != null)
	document.addEventListener("DOMContentLoaded", WindowOnload, false);
else if (isIE)
{
	document.write("<script id=\"IEWindowOnload\" defer src=\"javascript:void(0)\"><\/script>");
	var script = document.getElementById("IEWindowOnload");
	script.onreadystatechange =
		function()
		{
			if (this.readyState == "complete")
				WindowOnload();
		}
}
else
	window.onload = WindowOnload;

//-----------------------------------------------------------------------------
// Adds a function to the array of window.onload handlers.
//-----------------------------------------------------------------------------
function WindowAddOnloadHandler(h)
{
	window.onloadHandlers[window.onloadHandlers.length] = h
}

//-----------------------------------------------------------------------------
// The master window.onload handler, calls each function in the array.
//-----------------------------------------------------------------------------
function WindowOnload(e)
{
	// Call every onload handler in the list.
	for (var i = 0; i < window.onloadHandlers.length; i++)
	{
		try
		{
			window.onloadHandlers[i](e);
		}
		catch (ex)
		{}
	}
}

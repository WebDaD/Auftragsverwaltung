var cal;
function init_page(){
	loadOverview();
}


function navigateTo(page){
	switch(page){
	case "auftragsnummer":loadAuftragsnummer();break;
	case "overview":loadOverview();break;
	case "auftraggeber":loadAuftraggeber();break;
	}
}
	
function loadAuftragsnummer(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Auftragsnummer';
		e("output_text").innerHTML = ajax.responseText;
		cal = new JsDatePick({
			useMode:2,
			target:"nummer_datum",
			limitToToday:true,
			cellColorScheme:"ocean_blue",
			imgPath:"./img/",
			dateFormat:"%d.%m.%Y"
				});
		}
	};
	ajax.open("POST", "./php/nummer/loadNewDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
}
function loadOverview(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Übersicht Aufträge';
		e("output_text").innerHTML = ajax.responseText;
		}
	};
	ajax.open("POST", "./php/overview/loadData.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
}
function loadAuftraggeber(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Übersicht Auftraggeber';
		e("output_text").innerHTML = ajax.responseText;
		}
	};
	ajax.open("POST", "./php/auftraggeber/loadData.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
}
	
/**
 * Gets an Ajax Element
 * 
 *  @called function
 *  @since 0.1
 *  @worker none
 *  @manipulates none
 *  @return ajaxrequest
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function getAjax(){
	var ajaxRequest;  // The variable that makes Ajax possible!	
	try
		{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
		} 
	catch (e)
		{
		// Internet Explorer Browsers
		try
			{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} 
		catch (e) 
			{
			try
				{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} 
			catch (e)
				{
				// Something went wrong
				showError("Your browser broke!");
				return false;
				}
			}
		}
	return ajaxRequest;
}
/**
 * Gets Element from the DOM
 * 
 *  @called function
 *  @param name ID of the Element
 *  @since 0.1
 *  @worker none
 *  @manipulates none
 *  @return element
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function e(name){
	return document.getElementById(name);
}
function togglePopup(){
	toggle(e("page-cover"));
	toggle(e("popup"));
}
/**
 * Toogles Visibility of an Element by setting or removing CSS-Class .hidden
 * 
 *  @called function
 *  @param element element-object
 *  @since 0.1
 *  @worker none
 *  @manipulates The Element
 *  @return none
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function toggle(element){
	if(hasClass(element,"hidden")){
		element.className = element.className.replace('hidden','');
	}
	else {
		element.className = element.className + " hidden";
	}
}
/**
 * Shows an Element by removing CSS-Class .hidden
 * 
 *  @called function
 *  @param element element-object
 *  @since 0.1
 *  @worker none
 *  @manipulates The Element
 *  @return none
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function show(element){
	if(hasClass(element,"hidden"))element.className = element.className.replace('hidden','');
}
/**
 * Hides an Element by setting CSS-Class .hidden
 * 
 *  @called function
 *  @param element element-object
 *  @since 0.1
 *  @worker none
 *  @manipulates The Element
 *  @return none
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function hide(element){
	if(!hasClass(element,"hidden"))element.className = element.className + " hidden";
}



/**
 * Checks if an Element has a Certain Class
 * 
 *  @called function
 *  @param element element-object
 *  @param cls Name of the Class
 *  @since 0.1
 *  @worker none
 *  @manipulates none
 *  @return true or false
 *  @version 1.0
 *  @author Dominik Sigmund
 */
function hasClass(element, cls){
	return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}
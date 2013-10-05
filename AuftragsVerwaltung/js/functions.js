var cal;
var timePeriodInMs = 4000;
var loggedin = false;
function init_page(){
	navigateTo("overview");
}

function cancel(page){
	navigateTo(page);
}
function navigateTo(page){
	isLoggedIn();
	if(loggedin){
	switch(page){
	case "auftragsnummer":loadAuftragsnummer();break;
	case "overview":loadOverview();break;
	case "archiev":loadArchive();break;
	case "auftraggeber":loadAuftraggeber();break;
	case "login":loadLogin();break;
	case "reports":loadReports();break;
	}
	}
	else  {
		loadLogin();
	}
}
function logout(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		window.location.reload();
		}
	};
	ajax.open("POST", "./php/login/logout.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function loadLogin(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Login';
		e("output_text").innerHTML = ajax.responseText;
		}
	};
	ajax.open("POST", "./php/login/loadForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function checkLogin(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		if(ajax.responseText=="1"){
			clear();
			isLoggedIn();
			loadOverview();
		}
		else {
			m_e(ajax.responseText);
			loadLogin();
		}
		}
	};
	
	var params = p("login_name")+"&"+p("login_password", true);
	ajax.open("POST", "./php/login/checkLogin.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	wait();
}
function isLoggedIn(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		if(ajax.responseText=="1"){
			loggedin = true;
			show(e("logout_button"));
		}
		else {
			loggedin = false;
			hide(e("logout_button"));
		}
		}
	};
	ajax.open("POST", "./php/login/isLoggedIn.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
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
			limitToToday:false,
			cellColorScheme:"ocean_blue",
			imgPath:"../img/",
			dateFormat:"%d.%m.%Y"
				});
		}
	};
	ajax.open("POST", "./php/nummer/loadNewDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null);
	wait();
}
function saveAuftragsNummer(){
	var ajax = getAjax();
	
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		clear();
		e("output_header").innerHTML = 'Auftragsnummer';
		e("output_text").innerHTML = ajax.responseText;
		}
	};
	var fd = new FormData;
		if(e("nummer_file").files.length > 0){
	 	fd.append("File", e("nummer_file").files[0]);
		}
	 	fd.append("nummer_datum",e("nummer_datum").value);
	 	fd.append("nummer_strasse",e("nummer_strasse").value);
	 	fd.append("nummer_plz",e("nummer_plz").value);
	 	fd.append("nummer_ort",e("nummer_ort").value);
	 	
	 	fd.append("nummer_zusatz",e("nummer_zusatz").value);
	 	fd.append("nummer_nummer",e("nummer_nummer").value);
	 	
	 	fd.append("nummer_rb",rb_val("nummer_rb"));
	 	var ag_style = rb_val("nummer_rb");
	 	if(ag_style=="rb_select"){
	 		 fd.append("nummer_auftraggeber",e("nummer_auftraggeber").value);
	 	}
	 	else if(ag_style=="rb_above"){
	 		fd.append("ag_firma",e("ag_firma").value);
	 	}
	 	else {
	 		fd.append("ag_firma_full",e("ag_firma_full").value);
	 		fd.append("ag_zusatz_full",e("ag_zusatz_full").value);
	 		fd.append("ag_strasse_full",e("ag_strasse_full").value);
	 		fd.append("ag_plz_full",e("ag_plz_full").value);
	 		fd.append("ag_ort_full",e("ag_ort_full").value);
	 	}
	 	
	ajax.open("POST", "./php/nummer/saveDataSet.php", true);
	//ajax.setRequestHeader("Content-type", "multipart/form-data");
	ajax.setRequestHeader("Connection", "close");
	ajax.send(fd); 
	wait();
}
function loadOverview(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Übersicht Aufträge';
		e("output_text").innerHTML = ajax.responseText;
		sorttable.makeSortable(e("table_auftraege"));
		}
	};
	ajax.open("POST", "./php/overview/loadData.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function loadArchive(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Archiv Aufträge';
		e("output_text").innerHTML = ajax.responseText;
		sorttable.makeSortable(e("table_archiv"));
		}
	};
	ajax.open("POST", "./php/archive/loadData.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function loadReports(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'reports';
		e("output_text").innerHTML = ajax.responseText;
		}
	};
	ajax.open("POST", "./php/reports/loadOverview.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function loadOverviewDetails(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Details';
		e("output_text").innerHTML = ajax.responseText;
		cal = new JsDatePick({
			useMode:2,
			target:"nummer_datum",
			limitToToday:false,
			cellColorScheme:"ocean_blue",
			imgPath:"../img/",
			dateFormat:"%d.%m.%Y"
				});
		}
	};
	var params = "id="+id;
	ajax.open("POST", "./php/overview/loadOverviewDetails.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	wait();
}
function loadOverviewEdit(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		popup_set(ajax.responseText);
		cal = new JsDatePick({
			useMode:2,
			target:"nummer_datum",
			limitToToday:false,
			cellColorScheme:"ocean_blue",
			imgPath:"../img/",
			dateFormat:"%d.%m.%Y"
				});
		}
	};
	var params = "id="+id;
	ajax.open("POST", "./php/overview/loadEditDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	togglePopup();
	popup_set("wait");
}
function loadOverviewDelete(id,name){
	var answer = confirm("Do you really want to delete Auftrag "+name+"?");
	if (answer){
		var ajax = getAjax();
		ajax.onreadystatechange = function()
		{
		if(ajax.readyState == 4)
			{
			if(ajax.responseText == "1"){
				loadOverview();
				m_i("Deleted.");
			}
			else{
				m_e(ajax.responseText);
			}
			}
		};
		var params="id="+id;
		ajax.open("POST", "./php/overview/deleteDataSet.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.setRequestHeader("Content-length", params.length);
		ajax.setRequestHeader("Connection", "close");
		ajax.send(params); 
		wait();
	}
}
function loadOverviewStatus(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		popup_set(ajax.responseText);
		}
	};
	var params = "id="+id;
	ajax.open("POST", "./php/overview/loadStatusDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	togglePopup();
	popup_set("wait");
}
function saveOverviewStatus(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		if(ajax.responseText == "1"){
			clear();
			togglePopup();
			loadOverview();
			m_i("Saved.");
		}
		else{
			clear();
			togglePopup();
			loadOverview();
			m_e(ajax.responseText);
		}
		}
	};
	var params=p("overview_status")+"&id="+id;
	ajax.open("POST", "./php/overview/changeStatus.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	wait();
	popup_set("wait");
}
function saveOverviewEdit(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		if(ajax.responseText == "1"){
			clear();
			togglePopup();
			loadOverview();
			m_i("Saved.");
		}
		else{
			clear();
			togglePopup();
			m_e(ajax.responseText);
		}
		}
	};
	var params=p("nummer_datum")+"&id="+id+"&"+p("nummer_strasse")+"&"+p("nummer_plz")+"&"+p("nummer_ort")+"&"+p("nummer_auftraggeber")+"&"+p("nummer_status")+"&"+p("nummer_nummer")+"&"+p("nummer_zusatz");
	ajax.open("POST", "./php/overview/saveDataSet.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	wait();
	popup_set("wait");
}
function loadAuftraggeber(){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		e("output_header").innerHTML = 'Übersicht Auftraggeber';
		e("output_text").innerHTML = ajax.responseText;
		sorttable.makeSortable(e("table_auftraggeber"));
		}
	};
	ajax.open("POST", "./php/auftraggeber/loadData.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	wait();
}
function loadAuftragGeberEdit(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		popup_set(ajax.responseText);
		}
	};
	var params = "id="+id;
	ajax.open("POST", "./php/auftraggeber/loadEditDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	togglePopup();
	popup_set("wait");
}
function newAuftragGeber(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		popup_set(ajax.responseText);
		}
	};
	ajax.open("POST", "./php/auftraggeber/loadNewDataSetForm.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", 0);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(null); 
	togglePopup();
	popup_set("wait");
}
function deleteAuftragGeber(id,name){
	var answer = confirm("Do you really want to delete "+name+"?");
	if (answer){
		var ajax = getAjax();
		ajax.onreadystatechange = function()
		{
		if(ajax.readyState == 4)
			{
			if(ajax.responseText == "1"){
				loadAuftraggeber();
				m_i("Deleted.");
			}
			else{
				m_e(ajax.responseText);
			}
			}
		};
		var params="id="+id;
		ajax.open("POST", "./php/auftraggeber/deleteDataSet.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.setRequestHeader("Content-length", params.length);
		ajax.setRequestHeader("Connection", "close");
		ajax.send(params); 
		wait();
	}
}
function saveAuftragGeberEdit(id){
	var ajax = getAjax();
	ajax.onreadystatechange = function()
	{
	if(ajax.readyState == 4)
		{
		if(ajax.responseText == "1"){
			clear();
			togglePopup();
			loadAuftraggeber();
			m_i("Saved.");
		}
		else{
			clear();
			togglePopup();
			m_e(ajax.responseText);
		}
		}
	};
	var params=p("ag_edit_firma")+"&id="+id+"&"+p("ag_edit_zusatz")+"&"+p("ag_edit_status")+"&"+p("ag_edit_strasse")+"&"+p("ag_edit_plz")+"&"+p("ag_edit_ort");
	ajax.open("POST", "./php/auftraggeber/saveDataSet.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params); 
	wait();
	popup_set("wait");
}

/* Helper
 * 
 * 
 */
function rb_change(radiobutton){ //Only called on new one...
	if(radiobutton.value=="rb_select"){
		remClass("rb_select_t", "inactive");
		addClass("rb_above_t", "inactive");
		addClass("rb_new_t", "inactive");
	}
	else if(radiobutton.value=="rb_above"){
		addClass("rb_select_t", "inactive");
		remClass("rb_above_t", "inactive");
		addClass("rb_new_t", "inactive");
	}
	else { //rb_new
		addClass("rb_select_t", "inactive");
		addClass("rb_above_t", "inactive");
		remClass("rb_new_t", "inactive");
	}
}

function wait(){
	e("output_text").innerHTML = "<img src=\"./img/waiting.gif\" alt=\"Waiting...\"/>";
}
function m_e(txt){
	e("message").innerHTML = "ERROR: "+txt;
	setClass(e("message"), "error");
	setTimeout(function() { 
		setClass(e("message"), "hidden");
	}, timePeriodInMs);
}
function m_i(txt){
	e("message").innerHTML = "Info: "+txt;
	setClass(e("message"), "info");
	setTimeout(function() { 
		setClass(e("message"), "hidden");
	}, timePeriodInMs);
}


function p(id, encrypt){
	if(encrypt){
		var md5hash = SHA1(e(id).value);
		return id+"="+md5hash;
	}
	else {
		return id+"="+e(id).value;
	}
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
function rb_val(name){
	var radios = document.getElementsByName(name);
	var val = "";
	for (var i = 0, length = radios.length; i < length; i++) {
	    if (radios[i].checked) {
	        // do whatever you want with the checked radio
	        val = radios[i].value;

	        // only one radio can be logically checked, don't check the rest
	        break;
	    }
	}
	return val;
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
function popup_set(html){
	if(html=="wait"){
		e("popup").innerHTML="<img src=\"./img/waiting.gif\" alt=\"Waiting...\"/>";
	}
	else {
		e("popup").innerHTML=html;
	}
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

function setClass(element,className){
	e(element).className = className;
}
function addClass(element,SelclassName){
	if(!hasClass(e(element), SelclassName)){
	e(element).className = e(element).className +" "+ SelclassName;
	}
}
function remClass(element,SelclassName){
	if(hasClass(e(element), SelclassName)){
	e(element).className = e(element).className.replace(SelclassName,"");
	}
}

function clear(){
	var elements = document.getElementsByTagName("input");
	for (var ii=0; ii < elements.length; ii++) {
	  if (elements[ii].type == "text") {
	    elements[ii].value = "";
	  } 
	  if (elements[ii].type == "password") {
		    elements[ii].value = "";
	  } 
	  if (elements[ii].type == "file") {
		    elements[ii].files = null;
	  } 	
	}
	var elements2 = document.getElementsByTagName("textarea");
	for (var ii=0; ii < elements2.length; ii++) {
		elements2[ii].innerHTML = "";
	}
	var elements3 = document.getElementsByTagName("select");
	for (var ii=0; ii < elements3.length; ii++) {
		elements3[ii].options.length=0;
	}
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
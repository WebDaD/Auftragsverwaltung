<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" media="all" href="css/jsDatePick_ltr.css" />
		<script src="js/jsDatePick.full.1.3.js" type="text/javascript" ></script>
		<script src="js/functions.js" type="text/javascript"></script>
		<script src="js/gui.js" type="text/javascript"></script>
		<script src="js/sorttable.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="page-cover" class="hidden"><!-- Initially Hidden, will be used by Dialogs to dim the page--></div>
		<div id="popup" class="hidden"><!-- Initially Hidden, will be used by Dialogs --></div>
		<div id="container">
		    <div id="head">
		        <img alt="Logo" class="head_logo" src="img/head_logo.png" />
		    </div>
		    <div id="content_main">
			    <div id="navigation">
			    	<ul>
			    		<li><a href="#" onclick="navigateTo('auftragsnummer');">Auftragsnummer</a></li>
			    		<li><a href="#" onclick="navigateTo('overview');">Übersicht Aufträge</a></li>
			    		<li><a href="#" onclick="navigateTo('auftraggeber');">Übersicht Auftraggeber</a></li>
			    	</ul>
			    </div>
			    <div id="content">
			    	<h2 id="output_header"></h2>
			    	<div id="output_text"></div>
			    </div>
		    </div>
		    <div id="footer">
		    	&copy; 2013 by <a href="http://www.webdad.eu">WebDaD.eu</a>
		    </div>
	    </div>
	    <script type="text/javascript">
			init_page();
	    </script>
	</body>
</html>

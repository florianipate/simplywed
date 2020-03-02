<!-- <!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Simplywed V1</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/core/bootstrap.min.css"  />
        <link type="text/css" rel="stylesheet" href="demo.css">
		<link rel="stylesheet" type="text/css" href="../css/core/jquery-te-1.4.0.css">
		<link rel="stylesheet" type="text/css" href="../css/cms-style.css">
		<script type="text/javascript" src="../js/core/jquery.min.js" charset="utf-8"></script>
    	<script type="text/javascript" src="../js/core/jquery-te-1.4.0.min.js" charset="utf-8"></script>
	</head>
<body>
    <textarea name="the_editor" id="the_editor" class="jqte-test">

    </textarea>
    <script>

        $('.jqte-test').jqte();
    </script>
</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>jQuery TE | Downloaded Demo | v.1.4.0</title>

<link type="text/css" rel="stylesheet" href="demo.css">
<link type="text/css" rel="stylesheet" href="../css/core/jquery-te-1.4.0.css">

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="../js/core/jquery-te-1.4.0.min.js" charset="utf-8"></script>
</head>

<body>
<h1>jQuery TE</h1>

<!-- <div class="navigation">
<a href="http://jqueryte.com" target="_blank">Home</a>
<a href="http://jqueryte.com/demos" target="_blank">Demos</a>
<a href="http://jqueryte.com/documentation" target="_blank">Documentation</a>
<a href="http://jqueryte.com/comments" target="_blank">Comments</a>
<a href="http://jqueryte.com/about" target="_blank">About</a>
<a href="http://jqueryte.com/license" target="_blank">License</a>
</div> -->

<h2>Demo | v.1.4.0</h2>

<!------------------------------------------------------------ Toggle jQTE Button ------------------------------------------------------------>
<button class="status">Toggle jQTE</button>

<!------------------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------------------>

<textarea name="textarea" class="jqte-test"><b>My contents are from <u><span style="color:rgb(0, 148, 133);">TEXTAREA</span></u></b></textarea>

<input name="input" type="text" value="<b>My contents are from <u><span style=&quot;color:rgb(0, 148, 133);&quot;>INPUT</span></u></b>" class="jqte-test">

<span name="span" class="jqte-test"><b>My contents are from <u><span style="color:rgb(0, 148, 133);">SPAN</span></u></b></span>

<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

<!------------------------------------------------------------ jQUERY TEXT EDITOR ------------------------------------------------------------>


<hr>

<div class="footer">
<b>Please <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=U49X5YEFRPMSL" target="_blank">donate</a> us or <a href="http://jqueryte.com" target="_blank">click on advertisements</a> to improve more than.</b>
</div>

<p>Thanks for using!</p>

</body>
</html>
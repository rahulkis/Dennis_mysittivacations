<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	#myList li{ display:none;
	}
	#loadMore {
	    color:green;
	    cursor:pointer;
	}
	#loadMore:hover {
	    color:black;
	}
	#showLess {
	    color:red;
	    cursor:pointer;
	}
	#showLess:hover {
	    color:black;
	}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
</head>
<body>
<ul id="myList">
<?php
	for($i=1;$i<=20;$i++){
	echo "<li>Test:" . $i . "</li>";
}
?>
</ul>

<div id="loadMore">Load more</div>

</body>
<script type="text/javascript">
$(document).ready(function () {

	

    size_li = $("#myList li").size();
    x=3;
    $('#myList li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('#myList li:lt('+x+')').show();
    });
});
</script>
</html>

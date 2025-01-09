<!DOCTYPE html>
<html>
   <head> 
		<meta charset = "utf-8">
		<title>jQuery Ajax and PHP</title>
		<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>	
		<script>
			$(function(){ 
   				var id = window.prompt( "Please enter your ID" );
				$.ajax({
				url: "8 test.php",
				data: {
					name: id
				},
				type: "POST",     //type:傳送的方式 (GET/POST)
				datatype: "html", //資料回傳的格式(html/script/json/xml)
					success: function( output ) {
				$( "#out" ).html(output);
					},
				error : function(){
					alert( "Request failed." );
				}
				});
			});

      	</script>	
   </head>
   <body>
      <div id="out"></div>
   </body>
</html> 

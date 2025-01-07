<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Pulling Images onto the Page </title>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>	
    <style type = "text/css">
    li { display: inline-block; padding: 4px; width: 120px; }
    img { border: 1px solid black }
    </style>
    <script>
    function getImages( url )
    {
            $.ajax({
        url: url,
        type: "GET",
        datatype: "xml",
            success: function( xml ) {
            clearImages();
            var output = document.getElementById( "covers" );
            var imagesUL = document.createElement( "ul" );
            var baseUrl = $(xml).find("baseurl").text();
            $(xml).find("cover").each(function(){
                var image = $(this).children('image').text();
                var imageLI = document.createElement( "li" );
                var imageTag = document.createElement( "img" );
                imageTag.setAttribute( "src", baseUrl + escape( image ) ); 
                imageLI.appendChild( imageTag );
                imagesUL.appendChild( imageLI ); 
            });
            output.appendChild( imagesUL ); 
            },
        error : function(){
            alert( "Request failed." );
        }
        });
    }
    function clearImages()
    {
        document.getElementById( "covers" ).innerHTML = ""; 
    }
    function registerListeners()
    {
        document.getElementById( "all" ).addEventListener("click", 
            function() { getImages( "all.xml" ); }, false ); 
        document.getElementById( "simply" ).addEventListener("click", 
            function() { getImages( "simply.xml" ); }, false ); 
        document.getElementById( "howto" ).addEventListener("click", 
            function() { getImages( "howto.xml" ); }, false ); 
        document.getElementById( "dotnet" ).addEventListener("click", 
            function() { getImages( "dotnet.xml" ); }, false ); 
        document.getElementById( "javaccpp" ).addEventListener("click", 
            function() { getImages( "javaccpp.xml" ); }, false ); 
        document.getElementById( "none" ).addEventListener("click", clearImages, false ); 
    }
    window.addEventListener( "load", registerListeners, false );
    </script>
</head>
<body>
   <input type = "radio" name ="Books" value = "all" id = "all"> All Books
   <input type = "radio" name = "Books" value = "simply" id = "simply"> Simply Books
   <input type = "radio" name = "Books" value = "howto" id = "howto"> How to Program Books
   <input type = "radio" name = "Books" value = "dotnet" id = "dotnet"> .NET Books
   <input type = "radio" name = "Books" value = "javaccpp" id = "javaccpp"> Java/C/C++ Books
   <input type = "radio" checked name = "Books" value = "none" id = "none"> None
   <div id = "covers"></div>
</body>
</html>
 

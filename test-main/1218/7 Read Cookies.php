<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>Read Cookies</title>  
      <style type = "text/css">
         p { margin: 0px; }
      </style>
   </head>
   <body>
      <p>The following data is saved in a cookie on your computer.</p>
      <?php
         foreach ($_COOKIE as $key => $value )
            print( "<p>$key: $value</p>" );
      ?>
    </body>
</html>
 

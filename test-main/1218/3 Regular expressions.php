<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>Regular expressions</title>
      <style type = "text/css">
         p { margin: 0; }
      </style>
   </head>
   <body>
      <?php
         $search = "Now is the time";
         print( "<p>Test string is: '$search'</p>" );
         if ( preg_match( "/Now/", $search ) )
            print( "<p>'Now' was found.</p>" );
         if ( preg_match( "/^Now/", $search ) )
            print( "<p>'Now' found at beginning of the line.</p>" );
         if ( !preg_match( "/Now$/", $search ) )
            print( "<p>'Now' was not found at the end of the line.</p>" );
         if ( preg_match( "/\b([a-zA-Z]*ow)\b/i", $search, $match ) )
            print( "<p>Word found ending in 'ow': " . $match[ 1 ] . "</p>" );
         print( "<p>Words beginning with 't' found: " );
         while ( preg_match( "/\b(t[[:alpha:]]+)\b/i", $search, $match ) )
         {
            print( $match[ 1 ] . " " );
            $search = preg_replace( "/" . $match[ 1 ] . "/", "", $search );
         }
         print( "</p>" );
     ?>
   </body>
</html>

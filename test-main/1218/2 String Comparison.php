<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>String Comparison</title>
      <style type = "text/css">
         p { margin: 0; }
      </style>
   </head>
   <body>
      <?php
         $fruits = array( "apple", "orange", "banana" );
         for ( $i = 0; $i < count( $fruits ); ++$i )
         {
            if ( strcmp( $fruits[ $i ], "banana" ) < 0 )
               print( "<p>" . $fruits[ $i ] . " is less than banana " );
            else if ( strcmp( $fruits[ $i ], "banana" ) > 0 )
               print( "<p>" . $fruits[ $i ] . " is greater than banana " );
            else
               print( "<p>" . $fruits[ $i ] . " is equal to banana " );
            if ( $fruits[ $i ] < "apple" )
               print( "and less than apple!</p>" );
            else if ( $fruits[ $i ] > "apple" )
               print( "and greater than apple!</p>" );
            else if ( $fruits[ $i ] == "apple" )
               print( "and equal to apple!</p>" );
         }
      ?>
   </body>
</html>
 

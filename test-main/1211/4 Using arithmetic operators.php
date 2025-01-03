<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
     <style type = "text/css">
        p { margin: 0; }
     </style>
      <title>Using arithmetic operators</title>
   </head>
   <body>
      <?php
         $a = 5;
         print( "<p>The value of variable a is $a</p>" );
         define( "VALUE", 5 );
         $a = $a + VALUE;
         print( "<p>Variable a after adding constant VALUE is $a</p>" );
         $a *= 2;
         print( "<p>Multiplying variable a by 2 yields $a</p>" );
         if ( $a < 50 )
            print( "<p>Variable a is less than 50</p>" );
         $a += 40;
         print( "<p>Variable a after adding 40 is $a</p>" );
         if ( $a < 51 )
            print( "<p>Variable a is still 50 or less</p>" );
         else if ( $a < 101 )
            print( "<p>Variable a is now between 50 and 100, inclusive</p>" );
         else
            print( "<p>Variable a is now greater than 100</p>" );
         print( "<p>Using a variable before initializing: $nothing</p>" );
         $test = $num + VALUE;
         print( "<p>An uninitialized variable plus constant VALUE yields $test</p>" );
         $str = "3 dollars";
         $a += $str;
         print( "<p>Adding a string to variable a yields $a</p>" );
      ?>
   </body>
</html>

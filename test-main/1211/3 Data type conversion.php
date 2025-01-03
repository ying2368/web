<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>Data type conversion</title>
      <style type = "text/css">
         p      { margin: 0; }
         .head  { margin-top: 10px; font-weight: bold; }
         .space { margin-top: 10px; }
      </style>
   </head>
   <body>
      <?php
         $testString = "3.5 seconds";
         $testDouble = 79.2;
         $testInteger = 12;
      ?>
      <p class = "head">Original values:</p>
      <?php
         print( "<p>$testString is a(n) " . gettype( $testString ). "</p>" );
         print( "<p>$testDouble is a(n) " . gettype( $testDouble ). "</p>" );
         print( "<p>$testInteger is a(n) " . gettype( $testInteger ). "</p>" );
      ?>
      <p class = "head">Converting to other data types:</p>
      <?php
         print( "<p>$testString " );
         settype( $testString, "double" );
         print( " as a double is $testString</p>" );
         print( "<p>$testString " );
         settype( $testString, "integer" );
         print( " as an integer is $testString</p>" );
         settype( $testString, "string" );
         print( "<p class = ‘space’>Converting back to a string results in $testString</p>" );
         $data = "98.6 degrees";
         print( "<p class = 'space'>Before casting: $data is a " .  gettype( $data ) . "</p>" );
         print( "<p class = 'space'>Using type casting instead:</p>
          <p>as a double: " . (double) $data . "</p>" ."<p>as an integer: " . (integer) $data . "</p>" );
         print( "<p class = ‘space’>After casting: $data is a " . gettype( $data ) . "</p>" );
      ?>
   </body>
</html>

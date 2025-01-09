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
         $email = "tinin@saturn.yzu.edu.tw";
         if (preg_match("/^([A-Za-z0-9]+)@(.+)$/", $email, $match)) {
               echo "match[1] = " . $match[1] . "<br>";
               echo "match[2] = " . $match[2] . "<br>";
         }
         
         $ip ="140.138.145.75";
         if (preg_match("/^(\d+\.\d+)\.(\d+)\.(\d+)$/", $ip, $match)) {
            echo "match[1] = " . $match[1] . "<br>";
            echo "match[2] = " . $match[2] . "<br>";
            echo "match[3] = " . $match[3] . "<br>";
     }

     ?>
   </body>
</html>

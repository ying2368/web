<!DOCTYPE html>
<html>
   <head><meta charset = "utf-8"><title>Search Results</title>
      <style type = "text/css">
         body  { font-family: sans-serif;
                 background-color: lightyellow; }
         table { background-color: lightblue;
                 border-collapse: collapse;
                 border: 1px solid gray; }
         td    { padding: 5px; }
         tr:nth-child(odd) { background-color: white; }
      </style>
   </head>
   <body>
      <?php
         $select = $_POST["select"];
         $txt = $_POST["txt"];
         // $query = "SELECT " . $select . " FROM books";
         $query = "SELECT * FROM `books` WHERE `". $select ."` LIKE '". $txt ."'";

         // 使用 mysqli 连接数据库
         $database = mysqli_connect("localhost", "select", "123456", "products");

         if (!$database) {
            die("Could not connect to database </body></html>");
         }

         // 执行查询
         $result = mysqli_query($database, $query);

         if (!$result) {
            print("<p>Could not execute query!</p>");
            die(mysqli_error($database) . "</body></html>");
         }

         // 关闭数据库连接
         mysqli_close($database);
      ?>
      <table>
         <caption>Results of "SELECT <?php print( "$select" ) ?> FROM books"</caption>
         <?php
            // 获取查询结果并显示
            while ($row = mysqli_fetch_row($result)) {
               print("<tr>");
               foreach ($row as $value) {
                  print("<td>$value</td>");
               }
               print("</tr>");
            }
         ?>
      </table>
      <p>Your search yielded <?php print(mysqli_num_rows($result)) ?> results.</p>
      <p>Please email comments to <a href = "mailto:deitel@deitel.com">Deitel and Associates, Inc.</a></p>
   </body>
</html>
<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>Sample Database Query</title>
   </head>
   <body>
      <h1>Querying a MySQL database.</h1>
      <form method = "post" action = "6 database.php">
         <p>Select a field to display:
            <select name = "select">
               <option selected>*</option>
               <option>ID</option>
               <option>Title</option>
               <option>Category</option>
               <option>ISBN</option>
            </select>
            <input type="text" name="txt">
         </p>
         <p><input type = "submit" value = "Send Query"></p>
      </form>
   </body>
</html>

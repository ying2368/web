<!DOCTYPE html>
<html>
   <head>
      <meta charset = "utf-8">
      <title>個人新創公司募資網站</title>
      <link rel = "stylesheet" type = "text/css" href = "styles.css">
      <style>
         h1 { background-color: rgb(210, 173, 230); color: rgb(71, 132, 223)}
         p { color: rgb(31, 88, 173);
             font-size: 18px; }
      </style>    
   </head>
   <body>
   <?php
      $servername = "localhost";   // 数据库服务器地址
      $username = "CS380B";          // 数据库用户名
      $password = "YZUCS380B";              // 数据库密码
      $dbname = "CS380B";     // 要连接的数据库名称

      $conn = new mysqli($servername, $username, $password, $dbname);
      // 检查连接是否成功
      if ($conn->connect_error) {
         die("连接失败: " . $conn->connect_error);
      }

      // 執行 SQL 查詢
      $sql = "SELECT name, donation_amount FROM s1111442"; 
      $result = $conn->query($sql);
      if (!$result) {
         die("SQL error: " . $conn->error);
      }

      $totalDonors = 0;
      $totalAmount = 0;
      if ($result->num_rows > 0) {
         echo "<table>
                  <tr><th>姓名</th>
                     <th>捐款金額</th>
                  </tr>";
         // 輸出每一行資料
         while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"] . "</td>
                      <td>" . $row["donation_amount"] . "</td>
                  </tr>";
            $totalDonors++;
            $totalAmount += $row["donation_amount"];
         }
         echo "<div style='margin-right: 20px; margin-top: 40px; float:right'>
               <p>捐款者人數: " . $totalDonors . "</p>
               <p>募資總金額: " . $totalAmount . "</p>
               </div>";
      } else {
         echo "0 results";
      }

      $conn->close();
   ?>
      <h1>個人資料:</h1>
		<form method = "post" action = "s1111442_HW2.php">
			<p><label>姓名:
                <input name = "name" type = "text" required/>
            </label></p>
         <p><label>電話:
				<input name = "phone_number" type = "tel" placeholder = "09##-###-###" 
					  pattern = "09\d{2}-\d{3}-\d{3}"  autocomplete = "on" required/>
					  <label style="font-size: 12px;">09##-###-###</label>
            </label></p>
         <p>
            <label>YZU Email:
               <input name = "Email" type = "email" placeholder = "sxxxxxxx@mail.yzu.edu.tw" 
                  pattern = "(s\d{7}@mail|[A-Za-z0-9]{1,}@saturn).yzu.edu.tw"  autocomplete = "on" required/>
                  <label style="font-size: 12px;">sxxxxxxx@mail.yzu.edu.tw xxxxx@saturn.yzu.edu.tw</label>
            </label>
         </p>
         <p><label>地址:
               <input name = "address" type = "text" size = "25" maxlength = "30" required/>
           </label></p>
		
			<p>
				<label>捐款金額:<br></label>
				<label><input name = "rating" type = "radio" value = "30" checked>30</label>
				<label><input name = "rating" type = "radio" value = "100">100</label>
				<label><input name = "rating" type = "radio" value = "300">300</label>
				<label><input name = "rating" type = "radio" value = "750">750</label>
				<label><input name = "rating" type = "radio" value = "1500">1500</label>
			</p>
         <p><label>意見:<br>
				<textarea name = "comments" rows = "4" cols = "36">Enter comments here.</textarea>
			</label></p>

         <p>
            <input type = "submit" value = "Submit">
            <input type = "reset" value = "Clear">
         </p>
		</form>
   </body>
</html>

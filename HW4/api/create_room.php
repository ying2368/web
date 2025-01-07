<!DOCTYPE html>
<html>
   <head>
        <meta charset = "utf-8">
        <title>大富翁遊戲</title> 
        <link rel = "stylesheet" type = "text/css" href = "s1111442_HW3.css">
        <script src = "s1111442_HW3.js"></script>
    </head>
    <body>
        <div>
            <input type="text" id="room-name" placeholder="輸入遊戲室名稱">
            <button id="join-room">加入遊戲室</button>
        </div>
        <script>
            document.getElementById("join-room").addEventListener("click", function () {
            const roomName = document.getElementById("room-name").value;
            fetch("create_room.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ room_name: roomName }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        window.location.href = `game.html?room_id=${data.room_id}`;
                    } else {
                        alert("加入遊戲室失敗：" + data.message);
                    }
                });
        });
        </script>
    </body>
</html>
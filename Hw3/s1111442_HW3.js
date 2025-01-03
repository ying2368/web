//initial
const players = [
    { name: "玩家1" ,money: 10000, position: 0, img: "red-dot.png" },
    { name: "玩家2", money: 10000, position: 0, img: "blue-dot.png" },
    { name: "玩家3", money: 10000, position: 0, img: "green-dot.png" },
    { name: "玩家4", money: 10000, position: 0, img: "yellow-dot.png" },
];
const board = [{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },
                { owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },
                { owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },
                { owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },
                { owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 },{ owner: 5, houses: 0 }
];
color = ["background:rgb(240, 152, 152)","background:rgb(155, 173, 254)",
        "background:rgb(157, 254, 155)","background:rgb(254, 252, 155)"]
var currentPlayerIndex = 0;
var dieImages;

function start()
{
    var button = document.getElementById("Button");
    var rollButton = document.getElementById( "rollButton" );
    rollButton.addEventListener( "click", rollDice, false );
    dieImages = document.getElementById("die");
    updateBoard();
    updateInfo();
    window.alert( "start" ); 
    button.addEventListener("click", set, false);
}
    
function rollDice()
{
    const rollDuration = 1200; // 骰子滾動動畫持續時間（毫秒）
    const interval = 150; // 每次切換骰子圖片的時間間隔
    let elapsed = 0; // 記錄已經過的時間

    // 模擬骰子滾動的函數
    function rollAnimation() {
        const randomFace = Math.floor(1 + Math.random() * 6); // 隨機生成點數
        dieImages.setAttribute("src", `die${randomFace}.png`); // 更新骰子圖片
        elapsed += interval; // 更新已經過的時間

        if (elapsed < rollDuration) {
            setTimeout(rollAnimation, interval); // 繼續滾動
        } else {
            // 動畫結束
            handlePlayerMove(randomFace); // 開始處理玩家移動邏輯
        }
    }

    rollAnimation(); // 開始骰子滾動動畫
}

function updateInfo() {
    document.getElementById("current-player").textContent = players[currentPlayerIndex].name;

    for ( let i = 0; i < 4; ++i )
    {
        document.getElementById( "player" + (i+1) + "-money" ).textContent = players[i].money;
    }
}

function updateBoard() {
    // 清空所有格子的內容
    for (let i = 0; i < 20; i++) {
        const cell = document.getElementById("p" + i);
        const houseInfo = board[i].houses > 0 ? `<p>house: ${board[i].houses}</p>` : "";
        cell.innerHTML = houseInfo; // 顯示房屋數或清空格子
    }

    // 添加每個玩家的圖片到當前位置
    for (let i = 0; i < players.length; i++) {
        const player = players[i];
        const imgTag = `<img src="${player.img}" alt="${player.name}">`;
        document.getElementById("p" + player.position).innerHTML += imgTag; // 將圖片插入到格子中
    }
}

function changeColor(position) {
    document.getElementById( "p" + position ).setAttribute("style", color[currentPlayerIndex]);
}

function handlePlayerMove(face) {
    const player = players[currentPlayerIndex];
    const startPosition = player.position; // 記錄移動開始位置
    let stepsRemaining = face; // 剩餘移動步數
    
    // 動態逐格移動函數
    function moveStep() {
        // 清空玩家當前位置
        const currentCell = document.getElementById("p" + player.position);
        currentCell.innerHTML = board[player.position].houses > 0 ? `<p>house: ${board[player.position].houses}</p>` : "";
        for (let i = 0; i < players.length; i++) {
            if (players[i].position == player.position && i!=currentPlayerIndex)
            {
                const imgTag = `<img src="${players[i].img}" alt="${players[i].name}">`;
                document.getElementById("p" + player.position).innerHTML += imgTag; // 將圖片插入到格子中
            }
        }

        // 更新玩家位置
        player.position = (player.position + 1) % 20;

        // 在新位置顯示玩家圖標
        const nextCell = document.getElementById("p" + player.position);
        nextCell.innerHTML += `<img src="${player.img}" alt="${player.name}">`;

        stepsRemaining--;
        // 如果還有步數，繼續移動；否則處理格子邏輯
        if (stepsRemaining > 0) {
            setTimeout(moveStep, 300); // 每次移動間隔 200 毫秒
        } else {
            // 移動結束後檢查是否經過起點
            if (player.position < startPosition) {
                player.money += 2000; // 經過起點加錢
                window.alert(`${player.name}: +2000`);
            }
            handleCellAction(); // 移動結束後處理當前格子的邏輯
        }
    }

    moveStep(); 
}

// 處理格子邏輯（購買地產、繳租金等）
function handleCellAction() {
    const player = players[currentPlayerIndex];
    const cell = board[player.position];

    setTimeout(() => {
        // 處理格子邏輯
        if (cell.owner == 5) {
            if (confirm("是否購買該地? (1000元) ")) {
                if (player.money >= 1000) {
                    player.money -= 1000;
                    cell.owner = currentPlayerIndex;
                    cell.houses = 0;
                    changeColor(player.position); // 更新格子顏色
                } else {
                    window.alert("資金不足！");
                }
            }
        } else if (cell.owner === currentPlayerIndex) {
            if (cell.houses < 5) {
                if (player.money >= 500 && confirm("是否加蓋房屋？(500元/層)")) {
                    player.money -= 500;
                    cell.houses += 1;
                } else {
                    window.alert("資金不足！");
                }
            }
        } else {
            const rent = (1 + cell.houses) * 500;
            player.money -= rent;
            players[cell.owner].money += rent;
            window.alert(`${player.name}: -${rent}, ${players[cell.owner].name}: +${rent}`);
            if (player.money < 0) {
                window.alert(`${player.name} 已破產！`);
                players.splice(currentPlayerIndex, 1); // 移除破產玩家
                currentPlayerIndex = (currentPlayerIndex + 1) % players.length; // 切換到下一位玩家
                return;
            }
        }

        // 切換下一位玩家並更新畫面
        currentPlayerIndex = (currentPlayerIndex + 1) % players.length;
        updateBoard();
        updateInfo();
    }, 200); // 畫面更新延遲
}

window.addEventListener("load", start, false);

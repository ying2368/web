<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>樂器購買 - 和樂音樂教室</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/main.css">
    <style>
        .instruments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        .instrument-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        .instrument-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
        }
        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .filter-section {
            margin: 20px 0;
            display: flex;
            gap: 20px;
        }
        .cart-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .modal-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }    
    </style>
</head>

<body>
    <!-- 導覽列 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">和樂音樂教室</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">首頁</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teachers.php">師資介紹</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_instruments.php">樂器購買</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="booking.php">預約課程</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">登入</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">樂器購買</h2>

        <div class="filter-section">
            <select id="categoryFilter">
                <option value="">所有類別</option>
                <option value="piano">鋼琴</option>
                <option value="guitar">吉他</option>
                <option value="violin">小提琴</option>
                <option value="drum">鼓</option>
            </select>
            <input type="text" id="searchInput" placeholder="搜尋樂器...">
        </div>

        <div class="instruments-grid">
            <?php
            require_once '../module/config.php';
            $sql = "SELECT * FROM instruments WHERE stock > 0";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo '<div class="instrument-card" data-category="'.$row['category'].'">';
                echo '<img src="'.$row['image_url'].'" alt="'.$row['name'].'" class="instrument-img">';
                echo '<h3>'.$row['name'].'</h3>';
                echo '<p>NT$ '.number_format($row['price']).'</p>';
                echo '<p>庫存: '.$row['stock'].'</p>';
                echo '<button onclick="addToCart('.$row['id'].')" class="add-to-cart">加入購物車</button>';
                echo '</div>';
            }
            ?>
        </div>
        
    </div>
    <div class="cart-icon" onclick="showCart()">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">0</span>
    </div>

    <div class="modal-backdrop"></div>
    <div class="cart-modal">
        <h2>購物車</h2>
        <div id="cartItems"></div>
        <div id="cartTotal"></div>
        <button onclick="checkout()">結帳</button>
        <button onclick="hideCart()">關閉</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    let cart = {};

    function addToCart(instrumentId) {
        $.ajax({
            url: '../module/add_to_cart.php',
            type: 'POST',
            data: { id: instrumentId },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    if (cart[instrumentId]) {
                        cart[instrumentId]++;
                    } else {
                        cart[instrumentId] = 1;
                    }
                    updateCartCount();
                    alert('已加入購物車！');
                } else {
                    alert('加入購物車失敗：' + data.message);
                }
            }
        });
    }

    function updateCartCount() {
        const count = Object.values(cart).reduce((a, b) => a + b, 0);
        $('.cart-count').text(count);
    }

    function showCart() {
        $.ajax({
            url: '../module/get_cart.php',
            type: 'GET',
            success: function(response) {
                const data = JSON.parse(response);
                let html = '<table>';
                let total = 0;
                data.items.forEach(item => {
                    html += `<tr>
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>NT$ ${item.price}</td>
                        <td>
                            <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                            <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                            <button onclick="removeFromCart(${item.id})">刪除</button>
                        </td>
                    </tr>`;
                    total += item.price * item.quantity;
                });
                html += '</table>';
                $('#cartItems').html(html);
                $('#cartTotal').text(`總計: NT$ ${total}`);
                $('.modal-backdrop, .cart-modal').show();
            }
        });
    }

    function hideCart() {
        $('.modal-backdrop, .cart-modal').hide();
    }

    function checkout() {
        $.ajax({
            url: '../module/checkout.php',
            type: 'POST',
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('訂購成功！');
                    cart = {};
                    updateCartCount();
                    hideCart();
                } else {
                    alert('訂購失敗：' + data.message);
                }
            }
        });
    }

    // 篩選功能
    $('#categoryFilter').change(function() {
        const category = $(this).val();
        $('.instrument-card').each(function() {
            if (!category || $(this).data('category') === category) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // 搜尋功能
    $('#searchInput').on('input', function() {
        const searchText = $(this).val().toLowerCase();
        $('.instrument-card').each(function() {
            const name = $(this).find('h3').text().toLowerCase();
            if (name.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
    session_start();
    $user_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>預約課程 - 和樂音樂教室</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/main.css">

    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet' />
    <style>
        .booking-form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .calendar-container {
            margin: 20px;
            padding: 20px;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- 導覽列 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">和樂音樂教室</a>
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
                        <a class="nav-link" href="instruments.php">樂器購買</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="booking.php">預約課程</a>
                    </li>
                    <li class="nav-item">
                        <?php if ($user_logged_in): ?>
                                <a class="nav-link" href="../logout.php">登出</a>
                        <?php else: ?>
                                <a class="nav-link" href="../login.php">登入</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="text-center mb-4">預約課程</h2>
        <!-- 新增日曆容器 -->
        <div class="calendar-container">
                <div id="calendar"></div>
        </div>

        <div class="booking-form">
            <h4>可預約課程列表</h4>
            <div id="availableCourses">
                <!-- 可預約課程將由 JavaScript 動態載入 -->
            </div>
        </div>

        <!-- 修改 Modal 用於顯示課程詳情 -->
        <div class="modal fade" id="courseModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">課程詳情</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 課程詳情將由 JavaScript 填充 -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                        <button type="button" class="btn btn-primary" id="bookCourse">預約課程</button>
                    </div>
                </div>
            </div>
        </div>

        <form id="bookingForm">
            <div class="form-group">
                <label>選擇教室：</label>
                <select name="classroom" id="classroom" required>
                    <option value="">請選擇教室</option>
                    <?php
                    // require_once '../config.php';
                    // $result = $conn->query("SELECT DISTINCT classroom FROM courses");
                    // while ($row = $result->fetch_assoc()) {
                    //     echo "<option value='" . $row['classroom'] . "'>" . $row['classroom'] . "</option>";
                    // }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>選擇教師：</label>
                <select name="teacher" id="teacher" required>
                    <option value="">請選擇教師</option>
                    <?php
                    // $result = $conn->query("SELECT id, username FROM users WHERE role='admin'");
                    // while ($row = $result->fetch_assoc()) {
                    //     echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
                    // }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>選擇日期：</label>
                <input type="date" name="date" id="date" required>
            </div>
            <div class="form-group">
                <label>選擇時段：</label>
                <select name="time_slot" id="time_slot" required>
                    <option value="">請選擇時段</option>
                    <option value="09:00">09:00-10:00</option>
                    <option value="10:00">10:00-11:00</option>
                    <option value="11:00">11:00-12:00</option>
                    <option value="13:00">13:00-14:00</option>
                    <option value="14:00">14:00-15:00</option>
                    <option value="15:00">15:00-16:00</option>
                </select>
            </div>
            <button type="submit">預約課程</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>

    <script>
         $(document).ready(function() {
            // 初始化日曆
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'agendaWeek',
                slotDuration: '01:00:00',
                events: 'booking_api.php?action=get',
                eventClick: function(event) {
                    showCourseDetail(event);
                },
                eventRender: function(event, element) {
                    element.find('.fc-title').append('<br/>' +
                        '教室: ' + event.classroom + '<br/>' +
                        '老師: ' + event.teacher + '<br/>' +
                        '剩餘名額: ' + event.remaining + '/' + event.capacity);
                }
            });

            // 載入可預約課程
            function loadAvailableCourses() {
                $.get('booking_api.php?action=get_available_courses', function(data) {
                    let html = '';
                    data.forEach(function(course) {
                        html += `
                            <div class="course-info">
                                <h5>${course.name}</h5>
                                <p>
                                    教師: ${course.teacher}<br>
                                    教室: ${course.classroom}<br>
                                    時間: ${formatDateTime(course.start_time)} - ${formatDateTime(course.end_time)}<br>
                                    剩餘名額: ${course.remaining}/${course.capacity}
                                </p>
                                <button class="btn btn-primary book-btn" data-course-id="${course.id}">
                                    預約課程
                                </button>
                            </div>
                        `;
                    });
                    $('#availableCourses').html(html);
                });
            }

            // 格式化日期時間
            function formatDateTime(datetime) {
                return moment(datetime).format('YYYY-MM-DD HH:mm');
            }

            // 顯示課程詳情
            function showCourseDetail(event) {
                let modal = $('#courseModal');
                modal.find('.modal-title').text(event.title);
                modal.find('.modal-body').html(`
                    <p>教室: ${event.classroom}</p>
                    <p>教師: ${event.teacher}</p>
                    <p>開始時間: ${formatDateTime(event.start)}</p>
                    <p>結束時間: ${formatDateTime(event.end)}</p>
                    <p>剩餘名額: ${event.remaining}/${event.capacity}</p>
                `);
                modal.find('#bookCourse').data('course-id', event.id);
                modal.modal('show');
            }

            // 預約課程
            function bookCourse(courseId) {
                $.ajax({
                    url: 'booking_api.php?action=book',
                    type: 'POST',
                    data: { course_id: courseId },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('預約成功！');
                            $('#courseModal').modal('hide');
                            $('#calendar').fullCalendar('refetchEvents');
                            loadAvailableCourses();
                        } else {
                            toastr.error('預約失敗：' + response.message);
                        }
                    }
                });
            }

            // 檢查時段衝突
            function checkConflict() {
                var formData = $('#bookingForm').serialize();
                $.ajax({
                    url: '../module/check_conflict.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.conflict) {
                            toastr.error('該時段已被預約！');
                        }
                    }
                });
            }

            // 綁定預約按鈕事件
            $(document).on('click', '.book-btn', function() {
                let courseId = $(this).data('course-id');
                bookCourse(courseId);
            });

            // 表單提交處理
            $('#bookCourse').click(function() {
                let courseId = $(this).data('course-id');
                bookCourse(courseId);
            });

            // 初始載入可預約課程
            loadAvailableCourses();
            // 時段選擇變更時檢查衝突
            $('#time_slot, #date').change(checkConflict);
        });

    </script>
</body>

</html>
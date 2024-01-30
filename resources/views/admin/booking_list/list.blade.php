<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src="{{ asset('admin/lib/tempusdominus/js/moment.min.js') }}"></script>
<script src="{{ asset('admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.10/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #calendar {
        background: #fffafa;
        padding: 30px 40px;
        margin: 30px 30px;
        border-radius: 6px;
    }

    /* Màu cho ngày trong lịch */
    .fc-day a {
        color: #000 !important;
        /* Màu chữ cho ngày */
    }

    /* Màu cho tháng trong lịch */
    .fc-toolbar-title {
        color: #000;
        /* Màu chữ cho tháng */
    }

    .fc-event {
        background-color: #ffffff;
        /* Màu nền cho sự kiện */
        color: #000 !important;
    }

    .fc-event a {
        color: #000 !important;
    }

    /* Thêm đoạn mã này vào phần CSS của bạn */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .fc-createEventButton-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    .fc-createEventButton-button:hover {
        background-color: #45a049;
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #ddd;
        width: 60%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #333;
        text-decoration: none;
    }

    /* Thêm animation cho modal */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content {
        animation: fadeIn 0.3s ease-in-out;
    }

    .delete-event-button {
        background-color: #dc3545;
        /* Màu đỏ của Bootstrap cho nút xóa */
        color: #fff;
        /* Màu chữ trắng */
        border: none;
        /* Không viền */
        padding: 8px 16px;
        /* Kích thước nút */
        cursor: pointer;
        /* Hiển thị con trỏ khi di chuột qua nút */
        border-radius: 4px;
        /* Góc bo tròn */
        margin-left: 20px;
    }

    .delete-event-button:hover {
        background-color: #c82333;
        /* Màu đỏ đậm khi di chuột qua nút */
    }

    .modal-content {
        animation: fadeIn 0.3s ease-in-out;
    }

    .edit-event-button {
        background-color: #17e317;
        /* Màu đỏ của Bootstrap cho nút xóa */
        color: #fff;
        /* Màu chữ trắng */
        border: none;
        /* Không viền */
        padding: 8px 16px;
        /* Kích thước nút */
        cursor: pointer;
        /* Hiển thị con trỏ khi di chuột qua nút */
        border-radius: 4px;
        /* Góc bo tròn */
    }

    .edit-event-button:hover {
        background-color: #059105;
        /* Màu đỏ đậm khi di chuột qua nút */
    }

    #editEventModal form label,
    #editEventModal form input,
    #editEventModal form textarea {
        display: block;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    #editEventModal form textarea {
        height: 100px;
        /* Điều chỉnh chiều cao của textarea nếu cần thiết */
    }

    #editEventModal form button {
        width: auto;
        /* Đảm bảo nút có chiều rộng tùy theo nội dung */
    }

    .update {
        background-color: #17e317;
        /* Màu đỏ của Bootstrap cho nút xóa */
        color: #fff;
        /* Màu chữ trắng */
        border: none;
        /* Không viền */
        padding: 8px 16px;
        /* Kích thước nút */
        cursor: pointer;
        /* Hiển thị con trỏ khi di chuột qua nút */
        border-radius: 4px;
        /* Góc bo tròn */
    }

    .update:hover {
        background-color: #059105;
        /* Màu đỏ đậm khi di chuột qua nút */
    }

    #createEventModal {
        display: none;
        /* Ẩn modal khi không sử dụng */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Màu nền với độ mờ */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* Canh giữa modal */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Độ rộng của modal */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 30px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    label {
        font-weight: bold;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .create {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
        width: 100px;
    }

    .create:hover {
        background-color: #45a049;
    }
</style>

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<div id="calendar"></div>
<div id="createEventModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCreateEventModal()">&times;</span>
        <form id="createEventForm">
            <div id="error-message" style="color: red;"></div>
            <!-- Các trường chỉnh sửa -->
            <label for="visitor_name">Name:</label>
            <input type="text" id="visitor_name" name="visitor_name" class="form-field" placeholder="John Doe" required>
            <div class="error-container" id="visitor_name-error" style="color: #c82333;"></div>

            <label for="email">Email:</label>
            <input type="email" id="visitor_email" name="visitor_email" class="form-field" placeholder="john.doe@email.com" required>
            <div class="error-container" id="visitor_email-error" style="color: #c82333;"></div>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" class="form-field" placeholder="498-348-3872" required>
            <div class="error-container" id="phone-error" style="color: #c82333;"></div>

            <label for="type">Service:</label>
            <select id="service" name="services" class="form-field" required>
                <!-- Thêm một option mặc định -->
                <option value="" selected></option>
            </select>
            <div class="error-container" id="services-error" style="color: #c82333;"></div>

            <label for="slot">Slot:</label>
            <input type="number" id="slot" name="slot" class="form-field" placeholder="0" max="5" required>
            <div class="error-container" id="slot-error" style="color: #c82333;"></div>

            <label for="meet">Select Time:</label>
            <select id="timeSelect" name="booking_time" class="form-field" id="booking_time">
                <option value="">Choose Time</option>
            </select>
            <div class="error-container" id="booking_time-error" style="color: #c82333;"></div>

            <div class="elem-group inlined">
                <label for="checkin-date">Booking date</label>
                <input type="date" id="checkin-date" class="form-field" name="checkin">
            </div>
            <div class="error-container" id="checkin-error" style="color: #c82333;"></div>

            <label for="note">Note:</label>
            <textarea id="visitor_message" name="visitor_message" class="form-field" ></textarea>
            <div class="error-container" id="visitor_message-error" style="color: #c82333;"></div>

            <button class="create" type="button" onclick="saveNewEvent()">Create</button>
        </form>
    </div>
</div>
<div id="eventInfoModal" class="modal">
    <div class="modal-content">
        <span class="close" style="margin-left:98%;">&times;</span>
        <div id="eventInfoContent"></div>
    </div>
</div>
<div id="editEventModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="editEventForm">
            <input type="hidden" id="editEventId" name="editEventId">
            <!-- Các trường chỉnh sửa -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="type">Service:</label>
            <select id="type" name="type" required>
                <!-- Thêm một option mặc định -->
                <option value="" selected></option>
            </select>

            <label for="slot">Slot:</label>
            <input type="text" id="slot" name="slot" required>

            <label for="booking_time">Booking Time:</label>
            <input type="text" id="booking_time" name="booking_time" required>

            <label for="note">Note:</label>
            <textarea id="note" name="note"></textarea>

            <button class="update" type="button" onclick="saveEditedEvent()">Update Booking</button>
        </form>
    </div>
</div>
<script>
    var calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            slotMinTime: '10:00:00', // Giờ bắt đầu
            slotMaxTime: '20:00:00', // Giờ kết thúc
            dayMaxEvents: 2,
            events: function(info, successCallback, failureCallback) {
                $.ajax({
                    url: '/calendar-events',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Dữ liệu sự kiện:',
                            response); // Kiểm tra dữ liệu trong Console
                        var events = response.map(function(event) {
                            return {
                                title: event.title,
                                start: event.start,
                                slot: event.slot,
                                phone: event.phone,
                                email: event.email,
                                note: event.note,
                                type: event.type,
                                id: event.id
                            };
                        });
                        console.log('Dữ liệu được truyền vào successCallback:',
                            events); // Kiểm tra dữ liệu trong Console
                        successCallback(events);
                    },
                    error: function(error) {
                        console.error('Lỗi khi tải dữ liệu sự kiện:', error);
                        failureCallback(error);
                    }
                });
            },
            eventTextColor: '#000',
            eventClick: function(info) {
                var title = info.event.title;
                var start = moment(info.event.start).format('h:mm A');
                var slot = info.event.extendedProps.slot;
                var phone = info.event.extendedProps.phone;
                var email = info.event.extendedProps.email;
                var note = info.event.extendedProps.note;
                var type = info.event.extendedProps.type;

                // Hiển thị thông tin sự kiện trong modal
                var modal = document.getElementById('eventInfoModal');
                var modalContent = document.getElementById('eventInfoContent');
                modalContent.innerHTML = '<p><strong>Name:</strong> ' + title + '</p>' +
                    '<p><strong>Time:</strong> ' + start + '</p>' +
                    '<p><strong>People:</strong> ' + slot + '</p>' +
                    '<p><strong>Phone:</strong> ' + phone + '</p>' +
                    '<p><strong>Email:</strong> ' + email + '</p>' +
                    '<p><strong>Note:</strong> ' + note + '</p>' +
                    '<p><strong>Services:</strong> ' + type + '</p>' +
                    '<button class="edit-event-button" onclick="openEditForm(' + info.event.id +
                    ',\'' + title + '\',\'' + email + '\',\'' + phone + '\',\'' + start + '\',\'' +
                    slot + '\',\'' + type + '\',\'' + note + '\')">Edit Event</button>' +
                    '<button class="delete-event-button" onclick="deleteEvent(' + info.event.id +
                    ')">Delete Event</button>';
                modal.style.display = 'block';

                // Đóng modal khi nhấn vào nút đóng
                var span = document.getElementsByClassName('close')[0];
                span.onclick = function() {
                    modal.style.display = 'none';
                };

                // Đóng modal khi nhấn ra ngoài
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = 'none';
                    }
                };
            },
            eventContent: function(arg) {
                var content = arg.event.title + '</br>';
                if (arg.event.start) {
                    var formattedTime = moment(arg.event.start).format(
                        'h:mm A'); // Định dạng giờ theo định dạng 12 giờ với AM/PM
                    content += formattedTime;
                }
                if (arg.event.extendedProps && arg.event.extendedProps.slot) {
                    content += '<br>People: ' + arg.event.extendedProps.slot;
                } else if (arg.event.slot) {
                    content += '<br>People: ' + arg.event.slot;
                }

                return {
                    html: content
                };
            },
            customButtons: {
                createEventButton: {
                    text: 'Add Booking',
                    click: function() {
                        openCreateEventModal();
                    }
                }
            },

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'createEventButton dayGridMonth,timeGridWeek,timeGridDay'
            },
        });
        updateServiceList()
        calendar.render();

    });

    function deleteEvent(id) {
        console.log('Đã gọi hàm deleteEvent với ID:', id);
        $.ajax({
            url: '/delete-events/' + id, // Đường dẫn API để xóa sự kiện từ Laravel
            method: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        calendar.refetchEvents();
                        // Đóng modal sau khi xóa sự kiện
                        var modal = document.getElementById('eventInfoModal');
                        modal.style.display = 'none';
                    }
                });
            },
            error: function(error) {
                console.error('Lỗi khi xóa sự kiện:', error);
            }
        });
    }

    function openEditForm(id, title, email, phone, start, slot, type, note) {
        // Gọi route để lấy thông tin sự kiện và hiển thị form
        $('#editEventModal').modal('show');
        $('#type').empty();
        $.ajax({
            url: '/show-events/' + id,
            method: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Hiển thị form chỉnh sửa

                // Cập nhật giá trị của các trường trong form
                $('#editEventId').val(id);
                $('#name').val(title);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#booking_time').val(start);
                $('#slot').val(slot);

                // Thiết lập giá trị mặc định cho dropdown
                $('#type').append('<option value="' + response.selectedServiceId + '" selected>' + response
                    .selectedServiceId + '</option>');

                // Thêm các giá trị từ danh sách service
                $.each(response.listService, function(index, service) {
                    if (service.name !== response.selectedServiceId) {
                        $('#type').append('<option value="' + service.name + '">' + service.name +
                            '</option>');
                    }
                });

                $('#note').val(note);
            },
            error: function(error) {
                console.error('Lỗi khi tải form chỉnh sửa sự kiện:', error);
            }
        });
    }

    function closeModal() {
        // Đóng cửa sổ chỉnh sửa
        $('#editEventModal').modal('hide');
    }

    function saveEditedEvent() {
        var id = $('#editEventId').val();
        var formData = new FormData($('#editEventForm')[0]);

        $.ajax({
            url: '/edit-events/' + id,
            method: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Sự kiện đã được cập nhật:', response);

                // Hiển thị thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Event Updated Successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Ẩn modal chỉnh sửa sau khi cập nhật
                closeModal();

                // Làm mới trang sau khi cập nhật sự kiện
                location.reload();
            },
            error: function(error) {
                console.error('Lỗi khi cập nhật sự kiện:', error);

                // Hiển thị thông báo lỗi nếu cần
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update event. Please try again.',
                });
            }
        });
    }

    function updateServiceList() {
        // Gửi Ajax request để lấy dữ liệu services
        $.ajax({
            url: '/get-services', // Điều chỉnh URL theo đúng API hoặc route của bạn
            method: 'GET',
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Xử lý dữ liệu và hiển thị danh sách
                var serviceSelect = $('#service');

                // Xóa tất cả các tùy chọn hiện tại
                serviceSelect.empty();

                // Thêm tùy chọn mặc định nếu cần
                serviceSelect.append('<option value="" selected>Choose Service</option>');

                // Thêm các tùy chọn từ danh sách dịch vụ
                $.each(response.listService, function(index, service) {
                    serviceSelect.append('<option value="' + service.name + '">' + service.name +
                        '</option>');
                });
            },
            error: function(error) {
                console.error('Error fetching services:', error.responseText);
            }
        });
    }

    function openCreateEventModal() {
        var modal = document.getElementById('createEventModal');
        modal.style.display = 'block';
    }

    function closeCreateEventModal() {
        var modal = document.getElementById('createEventModal');
        modal.style.display = 'none';
    }

    function saveNewEvent() {
        // Thu thập dữ liệu từ biểu mẫu
        var formData = new FormData(document.getElementById('createEventForm'));
        // Gửi Ajax request
        $.ajax({
            url: '/create-events',
            method: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                // Đóng modal khi tạo lịch thành công
                closeCreateEventModal();

                // Hiển thị SweetAlert thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Booking created successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Cập nhật lịch trên FullCalendar (nếu cần)
                calendar.refetchEvents();
                },
            error: function(xhr, status, error) {
                // Xử lý khi có lỗi trong quá trình gửi AJAX request
                console.error('AJAX error:', status, error);

                // Hiển thị lỗi trong view
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    // Lặp qua tất cả các ô input có class "form-field"
                    $('.form-field').each(function() {
                        var fieldName = $(this).attr('name');
                        var errorContainer = $('#' + fieldName + '-error');
                        if (errorContainer.length) {
                            // Hiển thị lỗi tương ứng với từng trường
                            errorContainer.text(errors[fieldName] ? errors[fieldName][0] : '');
                        }
                    });
                }
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    // Hiển thị thông báo lỗi trong phần được thêm vào
                    $('#error-message').text(xhr.responseJSON.error);
                }
            }
        });
    }

    var currentDateTime = new Date();
    var year = currentDateTime.getFullYear();
    var month = (currentDateTime.getMonth() + 1);
    var date = (currentDateTime.getDate() + 1);

    if (date < 10) {
        date = '0' + date;
    }
    if (month < 10) {
        month = '0' + month;
    }

    var dateTomorrow = year + "-" + month + "-" + date;
    var checkinElem = document.querySelector("#checkin-date");

    checkinElem.setAttribute("min", dateTomorrow);

    var timeSelect = document.getElementById('timeSelect');

    for (var hours = 10; hours <= 19; hours++) {
        var formattedHour = hours % 12 === 0 ? 12 : hours % 12; // Chuyển đổi giờ sang định dạng 12 giờ
        var ampm = hours < 12 ? 'AM' : 'PM';
        var optionText = formattedHour + ':00 ' + ampm; // Sử dụng giờ và phút

        // Tạo một option mới và thêm vào danh sách select
        var option = document.createElement('option');
        option.value = formattedHour + ':00 ' + ampm; // Sử dụng giờ và AM/PM
        option.text = optionText;
        timeSelect.add(option);
    }
</script>

<link rel="stylesheet" href="{{ asset('client/css/booking.css') }}">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<section>
    <form action="{{ route('add_booking') }}" method="post">
        @csrf
        <div class="elem-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="visitor_name" placeholder="John Doe">
        </div>
        @error('visitor_name')
            <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <div class="elem-group">
            <label for="email">Your E-mail</label>
            <input type="email" id="email" name="visitor_email" placeholder="john.doe@email.com">
        </div>
        @error('visitor_email')
            <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <div class="elem-group">
            <label for="phone">Your Phone</label>
            <input type="tel" id="phone" name="phone" placeholder="498-348-3872">
        </div>
        @error('phone')
            <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <hr>
        <div class="elem-group inlined">
            <label for="adult">Number</label>
            <input type="number" id="adult" name="slot" placeholder="0" min="1" max="10">
        </div>
        @error('slot')
         <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <div class="elem-group inlined">
            <label for="checkin-date">Booking date</label>
            <input type="date" id="checkin-date" name="booking_date" onchange="getAvailableSlots()">
        </div>
        @error('booking_date')
            <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <div id="available-slots-info">
            <!-- Thông tin số lượng slot sẽ được hiển thị ở đây -->
        </div>
        <div>
            <label for="meet">Select Time:</label>
            <select id="timeSelect" name="booking_time" id="booking_time">
                <option value="">Choose Time</option>
            </select>
        </div>
        <div class="elem-group">
            <label for="room-selection">Select Services</label>
            <select id="room-selection" name="services">
                <option value="">Choose a service</option>
                @foreach ($services as $key => $value)
                    <option value="{{$value->name}}">{{$value->name}}</option>
                @endforeach
            </select>
        </div>
        @error('services')
            <div class="invalid-feedback" style="color: red;">{{ $message }}</div>
        @enderror
        <hr>
        <div class="elem-group">
            <label for="message">Anything Else?</label>
            <textarea id="message" name="visitor_message" placeholder="Tell us anything else that might be important."></textarea>
        </div>
        <button type="submit">Book The Appointment</button>
    </form>
</section>
<script>
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

    // Tạo danh sách giờ từ 10 AM đến 7 PM cách nhau mỗi giờ
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
    function getAvailableSlots() {
        var selectedDate = document.getElementById('checkin-date').value;

        // Sử dụng AJAX để gửi yêu cầu đến máy chủ
        $.ajax({
            url: '{{ route('available-slots') }}',
            method: 'GET',
            data: { date: selectedDate },
            success: function(response) {
                console.log(response);

                var availableSlotsInfo = document.getElementById('available-slots-info');

                if (response.message) {
                    // Hiển thị thông báo nếu có
                    availableSlotsInfo.innerHTML = '<p style="font-size: 18px; font-weight: bold; color: red;">' + response.message + '</p>';
                } else {
                    // Kiểm tra nếu có slot trống
                    if (response.available_slots > 0) {
                        availableSlotsInfo.innerHTML = '<p style="font-size: 18px; font-weight: bold; color: red;">Booking Available. Slot: ' + response.available_slots + '</p>';
                    } else {
                        availableSlotsInfo.innerHTML = '<p style="font-size: 18px; font-weight: bold; color: red;">Slot is full. Please Choose another day.</p>';
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>

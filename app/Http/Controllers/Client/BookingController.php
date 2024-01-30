<?php

namespace App\Http\Controllers\Client;

use App\Events\BookingSuccess;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Jobs\ResetSlotJob;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Client;
use App\Models\Holiday;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(){
        $services = BookingService::where('status', 1)->get();
        return view('client.pages.booking.booking', compact('services'));
    }

    public function add_booking(BookingRequest $request){
        $bookingdate = Carbon::parse($request->booking_date);
        $bookingTime = Carbon::createFromFormat('h:i A', $request->booking_time);
        $slot = Slot::where('booking_date', $bookingdate)->first();

        $slot = Slot::firstOrCreate(
            ['booking_date' =>$bookingdate],
            [
                'available_slots' => $request->input('available_slots', 50),
            ]
        );
        $client = Client::firstOrCreate(
            ['email' => $request->visitor_email],
            [
                'name' => $request->visitor_name,
                'phone' => $request->phone,
            ]
        );
        $slotId = $request->input('slot_id');
        $booking = Booking::create([
            'client_id' => $client->id,
            'slot_id' => $slot->id,
            'name' => $request->visitor_name,
            'email' => $request->visitor_email,
            'phone' => $request->phone,
            'booking_time' => $bookingTime->toTimeString(),
            'booking_date' => $bookingdate,
            'type' => $request->services,
            'slot' => $request->slot,
            'note' => $request->visitor_message,
        ]);
        $msg = $booking ? 'Booking Success': 'Booking Failed';
        event(new BookingSuccess($booking));
        return redirect()->route('home')->with('message',$msg);
    }

    public function get_available_slot(Request $request)
    {
        $date = $request->input('date');
        $selectedDay = Carbon::parse($date)->day;
        // Lấy slot cho ngày được chọn từ cơ sở dữ liệu
        $holiday = Holiday::whereDay('date', $selectedDay)->first();
        $slot = Slot::whereDay('booking_date', $selectedDay)->where('confirmed', 'confirmed')->first();

        // Nếu không có slot, sử dụng số lượng mặc định
        if ($holiday) {
            // Ngày hiện tại là ngày lễ, không thể chọn
            $message = 'Ngày lễ' . ($holiday->name ? ' ' . $holiday->name : '') . ', không thể chọn.';
            return response()->json(['available_slots' => 0, 'message' => $message]);
        } else {
            // Ngày hiện tại không phải là ngày lễ, thực hiện xử lý để lấy số lượng slot có sẵn
            $slot = Slot::where('booking_date', $selectedDay)->where('confirmed', false)->first();

            // Nếu không có slot, sử dụng số lượng mặc định
            $availableSlots = $slot ? $slot->available_slots : $this->getDefaultSlotCount($selectedDay);

        }
        return response()->json(['available_slots' => $availableSlots, 'message' => '']);
    }

    private function getDefaultSlotCount($day)
    {
        // Giả sử số lượng mặc định là 50 nếu không có số liệu trong CSDL
        return 50;
    }
}

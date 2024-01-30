<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Client;
use App\Models\Holiday;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CalendarController extends Controller
{
    public function getCalendar(){
        $bookingList = Booking::all();
        $events = [];
        foreach ($bookingList as $booking){
            $startDateTime = $booking->booking_date . ' ' . $booking->booking_time;
            $events[] = [
                'id' => $booking->id,
                'title' => $booking->name,
                'start' => $startDateTime,
                'slot' => $booking->slot,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'note' => $booking->note,
                'type' => $booking->type,
            ];
        }
        return response()->json($events);
    }

    public function delete($id){

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
    public function show($id){
        $booking = Booking::findOrFail($id);
        $selectedServiceId = $booking->type;
        $listService = BookingService::where('status', 1)->get();

        $data = [
            'booking' => $booking,
            'selectedServiceId' => $selectedServiceId,
            'listService' => $listService,
        ];

        return response()->json($data);
    }
    public function edit(Request $request, $id){
        try {
            // Tìm sự kiện cần chỉnh sửa
            $booking = Booking::with('services')->findOrFail($id);

            // Cập nhật thông tin sự kiện
            $booking->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'booking_time' => date('H:i:s', strtotime($request->input('booking_time'))),
                'note' => $request->input('note'),
                'type' => $request->input('type'),
                'slot' => $request->input('slot'),
            ]);
            return response()->json(['message' => 'Sự kiện đã được chỉnh sửa thành công'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi chỉnh sửa sự kiện: ' . $e->getMessage()], 500);
        }
    }
    public function store(BookingRequest $request)
    {
        try {

            $bookingdate = Carbon::parse($request->checkin);
            $bookingTime = Carbon::createFromFormat('h:i A', $request->booking_time);

            $isHoliday = Holiday::where('date', $bookingdate->toDateString())->exists();

            if ($isHoliday) {
                return response()->json(['error' => 'Không thể đặt lịch vào ngày lễ.'], 422);
            }

            // Slot
            $slot = Slot::firstOrCreate(
                ['booking_date' => $bookingdate],
                ['available_slots' => $request->input('available_slots', 50)]
            );

            // Client
            $client = Client::firstOrCreate(
                ['email' => $request->visitor_email],
                [
                    'name' => $request->visitor_name,
                    'phone' => $request->phone,
                ]
            );

            // Booking
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

            $status = $booking ? 'success' : 'fail';

            return response()->json(['status' => $status, 'message' => 'Booking ' . ucfirst($status)]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    public function getService() {
        $listService = BookingService::where('status', 1)->get();

        return response()->json(['listService' => $listService]);
    }


}

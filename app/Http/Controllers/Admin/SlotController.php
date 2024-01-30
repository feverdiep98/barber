<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;
use Illuminate\Support\Facades\DB;

class SlotController extends Controller
{
    public function store(Request $request)
    {
        //query Builder
        $check = DB::table('slot')->insert([
            'id' => $request->id,
            'day_of_week' => $request->day_of_week,
            'available_slots' => $request->available_slots
        ]);
        $msg = $check ? 'Create Slot Success' : 'Create Slot Failed';
        return redirect()->route('admin.slot.list')->with('message', $msg);
    }
    public function index(Request $request)
    {
        $slots = Slot::paginate(config('myconfig.item_per_page'));
        return view('admin.slot.list', compact('slots'));
    }
    public function detail($id)
    {
        $slot = DB::select('select * from slots where id = ?', [$id]);
        return view('admin.slot.detail', ['slot' => $slot]);
    }

    public function update(Request  $request)
    {
        $check = Slot::where('id', $request->id)->update([
            'id' => $request->id,
            'available_slots' => $request->available_slots,
            'booked_slots' => $request->booked_slots,
        ]);
        $msg = $check ? 'Update Slot Success' : 'Update Slot Failed';
        return redirect()->route('admin.slot.list')->with('message', $msg);
    }

    public function destroy($id)
    {
        $slot = Slot::find($id);
        $check = $slot->delete();

        $msg = $check ? 'Delete Slot Success' : 'Delete Slot Failed';

        return redirect()->route('admin.slot.list')->with('message', $msg);
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->id;
        foreach ($ids as $id) {
            $check = Slot::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete Slot Success' : 'Delete Slot Failed';
        return redirect()->route('admin.slot.list')->with('message', $msg);
    }
    public function confirm($id) {
        $slot = Slot::find($id);

        if (!$slot) {
            return redirect()->route('admin.booking_list.list')->with('error', 'Không tìm thấy slot');
        }

        // Trường hợp chưa xác nhận hoặc đã xác nhận
        if ($slot->confirmed !== 'confirmed') {
            // Nếu chưa xác nhận, thực hiện xác nhận
            $slot->confirmed = 'confirmed';

            // Lấy tất cả các đặt phòng liên quan đến slot này
            $bookings = $slot->booking;

            if ($bookings->isNotEmpty()) {
                // Tính tổng số lượng slot đã đặt trên từng đặt phòng
                $totalBookedSlots = $bookings->sum('slot');

                // Cập nhật số lượng slot đã đặt và số lượng slot còn trống của slot hiện tại
                $slot->available_slots -= $totalBookedSlots;
                $slot->booked_slots += $totalBookedSlots;

                // Lưu các thay đổi vào database
                $slot->save();

                // Cập nhật số lượng slot trong mỗi đặt phòng
                foreach ($bookings as $booking) {
                    // Tính tổng số lượng slot trong đặt phòng
                    $totalSlot = $booking->slot;

                    // Cập nhật số lượng slot đã đặt trong đặt phòng
                    $booking->booked_slots = $totalSlot;

                    // Lưu các thay đổi vào database
                    $booking->save();
                }

                return redirect()->route('admin.slot.list')->with('success', 'Xác nhận đặt lịch thành công');
            } else {
                return redirect()->route('admin.slot.list')->with('info', 'Không tìm thấy đặt lịch liên quan đến slot này');
            }
        }

        return redirect()->route('admin.slot.list')->with('info', 'Slot đã được xác nhận trước đó');
    }
}

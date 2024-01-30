<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Holiday;
use GuzzleHttp\Client;

class FetchHolidays extends Command
{
    protected $signature = 'fetch:holidays {--year=2024 : The year of holidays}';
    protected $description = 'Fetch public holidays and store in the database';

    public function handle()
    {
        $year = $this->option('year') ?: date('Y');
        // Gửi request đến API để lấy thông tin ngày lễ
        $client = new Client();
        $response = $client->get("https://date.nager.at/api/v2/publicholidays/{$year}/vn");
        // Decode JSON response
        $holidays = json_decode($response->getBody(), true);

        // Lưu thông tin vào bảng holidays
        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(
                ['date' => Carbon::parse($holiday['date'])->toDateString()],
                ['name' => $holiday['localName']]
            );
        }

        $this->info('Holidays fetched successfully!');
    }
}


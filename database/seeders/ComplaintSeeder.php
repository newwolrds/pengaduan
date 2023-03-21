<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\ComplaintImage;
use App\Models\Response;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $complaint = Complaint::create([
            'code' => 'P-SDFKJ',
            'user_id' => '3',
            'responded_by' => '2',
            'title' => 'Jalan Berlubang',
            'description' => 'Jalan Berlubang di kecamatan sindanglaya kabupaten magelang RT 001 RW 003 ',
            'date' => Carbon::now()->toDateString(),
            'level' => 'tinggi',
            'status' => 'DONE',
        ]);
        ComplaintImage::create([
            'complaint_id' => '1',
            'image' => 'complaint-1.jpg',
            'description' => 'Kondisi Rusak',
        ]);
        $response = Response::create([
            'user_id' => '1',
            'complaint_id' => '1',
            'response' => 'Baik akan segera kami renovasi',
        ]);
    }
}

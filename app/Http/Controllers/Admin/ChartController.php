<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(){

        return view('admin.chart.index');
    }

    public function chart() {
        $now = Carbon::now()->year;
        $datas = Order::select([
            DB::raw('MONTH(created_at) as month'),
            // DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total) as total'),
            DB::raw('COUNT(*) as count'),
        ])
        ->where('status_message', 'completed')
        ->whereYear('created_at', $now)
        ->groupBy([
            'month'
        ])
        ->orderBy('month')
        ->get();
        $labels = [
            1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',
        ];
        $total = $count = [];
        foreach($datas as $data){
            $total[$data->month] = $data->total;
            $count[$data->month] = $data->count;
        }
        foreach($labels as $month => $name) {
            if(!array_key_exists($month, $total)) {
                $total[$month] = 0;
            }
            if(!array_key_exists($month, $count)) {
                $count[$month] = 0;
            }
        }
        ksort($total);
        ksort($count);
        return [
            'labels' => array_values($labels),
            'dataset' => [
                'label' => '$ Total Sales in '.$now,
                'data' => array_values($total),
            ],
            [
                'label' => 'Order #',
                'data' => array_values($count),
            ],
        ];
    }
}

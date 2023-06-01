<?php

namespace App\Http\Controllers;

use App\Models\ReportProduct;
use Illuminate\Http\Request;
use App\Models\Statistical;
use Carbon\Carbon;
class ReportController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Xem báo cáo');
    // }
    public function index()
    {
        return view('admin.Report');
    }

    public function getReportDay(Request $request)
    {
        if($request->input('date') == 0){
            $date = Carbon::now();
        }
        else{
            $date = Carbon::parse($request->input('date'));
        }
        
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        $s = Statistical::whereDay('Date',$day)->whereMonth('Date',$month)->whereYear('Date',$year)->first();

        return response()->json($s);
    }

    public function getReportMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        
        $statisticals = Statistical::whereYear('Date', $year)
            ->whereMonth('date', $month)
            ->get();
        $TotalRevenueMonth = 0;
        $TotalProfitMonth = 0;
        foreach ($statisticals as $statistical) {
            $TotalRevenueMonth += $statistical->Revenue;
            $TotalProfitMonth += $statistical->Profit;
        }

        $resultList = $statisticals->toJson();

        return response()->json([
            'resultList' => $resultList,
            'TotalRevenueMonth' => $TotalRevenueMonth,
            'TotalProfitMonth' => $TotalProfitMonth
        ]);
    }

    public function getReportYear(Request $request)
    {
        $year = $request->input('year');
        $statisticals = Statistical::whereYear('Date', $year)
            ->get();
        $list = collect([]);
        $TotalRevenueYear = 0;
        $TotalProfitYear = 0;
        foreach ($statisticals as $statistical) {
            $TotalRevenueYear += $statistical->Revenue;
            $TotalProfitYear += $statistical->Profit;
            $month = Carbon::parse($statistical->Date)->month;
            $reportYear = $list->where('date', $month)->first();

            if ($reportYear != null) {
                $reportYear['Profit'] += $statistical->Profit;
                $reportYear['Revenue'] += $statistical->Revenue;
                $reportYear['Quantity'] += $statistical->Quantity;
                $reportYear['Total_Order'] += $statistical->Total_Order;
            } else {
                $reportYearNew = [
                    'date' => $month,
                    'Profit' => $statistical->Profit,
                    'Revenue' => $statistical->Revenue,
                    'Quantity' => $statistical->Quantity,
                    'Total_Order' => $statistical->Total_Order
                ];
                $list[] = $reportYearNew;
            }
        }

        $resultList = collect($list)->toJson();

        return response()->json([
            'resultList' => $resultList,
            'TotalRevenueYear' => $TotalRevenueYear,
            'TotalProfitYear' => $TotalProfitYear
        ]);
    }

    public function reportproduct(Request $request){
        return view('admin.report-product');
    }

    public function getReportProductDay(Request $request)
    {
        if($request->input('date') == 0){
            $date = Carbon::now();
        }
        else{
            $date = Carbon::parse($request->input('date'));
        }
        
        $day = $date->day;
        $month = $date->month;
        $year = $date->year;
        $s = ReportProduct::with('Product.ProductImages','ProductColor')->whereDay('Date',$day)->whereMonth('Date',$month)->whereYear('Date',$year)->orderByDesc('Profit')->get();
        return response()->json($s);
    }

    public function getReportProductMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        
        $reportProducts = ReportProduct::with('Product.ProductImages','ProductColor')
        ->whereYear('Date', $year)
            ->whereMonth('Date', $month)
            ->selectRaw('ProId, ProColorID, SUM(Profit) AS Profit, SUM(Revenue) AS Revenue, SUM(Quantity) AS Quantity')
            ->groupBy('ProId', 'ProColorID')
            ->orderByDesc('Profit')->get();

        $reportProducts = $reportProducts->toJson();
        return response()->json([
            'resultList' => $reportProducts
        ]);
    }

    public function getReportProductYear(Request $request)
    {
        $year = $request->input('year');
        $reportProducts = ReportProduct::with('Product.ProductImages','ProductColor')
        ->whereYear('Date', $year)
            ->selectRaw('ProId, ProColorID, SUM(Profit) AS Profit, SUM(Revenue) AS Revenue, SUM(Quantity) AS Quantity')
            ->groupBy('ProId', 'ProColorID')
            ->orderByDesc('Profit')->get();

        $reportProducts = $reportProducts->toJson();
        return response()->json([
            'resultList' => $reportProducts
        ]);
    }
}

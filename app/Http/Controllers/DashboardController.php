<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService) {}

    public function index(Request $request)
    {
        $filters = [
            'yearSearch' => $request->get('year'),
            'stateSearch' => $request->get('state', 'all'),
            'typeOfProjectSearch' => $request->get('type', 'all'),
            'justification' => $request->get('justification', 'all'),
            'plantFilter' => $request->get('plant', 'all'),
            'dollarOrEuro' => $request->get('currency', 'euro'),
            'rateValue' => $request->get('rate', 1)
        ];

        $dashboardData = $this->dashboardService->getDashboardData($filters);

        return view('dashboard', compact('dashboardData', 'filters'));
    }

    public function getMetrics(Request $request)
    {
        $filters = $request->only([
            'yearSearch',
            'stateSearch',
            'typeOfProjectSearch',
            'justification',
            'plantFilter',
            'dollarOrEuro',
            'rateValue'
        ]);

        $dashboardService = app(DashboardService::class);
        $data = $dashboardService->getDashboardData($filters);

        return response()->json([
            'metrics' => $data['mainMetrics'],
            'charts' => $data['chartData']
        ]);
    }
}

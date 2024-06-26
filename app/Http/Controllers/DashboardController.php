<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\VisitorRepositoryInterface;
use App\Builders\PaymentBuilder;
use App\Builders\PaymentQueryBuilder;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    private $reviewRepository;
    protected $paymentBuilder;
    private $visitorRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, PaymentBuilder $paymentBuilder, VisitorRepositoryInterface $visitorRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->paymentBuilder = $paymentBuilder;
        $this->visitorRepository = $visitorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //weekly review
        $weeklyReviewCount = $this->reviewRepository->weeklyReview();
        $weeklyReviewPercentageChange = $this->reviewRepository->weeklyReviewPercentageChange();
        if ($weeklyReviewPercentageChange > 0) {
            // increased
            $weeklyReviewPercentageChange = "Increased by {$weeklyReviewPercentageChange}%";
        } elseif ($weeklyReviewPercentageChange < 0) {
            // decreased
            $weeklyReviewPercentageChange = "Decreased by " . abs($weeklyReviewPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklyReviewPercentageChange = "No changes";
        }

        //weekly sales
        $weeklySalesTotal = $this->paymentBuilder->weeklySales();
        $weeklySalesPercentageChange = $this->paymentBuilder->weeklySalesPercentageChange();
        if ($weeklySalesPercentageChange > 0) {
            // increased
            $weeklySalesPercentageChange = "Increased by {$weeklySalesPercentageChange}%";
        } elseif ($weeklySalesPercentageChange < 0) {
            // decreased
            $weeklySalesPercentageChange = "Decreased by " . abs($weeklySalesPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklySalesPercentageChange = "No changes";
        }

        //weekly visitor
        $weeklyVisitorCount = $this->visitorRepository->weeklyVisitor();
        $weeklyVisitorPercentageChange = $this->visitorRepository->weeklyVisitorPercentageChange();

        if ($weeklyVisitorPercentageChange > 0) {
            // increased
            $weeklyVisitorPercentageChange = "Increased by {$weeklyVisitorPercentageChange}%";
        } elseif ($weeklyVisitorPercentageChange < 0) {
            // decreased
            $weeklyVisitorPercentageChange = "Decreased by " . abs($weeklyVisitorPercentageChange) . "%";
        } else {
            // stayed the same
            $weeklyVisitorPercentageChange = "No changes";
        }

        //review chart
        $weeklyReviewChart = $this->reviewRepository->weeklyReviewChart();
        $reviewChartData = array(0, 0, 0, 0, 0, 0, 0);
        foreach($weeklyReviewChart as $data) {
            switch($data->dayOfWeek) {
                case 'Monday':
                    $reviewChartData[0] = $data->count;
                    break;
                case 'Tuesday':
                    $reviewChartData[1] = $data->count;
                    break;
                case 'Wednesday':
                    $reviewChartData[2] = $data->count;
                    break;
                case 'Thursday':
                    $reviewChartData[3] = $data->count;
                    break;
                case 'Friday':
                    $reviewChartData[4] = $data->count;
                    break;
                case 'Saturday':
                    $reviewChartData[5] = $data->count;
                    break;
                case 'Sunday':
                    $reviewChartData[6] = $data->count;
                    break;
            }
        }
        $reviewChartData = json_encode($reviewChartData);

        //visit chart
        $weeklyVisitChart = $this->visitorRepository->weeklyVisitChart();
        $visitChartData = array(0, 0, 0, 0, 0, 0, 0);
        foreach($weeklyVisitChart as $data) {
            switch($data->dayOfWeek) {
                case 'Monday':
                    $visitChartData[0] = $data->count;
                    break;
                case 'Tuesday':
                    $visitChartData[1] = $data->count;
                    break;
                case 'Wednesday':
                    $visitChartData[2] = $data->count;
                    break;
                case 'Thursday':
                    $visitChartData[3] = $data->count;
                    break;
                case 'Friday':
                    $visitChartData[4] = $data->count;
                    break;
                case 'Saturday':
                    $visitChartData[5] = $data->count;
                    break;
                case 'Sunday':
                    $visitChartData[6] = $data->count;
                    break;
            }
        }
        $visitChartData = json_encode($visitChartData);

        //sales chart
        $weeklySalesChart = $this->paymentBuilder->weeklySalesChart();
        // return $weeklySalesChart;
        $salesChartData = array(0, 0, 0, 0, 0, 0, 0);
        $salesIncome = array(0, 0, 0, 0, 0, 0, 0);
        foreach($weeklySalesChart as $data) {
            switch($data->dayOfWeek) {
                case 'Monday':
                    $salesChartData[0] = $data->count;
                    $salesIncome[0] = $data->totalSales;
                    break;
                case 'Tuesday':
                    $salesChartData[1] = $data->count;
                    $salesIncome[1] = $data->totalSales;
                    break;
                case 'Wednesday':
                    $salesChartData[2] = $data->count;
                    $salesIncome[2] = $data->totalSales;
                    break;
                case 'Thursday':
                    $salesChartData[3] = $data->count;
                    $salesIncome[3] = $data->totalSales;
                    break;
                case 'Friday':
                    $salesChartData[4] = $data->count;
                    $salesIncome[4] = $data->totalSales;
                    break;
                case 'Saturday':
                    $salesChartData[5] = $data->count;
                    $salesIncome[5] = $data->totalSales;
                    break;
                case 'Sunday':
                    $salesChartData[6] = $data->count;
                    $salesIncome[6] = $data->totalSales;
                    break;
            }
        }
        $salesChartData = json_encode($salesChartData);

        //popular car make chart
        $popularCar = $this->paymentBuilder->popularCarMakeChart();

        return view('admin/admin-index', compact('weeklyReviewCount', 'weeklyReviewPercentageChange', 'weeklySalesTotal', 'weeklySalesPercentageChange', 'weeklyVisitorCount', 'weeklyVisitorPercentageChange', 'reviewChartData', 'visitChartData', 'salesChartData', 'salesIncome', 'popularCar'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

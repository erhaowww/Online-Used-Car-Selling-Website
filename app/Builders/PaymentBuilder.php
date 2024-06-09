<?php
namespace App\Builders;
use App\Builders\Interfaces\PaymentBuilderInterface;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PaymentBuilder implements PaymentBuilderInterface
{
    private $queryBuilder;

    public function __construct(PaymentQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function create($data)
    {
        return Payment::create($data);
    }

    public function readAll()
    {
        return $this->queryBuilder->get();
    }

    public function readById($id)
    {
        return $this->queryBuilder->findOrFail($id);
    }

    public function update($id, $data)
    {
        $payment = $this->queryBuilder->findOrFail($id);
        $payment->update($data);
        return $payment;
    }

    public function delete($id)
    {
        $payment = $this->queryBuilder->findOrFail($id);
        $payment->deleted = 1;
        $payment->update();
    }

    public function weeklySales($weeksAgo = 0)
    {
        $startDate = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
        $endDate = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();
    
        $weeklySalesTotal = DB::table('payments')
        ->join('orders', 'payments.order_id', '=', 'orders.id')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('payments.deleted', 0)
        ->where('orders.status', 'paid')
        ->whereBetween('payments.created_at', [$startDate, $endDate])
        ->whereIn('payments.order_id', function($query) {
            $query->select('orders.id')
                ->from('orders')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->where('products.deleted', 1);
        })
        ->selectRaw('SUM(payments.total_charge - products.price) as weekly_sales_total')
        ->first()
        ->weekly_sales_total;
    
        return $weeklySalesTotal;
    }

    public function weeklySalesPercentageChange()
    {
        // Get the current week's SalesTotal
        $currentSalesTotal = $this->weeklySales();

        // Get the previous week's SalesTotal
        $previousSalesTotal = $this->weeklySales(1);

        // Calculate the percentage change in review count
        $percentageChange = 0;
        if ($previousSalesTotal > 0) {
            $percentageChange = (($currentSalesTotal - $previousSalesTotal) / $previousSalesTotal) * 100;
        }

        return round($percentageChange, 2);
    }

    public function weeklySalesChart()
    {
        // Get the start and end dates of the current week (Monday to Sunday)
        $startDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
    
        // Get the sales for the current week and group them by the day of the week
        $sales = Payment::select(
                    DB::raw("DATE_FORMAT(payments.created_at,'%W') as dayOfWeek"), 
                    DB::raw('COUNT(payments.id) as count'), 
                    DB::raw('SUM(payments.total_charge - products.price) as totalSales')
                )
                ->join('orders', 'payments.order_id', '=', 'orders.id')
                ->join('products', 'orders.product_id', '=', 'products.id')
                ->where('payments.deleted', 0)
                ->where('products.deleted', 1)
                ->where('orders.status', 'paid')
                ->whereBetween('payments.created_at', [$startDate, $endDate])
                ->groupBy('dayOfWeek')
                ->get();
    
        return $sales;
    }

    public function popularCarMakeChart()
    {
        $payments = Payment::where('deleted', 0)->get();
        $car_make_counts = array();

        foreach($payments as $payment){
            $order_ids = explode(',', $payment->order_id);
            if (count($order_ids) > 1) {
                // Handle case where there is more than one order ID
                foreach ($order_ids as $order_id) {
                    $order = Order::where('id', $order_id)->first();
                    if ($order) {
                        $product = Product::where('id', $order->product_id)->first();
                        if ($product) {
                            // Count the number of times this car model appears in products
                            $car_make = $product->make;
                            if (array_key_exists($car_make, $car_make_counts)) {
                                $car_make_counts[$car_make]++;
                            } else {
                                $car_make_counts[$car_make] = 1;
                            }
                        }
                    }
                }
            } else {
                // Handle case where there is only one order ID
                $order_id = $order_ids[0];
                $order = Order::where('id', $order_id)->first();
                if ($order) {
                    $product = Product::where('id', $order->product_id)->first();
                    if ($product) {
                        // Count the number of times this car model appears in products
                        $car_make = $product->make;
                        if (array_key_exists($car_make, $car_make_counts)) {
                            $car_make_counts[$car_make]++;
                        } else {
                            $car_make_counts[$car_make] = 1;
                        }
                    }
                }
            }
        }
        return $car_make_counts;
    }
    

}

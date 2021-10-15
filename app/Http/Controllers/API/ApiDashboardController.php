<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Receipt;
use App\Credit;
use App\ReceiptItems;
use App\Ledger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiDashBoardController extends Controller
{
    public function daily_sales()
    {
          $data = Receipt::whereDate('created_at',Carbon::today())->sum('total');

          return $data;
    }

    public function daily_credits()
    {

        $credits = Credit::whereDate('created_at',Carbon::today())->sum('total');

        return $credits;
    }

    public function sold_products()
    {

          $products = ReceiptItems::sum('quantity');

          return $products;
    }

    public function month_sales()
    {




    }

    public function total_sales()
    {
        $total_sales = Receipt::selectRaw('sum(total) as sums')->selectRaw("DATE_FORMAT(created_at,'%M') as months")->groupBy('months')->get();

        return  $total_sales;
    }

    public function total_costs()
    {
        $total_cost = Receipt::selectRaw('sum(total) as sums')->selectRaw("DATE_FORMAT(created_at,'%M') as months")->groupBy('months')->get();

        return  $total_cost;

    }

    public function income()
    {
        $income = Ledger::selectRaw('sum(amount) as amounts')->selectRaw("DATE_FORMAT(created_at,'%M') as months")->groupBy('months')->get();

        return  $income;
    }

    public function expense()
    {
        $expense = Ledger::selectRaw('sum(amount) as amounts')->selectRaw("DATE_FORMAT(created_at,'%M') as months")->groupBy('months')->get();

        return  $expense;
    }

    public function top_selling_product()
    {

    }

    public function recent_invoice()
    {
        $recent_invoice = Ledger::get();

        return $recent_invoice;
    }

    public function recent_expense()
    {
        $recent_expense = Credit::get();

        return $recent_expense;
    }
}

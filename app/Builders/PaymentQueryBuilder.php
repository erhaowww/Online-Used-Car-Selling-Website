<?php
namespace App\Builders;
use App\Builders\Interfaces\PaymentQueryBuilderInterface;
use App\Models\Payment;


class PaymentQueryBuilder implements PaymentQueryBuilderInterface
{
    private $query;

    public function __construct()
    {
        $this->query = Payment::query();
    }

    public function whereAmountGreaterThan($amount)
    {
        $this->query->where('amount', '>', $amount);
        return $this;
    }

    public function whereStatus($status)
    {
        $this->query->where('status', $status);
        return $this;
    }

    public function orderByDate($direction = 'desc')
    {
        $this->query->orderBy('created_at', $direction);
        return $this;
    }

    public function get()
    {
        return $this->query->where('deleted', 0)->get();
    }

    public function first()
    {
        return $this->query->first();
    }

    public function findOrFail($id)
    {
        return $this->query->findOrFail($id);
    }
}
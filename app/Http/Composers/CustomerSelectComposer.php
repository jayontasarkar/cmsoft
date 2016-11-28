<?php

namespace App\Http\Composers;


use App\Models\Customer;
use Illuminate\View\View;

class CustomerSelectComposer
{
    /**
     * @var Customer
     */
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function compose(View $view)
    {
        $view->with('customers', $this->customer->orderBy('name')->get());
    }
}
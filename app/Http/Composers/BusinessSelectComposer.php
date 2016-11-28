<?php

namespace App\Http\Composers;


use App\Models\Business;
use Illuminate\View\View;

class BusinessSelectComposer
{
    /**
     * @var Business
     */
    private $business;

    public function __construct(Business $business)
    {

        $this->business = $business;
    }

    public function compose(View $view)
    {
        $view->with('businesses', $this->business->all());
    }
}
<?php

namespace App\Http\Composers;


use App\Models\Area;
use Illuminate\View\View;

class AreaSelectComposer
{
    /**
     * @var Business
     */
    private $area;

    public function __construct(Area $area)
    {

        $this->area = $area;
    }

    public function compose(View $view)
    {
        $view->with('areas', $this->area->orderBy('name')->get());
    }
}
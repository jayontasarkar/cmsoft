<?php

namespace App\Http\Composers;


use App\Models\Season;
use Illuminate\View\View;

class SeasonSelectComposer
{
    /**
     * @var Business
     */
    private $season;

    public function __construct(Season $season)
    {

        $this->season = $season;
    }

    public function compose(View $view)
    {
        $view->with('seasons', $this->season->all());
    }
}
<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyMembershipDashboardPageSection extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view(theme('components.my-membership-dashboard-page-section'));
    }
}

<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;
use Modules\Store\Entities\CancelReason;
use Modules\Store\Entities\DeliveryProcess;
use Modules\Store\Entities\OrderPackageDetail;
use Modules\Store\Entities\RefundReason;

class MyOrderRefundRequestPageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $id = decrypt($this->id);
        $enroll = Checkout::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->with('courses', 'user', 'courses.course.enrollUsers', 'bill')->first();
        if (!$enroll) {
            abort(404);
        }
        $data['order_status'] = [];
        $data['order'] = Checkout::find($id);
        $data['package'] = OrderPackageDetail::with('product_details.getCourse', 'products.course')->find($id);
        $data['processes'] = DeliveryProcess::all();
        $data['reasons'] = RefundReason::all();
        $data['cancel_reasons'] = CancelReason::all();
        return view(theme('components.my-order-refund-request-page-section'), compact('enroll'))->with($data);
    }
}

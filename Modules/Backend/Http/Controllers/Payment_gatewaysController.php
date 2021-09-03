<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment_gateway;
use Illuminate\Http\Request;

class Payment_gatewaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $payment_gateways = Payment_gateway::where('name', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $payment_gateways = Payment_gateway::latest()->paginate($perPage);
        }

        return view('backend::payment_gateways.index', compact('payment_gateways'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::payment_gateways.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Payment_gateway::create($requestData);

        return redirect('backend/payment_gateways')->with('flash_message', 'Payment_gateway added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $payment_gateway = Payment_gateway::findOrFail($id);

        return view('backend::payment_gateways.show', compact('payment_gateway'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $payment_gateway = Payment_gateway::findOrFail($id);

        return view('backend::payment_gateways.edit', compact('payment_gateway'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $payment_gateway = Payment_gateway::findOrFail($id);
        $payment_gateway->update($requestData);

        return redirect('backend/payment_gateways')->with('flash_message', 'Payment_gateway updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Payment_gateway::destroy($id);

        return redirect('backend/payment_gateways')->with('flash_message', 'Payment_gateway deleted!');
    }
}

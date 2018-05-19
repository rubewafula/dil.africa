<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Seller;
use Illuminate\Http\Request;

class SellersController extends Controller
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
            $sellers = Seller::where('name', 'LIKE', "%$keyword%")
                ->orWhere('username', 'LIKE', "%$keyword%")
                ->orWhere('logo', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('opening_hours', 'LIKE', "%$keyword%")
                ->orWhere('closing_hours', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('country_id', 'LIKE', "%$keyword%")
                ->orWhere('city_id', 'LIKE', "%$keyword%")
                ->orWhere('area_id', 'LIKE', "%$keyword%")
                ->orWhere('physical_location', 'LIKE', "%$keyword%")
                ->orWhere('email_address', 'LIKE', "%$keyword%")
                ->orWhere('telephone', 'LIKE', "%$keyword%")
                ->orWhere('other_telephone', 'LIKE', "%$keyword%")
                ->orWhere('contact_person', 'LIKE', "%$keyword%")
                ->orWhere('contact_telephone', 'LIKE', "%$keyword%")
                ->orWhere('contact_email_address', 'LIKE', "%$keyword%")
                ->orWhere('warehouse_id', 'LIKE', "%$keyword%")
                ->orWhere('bank_name', 'LIKE', "%$keyword%")
                ->orWhere('account_name', 'LIKE', "%$keyword%")
                ->orWhere('account_number', 'LIKE', "%$keyword%")
                ->orWhere('swift_code', 'LIKE', "%$keyword%")
                ->orWhere('bank_code', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $sellers = Seller::latest()->paginate($perPage);
        }

        return view('backend::sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::sellers.create');
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
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        
        Seller::create($requestData);

        return redirect('backend/sellers')->with('flash_message', 'Seller added!');
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
        $seller = Seller::findOrFail($id);

        return view('backend::sellers.show', compact('seller'));
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
        $seller = Seller::findOrFail($id);

        return view('backend::sellers.edit', compact('seller'));
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
        $this->validate($request, [
			'name' => 'required'
		]);
        $requestData = $request->all();
        
        $seller = Seller::findOrFail($id);
        $seller->update($requestData);

        return redirect('backend/sellers')->with('flash_message', 'Seller updated!');
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
        Seller::destroy($id);

        return redirect('backend/sellers')->with('flash_message', 'Seller deleted!');
    }
}

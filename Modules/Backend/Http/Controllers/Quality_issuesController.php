<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Quality_issue;
use Illuminate\Http\Request;

class Quality_issuesController extends Controller
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
            $quality_issues = Quality_issue::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $quality_issues = Quality_issue::latest()->paginate($perPage);
        }

        return  view('backend::quality_issues.index', compact('quality_issues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return  view('backend::quality_issues.create');
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
        
        Quality_issue::create($requestData);

        return redirect('backend/quality_issues')->with('flash_message', 'Quality_issue added!');
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
        $quality_issue = Quality_issue::findOrFail($id);

        return  view('backend::quality_issues.show', compact('quality_issue'));
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
        $quality_issue = Quality_issue::findOrFail($id);

        return  view('backend::quality_issues.edit', compact('quality_issue'));
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
        
        $quality_issue = Quality_issue::findOrFail($id);
        $quality_issue->update($requestData);

        return redirect('backend/quality_issues')->with('flash_message', 'Quality_issue updated!');
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
        Quality_issue::destroy($id);

        return redirect('backend/quality_issues')->with('flash_message', 'Quality_issue deleted!');
    }
}

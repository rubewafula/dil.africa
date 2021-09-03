<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\Campaign_group;
use App\Sms_campaign;
use App\Outbox;


use Session;

class CampaignGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index(Request  $request)
    {

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {

            $campaign_groups = Campaign_group::where('group_name', 'LIKE', "%$keyword%")
                    ->latest()->paginate($perPage);
        } else {
            $campaign_groups = Campaign_group::latest()->paginate($perPage);
        }

        return  view('backend::campaign_groups.index', compact('campaign_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend::campaign_groups.create');
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
            'group_name' => 'required'
        ]); 

        $requestData = $request->all();

        Campaign_group::create($requestData);

        return redirect('backend/campaign-groups')
            ->with('flash_message', 'Campaign group added successfully!');
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
        $campaign_group = Campaign_group::findOrFail($id);

        return view('backend::campaign_groups.show', compact('campaign_group'));
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
        $campaign_group = Campaign_group::findOrFail($id);

        return view('backend::campaign_groups.edit', compact('campaign_group'));
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
            'group_name' => 'required'
        ]); 

        $campaign_group = Campaign_group::findOrFail($id);

        $requestData = $request->all();

        $campaign_group->update($requestData);

        return redirect('backend/campaign-groups')
            ->with('flash_message', 'Campaign group details updated successfully!');
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
        Campaign_group::destroy($id);

        return redirect('backend/campaign-groups')
            ->with('flash_message', 'Campaign group deleted successfully!');
    }


    public function campaign_msisdns(Request $request, $id)
    {

        $campaign_group = Campaign_group::find($id);

        $campaign_msisdns = Sms_campaign::where('campaign_group_id', $campaign_group->id)
                    ->orderBy('id','DESC')->get();

        return  view('backend::campaign_groups.msisdns.index', 
            compact('campaign_group','campaign_msisdns'));
    }


    public function add_msisdn($group_id){

        $campaign_group = Campaign_group::find($group_id);

        $campaign_msisdns = Sms_campaign::where('campaign_group_id', $campaign_group->id)
                    ->orderBy('id','DESC')->get();

        return  view('backend::campaign_groups.msisdns.add', 
            compact('campaign_group','campaign_msisdns'));
    }
    

    public function send_sms($group_id){

        $campaign_group = Campaign_group::find($group_id);

        $campaign_msisdns = Sms_campaign::where('campaign_group_id', $campaign_group->id)
                    ->orderBy('id','DESC')->get();

        if(count($campaign_msisdns) == 0){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'There are no phone numbers added in this campaign group. Please add some before attempting to send a broadcast message!');

            return redirect(url()->previous());

        }

        return  view('backend::campaign_groups.msisdns.send_sms', 
            compact('campaign_group'));
    }
    
    public function save_sms(Request $request) {

        $this->validate($request, [
            'message' => 'required',
            'campaign_group_id' => 'required'
        ]); 

        $message = $request->message;
        $campaign_group_id = $request->campaign_group_id;

        $message = trim($message);

        if (strlen($message) < 1) {
          
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'There is no message specified. Please type in some sense!');

            return redirect(url()->previous());

        }

        $campaign_msisdns = Sms_campaign::where('campaign_group_id', $campaign_group_id)->get();

        if(count($campaign_msisdns) == 0){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Campaign group has no phone numbers. Please type in some sense!');
        }

        foreach ($campaign_msisdns as $msisdn) {
            
            $outbox = new Outbox();
            $outbox->campaign_group_id = $campaign_group_id;
            $outbox->sms_campaign_id = $msisdn->id;
            $outbox->msisdn = $msisdn->msisdn;
            $outbox->message = $message;
            $outbox->status = 0;

            $outbox->save();
        }

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'SMS scheduled for sending successfully');

        return redirect(url()->previous());
    }


    public function add_msisdn_to_campaign_group(Request $request) {

        $this->validate($request, [
            'msisdn' => 'required'
        ]); 

        $msisdn = $request->msisdn;
        $campaign_group_id = $request->campaign_group_id;

        $msisdn = trim($msisdn);

        if (!preg_match("/^(?:254|\+254|0)?7[0-9]{8}$/", $msisdn)) {
          
            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Invalid phone number format. Please correct!');

            return redirect(url()->previous());

        }

        $campaign_msisdn = new Sms_campaign();
        $campaign_msisdn->campaign_group_id = $campaign_group_id;
        $campaign_msisdn->msisdn = $msisdn;
        $campaign_msisdn->status = 1;

        $campaign_msisdn->save();

        Session::flash('alert-class', 'alert-success');
        Session::flash('flash_message', 'Number added to the campaign group successfully');

        return redirect(url()->previous());
    }


    public function remove_msisdn_from_group($id)
    {

        Sms_campaign::destroy($id);

        return redirect(url()->previous())->with('flash_message', 
            'Phone number removed from the campaign group successfully!');
    }

    public function upload_csv(Request $request)
    {

        $this->validate($request, [
            'msisdn_csv' => 'required',
            'campaign_group_id' => 'required'
        ]);

        $csv_file = $request->msisdn_csv;
        $campaign_group_id = $request->campaign_group_id;

        $extension = $csv_file->getClientOriginalExtension();
        if($extension != "csv"){

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'Only CSV files are allowed.');

            return redirect(url()->previous());
        }

        $count = 0;
        $invalid_count = 0;

        if (!file_exists($csv_file) || !is_readable($csv_file))
        {

            Session::flash('alert-class', 'alert-danger');
            Session::flash('flash_message', 'File does not exist or is unreadable.');

            return redirect(url()->previous());
        }

        $header = null;
        $data = array();

        if (($handle = fopen($csv_file, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, ",")) !== false)
            {
                $msisdn = $row[0];
                $msisdn = trim($msisdn);

                if (!preg_match("/^(?:254|\+254|0)?7[0-9]{8}$/", $msisdn)) {
                    
                    $invalid_count++;
                    continue;
                }

                $checkNumInGroup = Sms_campaign::where('msisdn', $msisdn)
                    ->where('campaign_group_id', $campaign_group_id)->first();

                if($checkNumInGroup == null) {

                    $campaign_msisdn = new Sms_campaign();
                    $campaign_msisdn->campaign_group_id = $campaign_group_id;
                    $campaign_msisdn->msisdn = "0".substr($msisdn, -9);
                    $campaign_msisdn->status = 1;

                    $campaign_msisdn->save();

                    $count++;
                }

            }
            fclose($handle);
        }

        return redirect(url()->previous())->with('flash_message', 
            $count.' phone numbers uploaded successfully! '.$invalid_count.' numbers were 
            invalid and were therefore ignored.');
    }

}
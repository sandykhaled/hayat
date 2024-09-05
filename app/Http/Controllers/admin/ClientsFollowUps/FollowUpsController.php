<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use Response;
use App\Models\Clients;
use Illuminate\Http\Request;
use App\Models\ClientFollowUps;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FollowUpsController extends Controller
{
    public function index()
    {
        if (!userCan('followups_view') && !userCan('followups_view_branch') && !userCan('followups_view_team') && !userCan('followups_view_mine_only')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $followups = ClientFollowUps::orderBy('id','desc');
        //if not allowed to view all just return his client employees
        if (!userCan('followups_view')) {
            if (!userCan('followups_view_branch')) {
                if (!userCan('followups_view_team')) {
                    $teamMembers = [];
                    $teamMembers[] = auth()->user()->id;
                    $followups = $followups->whereIn('UID', $teamMembers);
                } else {
                    $followups = $followups->where('UID', auth()->user()->id);
                }
            }
        } else {
            //filter by client
            if (isset($_GET['client_id'])) {
                if ($_GET['client_id'] != 'all') {
                    $followups = $followups->where('ClientID',$_GET['client_id']);
                }
            }
            //filter by agent

            //filter by branch

        }
        //filter by agent



        $followups = $followups->paginate(25);
        return view('AdminPanel.followups.index',[
            'active' => 'followups',
            'title' => trans('common.followups'),
            'followups' => $followups,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.followups')
                ]
            ]
        ]);
    }

    public function nextFollowups()
    {
        $followups = ClientFollowUps::orderBy( 'date', 'asc');

        // if not allowed to view all, filter by team
        if (!userCan('followups_view')) {
            if (!userCan('followups_view_team')) {
                $teamMembers = auth()->user()->teamMembers()->pluck('id');
                $followups = $followups->whereIn('UID', $teamMembers);
            } else {
                $followups = $followups->where('UID', auth()->user()->id);
            }
        }

        // filter by client, class, and contacting type
        if (isset($_GET['client_id']) && $_GET['client_id'] != 'all') {
            $followups = $followups->where('ClientID', $_GET['client_id']);
        }


        $followups = $followups->paginate(25);

        return view('AdminPanel.followups.index', [
            'active' => 'nextFollowups',
            'title' => trans('common.nextFollowups'),
            'followups' => $followups,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.nextFollowups')
                ]
            ]
        ]);
    }
    public function store(Request $request)
    {
        if (!userCan('followups_create')) {
            return redirect()->back()->with('PopError', trans('common.youAreNotAuthorized'));
        }

        if (auth()->user()->branch == '') {
            return redirect()->back()->with('PopError', trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }

        // Validation rules
        $rules = [
            'days' => 'required|string',
            'date' => 'nullable|date',
            'arrival_time' => 'nullable|date_format:H:i',
            'session_start' => 'nullable|date_format:H:i',
            'session_end' => 'nullable|date_format:H:i',
            'session_number' => 'required|string',
            'doctor' => 'required|string',
            'note' => 'required|string',
            'service_id' => 'nullable|string',
            'ClientID' => 'nullable|string',
            'UID' => 'nullable|string',
        ];


        // Validate the request
        $validator = Validator::make($request->except('_token'), $rules);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        // Create a new appointment
        $data = ClientFollowUps::create($request->only([
            'days', 'date', 'client', 'arrival_time', 'session_start', 'session_end', 'session_number', 'doctor', 'note', 'service_id',
        ])  + [
            'UID' => auth()->user()->id,

            'ClientID' => $request->ClientID,
        ]);;

        if ($data) {
            return redirect()->back()->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()->with('failed', trans('common.faildMessageText'));
        }
    }

    public function update(Request $request,$id)
    {
        if (!userCan('followups_edit')) {
            return redirect()->back()->with('PopError', trans('common.youAreNotAuthorized'));
        }

        if (auth()->user()->branch == '') {
            return redirect()->back()->with('PopError', trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }

        // Validation rules
        $followup = ClientFollowUps::find($id);
        $data = $request->except(['_token']);
        $update = $followup->update($data);

        if ($update) {
            // Update the remaining_sessions field in the Clients table
            $client = $followup->client;
            $client->remaining_sessions -= $request->input('session_number');
            $client->save();
        }

        if ($update) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        if (!userCan('followups_delete')) {
            return Response::json("false");
        }
        $followup = ClientFollowUps::find($id);
        if ($followup->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}

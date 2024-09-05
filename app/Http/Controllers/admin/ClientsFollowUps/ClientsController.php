<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;


use App\Models\User;
use App\Models\Clients;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Clients\EditClient;
use App\Http\Requests\Clients\CreateClient;
use App\Models\ClientFollowUps;

class ClientsController extends Controller
{
    public function index()
    {
        if (!userCan('clients_view') && !userCan('clients_view_branch') && !userCan('clients_view_team') && !userCan('clients_view_mine_only')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $clients = Clients::orderBy('id','desc');
        //if not allowed to view all just return his client employees
        if (!userCan('clients_view')) {
            if (!userCan('clients_view_branch')) {
                if (!userCan('clients_view_team')) {
                    $teamMembers = [];
                    $teamMembers[] = auth()->user()->id;
                    $myTeam = User::where('status','Active')->where('leader',auth()->user()->id)->get();
                    foreach ($myTeam as $myTeamKey => $myTeamV) {
                        $teamMembers[] = $myTeamV['id'];
                    }
                    $clients = $clients->whereIn('AgentID',$teamMembers);
                } else {
                    $clients = $clients->where('AgentID',auth()->user()->id);
                }
            } else {
                $clients = $clients->where('branch_id',auth()->user()->branch_id);
            }
        } else {
            //filter by client
            if (isset($_GET['client_id'])) {
                if ($_GET['client_id'] != 'all') {
                    $clients = $clients->where('client_id',$_GET['client_id']);
                }
            }
            //filter by agent
            if (isset($_GET['AgentID'])) {
                if ($_GET['AgentID'] != 'all') {
                    $clients = $clients->where('UID',$_GET['AgentID']);
                }
            }
        }
        //filter by agent
        if (isset($_GET['class'])) {
            if ($_GET['class'] != 'all') {
                $clients = $clients->where('clientClass',$_GET['class']);
            }
        }
        //filter by name
        if (isset($_GET['Name'])) {
            if ($_GET['Name'] != '') {
                $clients = $clients->where('Name','like','%'.$_GET['Name'].'%');
            }
        }
        //filter by phone
        if (isset($_GET['phone'])) {
            if ($_GET['phone'] != '') {
                $clients = $clients->where('phone',$_GET['phone']);
            }
        }
        //filter by cellphone
        if (isset($_GET['cellphone'])) {
            if ($_GET['cellphone'] != '') {
                $clients = $clients->where('cellphone',$_GET['cellphone']);
            }
        }
        //filter by whatsapp
        if (isset($_GET['whatsapp'])) {
            if ($_GET['whatsapp'] != '') {
                $clients = $clients->where('whatsapp',$_GET['whatsapp']);
            }
        }
        $services = Service::all();
        $clients = $clients->paginate(25);
        return view('AdminPanel.clients.index',[
            'active' => 'clients',
            'title' => trans('common.clients'),
            'services' => $services,
            'clients' => $clients,

            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.clients')
                ]
            ]
        ]);
    }
    public function noAgentClients()
    {
        if (!userCan('clients_view') && !userCan('clients_view_no_agent')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $clients = Clients::orderBy('id','desc')->where('UID','0');
        //if not allowed to view all just return his client employees
        if (!userCan('clients_view')) {
            if (!userCan('clients_view_branch')) {
            } else {
                $clients = $clients->where('branch_id',auth()->user()->branch_id);
            }
        }
        //filter by agent
        if (isset($_GET['class'])) {
            if ($_GET['class'] != 'all') {
                $clients = $clients->where('clientClass',$_GET['class']);
            }
        }
        //filter by name
        if (isset($_GET['Name'])) {
            if ($_GET['Name'] != '') {
                $clients = $clients->where('Name','like','%'.$_GET['Name'].'%');
            }
        }
        //filter by phone
        if (isset($_GET['phone'])) {
            if ($_GET['phone'] != '') {
                $clients = $clients->where('phone',$_GET['phone']);
            }
        }
        //filter by cellphone
        if (isset($_GET['cellphone'])) {
            if ($_GET['cellphone'] != '') {
                $clients = $clients->where('cellphone',$_GET['cellphone']);
            }
        }
        //filter by whatsapp
        if (isset($_GET['whatsapp'])) {
            if ($_GET['whatsapp'] != '') {
                $clients = $clients->where('whatsapp',$_GET['whatsapp']);
            }
        }
        $clients = $clients->paginate(25);
        return view('AdminPanel.clients.noAgentClients',[
            'active' => 'noAgentClients',
            'title' => trans('common.noAgentClients'),
            'clients' => $clients,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.noAgentClients')
                ]
            ]
        ]);
    }

    public function changeAgent(Request $request)
    {
        $this->validate($request, [
            'clients' => 'required'
        ]);
        foreach ($request['clients'] as $key => $client) {
            $update = Clients::find($client)->update([
                'UID' => $request['AgentID']
            ]);
        }
        return redirect()->back()
                        ->with('success',trans('common.successMessageText'));
    }



    public function store(CreateClient $request)
    {

        if (!userCan('clients_create')) {
            return redirect()->back()
                                ->with('PopError', trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $service = Service::find($request->input('service_id'));
        $data['remaining_sessions'] = $service->sessions_count;
        $client = Clients::create($data);

        $days = [];
        // Check if the chosen service has a visiting count of "multiple"
        if ($request->input('service_id')) {
            $service = Service::find($request->input('service_id'));
            if ($service->visiting_count == 'multiple') {
                // Create two rows in the follow-ups table
                ClientFollowUps::create([
                    'ClientId' => $client->id,
                    'service_id' => $service->id,
                    'UID' => auth()->user()->id,
                    'session_number' => $request->input('session_number'),
                    'days' => implode(',', $request->input('days', [])),
                    // Add other necessary fields here
                ]);

                ClientFollowUps::create([
                    'ClientId' => $client->id,
                    'service_id' => $service->id,
                    'UID' => auth()->user()->id,
                    'days' => implode(',', $request->input('days', [])),
                    'session_number' => $request->input('session_number'),
                    // Add other necessary fields here
                ]);
            } else {
                // Create one row in the follow-ups table
                ClientFollowUps::create([
                    'ClientId' => $client->id,
                    'service_id' => $service->id,
                    'UID' => auth()->user()->id,
                    'days' => implode(',', $request->input('days', [])),
                    'session_number' => $request->input('session_number'),
                    // Add other necessary fields here
                ]);
            }
        }

        if ($client) {
            return redirect()->back()
                                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                                ->with('faild', trans('common.faildMessageText'));
        }
        // Excel::import(new ClientsImport($branch_id,$user_id), request()->file('excel'));
        // $request->session()->put('success', trans('Site.SavedSuccessfully'));
        // return back();
    }

    public function update(EditClient $request, $id)
    {
        if (!userCan('clients_edit')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);
        $update = Clients::find($id)->update($data);
        if ($update) {
            return redirect()->back()
            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
            ->with('faild',trans('common.faildMessageText'));
        }


    }

    public function delete($id)
    {
        if (!userCan('clients_delete')) {
            return Response::json("false");
        }
        $client = Clients::find($id);
        if ($client->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}

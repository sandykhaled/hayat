<?php

namespace App\Http\Controllers\admin\projectsUnits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Models\Units;
use App\Cities;
use Response;

class UnitsController extends Controller
{
    public function index()
    {
        //check if authenticated
        if (!userCan('units_view')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }

        //select from DB
        $units = units::orderBy('id','desc');
        //filter by id
        if (isset($_GET['id'])) {
            if ($_GET['id'] != '') {
                $units = $units->where('id',$_GET['id']);
            }
        }
        //filter by floor
        if (isset($_GET['floor'])) {
            if ($_GET['floor'] != '') {
                $units = $units->where('floor',$_GET['floor']);
            }
        }
        //filter by rooms
        if (isset($_GET['rooms'])) {
            if ($_GET['rooms'] != '') {
                $units = $units->where('rooms',$_GET['rooms']);
            }
        }
        //filter by bathroom
        if (isset($_GET['bathroom'])) {
            if ($_GET['bathroom'] != '') {
                $units = $units->where('bathroom',$_GET['bathroom']);
            }
        }
        //filter by Kitchen
        if (isset($_GET['Kitchen'])) {
            if ($_GET['Kitchen'] != '') {
                $units = $units->where('Kitchen',$_GET['Kitchen']);
            }
        }
        //filter by Price
        if (isset($_GET['PriceFrom']) || isset($_GET['PriceTo'])) {
            if ($_GET['PriceFrom'] != '' && $_GET['PriceTo'] != '') {
                $units = $units->where('Price','>=',$_GET['PriceFrom'])
                                ->where('Price','<=',$_GET['PriceFrom']);
            }
            if ($_GET['PriceFrom'] != '' && $_GET['PriceTo'] == '') {
                $units = $units->where('Price','>=',$_GET['PriceFrom']);
            }
            if ($_GET['PriceFrom'] == '' && $_GET['PriceTo'] != '') {
                $units = $units->where('Price','<=',$_GET['PriceTo']);
            }
        }
        //filter by space
        if (isset($_GET['spaceFrom']) || isset($_GET['spaceTo'])) {
            if ($_GET['spaceFrom'] != '' && $_GET['spaceTo'] != '') {
                $units = $units->where('space','>=',$_GET['spaceFrom'])
                                ->where('space','<=',$_GET['spaceFrom']);
            }
            if ($_GET['spaceFrom'] != '' && $_GET['spaceTo'] == '') {
                $units = $units->where('space','>=',$_GET['spaceFrom']);
            }
            if ($_GET['spaceFrom'] == '' && $_GET['spaceTo'] != '') {
                $units = $units->where('space','<=',$_GET['spaceTo']);
            }
        }
        //filter by city
        if (isset($_GET['city'])) {
            if ($_GET['city'] != 'all') {
                $units = $units->where('CityID',$_GET['city']);
            }
        }
        //filter by name
        if (isset($_GET['name'])) {
            if ($_GET['name'] != '') {
                $units = $units->where('name','like','%' . $_GET['name'] . '%');
            }
        }
        $units = $units->paginate(50);

        return view('AdminPanel.projectsUnits.units.index',[
            'active' => 'units',
            'title' => trans('common.units'),
            'units' => $units,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.units')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('units_create')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token','images']);
        $data['GovernorateID'] = Cities::find($request['CityID'])->GovernorateID;
        $data['UID'] = auth()->user()->id;

        $unit = units::create($data);

        if ($request->images != '') {
            $Files = [];
            if ($request->hasFile('images')) {
                foreach ($request->images as $file) {
                    $Files[] = upload_image_without_resize('units/'.$unit->id , $file );
                }
                $unit['files'] = base64_encode(serialize($Files));
                $unit->update();
            }
        }
        if ($unit) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function view($id)
    {
        //check if authenticated
        if (!userCan('units_view')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }

        //select from DB
        $project = units::find($id);

        return view('AdminPanel.projectsUnits.units.view',[
            'active' => 'units',
            'title' => trans('common.units'),
            'project' => $project,
            'breadcrumbs' => [
                [
                    'url' => route('admin.units'),
                    'text' => trans('common.units')
                ],
                [
                    'url' => '',
                    'text' => trans('common.details').': '.$project->name
                ]
            ]
        ]);
    }

    public function edit($id)
    {
        //check if authenticated
        if (!userCan('units_edit')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }

        //select from DB
        $project = units::find($id);

        return view('AdminPanel.projectsUnits.units.edit',[
            'active' => 'units',
            'title' => trans('common.units'),
            'project' => $project,
            'breadcrumbs' => [
                [
                    'url' => route('admin.units'),
                    'text' => trans('common.units')
                ],
                [
                    'url' => '',
                    'text' => trans('common.details').': '.$project->name
                ]
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!userCan('units_edit')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        $project = units::find($id);
        $data = $request->except(['_token','files']);
        $data['GovernorateID'] = Cities::find($request['CityID'])->GovernorateID;

        if ($request->images != '') {
            if ($project->images != '') {
                $Files = unserialize(base64_decode($project->images));
            } else {
                $Files = [];
            }
            if ($request->hasFile('images')) {
                foreach ($request->images as $file) {
                    $Files[] = upload_image_without_resize('units/'.$id , $file );
                }
                $data['images'] = base64_encode(serialize($Files));
            }
        }

        $update = units::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function deletePhoto($id,$photo,$X)
    {
        if (!userCan('units_delete_photo')) {
            return Response::json("false");
        }
        $project = units::find($id);
        $Files = [];
        if ($project->images != '') {
            $Files = unserialize(base64_decode($project->images));
        }
        if (in_array($photo,$Files)) {
            delete_image('uploads/units/'.$id , $photo);
            if (($key = array_search($photo, $Files)) !== false) {
                unset($Files[$key]);
            }
            $project['images'] = base64_encode(serialize($Files));
            $project->update();
            return Response::json('photo_'.$X);
        }
        return Response::json("false");
    }

    public function delete($id)
    {
        if (!userCan('units_delete')) {
            return Response::json("false");
        }
        $project = units::find($id);
        if ($project->delete()) {
            delete_folder('uploads/units/'.$id);
            return Response::json($id);
        }
        return Response::json("false");
    }

}
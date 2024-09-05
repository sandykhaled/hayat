<?php

namespace App\Http\Controllers\admin\hr;

use Illuminate\Http\Request;
use App\Models\SalariesDeductions;
use App\Http\Controllers\Controller;

class DeductionsController extends Controller
{
    //

    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $data['Status'] = 'Done';
        $data['month'] = date('m',strtotime($request['DeductionDate']));
        $data['year'] = date('Y',strtotime($request['DeductionDate']));
        $data['UID'] = auth()->user()->id;

        $deduction = SalariesDeductions::create($data);
        if ($deduction) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function delete($id)
    {
        $deduction = SalariesDeductions::find($id);
        if ($deduction->delete()) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
}
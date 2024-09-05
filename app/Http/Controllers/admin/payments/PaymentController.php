<?php

namespace App\Http\Controllers\admin\payments;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Revenues;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        if (!userCan('branches_view')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }



        $payments = Payment::orderBy('package','asc')->paginate(25);
        return view('AdminPanel.payments.index',[
            'active' => 'payment',
            'title' => trans('common.payment'),
            'payments' => $payments,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.payment')
                ]
            ]
        ]);
    }

     public function details($id)
    {
        {
            $client = Clients::find($id);

            if (!$client) {
                // Client not found, redirect to a 404 page or display an error message
                abort(404, 'Client not found');
            }

            $payments = Payment::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            if (!$payments) {
                // No payments found, display a message or redirect to a default page
                $payment = null; // or redirect to a default page
            }


            $route = route('admin.payments.details', $client->id);
            $title = trans('common.payments');
            $active = 'payment';

            return view('AdminPanel.payments.details', [
                'active' => $active,
                'title' => $title,
                'payments' => $payments,
                'breadcrumbs' => [
                    [
                        'url' => $route,
                        'text' => $title
                    ],
                    [
                        'url' => '#',
                        'text' => trans('common.details')
                    ]
                ]
            ]);
    }



    }

    public function store(Request $request)
    {
        if (!userCan('payments_create')) {
            return redirect()->back()
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }
        // ...

        $rules = [
            'package' => 'required|string',
            'full_amount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'remaining_amount' => 'required|numeric',
            'session_number' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
        ];


        $validator = Validator::make($request->except('_token'), $rules);

        if ($request->full_amount != $request->amount_paid + $request->remaining_amount) {
            return redirect()->back()
                                ->with('faild', trans('common.faildMessageText') . ': ' . trans('common.invalidAmounts'));
        }



        $payment = Payment::create($request->only([
            'package', 'full_amount', 'amount_paid', 'remaining_amount', 'session_number', 'client_id'
        ])  + [
            'client_id'=> $request->client_id,
        ]);;


        if ($payment) {

            $revenue = new Revenues();
            $revenue->amount = $request->amount_paid;
            $revenue->UID = auth()->user()->id;
            $revenue->Type = 'revenues';
            $revenue->Date = date('Y-m-d');
            $revenue->month = date('m');
            $revenue->year = date('Y');
            $revenue->client_id = $request->client_id;
            $revenue->save();
        }



        if ($payment) {
            return redirect()->back()
                                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                                ->with('faild', trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('payments_update')) {
            return redirect()->back()
                                ->with('PopError', trans('common.youAreNotAuthorized'));
        }

        $payment = Payment::find($request->id);

        if (!$payment) {
            return redirect()->back()
                                ->with('faild', trans('common.faildMessageText'));
        }

        $rules = [
            'package' => 'required|string',
            'full_amount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'remaining_amount' => 'required|numeric',
            'session_number' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
        ];

        $validator = Validator::make($request->except('_token'), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                                ->withInput()
                                ->withErrors($validator);
        }

        $payment->package = $request->package;
        $payment->full_amount = $request->full_amount;
        $payment->amount_paid = $request->amount_paid;
        $payment->remaining_amount = $request->remaining_amount;
        $payment->session_number = $request->session_number;
        $payment->client_id = $request->client_id;




        if ($payment->save()) {
            return redirect()->back()
                                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                                ->with('faild', trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        if (!userCan('Payments_delete')) {
            return Response::json("false");
        }
        $payment = Payment::find($id);
        if ($payment->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}


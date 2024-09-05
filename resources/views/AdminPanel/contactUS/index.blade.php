@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead>
                            <tr>
                              <th>#</th>
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.email')}}</th>
                                <th>{{trans('common.phone')}}</th>
                                <th>{{trans('common.subject')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                            <tr id="row_{{$message->id}}">
                              <td>{{$loop->iteration}}</td>
                                <td>{{$message->name}}</td>
                                <td>{{$message->email}}</td>
                                <td>{{$message->phone}}</td>
                              <td>
                                  <a href="{{route('admin.contactus.details',['id'=>$message->id])}}">
                                      {{$message['message'] != '' ? $message['message'] : '-'}}<br>

                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php $delete = route('admin.contactus.delete',['id'=>$message->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$message->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <!-- Bordered table end -->



@stop

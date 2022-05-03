@extends('layouts.app')
@section('head','index')
@section('page_title','Settings')
@section('content')

    <div class="card-body">

        @include('partials.validation_errors')
        @if(count($settings))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    {{--                    <th scope="col">order</th>--}}
                    <th scope="col">About</th>
                    <th scope="col">social media</th>
                    <th scope="col">Account Restaurant</th>
                    <th scope="col">paid</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($settings as $setting)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        {{--                        <td>{{$order->name}}</td>--}}
                        <td>{{$setting->about_app}}</td>
                        <td>{{$setting->social_media}}</td>
                        <td>{{$setting->account_restaurant}}</td>
                        <td>{{$setting->paid}}</td>
                        <td>
                            @can('Setting')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$setting->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan

                        </td>
                    </tr>

                    {{--          Delete Modal                    --}}
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$setting->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($setting,[
                                    'route'=>['setting.destroy',$setting->id],
                                    'method'=>'delete',
                                       ]) !!}

                                    <div class="form-group">
                                        <h4>Are You Sure?</h4>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    {!! Form::close()!!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert.danger" role="alert">
                No Data
            </div>
        @endif
    </div>

@endsection








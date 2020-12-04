@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Report #{{$user->u_first_name . ' ' . $user->u_second_name}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="card m-b-30">
            <br>
            @foreach ($data as $key=>$value)
            @if ($value->h_from == 0)
            <div class="row ">
                <div class="col-8 ">
                    <div class="card bg-success m-l-10">
                        <div class="card-body">
                            <p class="card-text">{{$value->h_info}}</p>
                            <p class="card-text">
                                <small class="text-muted float-right">{{ date("F j, Y, g:i a", strtotime($value->created_at))  }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row justify-content-end">
                <div class="col-8">
                    <div class="card bg-primary m-r-10">
                        <div class="card-body">
                            <p class="card-text">{{$value->h_info}}</p>
                            <p class="card-text">
                                <small class="text-muted">{{ date("F j, Y, g:i a", strtotime($value->created_at))  }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="col-4">
        <div class="card m-b-30">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="mdi mdi-checkbox-marked-circle font-32"></i><strong class="pr-1">Success !</strong>
                    {{session('success')}}
                </div>
                @endif
                @if(count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="mdi mdi-close-circle font-32"></i><strong class="pr-1">Error !</strong> {{$error}}
                </div>
                @endforeach
                @endif
                <form action="{{route('dashboard.support.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <textarea class="form-control {{ $errors->has('report')? 'is-invalid' : '' }}"
                                placeholder="Message" name="report" cols="30" rows="10"></textarea>
                            @if($errors->has('report'))
                            <div class="invalid-feedback">
                                {{ $errors->first('report') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="user" value="{{$user->id}}">
                    <div class="form-group text-right row m-t-20">
                        <div class="col-12">
                            <button type="submit" style="width: 100%"  class="btn btn-primary waves-effect waves-light">Send</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>


@endsection
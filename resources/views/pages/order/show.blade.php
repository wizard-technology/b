@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
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
            <h4 class="page-title">Order ID #{{$data[0]->c_doc_id}}</h4>
            <h5 class="page-title">Name :{{$data[0]->user->u_first_name}} {{$data[0]->user->u_second_name}}</h4>
            <h5 class="page-title">Phone :{{$data[0]->user->u_phone}}</h4>
            <a class="btn btn-primary btn-lg mr-3 {{$data[0]->c_state == 1 ? 'disabled' : ''}}"
                href="{{route('dashboard.order.change_state',['id'=>$data[0]->c_doc_id,'type'=>'finish'])}}">Finish</a>
            <a class="btn btn-info btn-lg mr-3 {{$data[0]->c_state == 2 ? 'disabled' : ''}}"
                href="{{route('dashboard.order.change_state',['id'=>$data[0]->c_doc_id,'type'=>'pending'])}}">Pending</a>
            <a class="btn btn-danger btn-lg mr-3 {{$data[0]->c_state == 3 ? 'disabled' : ''}}"
                href="{{route('dashboard.order.change_state',['id'=>$data[0]->c_doc_id,'type'=>'reject'])}}">Reject</a>
            <a class="btn btn-success btn-lg mr-3 {{$data[0]->c_state == 4 ? 'disabled' : ''}}"
                href="{{route('dashboard.order.change_state',['id'=>$data[0]->c_doc_id,'type'=>'accept'])}}">Accept</a>
        </div>
    </div>
</div>
<div class="row">
    @foreach ($data as $key => $value)
    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$value->product->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$value->product->p_name}}</h4>
                <p class="card-text">{{$value->product->p_info}}</p>
                <p class="card-text">
                    <small class="text-muted">Amount :{{$value->c_amount}}</small>
                    <br>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Rejected Order</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
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

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('dashboard.order.index')}}">Pending Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dashboard.order.finished')}}">Finished Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('dashboard.order.rejected')}}">Rejected Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('dashboard.order.accept')}}">Accept Order</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="cat" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Rejected Order table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document ID</th>
                                                    <th>Price All</th>
                                                    <th>Amount</th>
                                                    <th>User</th>
                                                    <th>User Phone</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$value)
                                                <tr>

                                                    <td>{{++$key}}</td>
                                                    <td>{{$value->c_doc_id}}</td>
                                                    <td>${{$value->c_price_all}}</td>
                                                    <td>{{$value->c_amount}}</td>
                                                    <td>{{$value->user->u_first_name}} {{$value->user->u_second_name}}
                                                    </td>
                                                    <td>{{$value->user->u_phone}}
                                                    </td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td>
                                                        <div class="btn-group m-b-10">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Actions</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{route('dashboard.order.show',$value->c_doc_id)}}">Show Order</a>
                                                                <a class="dropdown-item" href="{{route('dashboard.order.change_state',['id'=>$value->c_doc_id,'type'=>'finish'])}}">Finish</a>
                                                                <a class="dropdown-item" href="{{route('dashboard.order.change_state',['id'=>$value->c_doc_id,'type'=>'pending'])}}">Pending</a>
                                                                <a class="dropdown-item" href="{{route('dashboard.order.change_state',['id'=>$value->c_doc_id,'type'=>'accept'])}}">Accept</a>

                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.order.cart_delete',$value->c_doc_id)}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">Delete</button>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
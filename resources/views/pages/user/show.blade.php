@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">User #{{$data->u_first_name . ' ' . $data->u_second_name}}</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#bizz" role="tab">Bizz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#chart" role="tab">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#analays" role="tab">Analays</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="cat" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Orders table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Document Number</th>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Price</th>
                                                    <th>Price All</th>
                                                    <th>State</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->cart as $key=>$value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>#{{$value->c_doc_id}}</td>
                                                    <td>{{$value->product->p_name}} / {{$value->product->p_name_ku}}
                                                    </td>
                                                    <td>{{$value->c_amount}}</td>
                                                    <td>{{$value->c_price}} $</td>
                                                    <td>{{$value->c_price_all}} $</td>
                                                    <td>
                                                        {!! $value->c_state == 0 ? '<span
                                                            class="badge bg-success badge-pill">In Cart</span>' : '
                                                        <span class="badge bg-primary badge-pill">Bought</span>' !!}
                                                    </td>
                                                    <td><img src="{{asset('storage/'.$value->product->p_image)}}" alt="" class="w-30"></td>
                                                    <td>{{$value->updated_at}}</td>


                                                    <td>
                                                        <div class="btn-group m-b-10">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Actions</button>
                                                            <div class="dropdown-menu">
                                                                <form
                                                                    action="{{route('dashboard.cart.destroy',$value->id)}}"
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

                    <div class="tab-pane p-3" id="bizz" role="tabpanel">
                        <p class="font-14 mb-0">
                            Coming Soon ..
                        </p>
                    </div>
                    <div class="tab-pane p-3" id="chart" role="tabpanel">
                        <p class="font-14 mb-0">
                            Coming Soon ..
                        </p>
                    </div>
                    <div class="tab-pane p-3" id="analays" role="tabpanel">
                        <p class="font-14 mb-0">
                            Coming Soon ..
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
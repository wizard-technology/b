@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Users</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All User</a>
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

                                        <h4 class="mt-0 header-title">User table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <th>First Name</th>
                                                    <th>Second Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Verification Code</th>
                                                    <th>City</th>
                                                    <th>Verified At</th>
                                                    <th>State</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key=>$value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->u_first_name}}</td>
                                                    <td>{{$value->u_second_name}}</td>
                                                    <td>{{$value->u_phone}}</td>
                                                    <td>{{$value->u_email}}</td>
                                                    <td>{{$value->u_code}}</td>
                                                    <td>{{$value->u_city}}</td>
                                                    <td>{{$value->u_phone_verified_at}}</td>
                                                    <td>
                                                        @switch($value->u_state)
                                                        @case(0)
                                                        <span class="badge bg-success badge-pill">Pending</span>
                                                        @break
                                                        @case(1)
                                                        <span class="badge bg-primary badge-pill">Active</span>
                                                        @break
                                                        @case(2)
                                                        <span class="badge bg-danger badge-pill">Disable</span>
                                                        @break
                                                        @default
                                                        1
                                                        @endswitch
                                                    </td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td>{{$value->updated_at}}</td>


                                                    <td>
                                                        <div class="btn-group m-b-10">

                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Actions</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{route('dashboard.user.show',$value->id)}}">Show</a>
                                                                <a class="dropdown-item"
                                                                    href="{{route('dashboard.support.show',$value->id)}}">Chat</a>
                                                                <a class="dropdown-item"
                                                                    href="{{route('dashboard.user.edit',$value->id)}}">{{ $value->u_state == 1 ? 'Disable' :'Active'}}</a>
                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.user.destroy',$value->id)}}"
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

                                                <div class="modal fade bd-example-modal-form-{{$value->id}}"
                                                    tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                    aria-hidden="true">
                                                    <form action="{{route('dashboard.user.update',$value->id)}}"
                                                        method="post">
                                                        @method('PUT')

                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalform">Update
                                                                        user #{{$value->id}}</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true"
                                                                            class="text-dark">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @csrf
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="first name"
                                                                                placeholder="First Name"
                                                                                value="{{$value->u_first_name}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="second name"
                                                                                placeholder="Second Name"
                                                                                value="{{$value->u_second_name}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="email"
                                                                                name="email" placeholder="Email"
                                                                                value="{{$value->u_email}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="phone" placeholder="Phone"
                                                                                value="{{$value->u_phone}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="code" placeholder="Code"
                                                                                value="{{$value->u_code}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-0 row">
                                                                        <div class="col-md-9">
                                                                            <div class="form-check-inline my-1">
                                                                                <div
                                                                                    class="custom-control custom-radio">
                                                                                    <input type="radio" value="0"
                                                                                        id="customRadio4"
                                                                                        {{$value->u_state == 0 ? 'checked' : ''}}
                                                                                        name="state"
                                                                                        class="custom-control-input">
                                                                                    <label class="custom-control-label"
                                                                                        for="customRadio4">Pending</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-check-inline my-1">
                                                                                <div
                                                                                    class="custom-control custom-radio">
                                                                                    <input type="radio" value="1"
                                                                                        id="customRadio5"
                                                                                        {{$value->u_state == 1 ? 'checked' : ''}}
                                                                                        name="state"
                                                                                        class="custom-control-input">
                                                                                    <label class="custom-control-label"
                                                                                        for="customRadio5">Active</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-check-inline my-1">
                                                                                <div
                                                                                    class="custom-control custom-radio">
                                                                                    <input type="radio" value="2"
                                                                                        id="customRadio6"
                                                                                        {{$value->u_state == 2 ? 'checked' : ''}}
                                                                                        name="state"
                                                                                        class="custom-control-input">
                                                                                    <label class="custom-control-label"
                                                                                        for="customRadio6">Disable</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit"
                                                                        class="btn btn-raised btn-primary ml-2">Update</button>
                                                                    <button type="button"
                                                                        class="btn btn-raised btn-danger"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

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
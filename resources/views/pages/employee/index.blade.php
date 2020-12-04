@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Admins</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Create Admin</a>
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

                                        <h4 class="mt-0 header-title">Admin table</h4>
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
                                                                    href="{{route('dashboard.employee.edit',$value->id)}}">{{ $value->u_state == 1 ? 'Disable' :'Active'}}</a>
                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.employee.destroy',$value->id)}}"
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
                                                    <form action="{{route('dashboard.employee.update',$value->id)}}"
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
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="password" placeholder="Password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="password confirmation"
                                                                                placeholder="Password Confirmation">
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
                                                                    <div class="form-group mb-0 row">
                                                                        <div class="col-md-9">
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'index' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="index"
                                                                                        class="custom-control-input"
                                                                                        id="index">
                                                                                    <label class="custom-control-label"
                                                                                        for="index">Dashboard</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'company' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="company"
                                                                                        class="custom-control-input"
                                                                                        id="company">
                                                                                    <label class="custom-control-label"
                                                                                        for="company">Company</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'type' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="type"
                                                                                        class="custom-control-input"
                                                                                        id="category">
                                                                                    <label class="custom-control-label"
                                                                                        for="category">Category</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'product' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="product"
                                                                                        class="custom-control-input"
                                                                                        id="product">
                                                                                    <label class="custom-control-label"
                                                                                        for="product">Product</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'card' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="card"
                                                                                        class="custom-control-input"
                                                                                        id="card">
                                                                                    <label class="custom-control-label"
                                                                                        for="card">Card</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'support' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="support"
                                                                                        class="custom-control-input"
                                                                                        id="support">
                                                                                    <label class="custom-control-label"
                                                                                        for="support">Support</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'employee' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="employee"
                                                                                        class="custom-control-input"
                                                                                        id="employee">
                                                                                    <label class="custom-control-label"
                                                                                        for="employee">Employee</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'city' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="city"
                                                                                        class="custom-control-input"
                                                                                        id="city">
                                                                                    <label class="custom-control-label"
                                                                                        for="city">City</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'user' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="user"
                                                                                        class="custom-control-input"
                                                                                        id="user">
                                                                                    <label class="custom-control-label"
                                                                                        for="user">User</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'profile' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="profile"
                                                                                        class="custom-control-input"
                                                                                        id="profile">
                                                                                    <label class="custom-control-label"
                                                                                        for="profile">Profile</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'tag' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="tag"
                                                                                        class="custom-control-input"
                                                                                        id="hashtag">
                                                                                    <label class="custom-control-label"
                                                                                        for="hashtag">Hashtag</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'order' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="order"
                                                                                        class="custom-control-input"
                                                                                        id="orders">
                                                                                    <label class="custom-control-label"
                                                                                        for="orders">Orders</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'setting' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="setting"
                                                                                        class="custom-control-input"
                                                                                        id="setting">
                                                                                    <label class="custom-control-label"
                                                                                        for="setting">Setting</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'bizzcoin' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="bizzcoin"
                                                                                        class="custom-control-input"
                                                                                        id="bizzcoin">
                                                                                    <label class="custom-control-label"
                                                                                        for="bizzcoin">Bizzcoin</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'subcategory' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="subcategory"
                                                                                        class="custom-control-input"
                                                                                        id="subcategory">
                                                                                    <label class="custom-control-label"
                                                                                        for="subcategory">Subcategory</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="checkbox my-2">
                                                                                <div
                                                                                    class="custom-control custom-checkbox">
                                                                                    <input type="checkbox"
                                                                                        name="access[]"
                                                                                        {{ in_array( 'grouped' ,json_decode($value->admin->a_access)) ? 'checked' : ''}}
                                                                                        value="grouped"
                                                                                        class="custom-control-input"
                                                                                        id="grouped">
                                                                                    <label class="custom-control-label"
                                                                                        for="grouped">Grouped</label>
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
                    <div class="tab-pane p-3" id="create" role="tabpanel">
                        <form action="{{route('dashboard.employee.store')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('first_name')? 'is-invalid' : '' }}"
                                        type="text" name="first name" placeholder="First Name"
                                        value="{{old('first_name')}}">
                                    @if($errors->has('first_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('first_name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('second_name')? 'is-invalid' : '' }}"
                                        type="text" name="second name" placeholder="Second Name"
                                        value="{{old('second_name')}}">
                                    @if($errors->has('second_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('second_name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('email')? 'is-invalid' : '' }}"
                                        type="email" name="email" placeholder="Email" value="{{old('email')}}">
                                    @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('phone')? 'is-invalid' : '' }}"
                                        type="text" name="phone" placeholder="Phone" value="{{old('phone')}}">
                                    @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}"
                                        type="text" name="password" placeholder="Password" value="{{old('password')}}">
                                    @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input
                                        class="form-control {{ $errors->has('password_confirmation')? 'is-invalid' : '' }}"
                                        type="text" name="password confirmation" placeholder="Password Confirmation"
                                        value="{{old('password_confirmation')}}">
                                    @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-0 row">
                                <div class="col-md-9">
                                    <div class="form-check-inline my-1">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="0" id="customRadio42" checked name="state"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio42">Pending</label>
                                        </div>
                                    </div>
                                    <div class="form-check-inline my-1">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="1" id="customRadio52" name="state"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio52">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-check-inline my-1">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="2" id="customRadio62" name="state"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="customRadio62">Disable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 row">
                                <div class="col-md-9">
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="index"
                                                class="custom-control-input" id="index2">
                                            <label class="custom-control-label" for="index2">Dashboard</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="company"
                                                class="custom-control-input" id="company2">
                                            <label class="custom-control-label" for="company2">Company</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="type"
                                                class="custom-control-input" id="category2">
                                            <label class="custom-control-label" for="category2">Category</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="product"
                                                class="custom-control-input" id="product2">
                                            <label class="custom-control-label" for="product2">Product</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="card"
                                                class="custom-control-input" id="card2">
                                            <label class="custom-control-label" for="card2">Card</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="support"
                                                class="custom-control-input" id="support2">
                                            <label class="custom-control-label" for="support2">Support</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="employee"
                                                class="custom-control-input" id="employee2">
                                            <label class="custom-control-label" for="employee2">Employee</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="city"
                                                class="custom-control-input" id="city2">
                                            <label class="custom-control-label" for="city2">City</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="user"
                                                class="custom-control-input" id="user2">
                                            <label class="custom-control-label" for="user2">User</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="profile"
                                                class="custom-control-input" id="profile2">
                                            <label class="custom-control-label" for="profile2">Profile</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="tag"
                                                class="custom-control-input" id="hashtag2">
                                            <label class="custom-control-label" for="hashtag2">Hashtag</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="order"
                                                class="custom-control-input" id="orders2">
                                            <label class="custom-control-label" for="orders2">Orders</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="setting"
                                                class="custom-control-input" id="setting2">
                                            <label class="custom-control-label" for="setting2">Setting</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="bizzcoin"
                                                class="custom-control-input" id="bizzcoin2">
                                            <label class="custom-control-label" for="bizzcoin2">Bizzcoin</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="subcategory"
                                                class="custom-control-input" id="subcategory2">
                                            <label class="custom-control-label" for="subcategory2">Subcategory</label>
                                        </div>
                                    </div>
                                    <div class="checkbox my-2">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="access[]" checked value="grouped"
                                                class="custom-control-input" id="grouped2">
                                            <label class="custom-control-label" for="grouped2">Grouped</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right row m-t-20">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                                </div>
                            </div>
                        </form>
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
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Company</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Companies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Create Company</a>
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

                                        <h4 class="mt-0 header-title">Companies table</h4>
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
                                                    <th>City</th>
                                                    <th>Updated By</th>
                                                    <th>State</th>
                                                    <th>Company Name</th>
                                                    <th>Company Phone</th>
                                                    <th>Company Address</th>
                                                    <th>Company Info</th>
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
                                                    <td>{{$value->city->ct_name}} / {{$value->city->ct_name_ku}}</td>
                                                    <td>{{$value->company->admin->u_first_name}} {{$value->company->admin->u_second_name}}</td>
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
                                                    <td>{{$value->company->co_name}}</td>
                                                    <td>{{$value->company->co_phone}}</td>
                                                    <td>{{$value->company->co_address}}</td>
                                                    <td>{{$value->company->co_info}}</td>
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
                                                                    href="{{route('dashboard.company.edit',$value->id)}}">{{ $value->u_state == 1 ? 'Disable' :'Active'}}</a>
                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                            <a class="dropdown-item" href="{{route('dashboard.company.show',$value->id)}}" >Show</a>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.company.destroy',$value->id)}}"
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
                                                    <form action="{{route('dashboard.company.update',$value->id)}}"
                                                        method="post" enctype="multipart/form-data">
                                                        @method('PUT')

                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalform">Update
                                                                        Company #{{$value->id}}</h5>
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
                                                                            <input class="form-control"
                                                                                type="text" name="company name" placeholder="Company Name"
                                                                                value="{{$value->company->co_name}}">
                                                                            
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
                                                                                name="phone account" placeholder="Phone Account"
                                                                                value="{{$value->u_phone}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                name="phone company" placeholder="Phone Company"
                                                                                value="{{$value->company->co_phone}}">

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
                                                                    <div class="form-group row">

                                                                        <div class="col-sm-12">
                                                                            <select name="city" class="form-control">
                                                                                @foreach ($city as $key=>$ct)
                                                                                <option value="{{$ct->id }}" {{$ct->id == $value->u_city ? 'selected' : ''}}>
                                                                                    {{$ct->ct_name}} /
                                                                                    {{$ct->ct_name_ku }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control"
                                                                                type="text" name="address" placeholder="Address" value="{{$value->company->co_address}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control"
                                                                                name="information" placeholder="Information" cols="5"
                                                                                rows="10">{{$value->company->co_info}}</textarea>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-2 col-form-label">Picture</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="file"
                                                                                id="actual-upload-{{$value->company->id}}"
                                                                                onchange="readURLS(this,{{$value->company->id}});"
                                                                                name="imgs" style="display: none">
                                                                            <div class="pull-right"
                                                                                id="upload-{{$value->company->id}}"
                                                                                onclick="clickFileChooser({{$value->company->id}})"
                                                                                style="height: 200px;width: 200px;background-image: url({{asset('storage/'.$value->company->co_image) }});background-size: contain;background-repeat: no-repeat;">
                                                                            </div>
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
                    <div class="tab-pane p-3" id="create" role="tabpanel">
                        <form action="{{route('dashboard.company.store')}}" method="post" enctype="multipart/form-data">
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
                                    <input class="form-control {{ $errors->has('company_name')? 'is-invalid' : '' }}"
                                        type="text" name="company name" placeholder="Company Name"
                                        value="{{old('company_name')}}">
                                    @if($errors->has('company_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company_name') }}
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
                                    <input class="form-control {{ $errors->has('phone_account')? 'is-invalid' : '' }}"
                                        type="text" name="phone account" placeholder="Phone Account"
                                        value="{{old('phone_account')}}">
                                    @if($errors->has('phone_account'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone_account') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('phone_company')? 'is-invalid' : '' }}"
                                        type="text" name="phone company" placeholder="Phone Company"
                                        value="{{old('phone_company')}}">
                                    @if($errors->has('phone_company'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone_company') }}
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
                            <div class="form-group row">

                                <div class="col-sm-12">
                                    <select name="city" class="form-control">
                                        @foreach ($city as $key=>$ct)
                                        <option value="{{$ct->id }}">
                                            {{$ct->ct_name}} /
                                            {{$ct->ct_name_ku }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('address')? 'is-invalid' : '' }}"
                                        type="text" name="address" placeholder="Address" value="{{old('address')}}">
                                    @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <textarea class="form-control {{ $errors->has('information')? 'is-invalid' : '' }}"
                                        name="information" placeholder="Information" cols="5"
                                        rows="10">{{old('information')}}</textarea>
                                    @if($errors->has('information'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('information') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-12">
                                    <input type="file" id="actual-upload" onchange="readURL(this);" name="imgs"
                                        style="display: none">
                                    <div class="pull-right" id="upload"
                                        style="height: 200px;width: 200px;background-image: url({{ asset('assets/images/logo.png') }});background-size: contain;background-repeat: no-repeat;">
                                    </div>
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
<script>
    document.getElementById('upload').onclick = function() {
    document.getElementById('actual-upload').click();
};
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#upload').css("background-image", "url("+ e.target.result + ")");
        };
        reader.readAsDataURL(input.files[0]);
    }else{
            $('#upload').css("background-image", "url({{asset('assets/images/logo.png') }})");
        reader.readAsDataURL(null);
    }
}
function clickFileChooser(id) {
    document.getElementById('actual-upload-'+id).click();
}
function readURLS(input,id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#upload-'+id).css("background-image", "url("+ e.target.result + ")");
        };
        reader.readAsDataURL(input.files[0]);
    }else{
            $('#upload'+id).css("background-image", "url({{asset('assets/images/logo.png') }})");
        reader.readAsDataURL(null);
    }
}
</script>
@endsection
@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Profile</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">Change Information</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Change Information</a>
                    </li> 
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#chart" role="tab">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#analays" role="tab">Analays</a>
                    </li> --}}
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="cat" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{route('dashboard.profile.update',1)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" name="first name"
                                                        placeholder="First Name" value="{{$data->u_first_name}}">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <input class="form-control" type="text" name="second name"
                                                        placeholder="Second Name" value="{{$data->u_second_name}}">

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <button type="submit"
                                                        class="btn btn-raised btn-primary float-right">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{route('dashboard.profile.update',2)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <input
                                                        class="form-control {{ $errors->has('old_password')? 'is-invalid' : '' }}"
                                                        type="text" name="old password"
                                                        placeholder="Old Password">
                                                    @if($errors->has('old_password'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('old_password') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <input
                                                        class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}"
                                                        type="text" name="password"
                                                        placeholder=" New Password">
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
                                                        type="text" name="password confirmation"
                                                        placeholder="Confirm New Password">
                                                    @if($errors->has('password_confirmation'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('password_confirmation') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <button type="submit"
                                                        class="btn btn-raised btn-primary float-right">Change Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                    {{-- <div class="tab-pane p-3" id="create" role="tabpanel">
                        <form action="{{route('dashboard.tag.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}" type="text"
                                required="" name="name" placeholder="Name" value="{{old('name')}}">
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control {{ $errors->has('name_kurdish')? 'is-invalid' : '' }}"
                                type="text" required="" name="name kurdish" dir="rtl" placeholder="ناو"
                                value="{{old('name_kurdish')}}">
                            @if($errors->has('name_kurdish'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name_kurdish') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="checkbox my-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="state" id="customCheck"
                                data-parsley-multiple="groups" data-parsley-mincheck="2">
                            <label class="custom-control-label" for="customCheck">Publish</label>
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
                </div> --}}
            </div>

        </div>
    </div>
</div>
</div>

@endsection
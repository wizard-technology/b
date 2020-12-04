@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Card</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Card</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Create Card</a>
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

                                        <h4 class="mt-0 header-title">Card table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Code</th>
                                                    <th>Price</th>
                                                    <th>State</th>
                                                    <th>Created By</th>
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
                                                    <td>{{$value->product->p_name}} / {{$value->product->p_name_ku}}
                                                    </td>
                                                    <td>{{$value->ci_code}}</td>
                                                    <td>{{$value->product->p_price}} $</td>
                                                    @if ($value->ci_state == 0)
                                                    <td>
                                                        <span class="badge bg-danger badge-pill">Inactive</span>
                                                    </td>
                                                    @endif
                                                    @if ($value->ci_state == 1)
                                                    <td>
                                                        <span class="badge bg-warning badge-pill">Active</span>
                                                    </td>
                                                    @endif
                                                    @if ($value->ci_state == 2)
                                                    <td>
                                                        <span class="badge bg-primary badge-pill">Used</span>
                                                    </td>
                                                    @endif
                                                    <td>{{$value->admin->u_first_name}} {{$value->admin->u_second_name}}
                                                    </td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td>{{$value->updated_at}}</td>
                                                    <td>
                                                        @if ($value->ci_state == 1 || $value->ci_state == 0)
                                                        <div class="btn-group m-b-10">
                                                            <button type="button"
                                                                class="btn btn-primary dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Actions</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{route('dashboard.card.edit',$value->id)}}">{{ $value->p_state == 1 ? 'Inactive' :'Active'}}</a>

                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.card.destroy',$value->id)}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">Delete</button>
                                                                </form>

                                                            </div>
                                                        </div>
                                                        @else
                                                        Done
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($value->ci_state == 1 || $value->ci_state == 0)
                                                <div class="modal fade bd-example-modal-form-{{$value->id}}"
                                                    tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                    aria-hidden="true">
                                                    <form action="{{route('dashboard.card.update',$value->id)}}"
                                                        method="post">
                                                        @method('PUT')
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalform">Update
                                                                        Card #{{$value->id}}</h5>
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
                                                                                 required="" name="code"
                                                                                 placeholder="Code"
                                                                                 value="{{$value->ci_code}}">
                                                                         </div>
                                                                     </div>
                                                                  
                                                                 
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-2 col-form-label">Product</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="product"
                                                                                class="form-control">
                                                                                @foreach ($product as $key=>$pro)
                                                                                <option
                                                                                    {{$pro->id == $value->p_product ? 'selected' : ''}}
                                                                                    value="{{$pro->id }}">
                                                                                    {{$pro->p_name}} /
                                                                                    {{$pro->p_name_ku }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                  
                                                                  
                                                                    <div class="checkbox my-2">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="state"
                                                                                id="customCheck{{$value->id}}"
                                                                                data-parsley-multiple="groups"
                                                                                {{ $value->ci_state == 1 ?'checked' : '' }}
                                                                                data-parsley-mincheck="2">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck{{$value->id}}">Publish</label>
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
                                                @endif

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div>

                    <div class="tab-pane p-3" id="create" role="tabpanel">
                        <form action="{{route('dashboard.card.store')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('code')? 'is-invalid' : '' }}"
                                        type="text" required="" name="code" placeholder="Code" value="{{old('code')}}">
                                    @if($errors->has('code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('code') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product</label>
                                <div class="col-sm-10">
                                    <select name="product" class="form-control">
                                        @foreach ($product as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->p_name}} / {{$value->p_name_ku }}
                                        </option>
                                        @endforeach
                                    </select>
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
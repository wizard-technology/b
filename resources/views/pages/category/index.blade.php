@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Categories</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Create Category</a>
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

                                        <h4 class="mt-0 header-title">Category table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <th>Name English</th>
                                                    <th>Name Kurmanji</th>
                                                    <th>Name Kurdish</th>
                                                    <th>Name Arabic</th>
                                                    <th>Name Persian</th>
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
                                                    <td>{{$value->t_name}}</td>
                                                    <td>{{$value->t_name_kr}}</td>
                                                    <td>{{$value->t_name_ku}}</td>
                                                    <td>{{$value->t_name_ar}}</td>
                                                    <td>{{$value->t_name_pr}}</td>
                                                    <td>{!! $value->t_state == 1 ?'<span
                                                            class="badge bg-success badge-pill">Active</span>' :'<span
                                                            class="badge bg-danger badge-pill">Inactive</span>' !!}
                                                    </td>
                                                    <td>{{$value->admin->u_first_name}} {{$value->admin->u_second_name}}
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
                                                                    href="{{route('dashboard.type.edit',$value->id)}}">{{ $value->t_state == 1 ? 'Inactive' :'Active'}}</a>
                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.type.destroy',$value->id)}}"
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
                                                    <form action="{{route('dashboard.type.update',$value->id)}}"
                                                        method="post" enctype="multipart/form-data">
                                                        @method('PUT')

                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalform">Update
                                                                        Category #{{$value->id}}</h5>
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
                                                                                required="" name="name"
                                                                                placeholder="Name"
                                                                                id="tranlate_en_{{$value->id}}"
                                                                                value="{{$value->t_name}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name_kurmanji"
                                                                                placeholder="Nav"
                                                                                id="tranlate_kr_{{$value->id}}"
                                                                                value="{{$value->t_name_kr}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name kurdish"
                                                                                dir="rtl" placeholder="ناو"
                                                                                id="tranlate_ku_{{$value->id}}"
                                                                                value="{{$value->t_name_ku}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name arabic" dir="rtl"
                                                                                placeholder="اسم"
                                                                                id="tranlate_ar_{{$value->id}}"
                                                                                value="{{$value->t_name_ar}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name persian"
                                                                                dir="rtl" placeholder="نام"
                                                                                id="tranlate_pr_{{$value->id}}"
                                                                                value="{{$value->t_name_pr}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-2 col-form-label">Picture</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="file"
                                                                                id="actual-upload-{{$value->id}}"
                                                                                onchange="readURLS(this,{{$value->id}});"
                                                                                name="imgs" style="display: none">
                                                                            <div class="pull-right"
                                                                                id="upload-{{$value->id}}"
                                                                                onclick="clickFileChooser({{$value->id}})"
                                                                                style="height: 200px;width: 200px;background-image: url({{asset('storage/'.$value->t_image) }});background-size: contain;background-repeat: no-repeat;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="checkbox my-2">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="state"
                                                                                id="customCheck{{$value->id}}"
                                                                                data-parsley-multiple="groups"
                                                                                {{ $value->t_state == 1 ?'checked' : '' }}
                                                                                data-parsley-mincheck="2">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck{{$value->id}}">Publish</label>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-raised btn-success waves-effect waves-light ml-2"
                                                                        onclick="translates_id('{{$value->id}}',this)">Translate</button>
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
                        <form action="{{route('dashboard.type.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}"
                                        id="tranlate_en" type="text" required="" name="name" placeholder="Name"
                                        value="{{old('name')}}">
                                    @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_kurmanji')? 'is-invalid' : '' }}"
                                        id="tranlate_kr" type="text" required="" name="name kurmanji" placeholder="Nav"
                                        value="{{old('name_kurmanji')}}">
                                    @if($errors->has('name_kurmanji'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_kurmanji') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_kurdish')? 'is-invalid' : '' }}"
                                        id="tranlate_ku" type="text" required="" name="name kurdish" dir="rtl"
                                        placeholder="ناو" value="{{old('name_kurdish')}}">
                                    @if($errors->has('name_kurdish'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_kurdish') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_arabic')? 'is-invalid' : '' }}"
                                        id="tranlate_ar" type="text" required="" name="name arabic" dir="rtl"
                                        placeholder="اسم" value="{{old('name_arabic')}}">
                                    @if($errors->has('name_arabic'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_arabic') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_persian')? 'is-invalid' : '' }}"
                                        id="tranlate_pr" type="text" required="" name="name persian" dir="rtl"
                                        placeholder="نام" value="{{old('name_persian')}}">
                                    @if($errors->has('name_persian'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_persian') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Picture</label>
                                <div class="col-sm-10">
                                    <input type="file" id="actual-upload" onchange="readURL(this);" name="imgs"
                                        style="display: none">
                                    <div class="pull-right" id="upload"
                                        style="height: 200px;width: 200px;background-image: url({{ asset('assets/images/logo.png') }});background-size: contain;background-repeat: no-repeat;">
                                    </div>
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
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        onclick="translates(this)">Translate</button>
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
    function translates(btn) {
        btn.textContent = 'Loading ...';
        btn.disabled = true;
        text = document.getElementById('tranlate_en').value;
        url = "{{route('dashboard.translate')}}";
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax(
        {
            url: url,
            type: 'POST', // replaced from put
            dataType: "JSON",
            data: {
                text:text,
            },
            success: function (response)
            {
                document.getElementById('tranlate_ar').value =response.ar ;
                document.getElementById('tranlate_pr').value =response.pr ;
                document.getElementById('tranlate_kr').value =response.kr ;
                btn.textContent = 'Translate';
                btn.disabled = false;
                console.log(response); // see the reponse sent
            },
            error:  function(jqXHR, textStatus, errorThrown) {
                    btn.textContent = 'Translate';
                    btn.disabled = false;
                    alert("Please put text to translate");
            }
        });
    }
    function translates_id(id,btn) {
        text = document.getElementById('tranlate_en_'+id).value;
        btn.textContent = 'Loading ...';
        btn.disabled = true;
        url = "{{route('dashboard.translate')}}";
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax(
        {
            url: url,
            type: 'POST', // replaced from put
            dataType: "JSON",
            data: {
                text:text,
            },
            success: function (response)
            {
                document.getElementById('tranlate_ar_'+id).value =response.ar ;
                document.getElementById('tranlate_pr_'+id).value =response.pr ;
                document.getElementById('tranlate_kr_'+id).value =response.kr ;
                btn.textContent = 'Translate';
                btn.disabled = false;
                console.log(response); // see the reponse sent
            },
            error:  function(jqXHR, textStatus, errorThrown) {
                    btn.textContent = 'Translate';
                    btn.disabled = false;
                    alert("Please put text to translate");
            }
        });
    }
</script>
@endsection
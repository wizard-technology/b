@extends('layouts.app')
@section('content')
<style>
    .my-custom-scrollbar {
        position: relative;
        height: 200px;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Products #{{$data->id}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$data->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$data->p_name}}</h4>
                <p class="card-text">{{$data->p_info}}</p>
                <p class="card-text">
                    <small class="text-muted">Created At {{$data->created_at}}</small>
                    <br>
                    <small class="text-muted">Created By {{$data->admin->u_first_name}}
                        {{$data->admin->u_second_name}}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$data->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$data->p_name_kr}}</h4>
                <p class="card-text">{{$data->p_info_kr}}</p>
                <p class="card-text">
                    <small class="text-muted">Created At {{$data->created_at}}</small>
                    <br>
                    <small class="text-muted">Created By {{$data->admin->u_first_name}}
                        {{$data->admin->u_second_name}}</small>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$data->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$data->p_name_ku}}</h4>
                <p class="card-text">{{$data->p_info_ku}}</p>
                <p class="card-text">
                    <small class="text-muted">Created At {{$data->created_at}}</small>
                    <br>
                    <small class="text-muted">Created By {{$data->admin->u_first_name}}
                        {{$data->admin->u_second_name}}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$data->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$data->p_name_ar}}</h4>
                <p class="card-text">{{$data->p_info_ar}}</p>
                <p class="card-text">
                    <small class="text-muted">Created At {{$data->created_at}}</small>
                    <br>
                    <small class="text-muted">Created By {{$data->admin->u_first_name}}
                        {{$data->admin->u_second_name}}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="card m-b-30">
            <img class="card-img-top img-fluid" height="50px" src="{{asset('storage/'.$data->p_image)}}"
                alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title font-20 mt-0">{{$data->p_name_pr}}</h4>
                <p class="card-text">{{$data->p_info_pr}}</p>
                <p class="card-text">
                    <small class="text-muted">Created At {{$data->created_at}}</small>
                    <br>
                    <small class="text-muted">Created By {{$data->admin->u_first_name}}
                        {{$data->admin->u_second_name}}</small>
                </p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card ">
            <div class="card-body">

                <h4 class="mt-0 header-title">Multi Image</h4>
                <p class="text-muted font-14">You can add multi image by drag and drop
                </p>

                <div class="mb-3">
                    <form action="{{route('dashboard.product.extra_image',$data->id)}}" enctype="multipart/form-data"
                        method="POST" class="dropzone" id="dropzone">
                        @csrf
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple">
                        </div>
                    </form>
                </div>

                <div class="text-center m-t-15">
                    <button type="button" class="btn btn-primary waves-effect waves-light">Send Files</button>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
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
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Extra Image</h4>
                <div style="height: 340px;" class="table-wrapper-scroll-y my-custom-scrollbar">
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="visibility: hidden">
                                <tr>
                                    <th class="border-top-0 w-60">Image</th>
                                    <th class="border-top-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->extra as $key => $value)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="{{asset('storage/'.$value->i_link)}}"
                                            alt="user" width="40" height="40px">
                                    </td>
                                    <td class="">
                                        <div class="btn-group m-b-10 float-right">
                                            <form
                                            action="{{route('dashboard.product.extra_delete',$value->id)}}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="dropdown-item text-danger">Delete</button>
                                        </form>
                                        </div>
                                    </td>


                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/plugins/dropzone/dist/dropzone.js')}}"></script>

<script>
    // $("dropzone").dropzone({ url: ""});
    Dropzone.options.imageUpload = {
        maxFilesize: 8,
        acceptedFile: ".jpeg,.png,.jpg,.gif"
    }
</script>
@endsection
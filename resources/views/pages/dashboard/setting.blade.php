@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Setting</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Activity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#term" role="tab">Terms And Condition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#privacy" role="tab">Privacy Policy</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="cat" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="mt-0 header-title">Logger Activity table</h4>
                                        <table id="datatable-buttons"
                                            class="table table-striped table-bordered dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <th>Employee</th>
                                                    <th>Email Employee</th>
                                                    <th>Logger Name</th>
                                                    <th>Logger Action</th>
                                                    <th>Logger State</th>
                                                    <th>Created At</th>
                                                    <th>Logger Informaion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($logger as $key=>$value)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$value->id}}</td>
                                                    <td>{{$value->employee->u_email }}</td>
                                                    <td>{{$value->employee->u_first_name }}
                                                        {{$value->employee->u_second_name }}</td>
                                                    <td>{{$value->log_name}}</td>
                                                    <td>{{$value->log_action}}</td>
                                                    <td>{!! $value->log_state == 1 ?'<span
                                                            class="badge bg-success badge-pill">New</span>' :'<span
                                                            class="badge bg-danger badge-pill">Seen</span>' !!}
                                                    </td>
                                                    <td>{{$value->created_at}}</td>
                                                    <td><button class="btn btn-primary" data-toggle="modal"
                                                            onclick="seen('{{route('dashboard.setting.destroy',$value->id)}}','json-{{$value->id}}','{{$value->log_info}}')"
                                                            data-target=".bd-example-modal-form-{{$value->id}}">Show</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade bd-example-modal-form-{{$value->id}}"
                                                    tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalform">Logger
                                                                    #{{$value->id}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true"
                                                                        class="text-dark">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <pre id="json-{{$value->id}}"></pre>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-raised btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <script>
                                                    function seen(url,id,data) {
                                                        document.getElementById(id).textContent = JSON.stringify(JSON.parse(data), undefined, 2);
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax(
                                                        {
                                                            url: url,
                                                            type: 'delete', // replaced from put
                                                            dataType: "JSON",
                                                            success: function (response)
                                                            {
                                                                console.log(response); // see the reponse sent
                                                            },
                                                            error: function(xhr) {
                                                             console.log(xhr.responseText); // this line will save you tons of hours while debugging
                                                            // do something here because of error
                                                           }
                                                        });
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div>
                    <div class="tab-pane p-3" id="create" role="tabpanel">
                        <form action="{{route('dashboard.setting.update',$setting->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('bizzcoin')? 'is-invalid' : '' }}"
                                        name="bizzcoin"   type="text" required="" placeholder="Bizzcoin per 1 Dollar"
                                        value="{{old('bizzcoin') ?? $setting->bizzcoin}}">
                                    @if($errors->has('bizzcoin'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bizzcoin') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('message')? 'is-invalid' : '' }}"
                                        name="message" type="text" required="" placeholder="message"
                                        value="{{old('message') ?? $setting->message}}">
                                    @if($errors->has('message'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('message') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('forget')? 'is-invalid' : '' }}"
                                        name="forget" type="text" required="" placeholder="Forget Password"
                                        value="{{old('forget') ?? $setting->forget}}">
                                    @if($errors->has('forget'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('forget') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="checkbox my-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input"
                                        {{ $setting->state_app == 1 ?'checked' : '' }} name="state" id="customCheck"
                                        data-parsley-multiple="groups" data-parsley-mincheck="2">
                                    <label class="custom-control-label" for="customCheck">Application Active</label>
                                </div>
                            </div>
                            <div class="form-group text-right row m-t-20">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="term" role="tabpanel">
                        <form action="{{route('dashboard.setting.more',1)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">Terms And Condition</label>
                                    <textarea  class="form-control summernote" name="article_english"  cols="30" rows="10">{!!  json_decode($article[0]->ar_article)  !!}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="">Termsert û merc</label>
                                    <textarea  class="form-control summernote" name="article_kurmanji" cols="30" rows="10">{!!  json_decode($article[0]->ar_article_kr)  !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">مەرجەکانی بەکارهێنان</label>
                                    <textarea  class="form-control summernote" dir="rtl" name="article_kurdish" cols="30" rows="10">{!!  json_decode($article[0]->ar_article_ku)  !!}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="">أحكام وشروط</label>
                                    <textarea  class="form-control summernote" dir="rtl" name="article_arabic" cols="30" rows="10">{!!  json_decode($article[0]->ar_article_ar)  !!}</textarea>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">شرایط و ضوابط</label>
                                    <textarea  class="form-control summernote" name="article_persian"  cols="30" rows="10">{!!  json_decode($article[0]->ar_article_pr)  !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group text-right row m-t-20">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="privacy" role="tabpanel">
                        <form action="{{route('dashboard.setting.more',2)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">Terms And Condition</label>
                                    <textarea  class="form-control summernote" name="article_english"  cols="30" rows="10">{!!  json_decode($article[1]->ar_article)  !!}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="">Termsert û merc</label>
                                    <textarea  class="form-control summernote" name="article_kurmanji" cols="30" rows="10">{!!  json_decode($article[1]->ar_article_kr)  !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">مەرجەکانی بەکارهێنان</label>
                                    <textarea  class="form-control summernote" dir="rtl" name="article_kurdish" cols="30" rows="10">{!!  json_decode($article[1]->ar_article_ku)  !!}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="">أحكام وشروط</label>
                                    <textarea  class="form-control summernote" dir="rtl" name="article_arabic" cols="30" rows="10">{!!  json_decode($article[1]->ar_article_ar)  !!}</textarea>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="">شرایط و ضوابط</label>
                                    <textarea  class="form-control summernote" name="article_persian"  cols="30" rows="10">{!!  json_decode($article[1]->ar_article_pr)  !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group text-right row m-t-20">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
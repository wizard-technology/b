@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Products</h4>
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
                        <a class="nav-link active" data-toggle="tab" href="#cat" role="tab">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#create" role="tab">Create Product</a>
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

                                        <h4 class="mt-0 header-title">Product table</h4>
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
                                                    <th>Price</th>
                                                    <th>Priority</th>
                                                    <th>State</th>
                                                    <th>Category</th>
                                                    <th>Subcategory</th>
                                                    <th>Grouped</th>
                                                    <th>Tags</th>
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
                                                    <td>{{$value->p_name}}</td>
                                                    <td>{{$value->p_name_kr}}</td>
                                                    <td>{{$value->p_name_ku}}</td>
                                                    <td>{{$value->p_name_ar}}</td>
                                                    <td>{{$value->p_name_pr}}</td>
                                                    <td>{{$value->p_price}} $</td>
                                                    <td>{{$value->p_order_by}}</td>
                                                    <td>{!! $value->p_state == 1 ?'<span
                                                            class="badge bg-success badge-pill">Active</span>' :'<span
                                                            class="badge bg-danger badge-pill">Inactive</span>' !!}
                                                    </td>
                                                    <td>{{$value->type->t_name}} / {{$value->type->t_name_ku}}</td>
                                                    <td>{{$value->subcategory->st_name}} / {{$value->subcategory->st_name_ku}}</td>
                                                    <td>{{$value->grouped->gr_name}} / {{$value->grouped->gr_name_ku}}</td>
                                                    <td>
                                                        @foreach ($value->tags as $tg)
                                                        {{ $tg->tagName->tg_name }} / {{ $tg->tagName->tg_name_ku }}
                                                        <br>
                                                        @endforeach
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
                                                                    href="{{route('dashboard.product.edit',$value->id)}}">{{ $value->p_state == 1 ? 'Inactive' :'Active'}}</a>
                                                                <button class="dropdown-item" data-toggle="modal"
                                                                    data-target=".bd-example-modal-form-{{$value->id}}">Edit</button>
                                                                <div class="dropdown-divider"></div>
                                                                <form
                                                                    action="{{route('dashboard.product.destroy',$value->id)}}"
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
                                                    <form action="{{route('dashboard.product.update',$value->id)}}"
                                                        method="post" enctype="multipart/form-data">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalform">Update
                                                                        Product #{{$value->id}}</h5>
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
                                                                                placeholder="Name"  id="tranlate_en_{{$value->id}}"
                                                                                value="{{$value->p_name}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name kurmanji"
                                                                                placeholder="Nav"  id="tranlate_kr_{{$value->id}}"
                                                                                value="{{$value->p_name_kr}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name kurdish"
                                                                                dir="rtl" placeholder="ناو"  id="tranlate_ku_{{$value->id}}"
                                                                                value="{{$value->p_name_ku}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name arabic"
                                                                                dir="rtl" placeholder="اسم"  id="tranlate_ar_{{$value->id}}"
                                                                                value="{{$value->p_name_ar}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="text"
                                                                                required="" name="name persian"
                                                                                dir="rtl" placeholder="نام"  id="tranlate_pr_{{$value->id}}"
                                                                                value="{{$value->p_name_pr}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <input class="form-control" type="number"
                                                                                required="" name="price"
                                                                                placeholder="Price"
                                                                                value="{{$value->p_price}}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control" name="info" id="translate_info_en_{{$value->id}}" cols="5" rows="10">{{$value->p_info}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control" name="info kurmanji" id="translate_info_kr_{{$value->id}}" cols="5" rows="10">{{$value->p_info_ku}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control" name="info kurdish" dir="rtl" id="translate_info_ku_{{$value->id}}" cols="5" rows="10">{{$value->p_info_ku}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control" name="info arabic" dir="rtl" id="translate_info_ar_{{$value->id}}" cols="5" rows="10">{{$value->p_info_ar}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-12">
                                                                            <textarea class="form-control" name="info persian" dir="rtl" id="translate_info_pr_{{$value->id}}" cols="5" rows="10">{{$value->p_info_pr}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Priority</label>
                                                                        <div class="col-sm-10">
                                                                            <select class="form-control" name="priority">
                                                                                <option {{5 == $value->p_order_by ? 'selected' : ''}} value="5">5</option>
                                                                                <option {{4 == $value->p_order_by ? 'selected' : ''}} value="4">4</option>
                                                                                <option {{3 == $value->p_order_by ? 'selected' : ''}} value="3">3</option>
                                                                                <option {{2 == $value->p_order_by ? 'selected' : ''}} value="2">2</option>
                                                                                <option {{1 == $value->p_order_by ? 'selected' : ''}} value="1">1</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Category</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="category" onchange="subcategory_fun_update({{$value->id}})" class="form-control" id="category-{{$value->id}}">
                                                                                @foreach ($types as $key=>$cat)
                                                                                <option {{$cat->id == $value->p_type ? 'selected' : ''}} value="{{$cat->id }}">{{$cat->t_name}} / {{$cat->t_name_ku }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Subcategory</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="subcategory" onchange="grouped_fun_update({{$value->id}})" class="form-control" id="subcategory-{{$value->id}}">
                                                                                <option selected  value="{{$value->subcategory->id }}">{{$value->subcategory->st_name}} / {{$value->subcategory->st_name_ku }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Grouped</label>
                                                                        <div class="col-sm-10">
                                                                            <select name="grouped" class="form-control"  id="grouped-{{$value->id}}">
                                                                                <option selected  value="{{$value->grouped->id }}">{{$value->grouped->gr_name}} / {{$value->grouped->gr_name_ku }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-2 col-form-label">Tags</label>
                                                                        <div class="col-sm-10">
                                                                            <select class="select2 mb-3 select2-multiple" name="tag[]" style="width: 100%"
                                                                                multiple="multiple" data-placeholder="Choose">
                                                                                @php
                                                                                    $pt = $value->tags->pluck('pt_tag')->toArray();
                                                                                @endphp
                                                                                @foreach ($tags as $key=>$tgs)
                                                                                <option {{in_array($tgs->id,  $pt) ? 'selected' : ''}}  value="{{$tgs->id}}">{{$tgs->tg_name}} / {{$tgs->tg_name_ku}}
                                                                                </option>
                                        
                                                                                @endforeach
                                                                            </select>
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
                                                                                style="height: 200px;width: 200px;background-image: url({{asset('storage/'.$value->p_image) }});background-size: contain;background-repeat: no-repeat;">
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
                                                                                {{ $value->p_state == 1 ?'checked' : '' }}
                                                                                data-parsley-mincheck="2">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck{{$value->id}}">Publish</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="checkbox my-2">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                name="hasinfo"
                                                                                id="customCheck{{$value->id}}-info"
                                                                                data-parsley-multiple="groups"
                                                                                {{ $value->p_has_info == 1 ?'checked' : '' }}
                                                                                data-parsley-mincheck="2">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck{{$value->id}}-info">Has Info ?</label>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-raised btn-success waves-effect waves-light ml-2" onclick="translates_id('{{$value->id}}',this)">Translate</button>
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
                        <form action="{{route('dashboard.product.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name')? 'is-invalid' : '' }}" id="tranlate_en"
                                        type="text" required="" name="name" placeholder="Name" value="{{old('name')}}">
                                    @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_kurmanji')? 'is-invalid' : '' }}" id="tranlate_kr"
                                        type="text" required="" name="name kurmanji" placeholder="Nav"
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
                                    <input class="form-control {{ $errors->has('name_kurdish')? 'is-invalid' : '' }}" id="tranlate_ku"
                                        type="text" required="" name="name kurdish" dir="rtl" placeholder="ناو"
                                        value="{{old('name_kurdish')}}">
                                    @if($errors->has('name_kurdish'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_kurdish') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_arabic')? 'is-invalid' : '' }}" id="tranlate_ar"
                                        type="text" required="" name="name arabic" dir="rtl" placeholder="اسم"
                                        value="{{old('name_arabic')}}">
                                    @if($errors->has('name_arabic'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_arabic') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('name_persian')? 'is-invalid' : '' }}" id="tranlate_pr"
                                        type="text" required="" name="name persian" dir="rtl" placeholder="نام"
                                        value="{{old('name_persian')}}">
                                    @if($errors->has('name_persian'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name_persian') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control {{ $errors->has('price')? 'is-invalid' : '' }}"
                                        type="number" required="" name="price" placeholder="Price"
                                        value="{{old('price')}}">
                                    @if($errors->has('price'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('price') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <textarea class="form-control {{ $errors->has('info')? 'is-invalid' : '' }}"  id="tranlate_info_en"
                                        name="info" placeholder="Information" cols="5"
                                        rows="10">{{old('info')}}</textarea>
                                    @if($errors->has('info'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('info') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control {{ $errors->has('info_kurmanji')? 'is-invalid' : '' }}"   id="tranlate_info_kr"
                                        name="info kurmanji" placeholder="Agahî" cols="5"
                                        rows="10">{{old('info_kurmanji')}}</textarea>
                                    @if($errors->has('info_kurmanji'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('info_kurmanji') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <textarea class="form-control {{ $errors->has('info_kurdish')? 'is-invalid' : '' }}"   id="tranlate_info_ku"
                                        name="info kurdish" placeholder="زانیاری" dir="rtl" cols="5"
                                        rows="10">{{old('info_kurdish')}}</textarea>
                                    @if($errors->has('info_kurdish'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('info_kurdish') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <textarea class="form-control {{ $errors->has('info_arabic')? 'is-invalid' : '' }}"  id="tranlate_info_ar"
                                        name="info arabic" placeholder="معلومات" dir="rtl" cols="5"
                                        rows="10">{{old('info_arabic')}}</textarea>
                                    @if($errors->has('info_arabic'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('info_arabic') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <textarea class="form-control {{ $errors->has('info_persian')? 'is-invalid' : '' }}"  id="tranlate_info_pr"
                                        name="info persian" placeholder="اطلاعات" dir="rtl" cols="5"
                                        rows="10">{{old('info_persian')}}</textarea>
                                    @if($errors->has('info_persian'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('info_persian') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="priority">
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category" onchange="subcategory_fun()" class="form-control" id="category">
                                        <option value="0" disabled selected>Categoty
                                        </option>
                                        @foreach ($types as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->t_name}} / {{$value->t_name_ku }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Subcategory</label>
                                <div class="col-sm-10">
                                    <select name="subcategory" onchange="grouped_fun()" class="form-control" id="subcategory">
                                        <option value="0" disabled selected>Subcategoty</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grouped</label>
                                <div class="col-sm-10">
                                    <select name="grouped" class="form-control" id="grouped">
                                        <option value="0" disabled selected>Grouped</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tags</label>
                                <div class="col-sm-10">
                                    <select class="select2 mb-3 select2-multiple" name="tag[]" style="width: 100%"
                                        multiple="multiple" data-placeholder="Choose">
                                        @foreach ($tags as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->tg_name}} / {{$value->tg_name_ku}}
                                        </option>

                                        @endforeach
                                    </select>
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
                            <div class="checkbox my-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="hasinfo" id="customCheckhasinfo"
                                        data-parsley-multiple="groups" data-parsley-mincheck="2">
                                    <label class="custom-control-label" for="customCheckhasinfo">Has Info ?</label>
                                </div>
                                
                            </div>
                            <div class="form-group text-right row m-t-20">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light" onclick="translates(this)">Translate</button>
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
    text = document.getElementById('tranlate_en').value;
    info = document.getElementById('tranlate_info_en').value;
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
            info:info,
        },
        success: function (response)
        {
            document.getElementById('tranlate_ar').value =response.ar ;
            document.getElementById('tranlate_pr').value =response.pr ;
            document.getElementById('tranlate_kr').value =response.kr ;
            document.getElementById('tranlate_info_ar').value =response.ar_info ;
            document.getElementById('tranlate_info_pr').value =response.pr_info ;
            document.getElementById('tranlate_info_kr').value =response.kr_info ;
            btn.textContent = 'Translate';
                    btn.disabled = false;
            console.log(response); // see the reponse sent
        },
        error: function(xhr) {
            btn.textContent = 'Translate';
                    btn.disabled = false;
                    alert("Please put text to translate");
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
        // do something here because of error
        }
    });
}
function translates_id(id,btn) {
    text = document.getElementById('tranlate_en_'+id).value;
    info = document.getElementById('translate_info_en_'+id).value;
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
            info:info,
        },
        success: function (response)
        {
            document.getElementById('tranlate_ar_'+id).value =response.ar ;
            document.getElementById('tranlate_pr_'+id).value =response.pr ;
            document.getElementById('tranlate_kr_'+id).value =response.kr ;
            document.getElementById('translate_info_ar_'+id).value =response.ar_info ;
            document.getElementById('translate_info_pr_'+id).value =response.pr_info ;
            document.getElementById('translate_info_kr_'+id).value =response.kr_info ;
            btn.textContent = 'Translate';
                    btn.disabled = false;
            console.log(response); // see the reponse sent
        },
        error: function(xhr) {
            btn.textContent = 'Translate';
                    btn.disabled = false;
                    alert("Please put text to translate");
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
        // do something here because of error
        }
    });
}
</script>
<script>
    function subcategory_fun() {
        var category = $('#category').find(":selected").val();

     console.log(category);

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
      $.ajax({
             url: "{{route('dashboard.product.subctegory')}}",
             method: "POST",
             dataType: 'json', 
             data:
             {
                 'category': category,
             },
             success: function(result){
                $('#subcategory').empty().append('<option value="0" disabled selected>Subcategoty</option>');
                $('#grouped').empty().append('<option value="0" disabled selected>Grouped</option>');

                result.forEach(element => {
                        /// jquerify the DOM object 'o' so we can use the html method
                        // $(o).html("option text");
                        var o = new Option(element.st_name +' / '+element.st_name_ku, element.id);
                        $("#subcategory").append(o);
                    console.log();
                });
             },
             error:  function(xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
             },
         });
 }
    function grouped_fun() {
        var subcategory = $('#subcategory').find(":selected").val();
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
      $.ajax({
             url: "{{route('dashboard.product.grouped')}}",
             method: "POST",
             dataType: 'json', 
             data:
             {
                 'subcategory': subcategory,
             },
             success: function(result){
                $('#grouped').empty().append('<option value="0" disabled selected>Grouped</option>');
                result.forEach(element => {
                        /// jquerify the DOM object 'o' so we can use the html method
                        // $(o).html("option text");
                        var o = new Option(element.gr_name +' / '+element.gr_name_ku, element.id);
                        $("#grouped").append(o);
                    console.log();
                });
             },
             error:  function(xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
             },
         });
 }
    function subcategory_fun_update(id) {
     console.log(id);
    var category = $('#category-'+id).find(":selected").val();
     console.log(category);

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
      $.ajax({
             url: "{{route('dashboard.product.subctegory')}}",
             method: "POST",
             dataType: 'json', 
             data:
             {
                 'category': category,
             },
             success: function(result){
                $('#subcategory-'+id).empty().append('<option value="0" disabled selected>Subcategoty</option>');
                $('#grouped-'+id).empty().append('<option value="0" disabled selected>Grouped</option>');

                result.forEach(element => {
                        /// jquerify the DOM object 'o' so we can use the html method
                        // $(o).html("option text");
                        var o = new Option(element.st_name +' / '+element.st_name_ku, element.id);
                        $("#subcategory-"+id).append(o);
                    console.log();
                });
             },
             error:  function(xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
             },
         });
 }
    function grouped_fun_update(id) {
        var subcategory = $('#subcategory-'+id).find(":selected").val();
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
      $.ajax({
             url: "{{route('dashboard.product.grouped')}}",
             method: "POST",
             dataType: 'json', 
             data:
             {
                 'subcategory': subcategory,
             },
             success: function(result){
                $('#grouped-'+id).empty().append('<option value="0" disabled selected>Grouped</option>');
                result.forEach(element => {
                        /// jquerify the DOM object 'o' so we can use the html method
                        // $(o).html("option text");
                        var o = new Option(element.gr_name +' / '+element.gr_name_ku, element.id);
                        $("#grouped-"+id).append(o);
                    console.log();
                });
             },
             error:  function(xhr, status, error){
                console.log(xhr);
                console.log(status);
                console.log(error);
             },
         });
 }
</script>
@endsection
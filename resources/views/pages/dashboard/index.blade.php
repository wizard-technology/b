@extends('layouts.app')
@section('content')
<style>
    .list-group {
        max-height: 340px;
        overflow-x: hidden; // hide horizontal

        overflow: scroll;
        -webkit-overflow-scrolling: touch;
    }
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
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between row">
                    <form class="col-md-12 col-xl-6 d-flex justify-content-center"
                        action="{{route('dashboard.index.show')}}" method="post">
                        @csrf
                        <div class="form-group" style="width: 100%">
                            <div class="input-group ">
                                <input type="date" name="date" onchange="submite(this)" class="form-control"
                                    value="{{$date ?? date('Y-m-d')}}">
                                <div class="input-group-append bg-primary b-0" st></div>
                            </div><!-- input-group -->
                        </div>
                    </form>
                    <div class="col-md-12 col-xl-6 d-flex justify-content-center">
                        <div class="form-group" style="width: 40%">
                            <div class="input-group ">
                                <input type="text" id="bizz" class="form-control" value="1"
                                    onchange="dollarToBizz(this,{{$setting->bizzcoin}})" placeholder="Dollar">
                                <div class="input-group-append bg-primary b-0" st><span
                                        class="input-group-text bg-primary text-light"><i
                                            class="mdi mdi-coin"></i></span></div>
                            </div><!-- input-group -->
                        </div>
                        <div style="width: 5%"></div>
                        <div class="form-group" style="width: 40%">
                            <div class="input-group ">
                                <input type="text" id="dollar" class="form-control" value="{{$setting->bizzcoin}}"
                                    onchange="bizzToDollar(this,{{$setting->bizzcoin}})" placeholder="Bizzcoin">
                                <div class="input-group-append bg-primary b-0" st><span
                                        class="input-group-text bg-primary text-light"><i
                                            class="mdi mdi-blogger"></i></span></div>
                            </div><!-- input-group -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end row-->
<div class="row">
    <div class="col-md-12 col-xl-4">
        <div class="card mini-stat">
            <div class="mini-stat-icon text-right">
                <i class="mdi mdi-cart-outline"></i>
            </div>
            <div class="p-4">
                <h6 class="text-uppercase mb-3">Order</h6>
                <div class="float-right">
                </div>
                <h4 class="mb-0">{{$order}}+<small class="ml-2"></small></h4>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-4">
        <div class="card mini-stat">
            <div class="mini-stat-icon text-right">
                <i class="mdi mdi-package-variant-closed"></i>
            </div>
            <div class="p-4">
                <h6 class="text-uppercase mb-3">Product</h6>
                <div class="float-right">
                </div>
                <h4 class="mb-0">{{$product}}+<small class="ml-2"></small></h4>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-xl-4">
        <div class="card mini-stat">
            <div class="mini-stat-icon text-right">
                <i class="mdi mdi-trending-up"></i>
            </div>
            <div class="p-4">
                <h6 class="text-uppercase mb-3">Profit</h6>
                <div class="float-right">
                </div>
                <h4 class="mb-0">{{ $profit->sum('c_price_all')}}<small class="ml-2"></small></h4>
            </div>
        </div>
    </div>

</div><!-- end row -->
<div class="row">
    <div class="col-md-12 col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Growth</h4>
                <div style="height: 340px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Accounts</h4>
                <div style="height: 340px;">
                    <div class="row" style="height: 100%;">
                        <div class="col-12 align-self-center">
                            <div class="row">
                                <div class="row col-2 justify-content-center"
                                    style="height: 60px;width: 60px;background-color:rgba(255,237, 117, 0.19);  border-radius: 10px;margin-left: 20px">
                                    <i style="color: #FFE66A" class="col-12 align-self-center" data-feather="user"></i>
                                </div>
                                <div class="col-2"></div>
                                <div class=" col-6 justify-content-center">
                                    <h4 class="ml-2">User</h4>
                                    <h1>{{$user}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 align-self-center">
                            <div class="row">
                                <div class="row col-2 justify-content-center"
                                    style="height: 60px;width: 60px;background-color:#F1F4FF;  border-radius: 10px;margin-left: 20px">
                                    <i style="color: #92B7FF" class="col-12 align-self-center"
                                        data-feather="briefcase"></i>
                                </div>
                                <div class="col-2"></div>
                                <div class=" col-6 justify-content-center">
                                    <h4 class="ml-2">Company</h4>
                                    <h1>{{$company}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end row-->
<div class="row">
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Top Companies</h4>
                <div style="height: 340px;">
                    <ul class="list-group">
                        @foreach ($top_company as $key=>$value)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$value->company->co_name}}
                            <span class="badge badge-primary badge-pill">{{count($value->product)}}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Trending</h4>
                <div style="height: 340px;" class="table-wrapper-scroll-y my-custom-scrollbar">
                    <div class="table-responsive">
                        <table class="table">
                            <thead style="visibility: hidden">
                                <tr>
                                    <th class="border-top-0 w-60">Image</th>
                                    <th class="border-top-0">Name</th>
                                    <th class="border-top-0">Ordered Times #</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($trending as $key => $value)
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="{{asset('storage/'.$value->product->p_image)}}" alt="user"
                                            width="40" height="40px">
                                    </td>
                                    <td>
                                        <a href="{{route('dashboard.product.show',$value->product->id)}}" class="text-dark">{{$value->product->p_name}} / {{$value->product->p_name_ku}}</a>
                                    </td>

                                    <td>{{$value->total}}</td>
                                   
                                </tr>
                              
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div><!-- end row-->
<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 mb-3 header-title">Analytics</h4>
                <div class="center">

                    <center>
                        <canvas id="myChart"></canvas>

                    </center>
                </div>
            </div>
        </div>
    </div>
</div><!-- end row-->
<script>
    function submite(form) {
        form.parentElement.parentElement.parentElement.submit();
    }
</script>
<script src="{{asset('assets/plugins/chart.js/chart.min.js')}}"></script>
<script>
    var json = '{!! $chart !!}';
    var datas = JSON.parse(json);
    console.log(datas);
    var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:["January", "February", "March", "April", "May", "June", "July", "August", "September","October","November","December"],
    datasets: [{
      label: '# Profit by Month in '+ new Date().getFullYear(),
      data: [datas['January'],datas['February'],datas['March'],datas['April'],datas['May'],datas['June'],datas['July'],datas['August'],datas['September'],datas['October'],datas['November'],datas['December']],
      backgroundColor: [
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
        'rgba(255, 230, 106,0.2)',
      ],
      borderColor: [
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)',
        'rgba(255, 230, 106,1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      xAxes: [{
        ticks: {
          maxRotation: 90,
          minRotation: 80
        },
          gridLines: {
          offsetGridLines: true // à rajouter
        }
      },
      {
        position: "top",
        ticks: {
          maxRotation: 90,
          minRotation: 80
        },
        gridLines: {
          offsetGridLines: true // et matcher pareil ici
        }
      }],
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  }
});
</script>
@endsection
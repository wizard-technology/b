<!DOCTYPE html>
<html lang="en">
@include('layouts.head',['title'=>'Login'])

<body class="fixed-left">
    <div id="stars"></div>
    <div id="stars2"></div>
    <div class="wrapper-page">

        <div class="card">
            <div class="card-body">
                <br>

                <h3 class="text-center mt-0">
                    <a href="{{route('dashboard.login')}}" class="logo logo-admin"><img
                            src="{{asset('assets/images/logo.png')}}" height="100" alt="logo"></a>
                </h3>
                <br>
                <br>
                <h3 class="text-center"><b>Bizz</b></h3>
                <br>

                <div class="p-3">

                    <form class="form-horizontal" action="{{route('dashboard.check')}}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control {{ $errors->has('email')? 'is-invalid' : '' }}" type="email"
                                    required="" name="email" placeholder="Email" value="{{old('email')}}">

                                @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input class="form-control {{ $errors->has('password')? 'is-invalid' : '' }}"
                                    name="password" type="password" required="" placeholder="Password">
                                @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group text-center row m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log
                                    In</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script')

    @if ($errors->has('admin'))
    <script>
        var text = '{{$errors->first("admin")}}';
        swal(
            {
                title: "Error",
                text: text,
                type: "error",
                confirmButtonText: 'OKEY',
                confirmButtonColor: "#FFE66A",
                timer: 5000,
            }
        );
    </script>
    <style>
        
    </style>
    @endif
</body>

</html>
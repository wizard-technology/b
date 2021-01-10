<!DOCTYPE html>
<html lang="{{ Session::get('lang')}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name') }} </title>
    <meta name="description" content="Everything you are looking for ">
    <link rel="stylesheet" href="{{asset('web/RTL.css')}}" />
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    {{-- <style>
        .feather {
            display: inline-block;
            line-height: 17px;
            margin-left: 3px;
            margin-right: 5px;
            text-align: center;
            vertical-align: middle;
            width: 18px;
        }
    </style> --}}
</head>

<body>

    <div class="container">

        <!-- nav bar  -->
        <div class="nav">
            <a style="text-decoration: none;" href="/">
                <p id="logo">Bizz</p>
            </a>

            <div class="flex">
                <div class="flex-ver">

                    <div onclick="showlang(this)" id="lang-icon">
                        <svg style="padding: 0px 0px 0px 20px;" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                            </path>
                        </svg>
                    </div>


                    <div class="lang-bg flex-ver">
                        <a id="lang" href="{{route('home','ku')}}">Sorani </a>
                        <a id="lang" href="{{route('home','en')}}">English</a>
                        <a id="lang" href="{{route('home','ar')}}">Arabic</a>
                        <a id="lang" href="{{route('home','kr')}}">Kurmanji</a>
                        <a id="lang" href="{{route('home','pr')}}">Persian</a>
                    </div>

                </div>
                <a href="{{route('terms',Session::get('lang'))}}" id="link">{{__('text.term')}}</a>

               

            </div>


        </div>

        <!-- banner  -->
        <div class="flex">

            <div class="banner">
                <div>
                    @if (Session::get('lang') == 'ar' )
                    <p id="brand"> {!! json_decode($title->ar_article_ar) !!}</p>
                    <p id="Moto"> {!! json_decode($desc->ar_article_ar) !!}</p>
                    @endif
                    @if (Session::get('lang') == 'ku' )
                    <p id="brand"> {!! json_decode($title->ar_article_ku) !!}</p>
                    <p id="Moto"> {!! json_decode($desc->ar_article_ku) !!}</p>
                    @endif
                    @if (Session::get('lang') == 'pr' )
                    <p id="brand"> {!! json_decode($title->ar_article_pr) !!}</p>
                    <p id="Moto"> {!! json_decode($desc->ar_article_pr) !!}</p>
                    @endif
                </div>
                <a id="Dawnload" href="#download">{{__('text.download')}}</a>
            </div>

            <img class="glow-icon" style="position: absolute; top: 25%; left: 50%;"
                src="{{asset('web/src/check.png')}}">
            <img class="glow-icon" style="position: absolute; top: 20%; left: 20%;"
                src="{{asset('web/src/message-square.png')}}">
            <img class="glow-icon" style="position: absolute; top: 60%; left: 53%;" src="{{asset('web/src/key.png')}}">
            <img class="glow-icon" style="position: absolute; top: 70%; left: 25%;"
                src="{{asset('web/src/heart.png')}}">




            <div>
                <img src="{{asset('web/src/loginscreen.png')}}" alt="" width="95%" height="95%">
            </div>
        </div>

        <div class="flex">
            <div>
                <img src="{{asset('web/src/homescreen.png')}}" alt="" width="95%" height="95%">
            </div>
            <div>
                <p id="brand">{{__('text.articl2')}}<br>{{__('text.articl3')}}</p>
            </div>
        </div>

        <!-- property -->
        <div class="flex-center">

            <div>
                <svg style="background-color:rgba(255, 237, 117, 26%); border-radius: 25px; padding: 20px;"
                    xmlns="http://www.w3.org/2000/svg" width="130" height="130" viewBox="0 0 24 24" fill="none"
                    stroke="#F9BF2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-key">
                    <path
                        d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4">
                    </path>
                </svg>
                <p class="title">{{__('text.secure')}}</p>
            </div>

            <div>
                <svg style="background-color:rgba(117, 255, 117, 26%); border-radius: 25px; padding: 20px; "
                    xmlns=" http://www.w3.org/2000/svg" width="130" height="130" viewBox="0 0 24 24" fill="none"
                    stroke="#79FEA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-check">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <p class="title">{{__('text.easy')}}</p>
            </div>

            <div>
                <svg style="background-color:rgba(117, 255, 232, 26%); border-radius: 25px; padding: 20px;"
                    xmlns="http://www.w3.org/2000/svg" width="130" height="130" viewBox="0 0 24 24" fill="none"
                    stroke="#63F9EF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-heart">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
                <p class="title">{{__('text.yours')}}</p>
            </div>

        </div>

        <!-- btns for play store and app store  -->
        <h1 style="text-align: center;margin-top: 10%;">{{__('text.download')}}</h1>

        <div class="flex-center" id="download">
            <div class="btn">
                <img width="25" height="25" src="{{asset('/web/src/playstore.png')}}">
                <a class="storesBtn" href="{{$setting->android}}" target="_blanck">Playstore</a>
            </div>
            <div class="btn">
                <img width="25" height="25" src="{{asset('/web/src/apple.png')}}">
                <a class="storesBtn" href="{{$setting->ios}}" target="_blanck">Appstore</a>
            </div>
        </div>

        <h1 style="text-align: center;margin-top: 10%;">
            {{__('text.loved')}}
            {{-- <svg style="fill: #ff414d;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"
                fill="none" stroke="#ff414d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-heart">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg> --}}

        </h1>

    </div>

    <!-- footer  -->
    <div style=" margin-top: 5%; text-align: center;">
        <h3>Bizz</h3>
        <p>{{__('text.articl2')}} {{__('text.articl3')}}</p>


        <div id="social">
            @foreach ($social as $item)
            <a href="{{$item->sm_link}}" target="_blanck"><i data-feather="{{$item->sm_icon}}"></i></a>
            @endforeach
        </div>
    </div>

    <script>
        var isShow = false;
        function showlang() {
            if (!isShow) {
                document.getElementsByClassName("lang-bg")[0].style.display = "";
                isShow = true
            }

            else {
                document.getElementsByClassName("lang-bg")[0].style.display = "none";
                isShow = false
            }
        }

    </script>

    <script>
        feather.replace()
    </script>
</body>

</html>
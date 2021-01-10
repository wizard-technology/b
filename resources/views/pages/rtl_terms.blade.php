<!DOCTYPE html>
<html lang="{{ Session::get('lang')}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name') }} </title>
    <meta name="description" content="Everything you are looking for ">
    <link rel="stylesheet" href="{{asset('web/style.css')}}" />
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

                <a href="{{route('terms',Session::get('lang'))}}" id="link">{{__('text.term')}}</a>

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
                        <a id="lang" href="{{route('terms','ku')}}">Sorani </a>
                        <a id="lang" href="{{route('terms','en')}}">English</a>
                        <a id="lang" href="{{route('terms','ar')}}">Arabic</a>
                        <a id="lang" href="{{route('terms','kr')}}">Kurmanji</a>
                        <a id="lang" href="{{route('terms','pr')}}">Persian</a>
                    </div>

                </div>

            </div>


        </div>

        <h3 id="link">{{__('text.term')}}</h3>
        <div>
            @if (Session::get('lang') == 'ar' )
            {!! json_decode($data->ar_article_ar) !!}
            @endif
            @if (Session::get('lang') == 'ku' )
            {!! json_decode($data->ar_article_ku) !!}
            @endif
            @if (Session::get('lang') == 'pr' )
            {!! json_decode($data->ar_article_pr) !!}
            @endif
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
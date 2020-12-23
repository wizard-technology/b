<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bizz</title>
    <meta name="description" content="Everything you are looking for ">
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="container">

        <!-- nav bar  -->
        <div class="nav">
            <a style="text-decoration: none;" href="./index.html">
                <p id="logo">Bizz</p>
            </a>

            <div class="flex">

                <a href="terms.html" id="link">Terms & Conditions</a>

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
                        <a id="lang" href="#">Kurdish</a>
                        <a id="lang" href="#">English</a>
                        <a id="lang" href="#">Arabic</a>
                    </div>

                </div>

            </div>


        </div>

        <h3 id="link">Terms & Conditions</h3>
        <div>
          {{$data->term}}
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



</body>

</html>
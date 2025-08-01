<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/img') }}/cbt-malela.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('/assets/cbt-malela') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/assets/css/authentication/form-1.css" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/assets/cbt-malela') }}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/cbt-malela') }}/assets/css/forms/switches.css">
    <link href="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/plugins/sweetalerts/custom-sweetalert.js"></script>
    <style>
        svg#freepik_stories-mobile-login:not(.animated) .animable {
            opacity: 0;
        }

        svg#freepik_stories-mobile-login.animated #freepik--background-complete--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomIn, 1.5s Infinite linear floating;
            animation-delay: 0s, 1s;
        }

        svg#freepik_stories-mobile-login.animated #freepik--Shadow--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) lightSpeedRight;
            animation-delay: 0s;
        }

        svg#freepik_stories-mobile-login.animated #freepik--Floor--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) fadeIn;
            animation-delay: 0s;
        }

        svg#freepik_stories-mobile-login.animated #freepik--Device--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) slideUp, 1.5s Infinite linear wind;
            animation-delay: 0s, 1s;
        }

        svg#freepik_stories-mobile-login.animated #freepik--Character--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) slideLeft;
            animation-delay: 0s;
        }

        svg#freepik_stories-mobile-login.animated #freepik--Plant--inject-40 {
            animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomIn;
            animation-delay: 0s;
        }

        @keyframes zoomIn {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes floating {
            0% {
                opacity: 1;
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0px);
            }
        }

        @keyframes lightSpeedRight {
            from {
                transform: translate3d(50%, 0, 0) skewX(-20deg);
                opacity: 0;
            }

            60% {
                transform: skewX(10deg);
                opacity: 1;
            }

            80% {
                transform: skewX(-2deg);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: inherit;
            }
        }

        @keyframes wind {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(1deg);
            }

            75% {
                transform: rotate(-1deg);
            }
        }

        @keyframes slideLeft {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="form">
    <div class="form-container">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Log In</h1>
                        @if (count($admin) == 0)
                            <p class="signup-link">Admin belum ada. <a href="{{ url('/install') }}">Buat akun Admin
                                    dulu</a></p>
                        @else
                            <p class="signup-link">Daftar Akun. <a href="{{ url('/register') }}">Klik Disini!</a></p>
                        @endif
                        @if (session('pesanRegis'))
                            <div class="alert alert-success" role="alert">
                                {{ session('pesanRegis') }}

                                <!-- Alert countdown -->
                                <div id="countdownAlert" class="alert alert-info mt-2">
                                    Anda dapat mengirim ulang email dalam <span id="countdown"></span> detik...
                                </div>

                                <!-- Form Kirim Ulang (sembunyi dulu) -->
                                <form id="resendForm" action="{{ url('/email_send') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('email') }}">
                                    <input type="hidden" name="password" value="{{ session('password') }}">
                                    <input type="hidden" name="token" value="{{ session('token') }}">
                                    <input type="hidden" name="nama" value="{{ session('nama') }}">
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Kirim Ulang Email
                                        Konfirmasi</button>
                                </form>
                            </div>
 
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let countdown = 60;
                                        const countdownSpan = document.getElementById('countdown');
                                        const countdownAlert = document.getElementById('countdownAlert');
                                        const resendForm = document.getElementById('resendForm');

                                        const interval = setInterval(() => {
                                            countdown--;
                                            countdownSpan.textContent = countdown;
                                            if (countdown <= 0) {
                                                clearInterval(interval);
                                                countdownAlert.style.display = 'none';
                                                resendForm.style.display = 'inline';
                                            }
                                        }, 1000);
                                    });
                                </script>
                        @endif



                        <form action="{{ url('/login') }}" method="POST" class="text-left">
                            <div class="form">
                                @csrf
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input type="email" id="username" name="email" class="form-control"
                                        value="{{ old('email') }}" placeholder="Email" required>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Password" required>
                                </div>

                                <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <div>
                                        <a href="{{ route('recovery') }}" class="text-primary">Lupa
                                            Password?</a>
                                    </div>
                                </div>

                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        {{-- <p class="signup-link">
                            Lupa Password? <a href="{{ url('/recovery') }}">Klik Disini</a>
                        </p> --}}
                        {{-- <p class="terms-conditions" style="margin-top: 30px;">© 2022 CBT-MALELA laravel10 by <a href="https://www.youtube.com/channel/UCvteoPo7Th3Q2Mdi9c8CT1w" target="_blank">ABDULOH</a> All Rights Reserved. <a href="https://www.freepik.com/" target="_blank">Illustration by Freepik</a></p> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image d-flex align-center">
                <svg class="animated" id="freepik_stories-mobile-login" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 500 500" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    xmlns:svgjs="http://svgjs.com/svgjs">
                    <g id="freepik--background-complete--inject-40" class="animable animator-active"
                        style="transform-origin: 249.995px 223.68px;">
                        <g id="el9z1u5jortcb">
                            <rect x="46.99" y="40.91" width="136.06" height="207.55"
                                style="fill: rgb(235, 235, 235); transform-origin: 115.02px 144.685px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <g id="elcgzv7hpz6hn">
                            <rect x="125.54" y="49.23" width="57.51" height="92.32"
                                style="fill: rgb(255, 255, 255); transform-origin: 154.295px 95.39px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <g id="elq2fso8cbqhd">
                            <rect x="61.74" y="49.23" width="57.51" height="92.32"
                                style="fill: rgb(255, 255, 255); transform-origin: 90.495px 95.39px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <g id="elwys2rbibvz">
                            <rect x="125.54" y="147.83" width="57.51" height="92.32"
                                style="fill: rgb(255, 255, 255); transform-origin: 154.295px 193.99px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <g id="ellyahybte1yf">
                            <rect x="61.74" y="147.83" width="57.51" height="92.32"
                                style="fill: rgb(255, 255, 255); transform-origin: 90.495px 193.99px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <polygon points="99.47 40.91 46.98 40.91 46.98 337.85 77.36 337.85 56.16 186.75 99.47 40.91"
                            style="fill: rgb(219, 219, 219); transform-origin: 73.225px 189.38px;" id="elqfdx1253duq"
                            class="animable"></polygon>
                        <polygon
                            points="90.38 48.94 82.06 83.45 73.59 117.93 56.64 186.87 56.65 186.7 64.49 258.75 68.41 294.78 72.16 330.82 67.92 294.83 63.83 258.82 55.66 186.81 55.66 186.72 55.68 186.63 72.95 117.77 81.59 83.34 90.38 48.94"
                            style="fill: rgb(235, 235, 235); transform-origin: 73.02px 189.88px;" id="el49bay5b9hrj"
                            class="animable"></polygon>
                        <polygon
                            points="50.11 55.03 50.35 84.81 50.49 114.59 50.61 174.15 50.49 233.7 50.35 263.48 50.11 293.26 49.86 263.48 49.72 233.7 49.61 174.15 49.73 114.59 49.87 84.81 50.11 55.03"
                            style="fill: rgb(235, 235, 235); transform-origin: 50.11px 174.145px;" id="eli7j38hv3aph"
                            class="animable"></polygon>
                        <path
                            d="M59.92,60.61,58.29,92.26l-1.77,31.65L53,187.19v0c.35,11.76.58,23.51.87,35.26l.83,35.26.83,35.26.67,35.27L55,293l-1-35.26-1-35.25c-.32-11.76-.71-23.51-1-35.26v0l3.88-63.27,1.95-31.63Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 55.96px 194.425px;" id="elivxfho6auxd"
                            class="animable"></path>
                        <path
                            d="M66.75,323.63l-3.44-34.16L60,255.29c-2.13-22.79-4.35-45.57-6.4-68.37v-.13l9.73-53.21L68.26,107l5-26.58-4.59,26.66L64,133.71,54.53,187v-.13c2.18,22.79,4.19,45.59,6.29,68.39l3,34.2Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 63.43px 202.025px;" id="elz3ltnbuw2xj"
                            class="animable"></path>
                        <g id="elekywkya8mpm">
                            <rect x="46.99" y="184.26" width="11.85" height="6.92"
                                style="fill: rgb(219, 219, 219); transform-origin: 52.915px 187.72px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                        <polygon
                            points="130.56 40.91 183.05 40.91 183.05 337.85 152.67 337.85 173.87 186.75 130.56 40.91"
                            style="fill: rgb(219, 219, 219); transform-origin: 156.805px 189.38px;" id="el1gvz82kw0us"
                            class="animable"></polygon>
                        <polygon
                            points="139.65 48.94 148.44 83.34 157.08 117.77 174.35 186.63 174.38 186.72 174.37 186.81 166.2 258.82 162.11 294.83 157.87 330.82 161.62 294.78 165.54 258.75 173.38 186.7 173.39 186.87 156.44 117.93 147.97 83.45 139.65 48.94"
                            style="fill: rgb(235, 235, 235); transform-origin: 157.015px 189.88px;" id="el2nivxhs5rh5"
                            class="animable"></polygon>
                        <polygon
                            points="179.92 55.03 180.17 84.81 180.31 114.59 180.42 174.15 180.31 233.7 180.17 263.48 179.92 293.26 179.68 263.48 179.54 233.7 179.42 174.15 179.54 114.59 179.68 84.81 179.92 55.03"
                            style="fill: rgb(235, 235, 235); transform-origin: 179.92px 174.145px;" id="elip4b8nmjt5"
                            class="animable"></polygon>
                        <path
                            d="M170.12,60.61l2.08,31.63,2,31.63L178,187.14v0c-.26,11.75-.65,23.5-1,35.26l-1,35.25L175,293l-1.17,35.25.67-35.27.83-35.26.83-35.26c.3-11.75.52-23.5.87-35.26v0l-3.56-63.28-1.77-31.65Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 174.06px 194.43px;" id="elbj2a9kz8vtt"
                            class="animable"></path>
                        <path
                            d="M163.28,323.63l2.91-34.21,3-34.2c2.1-22.8,4.11-45.6,6.29-68.39V187L166,133.71l-4.67-26.64-4.6-26.66,5,26.58,4.94,26.59,9.73,53.21v.13c-2.06,22.8-4.27,45.58-6.4,68.37l-3.33,34.18Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 166.565px 202.02px;" id="elva7j7yhd8t"
                            class="animable"></path>
                        <rect x="171.19" y="184.26" width="11.85" height="6.92"
                            style="fill: rgb(219, 219, 219); transform-origin: 177.115px 187.72px;" id="elsz0xvea5pw"
                            class="animable"></rect>
                        <path
                            d="M336.85,269.18V406.45h83V269.18Zm75.44,86.61H344.38V320.05h67.91Zm0-44.25H344.38V275.81h67.91Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 378.35px 337.815px;" id="elobuo075vebb"
                            class="animable"></path>
                        <rect x="419.83" y="269.18" width="33.18" height="137.26"
                            style="fill: rgb(219, 219, 219); transform-origin: 436.42px 337.81px;" id="el65zgqlmmf2"
                            class="animable"></rect>
                        <rect x="344.38" y="275.81" width="16.14" height="35.73"
                            style="fill: rgb(219, 219, 219); transform-origin: 352.45px 293.675px;" id="elr3xi77qc8c"
                            class="animable"></rect>
                        <path d="M412.79,398.33H344.31V363.26h68.48Zm-67.48-1h66.48V364.26H345.31Z"
                            style="fill: rgb(219, 219, 219); transform-origin: 378.55px 380.795px;" id="elcpgct8yny7p"
                            class="animable"></path>
                        <rect x="369.02" y="373.34" width="13.4" height="6.78"
                            style="fill: rgb(219, 219, 219); transform-origin: 375.72px 376.73px;" id="el2qvx93hb5aw"
                            class="animable"></rect>
                        <path d="M386.89,380.12H372.48v-6.76h14.41Zm-13.41-1h12.41v-4.76H373.48Z"
                            style="fill: rgb(219, 219, 219); transform-origin: 379.685px 376.74px;" id="eli8ggbgt9p4s"
                            class="animable"></path>
                        <rect x="344.38" y="320.06" width="16.14" height="35.73"
                            style="fill: rgb(219, 219, 219); transform-origin: 352.45px 337.925px;" id="el1c06hp6am6"
                            class="animable"></rect>
                        <path
                            d="M418.91,211.65c9.5,9.3,11.09,23.68,9.09,36.28-.05.29-.49.21-.49-.06,0-2.87.08-5.71.07-8.54l-.14-.38a19.12,19.12,0,0,1-6.17-6.63c-1.59-3.12-2.21-6.64-3.43-9.9-.11-.31.22-.22.44-.06,5.78,4.26,7.62,8.85,9.28,15a50.68,50.68,0,0,0-1-9.54c-1.25-5.81-3.72-11.58-7.89-15.89A.18.18,0,1,1,418.91,211.65Z"
                            style="fill: rgb(166, 166, 166); transform-origin: 423.289px 229.859px;"
                            id="ellynfbzkt7r9" class="animable"></path>
                        <path
                            d="M417.12,212.73c-1.63.06-2.65,2.67-3.93,3.43a1.22,1.22,0,0,1-1.8-.28c-1.26-1.76.47-3.94,2.1-5.15-1.17.48-2.13,1.32-3.39,1.56a1.19,1.19,0,0,1-1.53-.92c-.55-2.4,2.46-3.47,4.53-3.52-1-.7-3.88-2.59-2.35-3.52s4.91,1.77,6,2.66c1.62,1.31,3.55,3.27,3.62,5.32C420.47,214.71,418.38,213.23,417.12,212.73Z"
                            style="fill: rgb(219, 219, 219); transform-origin: 414.439px 210.288px;"
                            id="elrbb600xqiaq" class="animable"></path>
                        <path
                            d="M417.6,213.13c-2.09-.95-6.11.42-6.45-.37-.69-1.61,2.52-2.71,4.25-2.93-1.6-.43-4.65-1.12-4.56-2.65.12-1.88,4.69-.27,7,1.51,2.92,2.23,2.9,4.39,2.42,4.82C419.6,214.1,417.94,213.29,417.6,213.13Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 415.67px 210.03px;" id="el3biir6os6gy"
                            class="animable"></path>
                        <path
                            d="M440.54,210.73c-9.84,8.93-12,23.24-10.46,35.91,0,.29.48.23.49,0,.11-2.87.13-5.71.25-8.54.06-.13.1-.25.16-.38a19,19,0,0,0,6.42-6.39c1.7-3.06,2.46-6.55,3.8-9.76.12-.31-.22-.23-.44-.07-5.93,4-7.95,8.55-9.84,14.61a50.62,50.62,0,0,1,1.37-9.5c1.47-5.76,4.15-11.43,8.49-15.58C440.94,210.83,440.71,210.57,440.54,210.73Z"
                            style="fill: rgb(166, 166, 166); transform-origin: 435.428px 228.758px;"
                            id="el55d2jegelwn" class="animable"></path>
                        <path
                            d="M442.28,211.88c1.63.12,2.56,2.76,3.8,3.57a1.21,1.21,0,0,0,1.81-.21c1.33-1.71-.31-4-1.9-5.23,1.15.53,2.08,1.4,3.33,1.69a1.18,1.18,0,0,0,1.56-.86c.64-2.38-2.32-3.56-4.39-3.69,1-.65,4-2.44,2.48-3.42s-5,1.58-6.11,2.43c-1.66,1.25-3.66,3.13-3.81,5.18C438.86,213.72,441,212.33,442.28,211.88Z"
                            style="fill: rgb(219, 219, 219); transform-origin: 445.003px 209.637px;"
                            id="elila9uu48qgj" class="animable"></path>
                        <path
                            d="M441.8,212.26c2.12-.87,6.08.65,6.45-.13.75-1.58-2.41-2.8-4.13-3.08,1.61-.37,4.69-.94,4.65-2.48,0-1.89-4.67-.45-7,1.24-3,2.12-3.06,4.28-2.6,4.73C439.76,213.15,441.44,212.41,441.8,212.26Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 443.865px 209.227px;"
                            id="el2fceev2k8c9" class="animable"></path>
                        <path
                            d="M430.47,234.31a97.14,97.14,0,0,1-3.05,14.13.35.35,0,0,1-.69-.14c.64-4.36,1.82-8.63,2.47-13A65.27,65.27,0,0,0,430,222c-.42-7.33-2.41-15.13-7.19-20.87-.11-.14.11-.33.22-.2,9.58,11.17,8.06,24.86,8.05,26.09,1.36-4.62,2.75-9.92,7.88-14.63.22-.21.4-.11.36.24-.92,8.57-3.3,13.05-8.27,17.64C430.86,231.63,430.69,233,430.47,234.31Z"
                            style="fill: rgb(166, 166, 166); transform-origin: 431.053px 224.804px;"
                            id="elz9k351spt8s" class="animable"></path>
                        <path
                            d="M422.68,202.41c-1.72-.76-4.1,1.43-5.81,1.58a1.4,1.4,0,0,1-1.72-1.2c-.43-2.46,2.46-3.84,4.76-4.29-1.45-.08-2.87.3-4.29-.08a1.37,1.37,0,0,1-1.13-1.72c.64-2.77,4.3-2.36,6.47-1.38-.69-1.22-2.72-4.63-.67-4.83s4.21,4.31,4.9,5.79c1,2.17,2,5.18,1.08,7.34C425.16,206.15,423.73,203.57,422.68,202.41Z"
                            style="fill: rgb(219, 219, 219); transform-origin: 420.537px 197.589px;"
                            id="el6ehhfhp7luf" class="animable"></path>
                        <path
                            d="M423,203.07c-1.69-2-6.55-2.64-6.5-3.63.09-2,4-1.55,5.88-.9-1.44-1.25-4.26-3.5-3.39-5,1.06-1.89,5,2.09,6.5,5.09,1.9,3.79.8,6,.08,6.22C424.55,205.08,423.25,203.41,423,203.07Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 421.523px 198.961px;"
                            id="ele3dpskb104q" class="animable"></path>
                        <path d="M436.78,236.9,441,269.18H415.29c.53-2.86,5.32-32.32,5.32-32.32Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 428.145px 253.02px;" id="elwuvxdu6ba5"
                            class="animable"></path>
                    </g>
                    <g id="freepik--Shadow--inject-40" class="animable" style="transform-origin: 250px 439.23px;">
                        <path
                            d="M448.31,439.23c0,11.28-88.78,20.42-198.31,20.42S51.69,450.51,51.69,439.23,140.47,418.81,250,418.81,448.31,428,448.31,439.23Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 250px 439.23px;" id="el6yz1793cgbb"
                            class="animable"></path>
                    </g>
                    <g id="freepik--Floor--inject-40" class="animable"
                        style="transform-origin: 249.995px 406.445px;">
                        <polygon
                            points="46.98 406.44 97.74 406.2 148.49 406.11 250 405.95 351.51 406.11 402.26 406.2 453.01 406.44 402.26 406.69 351.51 406.78 250 406.94 148.49 406.78 97.74 406.69 46.98 406.44"
                            style="fill: rgb(38, 50, 56); transform-origin: 249.995px 406.445px;" id="el8huvuy0dbww"
                            class="animable"></polygon>
                    </g>
                    <g id="freepik--Device--inject-40" class="animable" style="transform-origin: 250px 253.34px;">
                        <path
                            d="M334.52,61.92H165.46a17.26,17.26,0,0,0-17.1,17.42v348a17.27,17.27,0,0,0,17.1,17.42H334.52a17.29,17.29,0,0,0,17.12-17.42v-348A17.28,17.28,0,0,0,334.52,61.92Zm6.42,354.67c0,9.16-6.86,16.57-15.32,16.57H174.38c-8.48,0-15.34-7.41-15.34-16.57V92.53C159,73.87,165.9,73,174.38,73h30.3c1.76,0,3.2,2,3.2,4.48v1.07c0,5.81,3.18,5.83,7.08,5.83H285c3.94,0,7.1,0,7.1-5.83V77.44c0-2.48,1.42-4.48,3.21-4.48h30.29c8.46,0,15.32,2.48,15.32,19.57Z"
                            style="fill: rgb(55, 71, 79); transform-origin: 250px 253.34px;" id="el3omeocu2ymm"
                            class="animable"></path>
                        <path
                            d="M340.94,92.53V416.59c0,9.16-6.86,16.57-15.32,16.57H174.38c-8.48,0-15.34-7.41-15.34-16.57V92.53C159,73.87,165.9,73,174.38,73h30.3c1.76,0,3.2,2,3.2,4.48v1.07c0,5.81,3.18,5.83,7.08,5.83H285c3.94,0,7.1,0,7.1-5.83V77.44c0-2.48,1.42-4.48,3.21-4.48h30.29C334.08,73,340.94,75.44,340.94,92.53Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 249.99px 253.06px;" id="el8jmwwgq5a8s"
                            class="animable"></path>
                        <path
                            d="M340.94,92.53V228.75H159V92.53C159,73.87,165.9,73,174.38,73h30.3c1.76,0,3.2,2,3.2,4.48v1.07c0,5.81,3.18,5.83,7.08,5.83H285c3.94,0,7.1,0,7.1-5.83V77.44c0-2.48,1.42-4.48,3.21-4.48h30.29C334.08,73,340.94,75.44,340.94,92.53Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 249.97px 150.855px;" id="elisnm7qlm5m8"
                            class="animable"></path>
                        <g id="freepik--u5Zjqx--inject-40" class="animable"
                            style="transform-origin: 196.175px 81.1625px;">
                            <path
                                d="M199.45,80.24l-.29.29c-.06,0-.11.11-.17.17a3.9,3.9,0,0,0-2.82-1.17,3.86,3.86,0,0,0-2.82,1.17l-.16-.17-.29-.29h0l0,0,.37-.32a4.06,4.06,0,0,1,.86-.55,4.18,4.18,0,0,1,1.13-.38c.19,0,.38,0,.57-.08h.5l.38,0a4.51,4.51,0,0,1,1,.25,4.58,4.58,0,0,1,.71.33,4.48,4.48,0,0,1,.67.47l.31.28Z"
                                style="fill: rgb(255, 255, 255); transform-origin: 196.175px 79.805px;"
                                id="ell5xrdt2zlnd" class="animable"></path>
                            <path
                                d="M194.27,81.62c-.15-.16-.3-.31-.46-.46a3.32,3.32,0,0,1,4.71,0l-.46.46a2.68,2.68,0,0,0-3.79,0Z"
                                style="fill: rgb(255, 255, 255); transform-origin: 196.165px 80.9001px;"
                                id="el3vphf6m9ln1" class="animable"></path>
                            <path
                                d="M197.6,82.08l-.46.46a1.31,1.31,0,0,0-1-.4,1.35,1.35,0,0,0-1,.4l-.46-.46A2,2,0,0,1,197.6,82.08Z"
                                style="fill: rgb(255, 255, 255); transform-origin: 196.14px 81.9934px;"
                                id="el7400cou9myr" class="animable"></path>
                            <path d="M196.58,83a.41.41,0,0,1-.41.41.42.42,0,1,1,0-.83A.41.41,0,0,1,196.58,83Z"
                                style="fill: rgb(255, 255, 255); transform-origin: 196.133px 82.995px;"
                                id="elsi8c8zvnp" class="animable"></path>
                        </g>
                        <path d="M170.9,81.12a1.21,1.21,0,1,1,1.21,1.21A1.21,1.21,0,0,1,170.9,81.12Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 172.11px 81.12px;" id="elagnmpie1hvd"
                            class="animable"></path>
                        <path d="M174.7,81.12a1.21,1.21,0,1,1,1.21,1.21A1.21,1.21,0,0,1,174.7,81.12Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 175.91px 81.12px;" id="eloyf7adgnt08"
                            class="animable"></path>
                        <path d="M178.5,81.12a1.21,1.21,0,1,1,1.2,1.21A1.2,1.2,0,0,1,178.5,81.12Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 179.71px 81.12px;" id="el54m5tyszuos"
                            class="animable"></path>
                        <path d="M182.3,81.12a1.21,1.21,0,1,1,1.2,1.21A1.2,1.2,0,0,1,182.3,81.12Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 183.51px 81.12px;" id="eljrzocvc9ero"
                            class="animable"></path>
                        <path d="M186.09,81.12a1.21,1.21,0,1,1,1.21,1.21A1.21,1.21,0,0,1,186.09,81.12Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 187.3px 81.12px;" id="elms8frns47jm"
                            class="animable"></path>
                        <path d="M327.3,83.75h-9.82V79.21h9.82Zm-9.32-.5h8.82V79.71H318Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 322.39px 81.48px;" id="elxxatzgfzpsj"
                            class="animable"></path>
                        <rect x="318.3" y="79.98" width="6.33" height="3"
                            style="fill: rgb(255, 255, 255); transform-origin: 321.465px 81.48px;" id="eld0nf1vdd25p"
                            class="animable"></rect>
                        <rect x="327.3" y="80.27" width="0.87" height="2.43"
                            style="fill: rgb(255, 255, 255); transform-origin: 327.735px 81.485px;" id="eljaulwsvtt3"
                            class="animable"></rect>
                        <polygon
                            points="176.28 110.7 170.91 105.67 176.28 100.64 177.11 101.52 172.69 105.67 177.11 109.82 176.28 110.7"
                            style="fill: rgb(255, 255, 255); transform-origin: 174.01px 105.67px;" id="ela0e8wygvbq"
                            class="animable"></polygon>
                        <path d="M271,190.94a39.29,39.29,0,0,1-11.55,4.84A40.08,40.08,0,1,1,271,190.94Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 249.925px 156.848px;"
                            id="elczjfxib0g88" class="animable"></path>
                        <path d="M262.17,152.29A12.19,12.19,0,1,1,250,140.1,12.19,12.19,0,0,1,262.17,152.29Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 249.98px 152.29px;" id="eljkl8fjh1zbo"
                            class="animable"></path>
                        <path
                            d="M271,185.92v5a39.29,39.29,0,0,1-11.55,4.84,39.88,39.88,0,0,1-30.57-4.85v-5a21.06,21.06,0,1,1,42.12,0Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 249.94px 180.882px;" id="elaq08cvubn8a"
                            class="animable"></path>
                        <rect x="178.52" y="214.87" width="142.96" height="138.8"
                            style="fill: rgb(255, 255, 255); transform-origin: 250px 284.27px;" id="el04n4qq439k9h"
                            class="animable"></rect>
                        <path
                            d="M226.78,231.38l-3.67,8.74a.47.47,0,0,1-.08.14h0l-.08.09s0,0,0,0a.34.34,0,0,0-.11.07h0c-.05,0-.08.08-.14.09h0a0,0,0,0,0,0,0l-.12,0h-.36l-.1,0,0,0a.28.28,0,0,1-.14-.09h0l-.11-.07,0,0a.47.47,0,0,0-.06-.09s0,0,0,0a.45.45,0,0,1-.06-.14l-2-4.65-2,4.65a.45.45,0,0,1-.06.14,0,0,0,0,0,0,0l-.09.09s0,0,0,0a.18.18,0,0,0-.08.07h0a.74.74,0,0,1-.12.09h0a0,0,0,0,0,0,0,.21.21,0,0,0-.12,0h-.37a.26.26,0,0,0-.11,0l0,0a.34.34,0,0,1-.14-.09h0c-.05,0-.06-.06-.11-.07a.09.09,0,0,1,0,0l-.08-.09h0s0-.09-.07-.14l-3.69-8.74a.82.82,0,0,1,1.52-.63l2.93,6.94,1.94-4.6a.82.82,0,0,1,.78-.51.86.86,0,0,1,.78.51l1.93,4.6,2.93-6.94a.83.83,0,0,1,1.09-.44A.81.81,0,0,1,226.78,231.38Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 219.779px 235.376px;" id="el7bz0y8tp3gj"
                            class="animable"></path>
                        <path
                            d="M229.19,239.81V231a.81.81,0,0,1,.82-.83h4.9a.83.83,0,0,1,.83.83.85.85,0,0,1-.83.84h-4.06v2.74h3.49a.84.84,0,0,1,0,1.67h-3.49V239h4.06a.83.83,0,1,1,0,1.66H230A.81.81,0,0,1,229.19,239.81Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 232.465px 235.415px;" id="els042kt8aeb"
                            class="animable"></path>
                        <path
                            d="M238.08,239.81V231a.83.83,0,0,1,.82-.83.85.85,0,0,1,.85.83v8h4.06a.83.83,0,0,1,0,1.66H238.9A.82.82,0,0,1,238.08,239.81Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 241.36px 235.415px;" id="elrm1k2blr1bg"
                            class="animable"></path>
                        <path
                            d="M245.46,235.23a5.5,5.5,0,0,1,5.5-5.4,5.67,5.67,0,0,1,3.47,1.17.89.89,0,0,1,.15,1.2.88.88,0,0,1-1.2.17,3.76,3.76,0,0,0-2.42-.83,4,4,0,0,0-2.7,1.08,3.72,3.72,0,0,0-1.09,2.61,3.66,3.66,0,0,0,1.09,2.61,4,4,0,0,0,2.7,1.08,3.79,3.79,0,0,0,2.42-.82.9.9,0,0,1,1.2.16.88.88,0,0,1-.15,1.2,5.61,5.61,0,0,1-3.47,1.17A5.48,5.48,0,0,1,245.46,235.23Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 250.105px 235.23px;" id="elhp3tdhthaek"
                            class="animable"></path>
                        <path
                            d="M265.47,231.44a5.52,5.52,0,0,1,0,7.59,5,5,0,0,1-3.59,1.6,5.06,5.06,0,0,1-3.67-1.6,5.58,5.58,0,0,1,0-7.59,5,5,0,0,1,3.67-1.61A4.88,4.88,0,0,1,265.47,231.44Zm-.2,3.79a3.85,3.85,0,0,0-1-2.62,3.23,3.23,0,0,0-4.8,0,3.8,3.8,0,0,0-1,2.62,3.74,3.74,0,0,0,1,2.61,3.21,3.21,0,0,0,4.8,0A3.79,3.79,0,0,0,265.27,235.23Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 261.851px 235.23px;" id="elwcsrw7s31x"
                            class="animable"></path>
                        <path
                            d="M278.37,231v8.85a.84.84,0,0,1-.84.82.82.82,0,0,1-.83-.82v-6.32l-2.16,3a.8.8,0,0,1-.67.35h0a.83.83,0,0,1-.69-.35l-2.15-3v6.32a.83.83,0,0,1-1.66,0V231a.83.83,0,0,1,.82-.83h0a.8.8,0,0,1,.66.35l3,4.14,3-4.14a.8.8,0,0,1,.67-.35h0A.86.86,0,0,1,278.37,231Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 273.87px 235.425px;" id="eln4601uogjkl"
                            class="animable"></path>
                        <path
                            d="M281.25,239.81V231a.81.81,0,0,1,.82-.83H287a.83.83,0,0,1,.82.83.85.85,0,0,1-.82.84h-4.07v2.74h3.5a.84.84,0,0,1,0,1.67h-3.5V239H287a.83.83,0,0,1,0,1.66h-4.91A.82.82,0,0,1,281.25,239.81Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 284.54px 235.415px;" id="elkk0q2k9e568"
                            class="animable"></path>
                        <path
                            d="M195.24,265.24V261.7a.33.33,0,0,1,.33-.33h2a.34.34,0,0,1,0,.67h-1.62v1.1h1.39a.33.33,0,0,1,0,.66h-1.39v1.11h1.62a.33.33,0,0,1,0,.66h-2A.33.33,0,0,1,195.24,265.24Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 196.57px 263.47px;" id="el44qwnu184br"
                            class="animable"></path>
                        <path
                            d="M202.41,261.7v3.54a.34.34,0,0,1-.34.33.33.33,0,0,1-.33-.33v-2.52l-.86,1.2a.32.32,0,0,1-.27.13h0a.34.34,0,0,1-.28-.13l-.85-1.2v2.52a.34.34,0,0,1-.67,0V261.7a.33.33,0,0,1,.33-.33h0a.33.33,0,0,1,.26.14l1.19,1.66,1.2-1.66a.32.32,0,0,1,.27-.14h0A.35.35,0,0,1,202.41,261.7Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 200.61px 263.47px;" id="elne4s79aylcl"
                            class="animable"></path>
                        <path
                            d="M205.61,264.58h-1.45l-.3.78a.34.34,0,0,1-.31.21.2.2,0,0,1-.11,0,.33.33,0,0,1-.2-.43l1.32-3.53a.34.34,0,0,1,.32-.21.32.32,0,0,1,.32.21l1.33,3.53a.34.34,0,0,1-.2.43.22.22,0,0,1-.12,0,.32.32,0,0,1-.3-.21Zm-.24-.66-.49-1.29-.48,1.29Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 204.884px 263.489px;" id="elalya3j7sk7"
                            class="animable"></path>
                        <path
                            d="M207.39,261.7a.33.33,0,0,1,.33-.33.34.34,0,0,1,.34.33v3.54a.34.34,0,0,1-.34.33.33.33,0,0,1-.33-.33Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 207.725px 263.47px;" id="elojymd4sy8jq"
                            class="animable"></path>
                        <path
                            d="M209.18,265.24V261.7a.33.33,0,0,1,.33-.33.34.34,0,0,1,.34.33v3.21h1.62a.33.33,0,0,1,0,.66h-2A.33.33,0,0,1,209.18,265.24Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 210.49px 263.47px;" id="elrmfyfjzdfx"
                            class="animable"></path>
                        <path
                            d="M195,276.91a1.42,1.42,0,1,1,2.84-.11h0a.15.15,0,0,1-.15.14h-2.41a1.15,1.15,0,0,0,1.14,1.12,1.11,1.11,0,0,0,1-.53.15.15,0,0,1,.19-.05.16.16,0,0,1,.05.21,1.4,1.4,0,0,1-1.19.66A1.44,1.44,0,0,1,195,276.91Zm.3-.24h2.23a1.13,1.13,0,0,0-2.23,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 196.419px 276.892px;" id="elk6tv08evwjd"
                            class="animable"></path>
                        <path
                            d="M203,276.63a.91.91,0,1,0-1.81,0v1.62h0v0a.12.12,0,0,1-.07.07.11.11,0,0,1-.07,0h0l0,0h0l0,0h0v0h0v0h0v-1.62a.91.91,0,1,0-1.81,0v1.6a.14.14,0,0,1-.06.12l0,0H199a.15.15,0,0,1-.12-.11v-2.68a.14.14,0,0,1,.14-.14.14.14,0,0,1,.14.14v.28a1.18,1.18,0,0,1,.91-.42,1.21,1.21,0,0,1,1,.62,1.21,1.21,0,0,1,1.05-.62,1.19,1.19,0,0,1,1.2,1.19v1.6a.14.14,0,0,1-.15.14.14.14,0,0,1-.14-.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 201.1px 276.955px;" id="elwuxw2ddciam"
                            class="animable"></path>
                        <path
                            d="M208.74,276.63a.91.91,0,1,0-1.82,0v1.62h0v0a.18.18,0,0,1-.08.07.08.08,0,0,1-.07,0h0l0,0h0l0,0h0v0h0v0h0v-1.62a.91.91,0,1,0-1.81,0v1.6a.15.15,0,0,1-.07.12l0,0h-.06a.13.13,0,0,1-.12-.11v-2.68a.13.13,0,0,1,.13-.14.14.14,0,0,1,.15.14v.28a1.16,1.16,0,0,1,.9-.42,1.18,1.18,0,0,1,1.05.62,1.22,1.22,0,0,1,1.06-.62,1.19,1.19,0,0,1,1.19,1.19v1.6a.14.14,0,0,1-.28,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 206.95px 276.955px;" id="elr2tlut6rypf"
                            class="animable"></path>
                        <path
                            d="M212.71,275.58v2.65a.15.15,0,0,1-.15.14.14.14,0,0,1-.14-.14v-.44a1.35,1.35,0,0,1-1.1.58,1.47,1.47,0,0,1,0-2.94,1.35,1.35,0,0,1,1.1.58v-.43a.14.14,0,0,1,.14-.15A.15.15,0,0,1,212.71,275.58Zm-.29,1.32a1.11,1.11,0,1,0-1.1,1.18A1.15,1.15,0,0,0,212.42,276.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 211.28px 276.9px;" id="eleu93kzip8su"
                            class="animable"></path>
                        <path
                            d="M214.23,279.23a.22.22,0,0,0,.22-.22v-3.43a.15.15,0,0,1,.15-.15.15.15,0,0,1,.14.15V279a.51.51,0,0,1-.51.51.14.14,0,0,1-.14-.14A.14.14,0,0,1,214.23,279.23Zm.23-4.61a.16.16,0,0,1,.15-.15.15.15,0,0,1,.14.15v.14a.15.15,0,0,1-.14.15.17.17,0,0,1-.15-.15Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 214.42px 276.99px;" id="eler94wer0h1r"
                            class="animable"></path>
                        <path
                            d="M218.51,275.58v2.65a.14.14,0,0,1-.28,0v-.44a1.39,1.39,0,0,1-1.11.58,1.47,1.47,0,0,1,0-2.94,1.39,1.39,0,0,1,1.11.58v-.43a.14.14,0,1,1,.28,0Zm-.28,1.32a1.11,1.11,0,1,0-1.11,1.18A1.15,1.15,0,0,0,218.23,276.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 217.08px 276.9px;" id="el0d75w9pkeroc"
                            class="animable"></path>
                        <path
                            d="M224,276.63a.91.91,0,1,0-1.82,0v1.62h0v0a.12.12,0,0,1-.07.07.1.1,0,0,1-.07,0h0l0,0h0v0h0v0h0v0h0v-1.62a.91.91,0,1,0-1.81,0v1.6a.15.15,0,0,1-.07.12l0,0h-.06a.15.15,0,0,1-.12-.11v-2.68a.14.14,0,0,1,.14-.14.14.14,0,0,1,.15.14v.28a1.16,1.16,0,0,1,.9-.42,1.18,1.18,0,0,1,1.05.62,1.22,1.22,0,0,1,1.06-.62,1.19,1.19,0,0,1,1.19,1.19v1.6a.14.14,0,0,1-.28,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 222.225px 276.955px;" id="eljnah8s459f7"
                            class="animable"></path>
                        <path
                            d="M225.26,276.91a1.42,1.42,0,1,1,2.84-.11h0a.14.14,0,0,1-.14.14h-2.41a1.15,1.15,0,0,0,1.14,1.12,1.08,1.08,0,0,0,.94-.53.16.16,0,0,1,.2-.05.16.16,0,0,1,0,.21,1.39,1.39,0,0,1-1.18.66A1.45,1.45,0,0,1,225.26,276.91Zm.31-.24h2.22a1.13,1.13,0,0,0-1.1-.95A1.15,1.15,0,0,0,225.57,276.67Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 226.679px 276.889px;" id="els0hw0cftkab"
                            class="animable"></path>
                        <path
                            d="M228.92,277.76a.14.14,0,0,1,.2,0,1.6,1.6,0,0,0,.9.34.87.87,0,0,0,.56-.18.43.43,0,0,0,.22-.36.46.46,0,0,0-.21-.36A1.52,1.52,0,0,0,230,277h0a1.56,1.56,0,0,1-.67-.23.62.62,0,0,1-.32-.52.75.75,0,0,1,.32-.58,1.26,1.26,0,0,1,.72-.2,1.62,1.62,0,0,1,.88.32.17.17,0,0,1,0,.21.15.15,0,0,1-.2,0,1.26,1.26,0,0,0-.72-.3.91.91,0,0,0-.56.17.45.45,0,0,0-.18.34.35.35,0,0,0,.16.29,1.66,1.66,0,0,0,.6.21h0a2,2,0,0,1,.71.23.7.7,0,0,1,0,1.2,1.18,1.18,0,0,1-.73.23,1.75,1.75,0,0,1-1.08-.42A.13.13,0,0,1,228.92,277.76Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 229.981px 276.92px;" id="elay8ooaf961b"
                            class="animable"></path>
                        <path
                            d="M234.25,277.51H232l-.09,0a.16.16,0,0,1,0-.21l2.43-3h0a.13.13,0,0,1,.2,0,.15.15,0,0,1,0,.07v2.92h.28a.15.15,0,1,1,0,.29h-.28v.72a.15.15,0,0,1-.3,0Zm0-.29v-2.46l-2,2.46Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 233.44px 276.352px;" id="elanhzq1ksxwd"
                            class="animable"></path>
                        <path
                            d="M237.92,274.17a2.09,2.09,0,0,1,2.1,2.1,2.05,2.05,0,0,1-.22,1,1.06,1.06,0,0,1-.54.45h-.12a.42.42,0,0,1-.35-.16.5.5,0,0,1-.09-.29V277a1,1,0,0,1-.78.36,1.13,1.13,0,0,1,0-2.25,1.1,1.1,0,0,1,1.07,1.12v1h0a.38.38,0,0,0,0,.13.14.14,0,0,0,.11,0h0a.61.61,0,0,0,.35-.31,1.72,1.72,0,0,0,.2-.82,1.81,1.81,0,1,0-1.81,1.81,1.68,1.68,0,0,0,.45-.05c.08,0,.17,0,.17.1a.14.14,0,0,1-.1.18,2.18,2.18,0,0,1-.52.06,2.1,2.1,0,1,1,0-4.2Zm0,2.92a.8.8,0,0,0,.77-.82.77.77,0,1,0-1.53,0A.79.79,0,0,0,237.92,277.09Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 237.881px 276.23px;" id="el64k7fpfu5oh"
                            class="animable"></path>
                        <path
                            d="M246.14,276.63a.91.91,0,1,0-1.81,0v1.62h0v0a.12.12,0,0,1-.07.07.11.11,0,0,1-.07,0h-.05l0,0h0l0,0h0v0h0v0h0v-1.62a.91.91,0,1,0-1.81,0v1.6a.14.14,0,0,1-.06.12l0,0h-.06a.15.15,0,0,1-.12-.11v-2.68a.14.14,0,0,1,.14-.14.14.14,0,0,1,.14.14v.28a1.18,1.18,0,0,1,.91-.42,1.2,1.2,0,0,0,2.1,0,1.19,1.19,0,0,1,1.19,1.19v1.6a.13.13,0,0,1-.14.14.14.14,0,0,1-.14-.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 244.33px 276.955px;" id="eljd9cscc1ut"
                            class="animable"></path>
                        <path
                            d="M250.11,275.58v2.65a.14.14,0,0,1-.14.14.15.15,0,0,1-.15-.14v-.44a1.35,1.35,0,0,1-1.1.58,1.47,1.47,0,0,1,0-2.94,1.35,1.35,0,0,1,1.1.58v-.43a.15.15,0,0,1,.15-.15A.15.15,0,0,1,250.11,275.58Zm-.29,1.32a1.1,1.1,0,1,0-1.1,1.18A1.15,1.15,0,0,0,249.82,276.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 248.68px 276.9px;" id="el4004n548chn"
                            class="animable"></path>
                        <path
                            d="M251.37,274.62a.15.15,0,0,1,.14-.15.15.15,0,0,1,.15.15v.14a.15.15,0,0,1-.15.15.15.15,0,0,1-.14-.15Zm0,1a.14.14,0,0,1,.14-.15.15.15,0,0,1,.15.15v2.65a.15.15,0,0,1-.15.14.14.14,0,0,1-.14-.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 251.515px 276.44px;" id="elnx06el7flrq"
                            class="animable"></path>
                        <path
                            d="M253,274.32a.15.15,0,0,1,.14-.15.15.15,0,0,1,.15.15v3.91a.14.14,0,0,1-.15.14.14.14,0,0,1-.14-.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 253.145px 276.27px;" id="el8je0feq5gp5"
                            class="animable"></path>
                        <path d="M254.65,277.77a.3.3,0,1,1,0,.6.3.3,0,0,1,0-.6Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 254.65px 278.07px;" id="elg5qsqavzyl"
                            class="animable"></path>
                        <path
                            d="M255.46,276.9a1.51,1.51,0,0,1,2.45-1.14.14.14,0,0,1,0,.2.15.15,0,0,1-.2,0,1.2,1.2,0,1,0-.76,2.1,1.24,1.24,0,0,0,.76-.25.15.15,0,0,1,.2,0,.15.15,0,0,1,0,.21,1.55,1.55,0,0,1-.93.31A1.48,1.48,0,0,1,255.46,276.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 256.706px 276.881px;" id="ell80nr8kf3dh"
                            class="animable"></path>
                        <path
                            d="M260.26,275.43a1.47,1.47,0,1,1-1.39,1.47A1.44,1.44,0,0,1,260.26,275.43Zm0,2.65a1.15,1.15,0,0,0,1.11-1.18,1.11,1.11,0,1,0-2.21,0A1.14,1.14,0,0,0,260.26,278.08Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 260.34px 276.898px;" id="elh7c7tv83ndk"
                            class="animable"></path>
                        <path
                            d="M267,276.63a.92.92,0,0,0-.91-.91.9.9,0,0,0-.9.91v1.62h0v0a.12.12,0,0,1-.07.07.11.11,0,0,1-.07,0H265l0,0h0l0,0h0v0h0v0h0v-1.62a.91.91,0,1,0-1.81,0v1.6a.13.13,0,0,1-.07.12l0,0h-.06a.15.15,0,0,1-.12-.11v-2.68a.14.14,0,0,1,.14-.14.14.14,0,0,1,.14.14v.28a1.18,1.18,0,0,1,.91-.42,1.2,1.2,0,0,0,2.1,0,1.19,1.19,0,0,1,1.19,1.19v1.6a.14.14,0,0,1-.28,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 265.18px 276.955px;" id="elob1iq2si368"
                            class="animable"></path>
                        <polygon
                            points="194.62 281.74 208.46 281.56 222.31 281.45 250 281.37 277.69 281.45 291.54 281.56 305.38 281.74 291.54 281.93 277.69 282.03 250 282.12 222.31 282.03 208.46 281.92 194.62 281.74"
                            style="fill: rgb(219, 219, 219); transform-origin: 250px 281.745px;" id="elyr7lcugbro"
                            class="animable"></polygon>
                        <path
                            d="M196.65,297.69h-.74V299a.34.34,0,0,1-.67,0v-3.54a.33.33,0,0,1,.33-.33h1.08a1.28,1.28,0,1,1,0,2.56Zm-.74-.66h.74a.62.62,0,1,0,0-1.24h-.74Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 196.585px 297.206px;" id="elcmfnnu6vi08"
                            class="animable"></path>
                        <path
                            d="M200.46,298.33H199l-.29.78a.32.32,0,0,1-.31.21h-.12a.34.34,0,0,1-.19-.43l1.32-3.54a.36.36,0,0,1,.32-.21.35.35,0,0,1,.32.21l1.32,3.54a.34.34,0,0,1-.2.43h-.11a.32.32,0,0,1-.31-.21Zm-.25-.65-.48-1.29-.49,1.29Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 199.729px 297.23px;" id="elpnx0qgpc18"
                            class="animable"></path>
                        <path
                            d="M202,298.28a.32.32,0,0,1,.44,0,1.89,1.89,0,0,0,1.14.46,1.31,1.31,0,0,0,.75-.22.54.54,0,0,0,.26-.43.38.38,0,0,0-.05-.19.51.51,0,0,0-.18-.18,2.41,2.41,0,0,0-.82-.29h0a3,3,0,0,1-.78-.23,1.35,1.35,0,0,1-.56-.47.9.9,0,0,1-.13-.49,1.11,1.11,0,0,1,.48-.88,1.77,1.77,0,0,1,1-.31,2.34,2.34,0,0,1,1.31.48.29.29,0,0,1,.08.42.29.29,0,0,1-.42.09,1.78,1.78,0,0,0-1-.38,1.13,1.13,0,0,0-.67.2.48.48,0,0,0-.23.38.31.31,0,0,0,.05.17.47.47,0,0,0,.16.15,1.94,1.94,0,0,0,.75.27h0a3.85,3.85,0,0,1,.83.25,1.47,1.47,0,0,1,.6.5,1,1,0,0,1,.14.51,1.18,1.18,0,0,1-.52.93,1.9,1.9,0,0,1-1.11.34,2.61,2.61,0,0,1-1.53-.6A.33.33,0,0,1,202,298.28Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 203.521px 297.205px;" id="elsnd4046kd1g"
                            class="animable"></path>
                        <path
                            d="M205.9,298.28a.32.32,0,0,1,.44,0,1.92,1.92,0,0,0,1.15.46,1.31,1.31,0,0,0,.75-.22.52.52,0,0,0,.25-.43.3.3,0,0,0-.05-.19.51.51,0,0,0-.18-.18,2.33,2.33,0,0,0-.82-.29h0a3.09,3.09,0,0,1-.78-.23,1.32,1.32,0,0,1-.55-.47.91.91,0,0,1-.14-.49,1.11,1.11,0,0,1,.48-.88,1.8,1.8,0,0,1,1-.31,2.31,2.31,0,0,1,1.3.48.31.31,0,0,1,.09.42.3.3,0,0,1-.43.09,1.78,1.78,0,0,0-1-.38,1.19,1.19,0,0,0-.68.2.47.47,0,0,0-.22.38.31.31,0,0,0,0,.17.47.47,0,0,0,.16.15,2.08,2.08,0,0,0,.75.27h0a3.69,3.69,0,0,1,.83.25,1.47,1.47,0,0,1,.6.5,1,1,0,0,1,.14.51,1.17,1.17,0,0,1-.51.93,2,2,0,0,1-1.11.34,2.61,2.61,0,0,1-1.54-.6A.33.33,0,0,1,205.9,298.28Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 207.373px 297.205px;" id="elatnkeox3l66"
                            class="animable"></path>
                        <path
                            d="M215.42,295.62l-1.47,3.5,0,.05h0l0,0h0l0,0h0a.13.13,0,0,1-.06,0h-.25a.09.09,0,0,1-.06,0h0l-.05,0h0s0,0,0,0h0s0,0,0-.05l-.78-1.86-.79,1.86,0,.05h0l0,0h0l0,0h0l-.05,0h-.26a.1.1,0,0,1-.05,0h0l0,0h0l0,0h0s0,0,0-.05l-1.47-3.5a.32.32,0,0,1,.18-.42.33.33,0,0,1,.43.17l1.17,2.78.77-1.84a.35.35,0,0,1,.32-.21.36.36,0,0,1,.31.21l.77,1.84,1.17-2.78a.34.34,0,0,1,.44-.17A.32.32,0,0,1,215.42,295.62Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 212.906px 297.174px;" id="elm2hqcqq722"
                            class="animable"></path>
                        <path
                            d="M219.6,295.65a2.19,2.19,0,0,1,0,3,2,2,0,0,1-1.43.64,2,2,0,0,1-1.47-.64,2.21,2.21,0,0,1,0-3,2,2,0,0,1,1.47-.64A1.91,1.91,0,0,1,219.6,295.65Zm-.08,1.52a1.53,1.53,0,0,0-.41-1.05,1.28,1.28,0,0,0-.94-.43,1.29,1.29,0,0,0-1,.43,1.54,1.54,0,0,0,0,2.09,1.29,1.29,0,0,0,1,.43,1.28,1.28,0,0,0,.94-.43A1.52,1.52,0,0,0,219.52,297.17Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 218.154px 297.15px;" id="el9qatyltxfn7"
                            class="animable"></path>
                        <path
                            d="M224.17,298.83a.34.34,0,0,1-.21.42h-.14a.5.5,0,0,1-.24-.06.77.77,0,0,1-.19-.21,1.7,1.7,0,0,1-.12-.72.5.5,0,0,0-.08-.26.43.43,0,0,0-.18-.17,1.22,1.22,0,0,0-.33-.15H222V299a.33.33,0,0,1-.34.32.32.32,0,0,1-.32-.32v-3.54a.32.32,0,0,1,.32-.33h1.08a1.28,1.28,0,0,1,.81,2.27.88.88,0,0,1,.21.22,1.14,1.14,0,0,1,.2.65,1.28,1.28,0,0,0,0,.35A.34.34,0,0,1,224.17,298.83Zm-.84-2.41a.63.63,0,0,0-.62-.63H222V297h.74A.62.62,0,0,0,223.33,296.42Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 222.762px 297.225px;" id="elvmhu2c0jsmq"
                            class="animable"></path>
                        <path
                            d="M225.14,299v-3.54a.32.32,0,0,1,.33-.33h.71a2.1,2.1,0,0,1,0,4.19h-.71A.32.32,0,0,1,225.14,299Zm.66-.34h.38a1.44,1.44,0,0,0,0-2.87h-.38Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 226.638px 297.225px;" id="elwqhdvabiy1"
                            class="animable"></path>
                        <path
                            d="M195.84,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29s-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38-.05-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38.1,0a.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13.26.26,0,0,1-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 195.921px 308.765px;" id="elaub8dtyrzqa"
                            class="animable"></path>
                        <path
                            d="M198.42,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38,0-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 198.526px 308.765px;" id="el8woo9xa4art"
                            class="animable"></path>
                        <path
                            d="M201,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29s-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38L201,308a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.55-.38a.16.16,0,0,1,.09,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13.18.18,0,0,1-.09,0l-.55-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 201.091px 308.815px;" id="eljnpovol0up"
                            class="animable"></path>
                        <path
                            d="M203.58,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38-.05-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 203.661px 308.765px;" id="el38194za2mp8"
                            class="animable"></path>
                        <path
                            d="M206.16,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29s-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38,0-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l0,.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37,0,.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 206.291px 308.765px;" id="eloydk0m8iq7"
                            class="animable"></path>
                        <path
                            d="M208.74,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38-.05-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 208.821px 308.765px;" id="elqdt4duez8"
                            class="animable"></path>
                        <path
                            d="M211.31,308.93l-.54.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.61-.3-.61-.29s-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.54.38,0-.66a.11.11,0,0,1,.12-.13.12.12,0,0,1,.12.13l0,.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37,0,.65a.12.12,0,0,1-.12.13.11.11,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 211.446px 308.765px;" id="el20d2dmnwjra"
                            class="animable"></path>
                        <path
                            d="M213.9,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38-.05-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 213.981px 308.765px;" id="ely228tr0sfm"
                            class="animable"></path>
                        <path
                            d="M216.48,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.61-.3-.61-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38,0-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l0,.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37,0,.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 216.611px 308.765px;" id="elekknb0fuqcn"
                            class="animable"></path>
                        <path
                            d="M219.06,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29s-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38L219,308a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.54-.38a.19.19,0,0,1,.1,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13s-.06,0-.1,0l-.54-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 219.121px 308.815px;" id="elnsq5jr6u2lp"
                            class="animable"></path>
                        <path
                            d="M221.64,308.93l-.55.37s-.06,0-.1,0a.12.12,0,0,1,0-.24l.62-.3-.62-.29c-.05,0-.09-.06-.09-.12a.13.13,0,0,1,.12-.12.17.17,0,0,1,.1,0l.55.38,0-.66a.12.12,0,0,1,.12-.13.12.12,0,0,1,.12.13l-.05.66.55-.38a.14.14,0,0,1,.09,0,.12.12,0,0,1,.12.12.12.12,0,0,1-.08.12l-.62.29.62.3a.1.1,0,0,1,.08.11.12.12,0,0,1-.12.13.15.15,0,0,1-.09,0l-.55-.37.05.65a.12.12,0,0,1-.12.13.12.12,0,0,1-.12-.13Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 221.746px 308.765px;" id="ellrrf4204cg"
                            class="animable"></path>
                        <polygon
                            points="194.62 315.5 208.46 315.31 222.31 315.21 250 315.12 277.69 315.21 291.54 315.31 305.38 315.5 291.54 315.68 277.69 315.78 250 315.87 222.31 315.78 208.46 315.68 194.62 315.5"
                            style="fill: rgb(219, 219, 219); transform-origin: 250px 315.495px;" id="elr3ah783x9vh"
                            class="animable"></polygon>
                        <rect x="223.16" y="304.52" width="0.5" height="8.98"
                            style="fill: rgb(38, 50, 56); transform-origin: 223.41px 309.01px;" id="el9vqet36ex3h"
                            class="animable"></rect>
                        <rect x="209.27" y="340.87" width="81.46" height="25.61"
                            style="fill: rgb(60, 79, 177); transform-origin: 250px 353.675px;" id="el2nge1myj9cp"
                            class="animable"></rect>
                        <path
                            d="M236.25,357v-5.31a.5.5,0,0,1,1,0v4.81h2.44a.51.51,0,0,1,.5.5.51.51,0,0,1-.5.5h-2.94A.5.5,0,0,1,236.25,357Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 238.22px 354.345px;" id="elx8yz6wmzjj"
                            class="animable"></path>
                        <path
                            d="M245.93,352a3.3,3.3,0,0,1,.91,2.28,3.26,3.26,0,0,1-.91,2.27,2.93,2.93,0,0,1-2.15,1,3,3,0,0,1-2.21-1,3.24,3.24,0,0,1-.89-2.27,3.28,3.28,0,0,1,.89-2.28,3,3,0,0,1,2.21-1A2.92,2.92,0,0,1,245.93,352Zm-.12,2.28a2.35,2.35,0,0,0-.61-1.58,2,2,0,0,0-1.42-.64,2,2,0,0,0-1.46.64,2.3,2.3,0,0,0-.61,1.58,2.22,2.22,0,0,0,.61,1.56,2,2,0,0,0,1.46.65,1.93,1.93,0,0,0,1.42-.65A2.26,2.26,0,0,0,245.81,354.28Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 243.76px 354.275px;" id="el7s1fasalrpc"
                            class="animable"></path>
                        <path
                            d="M248.33,354.29a3.28,3.28,0,0,1,3.32-3.25,3.35,3.35,0,0,1,2.06.7.51.51,0,0,1,.09.73.52.52,0,0,1-.72.08,2.35,2.35,0,0,0-1.43-.49,2.26,2.26,0,0,0-1.62.66,2.16,2.16,0,0,0-.67,1.57,2.13,2.13,0,0,0,.67,1.54,2.22,2.22,0,0,0,1.62.66,2.48,2.48,0,0,0,1.24-.34v-1.23H251.6a.52.52,0,0,1-.51-.52.5.5,0,0,1,.51-.5h1.79a.51.51,0,0,1,.52.5v2c0,.07,0,.1,0,.16l0,0h0a.49.49,0,0,1-.17.22,3.34,3.34,0,0,1-2,.7A3.27,3.27,0,0,1,248.33,354.29Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 251.122px 354.261px;"
                            id="elyqac0klwhdn" class="animable"></path>
                        <path
                            d="M256,351.71a.48.48,0,0,1,.49-.49.5.5,0,0,1,.51.49V357a.51.51,0,0,1-.51.5.49.49,0,0,1-.49-.5Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 256.5px 354.36px;" id="elzejyp4vytm"
                            class="animable"></path>
                        <path
                            d="M259.67,357a.49.49,0,1,1-1,0v-5.23h0a.47.47,0,0,1,.2-.41.49.49,0,0,1,.68.11l2.91,4v-3.71a.49.49,0,0,1,1,0V357a.5.5,0,0,1-.49.5.47.47,0,0,1-.37-.18l-.05-.06-2.88-4Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 261.065px 354.38px;" id="el80fqnpxk745"
                            class="animable"></path>
                        <path
                            d="M224.14,375.91a.14.14,0,0,1,.14-.14h2.17a.14.14,0,0,1,.14.14.15.15,0,0,1-.14.15h-2v1.66h1.76a.15.15,0,0,1,0,.3h-1.76v1.8a.15.15,0,0,1-.15.15.15.15,0,0,1-.14-.15Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 225.365px 377.87px;" id="ely6bn1ayg2em"
                            class="animable"></path>
                        <path
                            d="M228.52,377a1.47,1.47,0,1,1-1.39,1.47A1.44,1.44,0,0,1,228.52,377Zm0,2.65a1.19,1.19,0,1,0-1.11-1.18A1.15,1.15,0,0,0,228.52,379.68Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 228.6px 378.468px;" id="elcrvnxkfyb0s"
                            class="animable"></path>
                        <path
                            d="M230.89,377.18A.15.15,0,0,1,231,377a.14.14,0,0,1,.14.15v.65l0-.08a1.46,1.46,0,0,1,1.18-.72.14.14,0,0,1,.14.15.14.14,0,0,1-.14.14,1.07,1.07,0,0,0-.85.48,2.85,2.85,0,0,0-.36.68.13.13,0,0,0,0,0v1.29a.14.14,0,0,1-.14.15.15.15,0,0,1-.15-.15Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 231.64px 378.445px;" id="el6q214ikldpp"
                            class="animable"></path>
                        <path
                            d="M236.09,379.73a1.38,1.38,0,0,1-1.38,1.38,1.4,1.4,0,0,1-.61-.14.15.15,0,0,1-.06-.19.13.13,0,0,1,.19-.07,1,1,0,0,0,.48.11,1.09,1.09,0,0,0,1.1-1.09v-.36a1.33,1.33,0,0,1-1.1.58,1.46,1.46,0,0,1,0-2.92,1.35,1.35,0,0,1,1.1.57v-.43A.14.14,0,0,1,236,377a.13.13,0,0,1,.13.14Zm-.28-1.25a1.1,1.1,0,1,0-2.19,0,1.1,1.1,0,1,0,2.19,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 234.69px 379.049px;" id="elcnusdfs24mg"
                            class="animable"></path>
                        <path
                            d="M238.74,377a1.47,1.47,0,1,1-1.39,1.47A1.44,1.44,0,0,1,238.74,377Zm0,2.65a1.19,1.19,0,1,0-1.1-1.18A1.15,1.15,0,0,0,238.74,379.68Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 238.82px 378.468px;" id="elxkzax7k7e7p"
                            class="animable"></path>
                        <path
                            d="M242.15,377.17a.16.16,0,0,1-.15.15h-.37v2.14a.22.22,0,0,0,.21.21.15.15,0,0,1,0,.3.5.5,0,0,1-.51-.51v-2.14H241c-.14,0-.14-.08-.14-.15s0-.14.14-.14h.37v-1.09a.15.15,0,0,1,.14-.15.16.16,0,0,1,.16.15V377H242A.15.15,0,0,1,242.15,377.17Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 241.506px 377.88px;" id="elz9au8gae85n"
                            class="animable"></path>
                        <path
                            d="M245.32,378.54v-1.37a.15.15,0,0,1,.3,0v.43a1.36,1.36,0,0,1,1.11-.57,1.43,1.43,0,0,1,1.42,1.45,1.45,1.45,0,0,1-1.42,1.47,1.37,1.37,0,0,1-1.11-.58v1.68a.15.15,0,0,1-.3,0Zm.3-.06a1.12,1.12,0,1,0,2.24,0,1.12,1.12,0,1,0-2.24,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 246.735px 379.11px;" id="elzdml31skot"
                            class="animable"></path>
                        <path
                            d="M251.75,377.17v2.65a.15.15,0,1,1-.29,0v-.44a1.36,1.36,0,0,1-1.1.59,1.47,1.47,0,0,1,0-2.94,1.35,1.35,0,0,1,1.1.57v-.43a.14.14,0,0,1,.14-.14A.15.15,0,0,1,251.75,377.17Zm-.29,1.33a1.11,1.11,0,1,0-1.1,1.18A1.15,1.15,0,0,0,251.46,378.5Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 250.323px 378.519px;" id="elwnah4z887k"
                            class="animable"></path>
                        <path
                            d="M252.79,379.35a.14.14,0,0,1,.21,0,1.54,1.54,0,0,0,.9.34.86.86,0,0,0,.55-.18.45.45,0,0,0,.23-.36.46.46,0,0,0-.21-.36,1.47,1.47,0,0,0-.63-.22h0a1.65,1.65,0,0,1-.66-.23.61.61,0,0,1-.32-.53.74.74,0,0,1,.32-.58,1.3,1.3,0,0,1,.71-.19,1.62,1.62,0,0,1,.88.31.16.16,0,0,1,0,.21.14.14,0,0,1-.2,0,1.29,1.29,0,0,0-.72-.29.86.86,0,0,0-.55.16.46.46,0,0,0-.19.34.34.34,0,0,0,.17.29,1.43,1.43,0,0,0,.6.21h0a1.86,1.86,0,0,1,.71.24.7.7,0,0,1,.33.6.74.74,0,0,1-.33.59,1.23,1.23,0,0,1-.73.24,1.82,1.82,0,0,1-1.09-.42A.15.15,0,0,1,252.79,379.35Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 253.836px 378.49px;" id="ely8un9ohqlhh"
                            class="animable"></path>
                        <path
                            d="M255.69,379.35a.13.13,0,0,1,.2,0,1.57,1.57,0,0,0,.9.34.89.89,0,0,0,.56-.18.41.41,0,0,0,0-.72,1.47,1.47,0,0,0-.63-.22h0a1.65,1.65,0,0,1-.66-.23.61.61,0,0,1-.32-.53.74.74,0,0,1,.32-.58,1.34,1.34,0,0,1,.72-.19,1.62,1.62,0,0,1,.87.31.15.15,0,0,1,0,.21.13.13,0,0,1-.19,0,1.35,1.35,0,0,0-.72-.29.89.89,0,0,0-.56.16.46.46,0,0,0-.19.34.36.36,0,0,0,.17.29,1.43,1.43,0,0,0,.6.21h0a2,2,0,0,1,.72.24.72.72,0,0,1,.33.6.75.75,0,0,1-.34.59,1.18,1.18,0,0,1-.73.24,1.82,1.82,0,0,1-1.09-.42A.14.14,0,0,1,255.69,379.35Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 256.723px 378.49px;" id="el2yav72kzo8w"
                            class="animable"></path>
                        <path
                            d="M259.73,379.94s0,0-.06-.06l-1.1-2.63a.16.16,0,0,1,.07-.19.15.15,0,0,1,.19.08l1,2.32.67-1.62a.16.16,0,0,1,.29,0l.67,1.62,1-2.32a.14.14,0,0,1,.18-.08.15.15,0,0,1,.08.19l-1.1,2.61a.22.22,0,0,1-.05.08l-.07,0h0a.16.16,0,0,1-.12-.09h0l-.69-1.63-.68,1.62v0a.15.15,0,0,1-.13.09l-.05,0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 260.645px 378.495px;" id="elpc6w1hchw4c"
                            class="animable"></path>
                        <path
                            d="M265,377a1.47,1.47,0,1,1-1.39,1.47A1.44,1.44,0,0,1,265,377Zm0,2.65a1.19,1.19,0,1,0-1.1-1.18A1.15,1.15,0,0,0,265,379.68Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 265.08px 378.468px;" id="elapg1egpujem"
                            class="animable"></path>
                        <path
                            d="M267.4,377.18a.14.14,0,0,1,.15-.15.14.14,0,0,1,.13.15v.65l.05-.08a1.43,1.43,0,0,1,1.17-.72.15.15,0,0,1,.15.15.15.15,0,0,1-.15.14,1.07,1.07,0,0,0-.85.48,2.42,2.42,0,0,0-.35.68s0,0,0,0v1.29a.14.14,0,0,1-.13.15.14.14,0,0,1-.15-.15Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 268.225px 378.475px;" id="el9y61aji7xin"
                            class="animable"></path>
                        <path
                            d="M272.23,379.4a1.42,1.42,0,0,1-1.13.57,1.47,1.47,0,0,1,0-2.94,1.39,1.39,0,0,1,1.13.57v-1.69a.15.15,0,0,1,.3,0v3.91a.15.15,0,0,1-.3,0Zm0-.85v-.1a1.17,1.17,0,1,0,0,.1Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 271.08px 377.866px;" id="elkmn6nuxfe9s"
                            class="animable"></path>
                        <path
                            d="M274.52,378.24h0a.14.14,0,0,1,.14-.14,1,1,0,1,0,0-2,1,1,0,0,0-.87.51.16.16,0,0,1-.2.05.13.13,0,0,1,0-.19,1.27,1.27,0,0,1,1.11-.65,1.29,1.29,0,0,1,.15,2.58V379a.15.15,0,0,1-.15.14.14.14,0,0,1-.14-.14Zm0,1.46a.15.15,0,1,1,.29,0v.13a.15.15,0,0,1-.15.14.14.14,0,0,1-.14-.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 274.808px 377.894px;" id="elety519y5wwh"
                            class="animable"></path>
                        <path
                            d="M259.55,77.08H240.44a1.18,1.18,0,0,1-1.18-1.18h0a1.18,1.18,0,0,1,1.18-1.18h19.11a1.18,1.18,0,0,1,1.18,1.18h0A1.18,1.18,0,0,1,259.55,77.08Z"
                            style="fill: rgb(255, 255, 255); transform-origin: 249.995px 75.9px;" id="el35q07t7qxp5"
                            class="animable"></path>
                    </g>
                    <g id="freepik--Character--inject-40" class="animable"
                        style="transform-origin: 386.633px 266.605px;">
                        <path d="M340.31,129.43l-.4.1a.24.24,0,0,1,.07-.12h0Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 340.11px 129.47px;" id="el1yba9omblhs"
                            class="animable"></path>
                        <path d="M371.34,178h0"
                            style="fill: none; stroke: rgb(255, 152, 185); stroke-linecap: round; stroke-linejoin: round; stroke-width: 0px; transform-origin: 371.34px 178px;"
                            id="ely7wvay4yy5r" class="animable"></path>
                        <rect x="351.63" y="160.83" width="0.01" height="7.04"
                            style="fill: rgb(221, 106, 87); transform-origin: 351.635px 164.35px;" id="elvr5nlyara9o"
                            class="animable"></rect>
                        <path d="M351.64,160.83v8.92c0-.11,0-.23,0-.35v-8.57Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 351.64px 165.29px;" id="elhpof76rw52s"
                            class="animable"></path>
                        <path d="M371.34,178h0"
                            style="fill: none; stroke: rgb(255, 152, 185); stroke-linecap: round; stroke-linejoin: round; stroke-width: 0px; transform-origin: 371.34px 178px;"
                            id="elf13t54t5h1e" class="animable"></path>
                        <path d="M351.82,418.33l-.18,0v-.13Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 351.73px 418.265px;" id="elt24y50015j"
                            class="animable"></path>
                        <path
                            d="M393.12,426.86c-2.2-1-50.6-44.76-51.39-47.6-.31-1.07,5.66-8.49,13.13-17.26,1.61-1.89,20.43-32,20.43-32l33.91,26.89-23.06,33.29s11,25.06,11.56,28.27S395.32,427.83,393.12,426.86Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 375.459px 378.481px;" id="eluto64ykf31b"
                            class="animable"></path>
                        <path
                            d="M393.74,407.9a93.42,93.42,0,0,1,4,10.51c.52,3.21-2.38,9.42-4.58,8.45s-50.61-44.76-51.39-47.59c-.25-.88,3.62-5.93,9.09-12.48,9.78,11.36,40.62,46.72,42.88,43.43A4.39,4.39,0,0,0,393.74,407.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 369.78px 396.876px;" id="el5wk55gcb1l5"
                            class="animable"></path>
                        <path
                            d="M358.09,356.35l34.3,28.3s47.71-66.43,49.08-90.71c1-18.67-26.66-53.46-45.48-83.24-1.82-2.89-.71-13.85-.64-15.68l-37.29.07c-.45,4.2-3.37,25.33,2.91,35.62,12.92,21.16,33.78,51.87,34.58,58.52S358.09,356.35,358.09,356.35Z"
                            style="fill: rgb(55, 71, 79); transform-origin: 399.244px 289.835px;" id="elw2c3cd0wfa9"
                            class="animable"></path>
                        <path
                            d="M394.6,374.25c-5.48-4.64-3.84-3.38-9.37-8-2.71-2.24-16.28-13.54-19.15-15.22-.07,0-.14.06-.09.11,2.22,2.47,16,13.48,18.78,15.68,5.61,4.48,4.05,3.13,9.71,7.55A.1.1,0,1,0,394.6,374.25Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 380.325px 362.739px;" id="el04t4zncio9x9"
                            class="animable"></path>
                        <path
                            d="M398.85,283c-1.25-2.44-2.59-4.84-4-7.21C392.05,271,389,266.37,386,261.7q-4.69-7.32-9.4-14.62c-2.82-4.38-5.68-8.75-8.13-13.35a52.26,52.26,0,0,1-5.41-14.39c-1.1-5.54-.87-11.24-.39-16.84.12-1.4.25-2.79.38-4.19,0-.24-.39-.29-.42-.05a89.88,89.88,0,0,0-.79,16.55,44.37,44.37,0,0,0,3.82,14.69A101.81,101.81,0,0,0,373,242.8c3,4.73,6,9.43,9,14.13s6.13,9.51,9.12,14.31c1.46,2.33,2.89,4.68,4.25,7.07a71.42,71.42,0,0,1,3.8,7.25,11.75,11.75,0,0,1,1.05,3.93,9.64,9.64,0,0,1-.76,4.1c-1,2.57-2.34,5-3.56,7.5-2.44,4.93-4.92,9.84-7.48,14.71-5.14,9.77-19,32.77-19.73,33.95-.05.09.08.16.14.08,5.89-9.41,13.05-20.37,18.35-30.13q4-7.31,7.73-14.74,1.88-3.7,3.68-7.46c1.1-2.28,2.37-4.63,2.44-7.22S400,285.27,398.85,283Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 381.392px 273.984px;" id="eluu9yz165qca"
                            class="animable"></path>
                        <path
                            d="M394.05,195c-2.4,12.32-9.34,47.76-13.14,67.36-6.52-10.42-14.06-22-19.94-31.67-6.28-10.29-3.36-31.42-2.91-35.62Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 375.521px 228.68px;" id="elrius6h286t"
                            class="animable"></path>
                        <path
                            d="M401.31,451.53c-2.29.73-67.56-.19-70-1.8-.94-.61-1.36-10.12-1.54-21.63,0-2.48.55-40.37.55-40.37l43.66.49-2.13,40.35s24.84,11.53,27.35,13.59S403.6,450.8,401.31,451.53Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 366.056px 419.757px;" id="elv7jf2a4l6yn"
                            class="animable"></path>
                        <path
                            d="M389.25,436.88a95.07,95.07,0,0,1,9.92,5.28c2.51,2.06,4.43,8.64,2.14,9.36s-67.56-.18-70-1.79c-.77-.49-1.19-6.84-1.41-15.37,14.84,2.07,61.35,8.25,60.87,4.29C390.71,438.28,390.14,437.65,389.25,436.88Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 366.117px 443.066px;" id="el51f71d39x"
                            class="animable"></path>
                        <path
                            d="M395.35,195.09s-7.39,36-7.78,37.15a93.7,93.7,0,0,0-10.5,5.21l-2.64,183-47.08.31s5.84-97,5.67-103.24c-.26-10,4.07-77.64,3.47-79.34-6.15-17.36,3.5-43,3.5-43Z"
                            style="fill: rgb(55, 71, 79); transform-origin: 361.35px 307.925px;" id="elooyf9y4zlp9"
                            class="animable"></path>
                        <path
                            d="M372.66,411.72c-13.28-.57-39-.33-42.25.23-.07,0-.07.14,0,.15,3.29.53,34.5.59,42.25-.17A.11.11,0,0,0,372.66,411.72Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 351.547px 411.947px;" id="elcjgao1ltlv"
                            class="animable"></path>
                        <path
                            d="M338,365.14c.75-13.76,1.56-27.52,2.35-41.28s1.57-27.53,2.36-41.29c.39-6.88.76-13.76,1.18-20.64l.63-10.32a89.59,89.59,0,0,0,.44-10.22c-.19-3.72-1.82-7-2.75-10.55A41.37,41.37,0,0,1,341,220.51c0-7.18,1.45-14.28,2.82-21.29.08-.39.68-.22.6.17A102.75,102.75,0,0,0,341.53,219a42.12,42.12,0,0,0,.85,9.83c.67,3.1,2,6,2.8,9s.45,6.44.25,9.66c-.21,3.44-.38,6.88-.56,10.32-.37,6.74-.77,13.48-1.15,20.23-1.57,27.38-3.09,54.77-4.76,82.15C338,375.6,337.27,391,336,406.43c0,.11-.19.11-.18,0C336.34,392.66,337.24,378.9,338,365.14Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 340.75px 302.756px;" id="elu5x153m2dp"
                            class="animable"></path>
                        <path
                            d="M345.08,216.65c.79-.32,1.67-.42,2.48-.67a20.57,20.57,0,0,0,2.52-.93,19,19,0,0,0,4.32-2.71,10.08,10.08,0,0,0,2.76-4.17c.34-.85.66-1.71,1-2.57.16-.42.33-.85.5-1.27.06-.17.5-1.07.57-1.35a.08.08,0,0,1-.11,0l-.05,0a.09.09,0,0,1,0-.11c.05-.1.06-.11.17-.14a.11.11,0,0,1,.12.05c.17.28,0,.55-.06.85-.13.57-.26,1.13-.4,1.69-.25,1-.48,2-.76,2.94a9.9,9.9,0,0,1-2.76,4.79,15.45,15.45,0,0,1-4.82,2.88,17.14,17.14,0,0,1-2.79.82,7.59,7.59,0,0,1-2.68.2C344.92,216.89,345,216.7,345.08,216.65Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 352.212px 209.859px;" id="el6i1w1ph2e5q"
                            class="animable"></path>
                        <path
                            d="M383.11,226.52c.08-1.65.18-3.29.3-4.94.26-3.76.59-7.53,1.18-11.24.05-.3.46-.19.44.08-.2,2.92-.49,5.84-.71,8.75s-.52,5.82-.52,8.72c0,.87.08,2.35,1.16,2.58,1.44.3,2.09-1.61,2.42-2.65a47.92,47.92,0,0,0,1.67-8c.42-3.07.62-6.17.86-9.25,0-.11.19-.1.2,0,.12,6.11.14,12.5-2,18.31a3.41,3.41,0,0,1-2.49,2.46h-.06s0,.07,0,.1-.07.35-.09.52-.05.28-.08.43-.09.59-.16.89a.23.23,0,0,1-.45,0,.2.2,0,0,1-.13-.18,5,5,0,0,1,.37-1.74,2.15,2.15,0,0,1-1.6-1.3A7.61,7.61,0,0,1,383.11,226.52Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 386.59px 221.811px;" id="elxkjs6s40pk8"
                            class="animable"></path>
                        <path
                            d="M387.61,231.89a87,87,0,0,0-13.33,7.28c-.17.11,0,.37.14.27,4.5-2.28,9.1-4.48,13.47-7A.3.3,0,0,0,387.61,231.89Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 381.133px 235.66px;" id="elvsg6wgnbk3"
                            class="animable"></path>
                        <path
                            d="M375.74,327.9c0-.44.14-.61.16-.07.11,3,.07,7.39.1,10.43,0,3.58,0,7.15,0,10.72s-.13,7.15-.27,10.73l-.22,5.35c-.07,1.24,0,3.68-.12,4.91,0,.55-.17.65-.22.1-.09-1.79-.09-3.22-.15-5l-.06-5.37c0-3.57,0-7.15,0-10.72s.13-7.15.27-10.72S375.48,331.47,375.74,327.9Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 375.48px 348.964px;" id="elfzsok0ri0vo"
                            class="animable"></path>
                        <path
                            d="M399.23,144.31a.53.53,0,0,1-.39.59l-2.11.2c-2.11-5.24-4.33-9.39-3.73-7.76a28.94,28.94,0,0,1,1.65,7.94l-4.17.32c-2-9.27-4.42-16.11-4.2-14,.88,8.57.52,11.34.09,14.3-10.07.74-23.28,1.54-32.84,1.91-1.32-5.11-2.51-10.66-2.67-10.26-1.18,2.93-1.36,7.15-1.26,10.4-3.05.09-5.48.11-7,0,0,0-.89-4.31-1.05-5.73a31.41,31.41,0,0,1,.62-10.85,54.84,54.84,0,0,1,4-10.15l0-.07s0,0,0,0a31.22,31.22,0,0,0,2.28-6.77.2.2,0,0,0,0-.05,30.84,30.84,0,0,0,.58-5.17c.18-6.36,3.3-11.92,8.81-13.73,10.09-10.86,20.83-6.64,24.35,1.42.34.79.68,1.69,1,2.68v0c1.23,3.64,2.39,8.38,3.43,12v0s0,0,0,0h0a38.4,38.4,0,0,0,1.42,4.22C391.12,122.47,397.36,126.09,399.23,144.31Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 370.286px 118.458px;" id="el2km42tkuy7a"
                            class="animable"></path>
                        <path
                            d="M355.58,97.26a11.7,11.7,0,0,0-6.08,9.8,32.78,32.78,0,0,1-1.14,7.92,27.58,27.58,0,0,1-3.93,7,20.85,20.85,0,0,0-4.33,11.49c-.21,4.63.22,10.08,1.85,14.35,0,0,0,0,0,0a39.5,39.5,0,0,1-1.1-15c.59-5,3.12-8.27,5.68-12.15a21.4,21.4,0,0,0,3.58-10.36c.18-2.29.05-4.68.83-6.85.92-2.6,2.9-4.29,4.88-5.79C356.12,97.51,355.85,97.09,355.58,97.26Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 348.001px 122.52px;" id="el00fpps1xd1bth"
                            class="animable"></path>
                        <path
                            d="M394.62,122.87c-2.73-3.54-5.55-6.55-7.25-11-1.54-4-2.51-8.31-4.08-12.34,0-.07-.11,0-.09,0,2.46,7.16,3.18,14.44,7.79,20.4,2.5,3.24,5,6.24,6.72,10.16a37.77,37.77,0,0,1,3,13,.11.11,0,1,0,.21,0A31,31,0,0,0,394.62,122.87Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 392.076px 121.366px;" id="el9ogktlm0vjq"
                            class="animable"></path>
                        <path
                            d="M418.93,103.23l-6.47,29.64c-.29.88.16,1.56,1,1.54l15.17-.48a2.47,2.47,0,0,0,2.06-1.64l6.48-29.63c.28-.88-.17-1.56-1-1.54L421,101.6A2.47,2.47,0,0,0,418.93,103.23Z"
                            style="fill: rgb(55, 71, 79); transform-origin: 424.813px 117.765px;" id="elxx6bda7e7cm"
                            class="animable"></path>
                        <path
                            d="M420.73,103.16l-6.47,29.64c-.29.87.16,1.56,1,1.53l15.18-.48a2.46,2.46,0,0,0,2.05-1.63L439,102.58c.28-.87-.17-1.56-1-1.53l-15.17.48A2.47,2.47,0,0,0,420.73,103.16Z"
                            style="fill: rgb(69, 90, 100); transform-origin: 426.628px 117.69px;" id="el9l0hwldw2v9"
                            class="animable"></path>
                        <path
                            d="M424.93,104.37a1.29,1.29,0,0,1-1.27,1.31,1.29,1.29,0,1,1,0-2.58A1.28,1.28,0,0,1,424.93,104.37Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 423.65px 104.39px;" id="elaer7zod3btp"
                            class="animable"></path>
                        <path
                            d="M371.44,149.31c9,18.09,28.83,41.4,36.81,41.33,3.8,0,10.59.71,15.48-3.76,10.65-9.77,19.32-28.18,20.93-38.64.57-3.73-17.64-11.34-20.23-8.26-6.08,7.21-13,21.24-14.11,21.18C406.23,161,390,148,378.59,138.91,364.8,127.85,367.85,142.1,371.44,149.31Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 406.538px 162.764px;" id="eljc8m2lyucb8"
                            class="animable"></path>
                        <path
                            d="M444.67,129.07c-2.08-7.48-3.76-9.08-2.17-16.33,1.05-4.75-1.54-7.46-4.8-3.59-5.34,6.33-4.68,16.55-3.44,20Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 439.033px 118.228px;" id="el83n3hol7arh"
                            class="animable"></path>
                        <path
                            d="M443.85,151.48s3.12-10.56,1.69-18.75c-1-5.66-4.51-17.75-20.57-23.8-3.81-1.44-10.25-.78-4.88,3.82,3.81,3.27,7.22,4.19,9.09,6.5,0,0-8.1,1.81-9.39,5.68a76,76,0,0,0-2.65,10.36,15.89,15.89,0,0,0,1.9.67s-.86,3.73,1.95,8.83Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 431.528px 129.865px;" id="eleqy32i52gfb"
                            class="animable"></path>
                        <path
                            d="M443.74,127.47c-2.34-1.89-7.38-5.83-12.61-7.62-5.82-2-17.56-4.24-19,.07-1,3.16,3.37,4.41,3.37,4.41s-5,.09-5.37,3.15c-.29,2.79,3.18,3.56,3.18,3.56s-3.06.58-2.82,3.32c.29,3.29,6.64,1.54,9.81,4.62C421,139.68,443.74,127.47,443.74,127.47Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 426.926px 128.231px;" id="elqwt5q14uyj"
                            class="animable"></path>
                        <path
                            d="M430.05,126.35a24.45,24.45,0,0,0-14.44-2.1c-.12,0-.17.13-.05.13a60.82,60.82,0,0,1,14.48,2S430.08,126.37,430.05,126.35Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 422.776px 125.162px;" id="el7yrydjjnayw"
                            class="animable"></path>
                        <path
                            d="M427.88,132.16c-2.28-1-9.06-2.54-14.55-1.23-.12,0-.16.14,0,.13a64.46,64.46,0,0,1,14.57,1.16S427.91,132.17,427.88,132.16Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 420.563px 131.323px;" id="el1lplo1lkvlci"
                            class="animable"></path>
                        <path
                            d="M379.72,165.72l15-15.71s-11.2-10.23-19.42-14.22-9.57,1.35-6.16,9.58S379.72,165.72,379.72,165.72Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 381.057px 150.08px;" id="el4nqt7mslcvg"
                            class="animable"></path>
                        <g id="el1yhcnmu0b6s">
                            <path
                                d="M379.72,165.72l15-15.71s-11.2-10.23-19.42-14.22-9.57,1.35-6.16,9.58S379.72,165.72,379.72,165.72Z"
                                style="opacity: 0.1; transform-origin: 381.057px 150.08px;" class="animable"></path>
                        </g>
                        <path
                            d="M393.58,181.38l7.05,33.07s-54.36,4.38-67.93,4.32c0,0,6.91-63.15,20.4-79.87,6.75-8.37,15.32-8.34,21.11-3.18,1.47,1.31,19.31,21.92,21.58,30.09C397.78,173,393.58,181.38,393.58,181.38Z"
                            style="fill: rgb(235, 235, 235); transform-origin: 366.665px 175.469px;" id="elbz9kadz49f"
                            class="animable"></path>
                        <path d="M368.21,132.51h-5.77A12.23,12.23,0,0,1,368.21,132.51Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 365.325px 132.337px;" id="elq3e6ij6auka"
                            class="animable"></path>
                        <path
                            d="M374.15,135.67H356.27c.25-.21.51-.41.77-.59h16.4C373.68,135.27,373.92,135.46,374.15,135.67Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 365.21px 135.375px;" id="elhmeeu25jrk"
                            class="animable"></path>
                        <path d="M377,138.83H353.16l.49-.59h22.86Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 365.08px 138.535px;" id="elq0dwu877gb"
                            class="animable"></path>
                        <path d="M379.7,142H351c.11-.2.23-.4.36-.59h27.86Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 365.35px 141.705px;" id="el3ink3uar16a"
                            class="animable"></path>
                        <path d="M382.29,145.15h-33c.09-.2.19-.4.29-.59h32.24Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 365.79px 144.855px;" id="eljgkco4ogw8r"
                            class="animable"></path>
                        <path d="M384.79,148.31h-37c.09-.2.17-.4.25-.59h36.24Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.29px 148.015px;" id="el0af7cjb0q5ls"
                            class="animable"></path>
                        <path d="M387.2,151.47H346.59l.22-.6h39.94Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.895px 151.17px;" id="ellqcolncuebi"
                            class="animable"></path>
                        <path d="M389.49,154.63h-44c.07-.21.13-.4.2-.6h43.4Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 367.49px 154.33px;" id="elso8vbue1jcg"
                            class="animable"></path>
                        <path d="M391.64,157.79H344.42l.2-.6h46.62Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.03px 157.49px;" id="el9hsqfieurqi"
                            class="animable"></path>
                        <path d="M393.57,161H343.48c0-.21.11-.4.17-.6h49.57C393.35,160.55,393.46,160.75,393.57,161Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.525px 160.7px;" id="el89qlr43uo6l"
                            class="animable"></path>
                        <path d="M395.18,164.11H342.59c.05-.2.11-.4.16-.6h52.16Q395.06,163.81,395.18,164.11Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.885px 163.81px;" id="elfarcvmbdccs"
                            class="animable"></path>
                        <path d="M396.11,167.26H341.76l.15-.59H396C396,166.87,396.08,167.06,396.11,167.26Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.935px 166.965px;" id="el4h2spjj0j7w"
                            class="animable"></path>
                        <path d="M396.33,169.83c0,.2,0,.4,0,.59H341c0-.2.1-.4.14-.59Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.665px 170.125px;" id="elxvave342o2"
                            class="animable"></path>
                        <path d="M396.12,173c0,.2-.06.4-.1.59H340.25c0-.19.08-.39.13-.59Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 368.185px 173.295px;" id="elpypprlzak9s"
                            class="animable"></path>
                        <path d="M395.47,176.15c-.05.2-.1.4-.16.59H339.54c0-.2.09-.39.13-.59Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 367.505px 176.445px;" id="el1bhdggyr1t7"
                            class="animable"></path>
                        <path d="M394.46,179.31l-.23.59H338.88c0-.2.07-.39.12-.59Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.67px 179.605px;" id="elcdtluqqklfl"
                            class="animable"></path>
                        <path d="M393.94,183.06h-55.7c0-.2.07-.39.12-.59h55.45Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.09px 182.765px;" id="elipahxpgxrdb"
                            class="animable"></path>
                        <path d="M394.61,186.22h-57c0-.2.07-.39.11-.59h56.75Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.11px 185.925px;" id="elno9r2vcwli"
                            class="animable"></path>
                        <path d="M395.29,189.38H337.05c0-.2.07-.4.1-.6h58Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.17px 189.08px;" id="elaq6mrsroog"
                            class="animable"></path>
                        <path d="M396,192.54H336.49c0-.2.07-.4.1-.6h59.24Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.245px 192.24px;" id="elfa6xqlwonf"
                            class="animable"></path>
                        <path d="M396.63,195.7H336c0-.2.06-.4.1-.6H396.5Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.315px 195.4px;" id="elz04jj475ul8"
                            class="animable"></path>
                        <path d="M397.31,198.86H335.45l.09-.6h61.64Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.38px 198.56px;" id="el7ce0zonpo4s"
                            class="animable"></path>
                        <path d="M398,202H335c0-.2.07-.4.1-.6h62.8Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.5px 201.7px;" id="elualjdoojpq9"
                            class="animable"></path>
                        <path d="M398.65,205.17H334.48l.09-.59h64Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.565px 204.875px;" id="elh3zkj0p3fwb"
                            class="animable"></path>
                        <path d="M399.33,208.33H334l.09-.59H399.2Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.665px 208.035px;" id="el4vhef2mfkfv"
                            class="animable"></path>
                        <path d="M400,211.49H333.6c0-.19.06-.39.08-.59h66.19Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.8px 211.195px;" id="el3h8dibotrug"
                            class="animable"></path>
                        <path d="M400.63,214.45l-2.48.2H333.2c0-.19,0-.38.07-.59h67.28Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 366.915px 214.355px;" id="el7zhnu2pt072"
                            class="animable"></path>
                        <path d="M363.29,217.22c-3.08.21-6.14.41-9.09.59H332.81c0-.17,0-.37.07-.59Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 348.05px 217.515px;" id="elokgqyjhziwi"
                            class="animable"></path>
                        <path
                            d="M395.49,175.74a20.23,20.23,0,0,0,.42-6,28,28,0,0,0-4.07-11.39c-1.17-2-2.57-3.84-3.73-5.83a.05.05,0,1,1,.08-.06,41.81,41.81,0,0,1,3,4.08.61.61,0,0,0-.07-.14c-.32-.78-.65-1.55-1-2.31,0-.08.1-.15.14-.07.4.74.78,1.48,1.14,2.23.22.49.41,1,.58,1.48a37.47,37.47,0,0,1,3,5.46,18.91,18.91,0,0,1,1.41,12,21.47,21.47,0,0,1-2.73,6.17.08.08,0,0,1-.14-.07,29.9,29.9,0,0,0,2-5.59"
                            style="fill: rgb(38, 50, 56); transform-origin: 392.449px 166.915px;" id="elfg2m0unhh4i"
                            class="animable"></path>
                        <path
                            d="M361.55,136.37c.41,1,6.53,7.12,11.34,6.14,1.56-.32.19-8.94.19-8.94l0-.66.62-9.23-11.53-5.1-1.65-.66s0,2.54,0,5.7v1c0,.47,0,1,0,1.44s0,.72,0,1.1,0,.76,0,1.14A58.49,58.49,0,0,0,361.55,136.37Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 367.11px 130.268px;" id="elwqjyylk2pb"
                            class="animable"></path>
                        <path
                            d="M360.59,123.62a18.58,18.58,0,0,0,12.53,9.29l.62-9.23-11.53-5.1-1.65-.66S360.56,120.46,360.59,123.62Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 367.15px 125.415px;" id="el7w7qzrf4tq3"
                            class="animable"></path>
                        <path
                            d="M385.11,109.82c1.69,16.15-7.79,19-11.27,19.34-3.16.33-14,1-17.32-14.84s3.62-21.78,10.82-22.91S383.42,93.67,385.11,109.82Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 370.488px 110.244px;" id="eli0sqfh0oq4l"
                            class="animable"></path>
                        <path
                            d="M381.52,106.34a10.43,10.43,0,0,1-1.11-.11,1.79,1.79,0,0,1-1.12-.34.58.58,0,0,1-.07-.7,1.42,1.42,0,0,1,1.37-.48,2.13,2.13,0,0,1,1.39.6A.61.61,0,0,1,381.52,106.34Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 380.641px 105.511px;" id="elzn3azhw3m6e"
                            class="animable"></path>
                        <path
                            d="M370.89,107.57a9.52,9.52,0,0,0,1.07-.34,1.78,1.78,0,0,0,1-.56.57.57,0,0,0-.07-.7,1.46,1.46,0,0,0-1.44-.19,2.14,2.14,0,0,0-1.24.88A.61.61,0,0,0,370.89,107.57Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 371.583px 106.631px;" id="elhybwynlqs8j"
                            class="animable"></path>
                        <path
                            d="M373.74,111.42s-.08.06-.07.11c.17,1.09.19,2.37-.75,2.86,0,0,0,.07,0,.06C374.12,114.13,374.08,112.43,373.74,111.42Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 373.433px 112.935px;" id="eloicjzlt9uyj"
                            class="animable"></path>
                        <path d="M372.61,110.4c-1.78.1-1.46,3.65.19,3.56S374.11,110.32,372.61,110.4Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 372.653px 112.18px;" id="eliymao773f3g"
                            class="animable"></path>
                        <path
                            d="M371.93,110.65c-.29.23-.56.61-.93.69s-.79-.27-1.11-.6c0,0-.06,0-.06.05.05.68.38,1.36,1.12,1.39s1.1-.61,1.21-1.31C372.18,110.74,372.05,110.56,371.93,110.65Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 370.996px 111.403px;" id="elpfuq91unw8n"
                            class="animable"></path>
                        <path
                            d="M379.82,110.59s.09,0,.09.09c.06,1.11.31,2.36,1.33,2.65,0,0,0,.06,0,.06C380,113.32,379.69,111.65,379.82,110.59Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 380.516px 111.99px;" id="elj2cplqfto5"
                            class="animable"></path>
                        <path d="M380.71,109.36c1.76-.28,2.19,3.27.56,3.52S379.23,109.6,380.71,109.36Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 381.042px 111.118px;" id="elw6lzxycrq4"
                            class="animable"></path>
                        <path
                            d="M381.48,109.51c.3.15.62.46.95.44s.64-.44.84-.84c0,0,.05,0,.06,0,.1.68,0,1.41-.67,1.62s-1.09-.34-1.33-1C381.28,109.65,381.35,109.44,381.48,109.51Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 382.338px 109.943px;" id="el88ysjypypjj"
                            class="animable"></path>
                        <path
                            d="M374.63,120.22c.28.24.56.59,1,.6a2.71,2.71,0,0,0,1.17-.33s.07,0,.05.06a1.48,1.48,0,0,1-1.37.66,1.18,1.18,0,0,1-.91-.94C374.51,120.21,374.59,120.18,374.63,120.22Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 375.701px 120.709px;" id="eli9zs2zknr2e"
                            class="animable"></path>
                        <path
                            d="M378.83,115.77s.39,1.62.47,2.4c0,.07-.18.12-.44.17h0a3.72,3.72,0,0,1-3.72-1c-.06-.07,0-.16.11-.12a5.62,5.62,0,0,0,3.46.62c0-.22-.77-2.75-.65-2.77a6.55,6.55,0,0,1,1.8.22c-.72-3.4-2-6.65-2.65-10a.11.11,0,0,1,.2-.07,56.83,56.83,0,0,1,3.32,10.7C380.8,116.29,379.15,115.87,378.83,115.77Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 377.924px 111.83px;" id="elnjxj9mu4hqc"
                            class="animable"></path>
                        <path
                            d="M378.67,118.15a4.38,4.38,0,0,1-1.55,1.58,2,2,0,0,1-1.18.24c-.89-.11-1-.89-.95-1.59a4.66,4.66,0,0,1,.24-1.08A5.67,5.67,0,0,0,378.67,118.15Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 376.825px 118.641px;" id="el021v1254311i"
                            class="animable"></path>
                        <path
                            d="M377.12,119.73a2,2,0,0,1-1.18.24c-.89-.11-1-.89-.95-1.59A2.05,2.05,0,0,1,377.12,119.73Z"
                            style="fill: rgb(255, 154, 187); transform-origin: 376.05px 119.176px;" id="elh1a1tkax4gr"
                            class="animable"></path>
                        <path
                            d="M357.75,113.63c3,.49,4-6.28,4-6.28s12.74-1.63,14.22-11.88a17.48,17.48,0,0,0,8.41,9.89s0-11.31-8.85-13.86c0,0-10.94-4.5-17.54,4.07S355.77,113.3,357.75,113.63Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 369.432px 101.987px;" id="el7gpn1kxqxjr"
                            class="animable"></path>
                        <path
                            d="M376,94.71a11.24,11.24,0,0,1-.76,4.68,11.76,11.76,0,0,1-2.55,4.06,11.52,11.52,0,0,1-.89.82l-.45.4-.5.34c-.34.22-.67.45-1,.65s-.72.36-1.08.53c-.18.08-.36.18-.54.25l-.57.2-1.13.38c-.77.18-1.55.32-2.33.45.74-.29,1.5-.49,2.22-.78l1.07-.47.53-.23.5-.29c.34-.2.67-.39,1-.57s.62-.45.93-.67l.47-.34.42-.38a8.89,8.89,0,0,0,.83-.79,13.92,13.92,0,0,0,3.36-6A13.48,13.48,0,0,0,376,94.71Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 370.107px 101.09px;" id="el9m0ml8qj6t"
                            class="animable"></path>
                        <path d="M359.58,115s-3.63-5-5.91-3.7.52,8.6,3.24,9.56a2.75,2.75,0,0,0,3.65-1.54Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 356.696px 116.083px;" id="elxqb2402xb5"
                            class="animable"></path>
                        <path
                            d="M354.52,113.41a0,0,0,0,0,0,.07c1.91.74,2.94,2.47,3.67,4.28a1.52,1.52,0,0,0-2.28-.37s0,.11.05.1a1.68,1.68,0,0,1,1.87.55,8.79,8.79,0,0,1,.92,1.49c.09.17.4.07.33-.12l0,0C359.06,117,357.12,113.61,354.52,113.41Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 356.805px 116.514px;" id="el8v88qprah3n"
                            class="animable"></path>
                        <path
                            d="M359.26,95.39c1.45-.54,2.83-8.65-2.5-12.52s-12.16.55-9.3,7.2C349.27,94.27,356.19,96.53,359.26,95.39Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 353.678px 88.555px;" id="el3fbw8d0uk1z"
                            class="animable"></path>
                        <path
                            d="M349.3,82.4a9.07,9.07,0,0,0-3.07,5.14,5.46,5.46,0,0,0,1.62,5.22,10.94,10.94,0,0,0,5.29,2.59,16.42,16.42,0,0,0,3.05.38,8.64,8.64,0,0,0,3.07-.34,7.34,7.34,0,0,1-3.05.9,13.35,13.35,0,0,1-3.22-.05,10.61,10.61,0,0,1-5.94-2.64,6.38,6.38,0,0,1-1.76-2.91,6.59,6.59,0,0,1,.06-3.36A8,8,0,0,1,349.3,82.4Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 352.181px 89.382px;" id="elqbzo0yxd7le"
                            class="animable"></path>
                        <path
                            d="M352.1,140.18c-13.38,20.13-20.94,46.93-20,52.83,1.08,6.49,10.24,28.43,19.68,38.1,2.49,2.55,21.35-18.37,18.8-21.2-4.91-5.46-14.66-21.55-15.09-25.22-.4-3.39,4.54-25.2,5.84-37.6C362.63,135.18,358.32,130.81,352.1,140.18Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 351.419px 183.217px;" id="elm0h6u45am9"
                            class="animable"></path>
                        <path
                            d="M370,209.24s10.24,4.5,16.8,7.76c3.66,1.82,9.66,5.5,11.74,8.07,3.1,3.83,13.65,21.87,9.33,24.52-3.91,2.4-11-14.24-11-14.24s8.64,16.16,3.4,18.19-10.75-17.86-10.75-17.86,8.51,16.81,2.78,18C388,254.66,382,236.94,382,236.94s7.21,14.5,2.8,15.65c-4.88,1.27-11.45-14.74-11.45-14.74-11.71,1-17.71-3.27-21.61-6.83C350.78,230.16,370,209.24,370,209.24Z"
                            style="fill: rgb(221, 106, 87); transform-origin: 380.3px 231.48px;" id="eljhje703ec6j"
                            class="animable"></path>
                        <path
                            d="M394.27,229.56c1.08,1.86,2.19,3.74,3.11,5.69s1.76,3.94,2.49,6a36.79,36.79,0,0,1,2.08,8.16c-1-4.9-4.2-11.94-5.12-13.89s-1.73-4-2.64-5.9C394.17,229.55,394.24,229.52,394.27,229.56Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 398.068px 239.476px;" id="elhsvpvixg39g"
                            class="animable"></path>
                        <path
                            d="M387.16,232.74c1.28,2.43,2.64,4.81,3.82,7.3s2,4.94,3,7.5c.07.2-.06.17-.14,0-1.1-2.52-2.3-4.76-3.43-7.26s-2.15-5-3.36-7.5C387.08,232.72,387.14,232.7,387.16,232.74Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 390.525px 240.199px;" id="elmz63d56g4je"
                            class="animable"></path>
                        <path
                            d="M380.57,234.36a62.1,62.1,0,0,1,5,11.62c.07.2-.1.15-.18,0-1.58-3.89-2.8-7-4.93-11.49C380.41,234.37,380.52,234.29,380.57,234.36Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 383.017px 240.223px;" id="el7doaiyrl2fc"
                            class="animable"></path>
                        <path
                            d="M339.24,160.83l21.32,4.11s2.55-14.95,1.46-24-6.31-7.31-11.38,0S339.24,160.83,339.24,160.83Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 350.765px 149.864px;" id="el5f0c6rt8txk"
                            class="animable"></path>
                        <g id="el9fv27ki1c38">
                            <path
                                d="M339.24,160.83l21.32,4.11s2.55-14.95,1.46-24-6.31-7.31-11.38,0S339.24,160.83,339.24,160.83Z"
                                style="opacity: 0.1; transform-origin: 350.765px 149.864px;" class="animable">
                            </path>
                        </g>
                    </g>
                    <g id="freepik--Plant--inject-40" class="animable"
                        style="transform-origin: 112.418px 340.221px;">
                        <path
                            d="M121.6,343.45c-1.16,4.93-2.39,9.78-2.63,14.84.14.25.11,1.17,0,.92,0,.82-1.27.67-1.27-.14,0-.52,0-1.05,0-1.55-2.9-3.61-7.11-5.89-10.51-9a19.76,19.76,0,0,1-5.76-9.17c-2.82-9.73-.18-20-3.57-29.75-2.93-8.36-8.18-15.64-12.62-23.22-4.69-8-8.15-16.44-8.5-25.83-.27-7.19.58-16.77,6.06-22.15,5.8-5.72,13-1.44,17.45,3.66,12.88,14.79,18.84,33.48,21.25,52.59,1.33,10.58,2.71,21.22,2.39,31.89A86,86,0,0,1,121.6,343.45Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 100.316px 297.714px;" id="el3w9743neehx"
                            class="animable"></path>
                        <path
                            d="M119,362.18a182.85,182.85,0,0,0-.35-30,.93.93,0,0,0,0-.1c.16-8.1.8-16.17.48-24.28a143.87,143.87,0,0,0-3.56-26c0-.1-.18-.07-.16,0a170.1,170.1,0,0,1,2.82,25.46q.24,6.87-.11,13.73c-.08,1.49-.22,3-.32,4.49v0a160.16,160.16,0,0,0-24.1-63.77c-.16-.26-.63,0-.47.29a166.42,166.42,0,0,1,19.62,47.28c-6.2-11.48-15.56-20.92-22.5-31.95,0-.06-.14,0-.11.06,6.24,12.29,16.55,22,23.12,34.07,1.13,4.93,2.07,9.91,2.76,14.92a167.31,167.31,0,0,1,1.5,20.72c-3.78-7.05-7.7-13.8-10.78-21.26a.16.16,0,0,0-.3.13c2.62,7.75,6.15,16.1,11.1,22.71q0,7.36-.41,14.72c-.77,13.08-3,26-4,39a.3.3,0,0,0,.6.07A298.62,298.62,0,0,0,119,362.18Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 104.845px 332.17px;" id="elm5osk3d93x"
                            class="animable"></path>
                        <path
                            d="M105.14,261.29c0-.09-.18,0-.15.07,2.39,6.61,3.74,13.3,5.47,20.07a.25.25,0,0,0,.49-.08C110.25,274.48,107.8,267.63,105.14,261.29Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 107.968px 271.432px;" id="elxjivjygj93"
                            class="animable"></path>
                        <path
                            d="M165.81,289a101.34,101.34,0,0,1-5.49,11.29c-4.31,7.81-8.79,15-9.61,24.07-.36,4.06-.49,8.14-1.73,12a35.77,35.77,0,0,1-4.8,9.44c-4.66,6.79-10.49,12.65-14.81,19.7a82.73,82.73,0,0,0-9.85,23.73c-.1.46-.82.33-.72-.12a.45.45,0,0,0,0-.11.11.11,0,0,1,0-.09c-.69-19.51.87-39.17,6.82-57.86A200.25,200.25,0,0,1,135.06,307c3.19-6.77,7.16-13.29,12.76-18.35,3.63-3.27,11.5-9.47,16.67-6.19C167,284.06,166.79,286.55,165.81,289Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 142.571px 335.524px;" id="el2wfgbtegzkd"
                            class="animable"></path>
                        <path
                            d="M146.21,333.21a161.87,161.87,0,0,1-11.34,16.3c-1.89,2.46-3.8,4.91-5.69,7.38-.89,1.16-1.89,2.32-2.71,3.58.52-2.05,1-4.11,1.54-6.16,2.52-9.85,4.94-19.8,8.69-29.27,3.66-9.27,8.54-18,13.54-26.56.14-.22-.23-.39-.36-.17-4.12,6.78-8.31,13.55-11.77,20.7a107.82,107.82,0,0,0-5,12.28,190.63,190.63,0,0,1,6.65-26.24c0-.08-.08-.13-.11-.05a89.54,89.54,0,0,0-6.91,27.29l0,0q-1.27,3.8-2.35,7.67c-3.07,10.91-5.77,21.94-8.27,33a118,118,0,0,1,1.88-21.7c0-.16-.22-.2-.26,0a68.84,68.84,0,0,0-1.88,22.87q-1.42,6.32-2.77,12.63c-1.91,9-4.27,18.15-5.39,27.28a.18.18,0,0,0,.36.06c1.34-4.92,2.15-10,3.24-15s2.23-10,3.39-15q2.55-10.89,5.28-21.73c1.21-2.65,3.54-5,5.29-7.22,1.92-2.44,3.84-4.88,5.71-7.36a109.48,109.48,0,0,0,9.39-14.53C146.44,333.18,146.27,333.11,146.21,333.21Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 131.984px 356.23px;" id="eld5ync2osr9s"
                            class="animable"></path>
                        <path
                            d="M147,324.87A101.76,101.76,0,0,0,136,342.49c0,.08.08.17.13.09,3.73-5.85,7.4-11.75,11.13-17.6C147.27,324.88,147.11,324.78,147,324.87Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 141.63px 333.723px;" id="elhpjkk1qul8d"
                            class="animable"></path>
                        <path
                            d="M64,307.48c2.53,4.36,5.41,9.58,4.33,14.81-.69,3.31-3.11,6-3.55,9.37-1,7.45,6.44,12.38,11.82,15.9,13.39,8.79,31.76,16.62,34.2,34.57.09.64,1.19.48,1.11-.15a.26.26,0,0,0,0-.11s.07-.06.07-.11a68.93,68.93,0,0,0-.25-27.41c-2-9.25-6-17.56-10.8-25.69-8.06-13.75-16.6-27.84-28.79-38.37-3.37-2.91-10.28-8.16-13-1.58C56.53,295.11,60.9,302.17,64,307.48Z"
                            style="fill: rgb(60, 79, 177); transform-origin: 85.7883px 334.04px;" id="elweewxome13"
                            class="animable"></path>
                        <path
                            d="M76.26,336.64c8.88,9.61,23,15,30.64,25.77-4.53-16.5-12-31.35-23.55-44.24a.35.35,0,0,1,.49-.49,87.16,87.16,0,0,1,19.25,27.88,124.56,124.56,0,0,0-8.29-21.2.23.23,0,0,1,.39-.23A80.73,80.73,0,0,1,104.12,348c10.08,24.38,11,53,8.9,78.68,0,.37-.59.38-.58,0,.58-20.25.25-40.86-4.6-60.64-.1-.42-.22-.82-.32-1.23-8.32-11.6-22.38-17-31.42-28C76,336.69,76.16,336.53,76.26,336.64Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 95.004px 372.286px;" id="elm2xzeawwyz"
                            class="animable"></path>
                        <path
                            d="M74.2,328.38c4.66,4.28,9.25,8.65,13.92,12.93,0,0,0,.12-.07.09a68.51,68.51,0,0,1-14.13-12.74A.2.2,0,0,1,74.2,328.38Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 81px 334.872px;" id="elji9faz8cu9"
                            class="animable"></path>
                        <path
                            d="M73.46,309.85a147.49,147.49,0,0,0,14,19.19.08.08,0,1,1-.12.11A67.63,67.63,0,0,1,73.21,310,.15.15,0,0,1,73.46,309.85Z"
                            style="fill: rgb(38, 50, 56); transform-origin: 80.3425px 319.491px;" id="el0p2f98nawrea"
                            class="animable"></path>
                        <polygon points="94.45 444.77 135.29 444.77 129.78 389.83 100.74 389.83 94.45 444.77"
                            style="fill: rgb(69, 90, 100); transform-origin: 114.87px 417.3px;" id="elho3m72ufkb"
                            class="animable"></polygon>
                        <polygon points="99.72 398.76 130.68 398.76 129.79 389.83 100.74 389.83 99.72 398.76"
                            style="fill: rgb(38, 50, 56); transform-origin: 115.2px 394.295px;" id="elzzr65a499u"
                            class="animable"></polygon>
                        <g id="elne0gmedj9b9">
                            <rect x="95.73" y="383.74" width="38.28" height="8.77"
                                style="fill: rgb(69, 90, 100); transform-origin: 114.87px 388.125px; transform: rotate(180deg);"
                                class="animable"></rect>
                        </g>
                    </g>
                    <defs>
                        <filter id="active" height="200%">
                            <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2">
                            </feMorphology>
                            <feFlood flood-color="#32DFEC" flood-opacity="1" result="PINK"></feFlood>
                            <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE">
                            </feComposite>
                            <feMerge>
                                <feMergeNode in="OUTLINE"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                        </filter>
                        <filter id="hover" height="200%">
                            <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2">
                            </feMorphology>
                            <feFlood flood-color="#ff0000" flood-opacity="0.5" result="PINK"></feFlood>
                            <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE">
                            </feComposite>
                            <feMerge>
                                <feMergeNode in="OUTLINE"></feMergeNode>
                                <feMergeNode in="SourceGraphic"></feMergeNode>
                            </feMerge>
                            <feColorMatrix type="matrix"
                                values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 ">
                            </feColorMatrix>
                        </filter>
                    </defs>
                </svg>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ url('/assets/cbt-malela') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ url('/assets/cbt-malela') }}/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ url('/assets/cbt-malela') }}/assets/js/authentication/form-1.js"></script>

    {!! session('pesan') !!}
</body>

</html>

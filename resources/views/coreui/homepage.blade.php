<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="asset-url" content="{{substr(asset(''), 0, -1) }}">
    <link rel="icon" href="<%= BASE_URL %>favicon.ico">
    <title>Pudo</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhcthMxe-_IQy1Jqa5KwcdO4kYNSQYcH8&libraries=drawing,places,geometry">
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Vue.js ID
        gtag('config', 'UA-118965717-7');
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script> -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {
            !!json_encode([
                'csrfToken' => csrf_token(),
            ]) !!
        };
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "e69956bf-278e-49cf-a2b3-5cbf58eece5e",
            });

            // OneSignal.showNativePrompt();
            OneSignal.getUserId().then(function(userId) {

                //window.localStorage.setItem('name', 'Obaseki Nosa');
                // (Output) OneSignal User ID: 270a35cd-4dda-4b3f-b04e-41d7463a2316
                $.ajax({
                    type: 'POST', // Define the type of HTTP verb we want to use
                    url: '/api/installNoteDevice?token=' + window.localStorage.getItem("api_token"), // The URL where we want to POST
                    data: {
                        player_id: userId,
                        os: "Web"
                    },
                    dataType: 'json', // What type of data do we expect back.
                    beforeSend: function() {

                        // This will run before sending an Ajax request.
                        // Do whatever activity you want, like show loaded.
                    },
                    success: function(response) {

                    },
                    complete: function() {
                        // This will run after sending an Ajax complete
                    },
                    error: function(xhr, ajaxOptions, thrownError) {

                    }
                });

                // Stop the form from submitting the normal way
                // and refreshing the page
                event.preventDefault();
            });

        });
    </script>


</head>

<!-- BODY options, add following classes to body to change options

  // Header options
  1. '.header-fixed'					- Fixed Header

  // Brand options
  1. '.brand-minimized'       - Minimized brand (Only symbol)

  // Sidebar options
  1. '.sidebar-fixed'					- Fixed Sidebar
  2. '.sidebar-hidden'				- Hidden Sidebar
  3. '.sidebar-off-canvas'		- Off Canvas Sidebar
  4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
  5. '.sidebar-compact'			  - Compact Sidebar

  // Aside options
  1. '.aside-menu-fixed'			- Fixed Aside Menu
  2. '.aside-menu-hidden'			- Hidden Aside Menu
  3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

  // Breadcrumb options
  1. '.breadcrumb-fixed'			- Fixed Breadcrumb

  // Footer options
  1. '.footer-fixed'					- Fixed footer

  -->

<body style=" background: linear-gradient(to left, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url('{{asset('/img/main_image-min.png')}}')">

    <noscript>
        <strong>We're sorry but this app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>
    <audio id="chat-sound">
        <source src="{{asset('sounds/chat.mp3')}}" />
    </audio>






    <div id="app"></div>
    <!-- built files will be auto injected -->

    <script src="{{ asset('js/app.js') }}"></script>


</body>

</html>

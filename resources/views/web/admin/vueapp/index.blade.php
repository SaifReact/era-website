<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta name="csrf-token" content="">--}}{{--csrf-token in meta creates issue in laravel file manager. Till now, it does not effect the api.--}}
    <title>Lara CMS - Administrator</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    {{--FOR FILE MANAGER IT WAS ADDED. BUT CONFLICT WITH BOOTSTRAP 5 DESIGN WHICH BREAKS CURRENT DESIGN OF ADMIN.
    SO, KEEPING IT OFF AND SYSTEM IS WORKING PERFECTLY ALONG WITH FILE MANAGER.--}}
    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
</head>

<body>
    <div id="jsapp">
    </div>
    <script>
    /*let standaloneInputFieldId = '';
    function standaloneButtonAction(standaloneButton, standaloneInputField) {
        document.getElementById(standaloneButton).addEventListener('click', (event) => {
            event.preventDefault();
            standaloneInputFieldId = standaloneInputField;

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    }
    function setStandaloneInputFieldId(standaloneInputField) {
        standaloneInputFieldId = standaloneInputField;
    }

    function fmSetLink($url) {
        document.getElementById(standaloneInputFieldId).value = $url;
    }*/
    </script>
    {{--<script src="{{ url('vendor/file-manager/js/file-manager.js') }}"></script>--}}
    <script src="{{ asset('js/admin/app.js') }}" defer></script>
</body>

</html>
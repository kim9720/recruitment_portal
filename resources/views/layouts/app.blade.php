<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Recruitment Portal')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/layouts/style.css') }}">

</head>

<body>
    @include('includes.sidebar')
    <div class="main-content" id="mainContent">
        @include('includes.topbar')
        @yield('content')
    </div>
 <script src="{{ asset('assets/layouts/script.js') }}"></script>
</body>

</html>

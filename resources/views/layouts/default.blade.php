<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
  <head>
    @include('includes.head')
  </head>
  <body>
    @include('includes.header')

    <div id="main" class="container">
      @yield('content')
    </div>

    @include('includes.footer')
  </body>
</html>

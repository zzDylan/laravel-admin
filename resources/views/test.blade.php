<!DOCTYPE html>
<html>
    <head>
        <!-- styles, scripts, etc -->
    </head>
    <body>
        <h1>My Site</h1>
        <div class="container" id="pjax-container">
            Go to <a href="/test3">next page</a>
        </div>
        <script src="{{asset('assets/global/plugins/jquery.min.js')}}"></script>
        <script src="{{asset('js/jquery.pjax.js')}}"></script>
        <script>
            $(document).pjax('a','#pjax-container',{timeout:60000})
        </script>
    </body>
</html>
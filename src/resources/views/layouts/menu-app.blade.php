<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
         <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        
     
        <!-- Styles -->
       
    </head>
    <body class="body">
        
        
            

            <!-- Page Heading -->
           
           
    
    
           

            <!-- Page Content -->
            <main>
                @yield('main')
            </main>
        </div>

      

      
    </body>
</html>

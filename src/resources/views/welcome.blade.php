<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yaraku Web Dev Assignment</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}">
    </head>
    <body>
        <div class="container full-height">
            <div class="content">
                @include('books_form')
                @include('books_table', ['books' => $books])
                <p>{{$total}} {{$total == 1 ? "Book" : "Books"}}</p>
            </div>
        </div>
    </body>
</html>

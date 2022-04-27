<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body style="background:linear-gradient(to left, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url(https://www.pngitem.com/pimgs/m/179-1791378_excel-spreadsheet-computer-hd-png-download.png)">
    <div class="container p-2">
        <h1 class="text-danger text-center">Failed To Upload File</h1>
        <ul class="alert alert-warning ">
            @if(isset($my_errors))
            @foreach($my_errors->messages() as $error)
            @foreach($error as $e)
            <li class="alert alert-danger " style="background-color: #f65858  !important; color:white !important">
                {{$e}}
            </li>
            @endforeach
            @endforeach
            @else
            <li class="alert alert-danger">
                {{$size_error}}
            </li>
            @endif

        </ul>
    </div>

</body>

</html>

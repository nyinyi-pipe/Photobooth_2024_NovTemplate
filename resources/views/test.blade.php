<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="container">
        <div class="d-flex vh-100 justify-content-center align-items-center">
            <div class="card">
                <div class="card-body">
                    <h1>hello</h1>
                    @foreach($photos as $photo)
                        @php 
                            $images = json_decode($photo->image);
                        @endphp
                        @foreach($images as $img)
                            <img src="{{$img}}" width=100 alt="">
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>
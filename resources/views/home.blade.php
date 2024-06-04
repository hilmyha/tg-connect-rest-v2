<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>tess</h1>

  @foreach ($dokumens as $item)
    <h1>{{ $item->dokumen }}</h1>
    {{-- show image from storage --}}
    <img src="{{ asset('public/app/storage/'.$item->dokumen) }}" alt="">
  @endforeach
</body>
</html>
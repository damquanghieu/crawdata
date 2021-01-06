<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <table class="table dtTable table-bordered" width="100%" cellspacing="0">
    <thead>
      <tr align="center">
        <th style="border: 1px solid black;" align="center">STT</th>
        <th style="border: 1px solid black;" align="center">Sku</th>
        <th style="border: 1px solid black;" align="center">Title</th>
        <th style="border: 1px solid black;" align="center">Description</th>
        <th style="border: 1px solid black;" align="center">Size</th>
        <th style="border: 1px solid black;" align="center">Link_image</th>
        <th style="border: 1px solid black;" align="center">Dot_description</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $key => $product)
      <tr style="vertical-align: middle;">
        <td style="border: 1px solid black;width: 5px; vertical-align : middle;">{{$key+1}}</td>
        <td style="border: 1px solid black; vertical-align: middle;" align="center">{{htmlspecialchars_decode($product[0])}}</td>
        <td style="border: 1px solid black;" align="center">{{htmlspecialchars_decode($product[1])}}</td>
        <td style="border: 1px solid black; width:100px;" align="center">{{htmlspecialchars_decode($product[4])}}</td>
        <td style="border: 1px solid black;">
          @foreach ($product[2] as $size)
          <p>-{{htmlspecialchars_decode($size)}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">
          @foreach ($product[3] as $linkimage)
          <p>-{{htmlspecialchars_decode($linkimage)}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">
          @foreach ($product[5] as $dotdescription)
          <p>-{{htmlspecialchars_decode($dotdescription)}}</p>
          @endforeach
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
 {{--  {{dd("ok")}} --}}
</body>

</html>
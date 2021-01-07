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
        <th style="border: 1px solid black;" align="center">Url</th>
        <th style="border: 1px solid black;" align="center">Type</th>
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

        <td style="border: 1px solid black; vertical-align: middle;" align="center">
          {{htmlspecialchars_decode($product[0])}}</td>
        <td style="border: 1px solid black; vertical-align: middle;">{{$product[1]}}</td>
        <td style="border: 1px solid black; vertical-align: middle;" align="center">{{$product[2]}}</td>
        <td style="border: 1px solid black;">{{htmlspecialchars_decode($product[3])}}</td>
        <td style="border: 1px solid black;">
          @foreach ($product[4] as $des)
          <p>{{$des}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">
          @foreach ($product[5] as $size)
          <p>-{{$size}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">
          @foreach ($product[6] as $linkimage)
          <p>{{$linkimage}}</p>
          <p></p>
          @endforeach
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{--  {{dd("ok")}} --}}
</body>

</html>
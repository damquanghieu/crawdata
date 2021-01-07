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
        <th style="border: 1px solid black;" align="center">Sex</th>
        <th style="border: 1px solid black;" align="center">Title</th>
        <th style="border: 1px solid black;" align="center">Price</th>
        <th style="border: 1px solid black;" align="center">SizeFemale</th>
        <th style="border: 1px solid black;" align="center">SizeMale</th>
        <th style="border: 1px solid black;" align="center">Link_image</th>
        <th style="border: 1px solid black;" align="center">Description</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $key => $product)
      <tr style="vertical-align: middle;">
        <td style="border: 1px solid black;width: 5px; vertical-align : middle;">{{$key+1}}</td>

        <td style="border: 1px solid black; vertical-align: middle;" align="center">{{htmlspecialchars_decode($product[0])}}</td>
        <td style="border: 1px solid black; vertical-align: middle;">{{$product[1]}}</td>
        <td style="border: 1px solid black; vertical-align: middle;" align="center">{{$product[2]}}</td>
        <td style="border: 1px solid black;">
          @foreach ($product[3] as $sex)
          <p>{{$sex}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">{{htmlspecialchars_decode($product[4])}}</td>
        <td style="border: 1px solid black;">{{$product[5]}}</td>

        <td style="border: 1px solid black;">
          @foreach ($product[6] as $sizeFemale)
          <p>{{$sizeFemale}}</p>
          @endforeach
        </td>
        <td style="border: 1px solid black;">
          @foreach ($product[7] as $sizeMale)
          <p>{{$sizeMale}}</p>
          @endforeach
        </td>

        <td style="border: 1px solid black;">
          @foreach ($product[8] as $linkImage)
          <p>-{{$linkImage}}</p>
          <p></p>
          @endforeach
        </td>

        <td style="border: 1px solid black;">
          @foreach ($product[9] as $des)
          <p>{{$des}}</p>
          @endforeach
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{--  {{dd("ok")}} --}}
</body>

</html>
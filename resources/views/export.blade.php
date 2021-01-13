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
        <th style="border: 1px solid black;" align="center">Sku</th>
        <th style="border: 1px solid black;" align="center">Name</th>
        <th style="border: 1px solid black;" align="center">Size</th>
        <th style="border: 1px solid black;" align="center">Price</th>
        <th style="border: 1px solid black;" align="center">Image1</th>
        <th style="border: 1px solid black;" align="center">Image2</th>
        <th style="border: 1px solid black;" align="center">Description</th>
        <th style="border: 1px solid black;" align="center">Bullet_point1</th>
        <th style="border: 1px solid black;" align="center">Bullet_point2</th>
        <th style="border: 1px solid black;" align="center">Bullet_point3</th>
        <th style="border: 1px solid black;" align="center">Bullet_point4</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $key => $product)
        @foreach ($product as $item)
          <tr>
            <td>{{$item['sku']}}</td>
            <td style="width:50px;">{{htmlspecialchars_decode($item['name'])}}</td>
            <td align="center">{{$item['size']}}</td>
            <td align="center">{{$item['price']}}</td>
            <td style="width:50px;">{{$item['image_1']}}</td>
            <td style="width:50px;">{{$item['image_2']}}</td>
            <td style="width:50px;">{{$item['description']}}</td>
            <td style="width:50px;">{{$item['bullet_point1']}}</td>
            <td style="width:50px;">{{$item['bullet_point2']}}</td>
            <td style="width:50px;">{{$item['bullet_point3']}}</td>
            <td style="width:50px;">{{$item['bullet_point4']}}</td>
          </tr>
        @endforeach
        <tr></tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
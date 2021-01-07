<?php

namespace App\Http\Controllers;

use App\Exports\SocityTshirt;
use Maatwebsite\Excel\Facades\Excel;

class TshirtController extends Controller
{
    public function index()
    {
        $products = [];
        for ($i = 2; $i < 100; $i++) {
            $ch = curl_init("https://society6.com/gateway/v1/search?alias=tshirts&page=1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($content);
            foreach ($data->data->attributes->cards as $key => $item) {
               

                $urlItem = "https://society6.com" . $item->card->link->href;
                $urlApi = "https://society6.com/gateway/v1" . str_replace('product', 'products', $item->card->link->href);
                $productType = $item->product->product_type->display_name;
                $ch = curl_init($urlApi);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($ch);
                curl_close($ch);
                $data1 = json_decode($content);
                if ($key ==6) {
                    dd($data1);
                }
               
                if (isset($data1->errors)) {
                    continue;
                }
                if (!isset($data1->data)) {
                    continue;
                }
                $description = $data1->data->attributes->description_map->b;
                $title = $item->card->image->alt;
                $price = $item->product->price;
                $linkImage = $data1->data->attributes->media_map;

                $arrSizeFemale = ['Small', 'Medium', 'Large', 'X-Large'];
                $arrSizeMale = ['Small', 'Medium', 'Large', 'X-Large', '2x-Large'];
                $type_tshirt = ['Mens Fitted Tee', ' Womens Fitted Tee'];
                $arrLinkImage = [
                    'size_1' => $linkImage->d->src->xxl,
                    'size_2' => $linkImage->e->src->xxl,
                ];
                $description = explode("\n", $description);
                $products[] = [$item->id, $urlItem, $productType, $type_tshirt, $title, $price,  $arrSizeFemale, $arrSizeMale,$arrLinkImage, $description];
            }
            return Excel::download(new SocityTshirt($products), "society_tshirt.xlsx");
        }
        return Excel::download(new SocityTshirt($products), "society_tshirt.xlsx");
    }
}

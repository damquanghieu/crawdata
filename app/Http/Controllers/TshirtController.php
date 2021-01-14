<?php

namespace App\Http\Controllers;

use App\Exports\SocityTshirt;
use Maatwebsite\Excel\Facades\Excel;

class TshirtController extends Controller
{
    public function index()
    {
        $products = [];
        for ($i = 1; $i <= 1; $i++) {
            $ch = curl_init("https://society6.com/gateway/v1/search?alias=tshirts&page=" . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($content);
            /*     dd($data); */
            foreach ($data->data->attributes->cards as $key => $item) {
                $urlItem = "https://society6.com" . $item->card->link->href;
                $urlApi = "https://society6.com/gateway/v1" . str_replace('product', 'products', $item->card->link->href);
                $productType = $item->product->product_type->display_name;
                $ch = curl_init($urlApi);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($ch);
                curl_close($ch);

                $data1 = json_decode($content);

                if (isset($data1->errors)) {
                    continue;
                }
                if (!isset($data1->data)) {
                    continue;
                }
                $object = [];

                /* $attribute_items = $data1->data->attributes->attributes;
                $image_map = $data1->data->attributes->media_map;
                $description_map = $data1->data->attributes->description_map->a;
                $description_map = explode("\n", $description_map);
                $description_map = array_filter(array_map('trim', $description_map)); */
                $colors = $data1->data->attributes->attributes->a4->values;
                $sizes = $data1->data->attributes->attributes->a5->values;
                $types = $data1->data->attributes->attributes->a11->values;
                $mediaMap = $data1->data->attributes->media_map;
                $name_item = $data1->data->attributes->creative->title . "T Shirts";
                $description_map = $data1->data->attributes->description_map;

                foreach ($data1->data->attributes->skus as $keySku => $sku) {
                    $idColor = $sku->attributes->a4;
                    $idSize = $sku->attributes->a5;
                    $idType = $sku->attributes->a11;
                    $description = $sku->descriptions[0];

                    $description = explode("\n", $description_map->$description);
                    $getImage = $sku->media[0];

                    $object[] = [
                        'sku' => $keySku,
                        'name' => $name_item,
                        'style' => $types->$idType->label,
                        'price' => $sku->retail_price,
                        'color' => $colors->$idColor->label,
                        'size' => $sizes->$idSize->label,
                        'image' => $mediaMap->$getImage->src->xxl,
                        'description' => $description[0],
                        'bullet_point1' => $description[2],
                        'bullet_point2' => $description[3],
                    ];
                }
                array_push($products, $object);
            }
        }
        return Excel::download(new SocityTshirt($products), "society_tshirt.xlsx");
    }
    public function show($id)
    {
        switch ($id) {
            case 'case_1':
                return $this->crawData(76, 80);
                break;

            case 'case_2':
                return $this->crawData(81, 85);
                break;
            case 'case_3':
                return $this->crawData(86, 87);
                break;
            case 'case_4':
                return $this->crawData(91, 95);
                break;
            case 'case_5':
                return $this->crawData(96, 100);
                break;
                case 'case_6':
                    return $this->crawData(56, 60);
                    break;
            default:
                # code...
                break;
        }
    }
    public function crawData($from, $to)
    {
        $products = [];
        for ($i = $from; $i <= $to; $i++) {
            $ch = curl_init("https://society6.com/gateway/v1/search?alias=tshirts&page=" . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($content);
            /*     dd($data); */
            foreach ($data->data->attributes->cards as $key => $item) {
                $urlItem = "https://society6.com" . $item->card->link->href;
                $urlApi = "https://society6.com/gateway/v1" . str_replace('product', 'products', $item->card->link->href);
                $productType = $item->product->product_type->display_name;
                $ch = curl_init($urlApi);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($ch);
                curl_close($ch);

                $data1 = json_decode($content);

                if (isset($data1->errors)) {
                    continue;
                }
                if (!isset($data1->data)) {
                    continue;
                }
                $object = [];

                /* $attribute_items = $data1->data->attributes->attributes;
                $image_map = $data1->data->attributes->media_map;
                $description_map = $data1->data->attributes->description_map->a;
                $description_map = explode("\n", $description_map);
                $description_map = array_filter(array_map('trim', $description_map)); */
                $colors = $data1->data->attributes->attributes->a4->values;
                $sizes = $data1->data->attributes->attributes->a5->values;
                $types = $data1->data->attributes->attributes->a11->values;
                $mediaMap = $data1->data->attributes->media_map;
                $name_item = $data1->data->attributes->creative->title . "T Shirts";
                $description_map = $data1->data->attributes->description_map;

                foreach ($data1->data->attributes->skus as $keySku => $sku) {
                    $idColor = $sku->attributes->a4;
                    $idSize = $sku->attributes->a5;
                    $idType = $sku->attributes->a11;
                    $description = $sku->descriptions[0];

                    $description = explode("\n", $description_map->$description);
                    $getImage = $sku->media[0];

                    $object[] = [
                        'sku' => $keySku,
                        'name' => $name_item,
                        'style' => $types->$idType->label,
                        'price' => $sku->retail_price,
                        'color' => $colors->$idColor->label,
                        'size' => $sizes->$idSize->label,
                        'image' => $mediaMap->$getImage->src->xxl,
                        'description' => $description[0],
                        'bullet_point1' => $description[2],
                        'bullet_point2' => $description[3],
                    ];
                }
                array_push($products, $object);
            }
        }
        return Excel::download(new SocityTshirt($products), "society_tshirt_page_" . $from . "-" . $to . ".xlsx");
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\Society;
use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use Maatwebsite\Excel\Facades\Excel;

class ComforterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = [];
        for ($i = 1; $i <= 1; $i++) {
            if ($i == 61) {
                continue;
            }
            $ch = curl_init("https://society6.com/gateway/v1/search?alias=comforters&page=" . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($content);
            /*  dd($data->data->attributes->cards); */
            foreach ($data->data->attributes->cards as $key => $item) {

                $urlItem = "https://society6.com" . $item->card->link->href;
                $urlApi = "https://society6.com/gateway/v1" . str_replace('product', 'products', $item->card->link->href);
                $productType = $item->product->product_type->display_name;

                $ch = curl_init($urlApi);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($ch);

                curl_close($ch);
                $data1 = json_decode($content);
                /*  if ($key == 41) {
                dd($data1);
                } */
                if (isset($data1->errors)) {
                    continue;
                }
                if (!isset($data1->data)) {
                    continue;
                }
                $object = [];
                $attribute_items = $data1->data->attributes->attributes;
                $image_map = $data1->data->attributes->media_map;
                $description_map = $data1->data->attributes->description_map->a;
                $description_map = explode("\n", $description_map);
                $description_map = array_filter(array_map('trim', $description_map));
                $name_item = $data1->data->attributes->creative->title . " Comforter";
                foreach ($data1->data->attributes->skus as $keySku => $sku) {
                    $idSize = $sku->attributes->a200;
                    $object[] = [
                        'sku' => $keySku,
                        'name' => $name_item,
                        'size' => $attribute_items->a200->values->$idSize->label,
                        'price' => $sku->retail_price,
                        'image_1' => $image_map->e->src->xxl,
                        'image_2' => $image_map->d->src->xxl,
                        'description' => $description_map[0],
                        'bullet_point1' => $description_map[2],
                        'bullet_point2' => $description_map[3],
                        'bullet_point3' => $description_map[4],
                        'bullet_point4' => $description_map[5],
                    ];
                }
                array_push($products, $object);

                /*  $description = $data1->data->attributes->description_map->a;
            $title = $item->card->image->alt;
            $sizes = $data1->data->attributes->attributes->a200->values;
            $linkImage = $data1->data->attributes->media_map;
            $arrSizePrice = [];
            $arrLinkImage = [
            'size_1' => $linkImage->e->src->xxl,
            'size_2' => $linkImage->f->src->xxl,
            ];
            foreach ($sizes as $keySize => $valueSize) {
            array_push($arrSizePrice, $valueSize->label . "|" . $valueSize->price);
            }

            $description = explode("\n", $description);
            $products[] = [$item->id, $urlItem, $productType, $title, $description, $arrSizePrice, $arrLinkImage];*/
            }

        }

        return Excel::download(new Society($products), "society_comforter.xlsx");
        dd($products);

        die;
        $products = [];
        for ($i = 1; $start <= $to; $i++) {
            $ch = curl_init("https://society6.com/comforters?page=" . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);

            $html = HtmlDomParser::str_get_html($content);
            $data = $html->find('div.imageWrap_product_3TDXW a');
            foreach ($data as $key => $value) {
                $ch = curl_init("https://society6.com" . $value->href);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content_2 = curl_exec($ch);
                curl_close($ch);

                $sku = substr($value->href, strpos($value->href, '=') + 1);
                $html1 = HtmlDomParser::str_get_html($content_2);
                $title = $html1->find("h1.title_header_3f6JK", 0)->plaintext;
                $description = $html1->find("div.detailsProductDescriptionDesktop_productDescription_3qzvS p", 0)->plaintext;
                $dotDescription = [];
                foreach ($html1->find(".detailsProductDescriptionDesktop_productDescription_3qzvS ul li") as $key => $dot) {
                    array_push($dotDescription, $dot->plaintext);
                }
                $keyEnd = substr($value->href, -4);
                $newUrlSize = str_replace($keyEnd, "", $value->href);
                $arrSize = [];
                $linkImage = [];
                $idProduct = $html1->find(".ddOption_dropdown_28TpC");
                foreach ($idProduct as $key => $div) {
                    $ch = curl_init("https://society6.com" . $newUrlSize . $div->value);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content_3 = curl_exec($ch);
                    curl_close($ch);
                    $html2 = HtmlDomParser::str_get_html($content_3);
                    if ($html2 == "false") {
                        continue;
                    }
                    array_push($linkImage, $html2->find('img.image_preview_p8mXz', 0)->src);
                    array_push($arrSize, $html2->find('div.select_dropdown_xyLsr', 0)->title);
                }
                $products[] = [$sku, $title, $arrSize, $linkImage, $description, $dotDescription];
            }
        }
        return Excel::download(new Society($products), $nameFile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        switch ($id) {
            case 'case_1':
                return $this->crawData(1,20);
                break;

            case 'case_2':
                return $this->crawData(21,40);
                break;
            case 'case_3':
                return $this->crawData(41,60);
                break;
            case 'case_4':
                return $this->crawData(61,80);
                break;
            case 'case_5':
                return $this->crawData(81,100);
                break;
                case 'case_6':
                    return $this->crawData(73,73);
                    break;
                    case 'case_7':
                        return $this->crawData(74,75);
                        break;
            default:
                # code...
                break;
        }
    }

    public function crawData($start, $to)
    {
        $products = [];
        for ($i = $start; $i <= $to; $i++) {
            if ($i == 61 || $i == 73) {
                continue;
            }
            $ch = curl_init("https://society6.com/gateway/v1/search?alias=comforters&page=" . $i);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($content);
            /*  dd($data->data->attributes->cards); */
            foreach ($data->data->attributes->cards as $key => $item) {

                $urlItem = "https://society6.com" . $item->card->link->href;
                $urlApi = "https://society6.com/gateway/v1" . str_replace('product', 'products', $item->card->link->href);
                $productType = $item->product->product_type->display_name;

                $ch = curl_init($urlApi);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $content = curl_exec($ch);

                curl_close($ch);
                $data1 = json_decode($content);
                /*  if ($key == 41) {
                dd($data1);
                } */
                if (isset($data1->errors)) {
                    continue;
                }
                if (!isset($data1->data)) {
                    continue;
                }
                $object = [];
                $attribute_items = $data1->data->attributes->attributes;
                $image_map = $data1->data->attributes->media_map;
                $description_map = $data1->data->attributes->description_map->a;
                $description_map = explode("\n", $description_map);
                $description_map = array_filter(array_map('trim', $description_map));
                $name_item = $data1->data->attributes->creative->title . " Comforter";
                foreach ($data1->data->attributes->skus as $keySku => $sku) {
                    $idSize = $sku->attributes->a200;
                    $object[] = [
                        'sku' => $keySku,
                        'name' => $name_item,
                        'size' => $attribute_items->a200->values->$idSize->label,
                        'price' => $sku->retail_price,
                        'image_1' => $image_map->e->src->xxl,
                        'image_2' => $image_map->d->src->xxl,
                        'description' => $description_map[0],
                        'bullet_point1' => $description_map[2],
                        'bullet_point2' => $description_map[3],
                        'bullet_point3' => $description_map[4],
                        'bullet_point4' => $description_map[5],
                    ];
                }
                array_push($products, $object);

                /*  $description = $data1->data->attributes->description_map->a;
            $title = $item->card->image->alt;
            $sizes = $data1->data->attributes->attributes->a200->values;
            $linkImage = $data1->data->attributes->media_map;
            $arrSizePrice = [];
            $arrLinkImage = [
            'size_1' => $linkImage->e->src->xxl,
            'size_2' => $linkImage->f->src->xxl,
            ];
            foreach ($sizes as $keySize => $valueSize) {
            array_push($arrSizePrice, $valueSize->label . "|" . $valueSize->price);
            }

            $description = explode("\n", $description);
            $products[] = [$item->id, $urlItem, $productType, $title, $description, $arrSizePrice, $arrLinkImage];*/
            }

        }

        return Excel::download(new Society($products), "society_comforter_".$to.".xlsx");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

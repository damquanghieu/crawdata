<?php

namespace App\Http\Controllers;

use App\Exports\Society;
use KubAT\PhpSimple\HtmlDomParser;
use Maatwebsite\Excel\Facades\Excel;

class TshirtController extends Controller
{
    public function index()
    {
        $products = [];
        for ($i = 1; $i <= 20; $i++) {
            $ch = curl_init("https://society6.com/tshirts?page=" . $i);
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
                $html = HtmlDomParser::str_get_html($content_2);
                $title = $html->find("h1.title_header_3f6JK", 0)->plaintext;
                $description = $html->find("div.detailsProductDescriptionDesktop_productDescription_3qzvS p", 0)->plaintext;
                $dotDescription = [];
                foreach ($html->find(".detailsProductDescriptionDesktop_productDescription_3qzvS ul li") as $key => $dot) {
                    array_push($dotDescription, $dot->plaintext);
                }
                $keyEnd = substr($value->href, -3);
                $newUrlSize = str_replace($keyEnd, "", $value->href);
                $arrSizeMale = ['Small', 'Medium', 'Large', 'X-Large', '2x-Large'];
                $arrSizeFemale = ['Small', 'Medium', 'Large', 'X-Large'];
                $linkImageMale = [];
                $linkImageFemale = [];
                $arrColor = [];

                $getColor = $html->find('div .outerCircle_colorpicker_1fqqT');
                foreach ($getColor as $keyColor => $color) {
                    array_push($arrColor, $color->title);
                }
                $typeProduct = ['v49', 'v50'];
                foreach ($typeProduct as $key => $div) {
                    $ch = curl_init("https://society6.com" . $newUrlSize . $div);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content_3 = curl_exec($ch);
                    curl_close($ch);
                    $html = HtmlDomParser::str_get_html($content_3);

                    array_push($linkImage, $html->find('img.image_preview_p8mXz', 0)->src);
                    array_push($arrSize, $html->find('div.select_dropdown_xyLsr', 0)->title);

                }
                $products[] = [$sku, $title, $arrSize, $linkImage, $description, $dotDescription];

            }
        }
        return Excel::download(new Society($products), 'society.xlsx');
        echo '<pre>';
        print_r($products);
        echo '<pre>';
    }
}

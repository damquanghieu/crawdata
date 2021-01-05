<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

class CurlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = [];
        for ($i = 1; $i <= 5; $i++) {
            $ch = curl_init("https://society6.com/comforters?page=1");
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
                $keyEnd = substr($value->href, -4);
                $newUrlSize = str_replace($keyEnd, "", $value->href);
                $arrSize = [];
                $linkImage = [];
                $idProduct = $html->find(".ddOption_dropdown_28TpC");
                foreach ($idProduct as $key => $div) {
                    $ch = curl_init("https://society6.com" . $newUrlSize . $div->value);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content_3 = curl_exec($ch);
                    curl_close($ch);
                    $html = HtmlDomParser::str_get_html($content_3);
                    array_push($linkImage, $html->find('img.image_preview_p8mXz', 0)->src);
                    array_push($arrSize, $html->find('div.select_dropdown_xyLsr', 0)->title);

                }
                $products[] = [$sku, $title, $arrSize, $linkImage, $description, $dotDescription];

            }
            /*   array_push($totalProduct, $products); */
        }
        echo '<pre>';
        print_r($products);
        echo '<pre>';

        /*  $html = HtmlDomParser::file_get_html('https://society6.com/comforters?page=1');
        $data = $html->find('div.imageWrap_product_3TDXW a');

        $html = HtmlDomParser::str_get_html($html);

        dd($data); */
        /* $arr = [];
    foreach ($data as $key => $value) {
    if ($key >= 2) {
    $arr[$value->childNodes(1)->innertext] = explode(',', trim(str_replace(array("(", ")", ' '), '', $value->childNodes(2)->innertext)));
    }
    }
    return $arr; */

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
        //
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

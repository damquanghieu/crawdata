<?php

namespace App\Http\Controllers;

use App\Exports\Society;
use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use Maatwebsite\Excel\Facades\Excel;

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
        for ($i = 1; $i <= 100; $i++) {
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
                    if ($html2 == false) {
                        continue;
                    }
                    array_push($linkImage, $html2->find('img.image_preview_p8mXz', 0)->src);
                    array_push($arrSize, $html2->find('div.select_dropdown_xyLsr', 0)->title);
                }
                $products[] = [$sku, $title, $arrSize, $linkImage, $description, $dotDescription];
                  return Excel::download(new Society($products), 'society.xlsx');
            }
        }
        return Excel::download(new Society($products), 'society.xlsx');
        echo '<pre>';
        print_r($products);
        echo '<pre>';
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
                return $this->getData(1, 5, "page_1.xlsx");
                break;
            case 'case_2':
                return $this->getData(6, 10, "page_2.xlsx");
                break;
            case 'case_3':
                return  $this->getData(11, 15, "page_3.xlsx");
                break;
            case 'case_4':
                return $this->getData(16, 20, "page_4.xlsx");
                break;
            case 'case_5':
                return $this->getData(21, 25, "page_5.xlsx");
                break;
            case 'case_6':
                return $this->getData(26, 30, "page_6.xlsx");
                break;
            case 'case_7':
                return $this->getData(31, 35, "page_7.xlsx");
                break;
            case 'case_8':
                return $this->getData(36, 40, "page_8.xlsx");
                break;
            case 'case_9':
                return $this->getData(41, 45, "page_9.xlsx");
                break;
            case 'case_10':
                return $this->getData(46, 50, "page_10.xlsx");
                break;

            default:
                # code...
                break;
        }
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
    public function getData($start, $to, $nameFile)
    {
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
}

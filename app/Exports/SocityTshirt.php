<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SocityTshirt implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }
    public function view(): View
    {
        return view('export_tshirt', [
            'products' => $this->products,
        ]);
    }
}

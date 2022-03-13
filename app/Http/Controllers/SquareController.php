<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SquareService as Square;

class SquareController extends Controller
{
    protected $square;
    public function __construct(Square $square)
    {
        $this->square = $square;
    }

    public function fetchVatRates()
    {
        $this->square->fetchVatRates();

        return redirect()->back()->withSuccess(__('crud.common.imported'));
    }

    public function fetchCategories()    
    {
        $this->square->fetchCategory();
        
        return redirect()->back()->withSuccess(__('crud.common.imported'));
    }

    public function fetchLocations()
    {
        $this->square->fetchLocation();
                
        return redirect()->back()->withSuccess(__('crud.common.imported'));
    }

    public function fetchSellables()
    {
        $this->square->fetchSellable();

        return redirect()->back()->withSuccess(__('crud.common.imported'));
    }   
    
    public function fetchSales()
    {
        $this->square->fetchSales();

        return redirect()->back()->withSuccess(__('crud.common.imported'));
    } 
}

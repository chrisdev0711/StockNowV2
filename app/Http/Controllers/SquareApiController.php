<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Settings\SquareApiSettings;
use App\Services\SquareService as Square;
use Auth;

class SquareApiController extends Controller
{
  protected $square;
  public function __construct()//Square $square
  {
      // $this->square = $square;
  }
    /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return view('squareModal');
  }

  public function save_data(Request $request) {
    $token = $request['access_token'];
    if($token == '')
      return;
    $setting = app(SquareApiSettings::class);
    $setting->access_token = $token;
    $setting->save();
    $this->square = new Square();
    $this->square->fetchLocation();
    sleep(2);
    $this->square->fetchVatRates();
    sleep(2);
    $this->square->fetchCategory();
    sleep(3);
    $this->square->fetchSellable();
    sleep(3);
    $this->square->fetchSales();
    sleep(3);
    return redirect('/dashboard')->withSuccess('Successfully Complete!');
  }
}

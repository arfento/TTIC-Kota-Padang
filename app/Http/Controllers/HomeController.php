<?php


namespace App\Http\Controllers;

use App\Barang;
use App\Models\Order;

use App\Models\Slide;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * HomeController
 *
 * PHP version 7
 */
class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	// public function __construct()
	// {
	// 	parent::__construct();
	// }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		// $products = Barang::popular()->get();
		$barangs = Barang::orderBy('created_at', 'DESC')->paginate(10);
		// $this->data['products'] = $products;

		// $slides = Slide::active()->orderBy('position', 'ASC')->get();
		// $this->data['slides'] = $slides;

		return view('themes.ezone.home', compact('barangs'));
	}
}

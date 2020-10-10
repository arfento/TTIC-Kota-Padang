<?php

namespace App\Http\Controllers;

use App\Barang;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
	{
		parent::__construct();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        $product = Barang::orderBy('created_at', 'asc')->get();
        $items = \Cart::getContent();
		// $this->data['items'] =  $items;

		return view('themes.ezone.carts.index', compact('items','product'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request request form
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$params = $request->except('_token');
		
		$product = Barang::findOrFail($params['barang_id']);
		// $slug = $product->slug;

		// $attributes = [];
		// if ($product->configurable()) {
		// 	$product = Product::from('products as p')
		// 		->whereRaw(
		// 			"p.parent_id = :parent_product_id
		// 		and (select pav.text_value 
		// 				from product_attribute_values pav
		// 				join attributes a on a.id = pav.attribute_id
		// 				where a.code = :size_code
		// 				and pav.product_id = p.id
		// 				limit 1
		// 			) = :size_value
		// 		and (select pav.text_value 
		// 				from product_attribute_values pav
		// 				join attributes a on a.id = pav.attribute_id
		// 				where a.code = :color_code
		// 				and pav.product_id = p.id
		// 				limit 1
		// 			) = :color_value
		// 			",
		// 			[
		// 				'parent_product_id' => $product->id,
		// 				'size_code' => 'size',
		// 				'size_value' => $params['size'],
		// 				'color_code' => 'color',
		// 				'color_value' => $params['color'],
		// 			]
		// 		)->firstOrFail();

		// 	$attributes['size'] = $params['size'];
		// 	$attributes['color'] = $params['color'];
		// }

		$itemQuantity =  $this->_getItemQuantity($product->id_barang) + $params['jumlah'];
		$this->_checkProductInventory($product, $itemQuantity);
		
		$item = [
			// 'id_barang' => md5($product->id_barang),
			'id' => $product->id_barang,
            'name' => $product->nama_barang,
			'price' => $product->harga_jual,
			'quantity' => $params['jumlah'],
			// 'attributes' => $attributes,
			'associatedModel' => $product,
		];
        // dd($item);
		\Cart::add($item);

		// \Session::flash('success', 'Product '. $item['nama_barang'] .' has been added to cart');
		return redirect('/products/'. $product->id_barang)->with('success', 'Product '. $item['name'] .' has been added to cart');
	}

	/**
	 * Get total quantity per item in the cart
	 *
	 * @param string $itemId item ID
	 *
	 * @return int
	 */
	private function _getItemQuantity($itemId)
	{
		$items = \Cart::getContent();
		$itemQuantity = 0;
		if ($items) {
			foreach ($items as $item) {
				if ($item->id == $itemId) {
					$itemQuantity = $item->quantity;
					break;
				}
			}
		}

		return $itemQuantity;
	}

	/**
	 * Check product inventory
	 *
	 * @param Product $product      product object
	 * @param int     $itemQuantity qty
	 *
	 * @return int
	 */
	private function _checkProductInventory($product, $itemQuantity)
	{
		if ($product->persediaanstok->stok < $itemQuantity) {
			throw new \App\Exceptions\OutOfStockException('The product '. $product->nama_barang .' is out of stock');
		}
	}

	/**
	 * Get cart item by card item id
	 *
	 * @param string $cartID cart ID
	 *
	 * @return array
	 */
	private function _getCartItem($cartID)
	{
		$items = \Cart::getContent();

		return $items[$cartID];
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request request form
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$params = $request->except('_token');

		if ($items = $params['items']) {
			foreach ($items as $cartID => $item) {
				$cartItem = $this->_getCartItem($cartID);
				$this->_checkProductInventory($cartItem->associatedModel, $item['quantity']);

				\Cart::update(
					$cartID,
					[
						'quantity' => [
							'relative' => false,
							'value' => $item['quantity'],
						],
					]
				);
			}

			\Session::flash('success', 'The cart has been updated');
			return redirect('carts');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param string $id card ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		\Cart::remove($id);

		return redirect('carts');
	}
}

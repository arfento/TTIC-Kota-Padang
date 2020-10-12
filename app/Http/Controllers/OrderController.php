<?php

namespace App\Http\Controllers;

use App\User;
use App\Payment;
use App\Shipment;
use App\Penjualan;
use App\Persediaan;
use App\Models\Order;
use App\DetailPenjualan;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * OrderController
 *
 * PHP version 7
 *
 * @category OrderController
 * @package  OrderController
 */
class OrderController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$orders = Penjualan::forUser(Auth::user())
			->orderBy('created_at', 'DESC')
			->paginate(10);

		// $this->data['orders'] = $orders;

		return view('themes.ezone.orders.index', compact('orders'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id order ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$order = Penjualan::forUser(Auth::user())->findOrFail($id);
		// $this->data['order'] = $order;

		return view('themes.ezone.orders.show', compact('order'));
	}

	/**
	 * Show the checkout page
	 *
	 * @return void
	 */
	public function checkout()
	{
		if (\Cart::isEmpty()) {
			return redirect('carts');
		}

		\Cart::removeConditionsByType('shipping');
		// $this->_updateTax();
		$items = \Cart::getContent();
		// $this->data['items'] = $items;
		$totalWeight = $this->_getTotalWeight() / 1000;

		$provinces = $this->getProvinces();
		$cities = isset(Auth::user()->province_id) ? $this->getCities(Auth::user()->province_id) : [];
		$user = Auth::user();



		return view('themes.ezone.orders.checkout', compact('items','user', 'provinces','cities', 'totalWeight'));
	}

	/**
	 * Get cities by province ID
	 *
	 * @param Request $request province id
	 *
	 * @return json
	 */
	public function cities(Request $request)
	{
		$cities = $this->getCities($request->query('province_id'));
		return response()->json(['cities' => $cities]);
	}

	/**
	 * Calculate shipping cost
	 *
	 * @param Request $request shipping cost params
	 *
	 * @return array
	 */
	public function shippingCost(Request $request)
	{
		$destination = $request->input('city_id');
		
		return $this->_getShippingCost($destination, $this->_getTotalWeight());
	}

	/**
	 * Set shipping cost
	 *
	 * @param Request $request selected shipping cost
	 *
	 * @return string
	 */
	public function setShipping(Request $request)
	{
		\Cart::removeConditionsByType('shipping');

		$shippingService = $request->get('shipping_service');
		$destination = $request->get('city_id');

		$shippingOptions = $this->_getShippingCost($destination, $this->_getTotalWeight());

		$selectedShipping = null;
		if ($shippingOptions['results']) {
			foreach ($shippingOptions['results'] as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
		}

		$status = null;
		$message = null;
		$data = [];
		if ($selectedShipping) {
			$status = 200;
			$message = 'Success set shipping cost';

			$this->_addShippingCostToCart($selectedShipping['service'], $selectedShipping['cost']);

			$data['total'] = number_format(\Cart::getTotal());
		} else {
			$status = 400;
			$message = 'Failed to set shipping cost';
		}

		$response = [
			'status' => $status,
			'message' => $message
		];

		if ($data) {
			$response['data'] = $data;
		}

		return $response;
	}

	/**
	 * Get selected shipping from user input
	 *
	 * @param int    $destination     destination city
	 * @param int    $totalWeight     total weight
	 * @param string $shippingService service name
	 *
	 * @return array
	 */
	private function _getSelectedShipping($destination, $totalWeight, $shippingService)
	{
		$shippingOptions = $this->_getShippingCost($destination, $totalWeight);

		$selectedShipping = null;
		if ($shippingOptions['results']) {
			foreach ($shippingOptions['results'] as $shippingOption) {
				if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
					$selectedShipping = $shippingOption;
					break;
				}
			}
		}

		return $selectedShipping;
	}

	/**
	 * Apply shipping cost to cart data
	 *
	 * @param string $serviceName Service name
	 * @param float  $cost        Shipping cost
	 *
	 * @return void
	 */
	private function _addShippingCostToCart($serviceName, $cost)
	{
		$condition = new \Darryldecode\Cart\CartCondition(
			[
				'name' => $serviceName,
				'type' => 'shipping',
				'target' => 'total',
				'value' => '+'. $cost,
			]
		);

		\Cart::condition($condition);
	}

	/**
	 * Get shipping cost option from api
	 *
	 * @param string $destination destination city
	 * @param int    $weight      total weight
	 *
	 * @return array
	 */
	private function _getShippingCost($destination, $weight)
	{
		$params = [
			'origin' => env('RAJAONGKIR_ORIGIN'),
			'destination' => $destination,
			'weight' => $weight,
		];

		$results = [];
		foreach ($this->couriers as $code => $courier) {
			$params['courier'] = $code;
			
			$response = $this->rajaOngkirRequest('cost', $params, 'POST');
			
			if (!empty($response['rajaongkir']['results'])) {
				foreach ($response['rajaongkir']['results'] as $cost) {
					if (!empty($cost['costs'])) {
						foreach ($cost['costs'] as $costDetail) {
							$serviceName = strtoupper($cost['code']) .' - '. $costDetail['service'];
							$costAmount = $costDetail['cost'][0]['value'];
							$etd = $costDetail['cost'][0]['etd'];

							$result = [
								'service' => $serviceName,
								'cost' => $costAmount,
								'etd' => $etd,
								'courier' => $code,
							];

							$results[] = $result;
						}
					}
				}
			}
		}

		$response = [
			'origin' => $params['origin'],
			'destination' => $destination,
			'weight' => $weight,
			'results' => $results,
		];
		
		return $response;
	}

	/**
	 * Get total of order items
	 *
	 * @return int
	 */
	private function _getTotalWeight()
	{
		if (\Cart::isEmpty()) {
			return 0;
		}

		$totalWeight = 0;
		$items = \Cart::getContent();

		foreach ($items as $item) {
			$totalWeight += ($item->quantity * $item->associatedModel->berat_barang);
		}

		return $totalWeight;
	}

	/**
	 * Update tax to the order
	 *
	 * @return void
	 */
	// private function _updateTax()
	// {
	// 	\Cart::removeConditionsByType('tax');

	// 	$condition = new \Darryldecode\Cart\CartCondition(
	// 		[
	// 			'name' => 'TAX 10%',
	// 			'type' => 'tax',
	// 			'target' => 'total',
	// 			'value' => '10%',
	// 		]
	// 	);

	// 	\Cart::condition($condition);
	// }

	/**
	 * Checkout process and saving order data
	 *
	 * @param OrderRequest $request order data
	 *
	 * @return void
	 */
	public function doCheckout(Request $request)
	{
		$params = $request->except('_token');
		
		$order = \DB::transaction(
			function () use ($params) {
				$order = $this->_saveOrder($params);
				// dd($order);
				$this->_saveOrderItems($order);
				$this->_generatePaymentToken($order);
				$this->_saveShipment($order, $params);
	
				return $order;
			}
		);

		if ($order) {
			\Cart::clear();
			// $this->_sendEmailOrderReceived($order);

			\Session::flash('success', 'Thank you. Your order has been received!');
			return redirect('orders/received/'. $order->id_penjualan);
		}

		return redirect('orders/checkout');
	}

	/**
	 * Generate payment token
	 *
	 * @param Order $order order data
	 *
	 * @return void
	 */
	private function _generatePaymentToken($order)
	{
		$this->initPaymentGateway();

		$customerDetails = [
			'first_name' => $order->customer_first_name,
			'last_name' => $order->customer_last_name,
			'email' => $order->customer_email,
			'phone' => $order->customer_phone,
		];

		$params = [
			'enable_payments' => Payment::PAYMENT_CHANNELS,
			'transaction_details' => [
				'order_id' => $order->nomor_faktur,
				'gross_amount' => $order->grand_total,
			],
			'customer_details' => $customerDetails,
			'expiry' => [
				'start_time' => date('Y-m-d H:i:s T'),
				'unit' => Payment::EXPIRY_UNIT,
				'duration' => Payment::EXPIRY_DURATION,
			],
		];
		// dd($params);
		$snap = \Midtrans\Snap::createTransaction($params);
		// dd($snap);
		if ($snap->token) {
			$order->payment_token = $snap->token;
			$order->payment_url = $snap->redirect_url;
			$order->save();
		}
		// dd($snap);
	}

	/**
	 * Save order data
	 *
	 * @param array $params checkout params
	 *
	 * @return Order
	 */
	private function _saveOrder($params)
	{
		$destination = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
		$selectedShipping = $this->_getSelectedShipping($destination, $this->_getTotalWeight(), $params['shipping_service']);
		

		$baseTotalPrice = \Cart::getSubTotal();
		$shippingCost = $selectedShipping['cost'];
		
		$grandTotal = ($baseTotalPrice  + $shippingCost);

		$orderDate = date('Y-m-d H:i:s');
		$paymentDue = (new \DateTime($orderDate))->modify('+3 day')->format('Y-m-d H:i:s');

		$orderParams = [
			'user_id' => Auth::user()->id,
			'nomor_faktur' => Penjualan::generateCode(),
			'status' => Penjualan::CREATED,
			'tanggal' => $orderDate,
			'payment_due' => $paymentDue,
			'payment_status' => Penjualan::UNPAID,
			'total' => $baseTotalPrice,
			'shipping_cost' => $shippingCost,
			'grand_total' => $grandTotal,
			'note' => $params['note'],
			'customer_first_name' => $params['first_name'],
			'customer_last_name' => $params['last_name'],
			'customer_company' => $params['company'],
			'customer_address1' => $params['address1'],
			'customer_address2' => $params['address2'],
			'customer_phone' => $params['phone'],
			'customer_email' => $params['email'],
			'customer_city_id' => $params['city_id'],
			'customer_province_id' => $params['province_id'],
			'customer_postcode' => $params['postcode'],
			'shipping_courier' => $selectedShipping['courier'],
			'shipping_service_name' => $selectedShipping['service'],
		];

		return Penjualan::create($orderParams);
	}

	/**
	 * Save order items
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	private function _saveOrderItems($order)
	{
		$cartItems = \Cart::getContent();

		if ($order && $cartItems) {
			foreach ($cartItems as $item) {
				// $itemTaxAmount = 0;
				// $itemTaxPercent = 0;
				// $itemDiscountAmount = 0;
				// $itemDiscountPercent = 0;
				$itemBaseTotal = $item->quantity * $item->price;

				$product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;

				$orderItemParams = [
					'penjualan_id' => $order->id_penjualan,
					'barang_id' => $item->associatedModel->id_barang,
					'jumlah' => $item->quantity,
					'harga_satuan' => $item->price,
					'total' => $itemBaseTotal,
					'berat_barang' => $item->associatedModel->berat_barang,
				];

				$orderItem = DetailPenjualan::create($orderItemParams);
				
				if ($orderItem) {
					Persediaan::reduceStock($orderItem->barang_id, $orderItem->jumlah);
				}
			}
		}
	}

	/**
	 * Save shipment data
	 *
	 * @param Order $order  order object
	 * @param array $params checkout params
	 *
	 * @return void
	 */
	private function _saveShipment($order, $params)
	{
		$shippingFirstName = isset($params['ship_to']) ? $params['shipping_first_name'] : $params['first_name'];
		$shippingLastName = isset($params['ship_to']) ? $params['shipping_last_name'] : $params['last_name'];
		$shippingCompany = isset($params['ship_to']) ? $params['shipping_company'] :$params['company'];
		$shippingAddress1 = isset($params['ship_to']) ? $params['shipping_address1'] : $params['address1'];
		$shippingAddress2 = isset($params['ship_to']) ? $params['shipping_address2'] : $params['address2'];
		$shippingPhone = isset($params['ship_to']) ? $params['shipping_phone'] : $params['phone'];
		$shippingEmail = isset($params['ship_to']) ? $params['shipping_email'] : $params['email'];
		$shippingCityId = isset($params['ship_to']) ? $params['shipping_city_id'] : $params['city_id'];
		$shippingProvinceId = isset($params['ship_to']) ? $params['shipping_province_id'] : $params['province_id'];
		$shippingPostcode = isset($params['ship_to']) ? $params['shipping_postcode'] : $params['postcode'];

		$shipmentParams = [
			'user_id' => Auth::user()->id,
			'penjualan_id' => $order->id_penjualan,
			'status' => Shipment::PENDING,
			'total_qty' => \Cart::getTotalQuantity(),
			'total_weight' => $this->_getTotalWeight(),
			'first_name' => $shippingFirstName,
			'last_name' => $shippingLastName,
			'address1' => $shippingAddress1,
			'address2' => $shippingAddress2,
			'phone' => $shippingPhone,
			'email' => $shippingEmail,
			'city_id' => $shippingCityId,
			'province_id' => $shippingProvinceId,
			'postcode' => $shippingPostcode,
		];

		Shipment::create($shipmentParams);
	}

	/**
	 * Send email order detail to current user
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	// private function _sendEmailOrderReceived($order)
	// {
	// 	\App\Jobs\SendMailOrderReceived::dispatch($order, \Auth::user());
	// }

	/**
	 * Show the received page for success checkout
	 *
	 * @param int $orderId order id
	 *
	 * @return void
	 */
	public function received($orderId)
	{
		$order = Penjualan::where('id_penjualan', $orderId)
			->where('user_id', Auth::user()->id)
			->firstOrFail();

		return view('themes.ezone.orders/received', compact('order'));
	}
}

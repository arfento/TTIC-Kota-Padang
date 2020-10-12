<?php

namespace App\Http\Controllers\Admin;

use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Penjualan;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    use Authorizable;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->data['currentAdminMenu'] = 'order';
		$this->data['currentAdminSubMenu'] = 'shipment';
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$shipments = Shipment::join('orders', 'shipments.penjualan_id', '=', 'penjualan.id_penjualan')
			->whereRaw('penjualan.deleted_at IS NULL')
			->orderBy('shipments.created_at', 'DESC')->paginate(10);
	

		return view('shipments.index', compact('shipments'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id shipment ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$shipment = Shipment::findOrFail($id);

		$provinces = $this->getProvinces();
		$cities = isset($shipment->province_id) ? $this->getCities($shipment->province_id) : [];

		return view('shipments.edit', compact('shipment', 'provinces', 'cities'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request request params
	 * @param int     $id      shipment ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate(
			[
				'track_number' => 'required|max:255',
			]
		);
		
		$shipment = Shipment::findOrFail($id);

		$order = DB::transaction(
			function () use ($shipment, $request) {
				$shipment->track_number = $request->input('track_number');
				$shipment->status = Shipment::SHIPPED;
				$shipment->shipped_at = now();
				$shipment->shipped_by = Auth::user()->id;
				
				if ($shipment->save()) {
					$shipment->order->status = Penjualan::DELIVERED;
					$shipment->order->save();
				}

				return $shipment->order;
			}
		);

		// if ($order) {
		// 	$this->_sendEmailOrderShipped($shipment->order);
		// }

		\Session::flash('success', 'The shipment has been updated');
		return redirect('admin/orders/'. $order->id_penjualan);
	}

	/**
	 * Sending order shipped email
	 *
	 * @param Order $order order object
	 *
	 * @return void
	 */
	// private function _sendEmailOrderShipped($order)
	// {
	// 	\App\Jobs\SendMailOrderShipped::dispatch($order);
	// }
}

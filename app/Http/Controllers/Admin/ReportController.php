<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Penjualan;

use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportPaymentExport;
use App\Exports\ReportProductExport;
use App\Exports\ReportRevenueExport;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportInventoryExport;

class ReportController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->data['currentAdminMenu'] = 'report';

		$this->data['exports'] = [
			'xlsx' => 'Excel File',
			'pdf' => 'PDF File',
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function revenue(Request $request)
	{
		$this->data['currentAdminSubMenu'] = 'report-revenue';

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			\Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/reports/revenue');
		}

		if (!$startDate && $endDate) {
			\Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/reports/revenue');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				\Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/reports/revenue');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				\Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect('admin/reports/revenue');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}
		$this->data['startDate'] = $startDate;
		$this->data['endDate'] = $endDate;

		$sql = "WITH recursive date_ranges AS (
			SELECT :start_date_series AS date
			UNION ALL
			SELECT date + INTERVAL 1 DAY
			FROM date_ranges
			WHERE date < :end_date_series
			),
			filtered_orders AS (
				SELECT * 
				FROM penjualans
				WHERE DATE(tanggal) >= :start_date
					AND DATE(tanggal) <= :end_date
					AND status = :status
					AND payment_status = :payment_status
			)

		 SELECT 
			 DISTINCT DR.date,
			 COUNT(FO.id_penjualan) num_of_orders,
			 COALESCE(SUM(FO.grand_total),0) gross_revenue,
			 COALESCE(SUM(FO.shipping_cost),0) shipping_amount,
			 COALESCE(SUM(FO.grand_total - FO.shipping_cost ),0) net_revenue
		 FROM date_ranges DR
		 LEFT JOIN filtered_orders FO ON DATE(tanggal) = DR.date
		 GROUP BY DR.date
		 ORDER BY DR.date ASC";

		$revenues = \DB::select(
			\DB::raw($sql),
			[
				'start_date_series' => $startDate,
				'end_date_series' => $endDate,
				'start_date' => $startDate,
				'end_date' => $endDate,
				'status' => Penjualan::COMPLETED,
				'payment_status' => Penjualan::PAID,
			]
		);

		$this->data['revenues'] = ($startDate && $endDate) ? $revenues : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				\Session::flash('error', 'Invalid export request');
				return redirect('reports/revenue');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new ReportRevenueExport($revenues), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-revenue-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('admin.reports.exports.revenue_pdf', $this->data);

				return $pdf->download($fileName);
			}
		}

		return view('reports.revenue', $this->data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function product(Request $request)
	{
		$this->data['currentAdminSubMenu'] = 'report-product';

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			\Session::flash('error', 'The end date is required if the start date is present');
			return redirect('admin/reports/product');
		}

		if (!$startDate && $endDate) {
			\Session::flash('error', 'The start date is required if the end date is present');
			return redirect('admin/reports/product');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				\Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('admin/reports/product');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				\Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect('admin/reports/product');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}
		$this->data['startDate'] = $startDate;
		$this->data['endDate'] = $endDate;

		$sql = "
		SELECT
			OI.barang_id,
			
			
			SUM(OI.jumlah) as items_sold,
			COALESCE(SUM(OI.total),0) net_revenue,
			COUNT(OI.penjualan_id) num_of_orders,
			PI.stok as stock
		FROM detail_penjualans OI
		LEFT JOIN penjualans O ON O.id_penjualan = OI.barang_id
		LEFT JOIN persediaans PI ON PI.barang_id = OI.barang_id
		WHERE DATE(O.tanggal) >= :start_date
			AND DATE(O.tanggal) <= :end_date
			AND O.status = :status
			AND O.payment_status = :payment_status
		GROUP BY OI.barang_id,  PI.stok
		";

		$products = DB::select(
			DB::raw($sql),
			[
				'start_date' => $startDate,
				'end_date' => $endDate,
				'status' => Penjualan::COMPLETED,
				'payment_status' => Penjualan::PAID,
			]
		);

		$this->data['products'] = ($startDate && $endDate) ? $products : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				\Session::flash('error', 'Invalid export request');
				return redirect('reports/product');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-product-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new ReportProductExport($products), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-product-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('reports.exports.product_pdf', $this->data);

				return $pdf->download($fileName);
			}
		}

		return view('reports.product', $this->data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function inventory(Request $request)
	{
		$this->data['currentAdminSubMenu'] = 'report-inventory';

		$sql = "
		SELECT
			P.*,
			PI.stok as stock
		FROM persediaans PI
		LEFT JOIN barangs P ON P.id_barang = PI.barang_id
		ORDER BY stock ASC
		";

		$products = DB::select(\DB::raw($sql));

		$this->data['products'] = $products;

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				\Session::flash('error', 'Invalid export request');
				return redirect('reports/inventory');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-inventory.xlsx';

				return Excel::download(new ReportInventoryExport($products), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-inventory.pdf';
				$pdf = PDF::loadView('reports.exports.inventory_pdf', $this->data);

				return $pdf->download($fileName);
			}
		}

		return view('reports.inventory', $this->data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function payment(Request $request)
	{
		$this->data['currentAdminSubMenu'] = 'report-payment';

		$startDate = $request->input('start');
		$endDate = $request->input('end');

		if ($startDate && !$endDate) {
			\Session::flash('error', 'The end date is required if the start date is present');
			return redirect('reports/payment');
		}

		if (!$startDate && $endDate) {
			\Session::flash('error', 'The start date is required if the end date is present');
			return redirect('reports/payment');
		}

		if ($startDate && $endDate) {
			if (strtotime($endDate) < strtotime($startDate)) {
				\Session::flash('error', 'The end date should be greater or equal than start date');
				return redirect('reports/payment');
			}

			$earlier = new \DateTime($startDate);
			$later = new \DateTime($endDate);
			$diff = $later->diff($earlier)->format("%a");
			
			if ($diff >= 31) {
				\Session::flash('error', 'The number of days in the date ranges should be lower or equal to 31 days');
				return redirect('reports/payment');
			}
		} else {
			$currentDate = date('Y-m-d');
			$startDate = date('Y-m-01', strtotime($currentDate));
			$endDate = date('Y-m-t', strtotime($currentDate));
		}
		$this->data['startDate'] = $startDate;
		$this->data['endDate'] = $endDate;

		$sql = "
		SELECT
			O.nomor_faktur,
			P.*
		FROM payments P
		LEFT JOIN penjualans O ON O.id_penjualan = P.penjualan_id
		WHERE DATE(P.created_at) >= :start_date
			AND DATE(P.created_at) <= :end_date
		ORDER BY created_at DESC
		";

		$payments = DB::select(
			DB::raw($sql),
			[
				'start_date' => $startDate,
				'end_date' => $endDate
			]
		);

		$this->data['payments'] = ($startDate && $endDate) ? $payments : [];

		if ($exportAs = $request->input('export')) {
			if (!in_array($exportAs, ['xlsx', 'pdf'])) {
				\Session::flash('error', 'Invalid export request');
				return redirect('reports/payment');
			}

			if ($exportAs == 'xlsx') {
				$fileName = 'report-payment-'. $startDate .'-'. $endDate .'.xlsx';

				return Excel::download(new ReportPaymentExport($payments), $fileName);
			}

			if ($exportAs == 'pdf') {
				$fileName = 'report-payment-'. $startDate .'-'. $endDate .'.pdf';
				$pdf = PDF::loadView('reports.exports.payment_pdf', $this->data);

				return $pdf->download($fileName);
			}
		}

		return view('reports.payment', $this->data);
	}
}

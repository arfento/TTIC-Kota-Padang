<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
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
		$user = Auth::user();
		
		$provinces = $this->getProvinces();
		$cities = isset(Auth::user()->province_id) ? $this->getCities(Auth::user()->province_id) : [];
	

		return view('themes.ezone.auth.profile', compact('user','provinces','cities'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$params = $request->except('_token');

		$user = \Auth::user();

		if ($user->update($params)) {
			\Session::flash('success', 'Your profile have been updated!');
			return redirect('profile');
		}
	}
}

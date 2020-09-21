<?php

namespace App\Http\Controllers\Frontend;

use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$user = User::where('id', Auth::user()->id)->first();

		return view('frontend.profile.index', compact('user'));
	}

	public function update(Request $request)
	{
		$this->validate($request, [
			'password'  => 'confirmed',
		]);

		$user = User::where('id', Auth::user()->id)->first();
		$user->name = $request->name;
		$user->email = $request->email;
		$user->nohp = $request->nohp;
		$user->alamat = $request->alamat;
		if (!empty($request->password)) {
			$user->password = Hash::make($request->password);
		}

		$user->update();

		return redirect('profile')->with('success', 'User Sukses diupdate');
	}
}

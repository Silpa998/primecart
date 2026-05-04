<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AuthHomeController extends Controller
{
    public function index()
    {
        $products = Product::with('variations')->get();
        return view('usershome', compact('products'));
    } 
    
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
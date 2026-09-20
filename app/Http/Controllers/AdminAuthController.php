<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Cart;

class AdminAuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        if ($request->has('message') && $request->message == 'checkout') {
            session()->flash('info', 'Please login to proceed with your checkout.');
        }
    
        return view('login');
    }

    public function login(Request $request) {

        $messages = [
            'email.required' => 'Email field is required.',
            'email.email'    => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
        ];
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (session()->has('temp_cart')) {
                $tempCart = session()->get('temp_cart');

                foreach (array_reverse($tempCart) as $key => $item) {

                    $realProductId = $item['product_id'];

                    $cartItem = Cart::where('user_id', $user->id)
                                    ->where('product_id', $realProductId)
                                    ->where('product_variation_id', $item['variant_id'])
                                    ->where('selected_size', $item['selected_size'])
                                    ->where('selected_color', $item['selected_color'])
                                    ->where('selected_variant', $item['selected_variant'])
                                    ->first();

                    if ($cartItem) {
                        $cartItem->increment('quantity', $item['quantity']);
                    } else {
                        Cart::create([
                            'user_id'              => $user->id,
                            'product_id'           => $realProductId, 
                            'product_variation_id' => $item['variant_id'],
                            'selected_size'        => $item['selected_size'],
                            'selected_color'       => $item['selected_color'],
                            'selected_variant'     => $item['selected_variant'],
                            'quantity'             => $item['quantity'],            
                   ]);
                    }                
                }

                session()->forget('temp_cart');

                return redirect()->route('cart')->with('success', 'Cart updated successfully');
            }

            if($user->type ==1) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.home');

        }
        return  back()->withErrors(['Invalid credentials'])->withInput();

    }
    
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('login');
    }

}


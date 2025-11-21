<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = $this->getWishlist();
        return view('wishlist', compact('wishlist'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->input('id'));

        $attributes = ['product_id' => $product->id];
        if (Auth::check()) {
            $attributes['user_id'] = Auth::id();
        } else {
            $attributes['session_id'] = Session::getId();
        }

        Wishlist::firstOrCreate($attributes);

        return response()->json(['success' => true, 'message' => 'Added to wishlist!']);
    }

    public function remove(Request $request)
    {
        $query = Wishlist::where('product_id', $request->input('id'));

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        $query->delete();

        return response()->json(['success' => true, 'message' => 'Removed from wishlist!']);
    }

    private function getWishlist()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->with('product')->get();
        } else {
            return Wishlist::where('session_id', Session::getId())->with('product')->get();
        }
    }
}

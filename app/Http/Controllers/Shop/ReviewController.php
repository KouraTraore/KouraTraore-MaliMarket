<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($productId);

        // Vérifier si le client a déjà laissé un avis
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            // Mettre à jour l'avis existant
            $existingReview->update([
                'note'        => $request->note,
                'commentaire' => $request->commentaire,
            ]);
            return back()->with('success', 'Votre avis a été mis à jour !');
        }

        // Créer un nouvel avis
        Review::create([
            'user_id'     => Auth::id(),
            'product_id'  => $productId,
            'note'        => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Merci pour votre avis ! ⭐');
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return back()->with('success', 'Avis supprimé !');
    }
}
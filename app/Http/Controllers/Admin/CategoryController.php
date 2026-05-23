<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'   => 'required|string|max:255',
            'image' => 'nullable|url',
        ]);

        Category::create([
            'nom'    => $request->nom,
            'slug'   => Str::slug($request->nom),
            'image'  => $request->image,
            'active' => true,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nom'   => 'required|string|max:255',
            'image' => 'nullable|url',
        ]);

        $category->update([
            'nom'    => $request->nom,
            'slug'   => Str::slug($request->nom),
            'image'  => $request->image,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie modifiée avec succès !');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }

    public function show(Category $category)
    {
        return redirect()->route('admin.categories.index');
    }
}
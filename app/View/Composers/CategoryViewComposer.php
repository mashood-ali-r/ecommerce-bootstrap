<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryViewComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get all active parent categories with their active children
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }
            ])
            ->orderBy('sort_order')
            ->get();

        $view->with('navCategories', $categories);
    }
}

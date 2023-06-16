<?php

namespace Takshak\Ablog\Traits\Controllers\Admin;

use Takshak\Ablog\Actions\BlogCategoryAction;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Takshak\Ablog\Models\Blog\BlogCategory;

trait BlogCategoryTrait
{
    public function index(Request $request)
    {
        $this->authorize('blog_categories_access');
        $query = BlogCategory::select('id', 'name', 'slug', 'blog_category_id', 'image_sm', 'status', 'featured')->with('parentCategory:id,name,slug,blog_category_id');
        if ($request->get('search')) {
            $query->where('name', 'LIKE', '%' . $request->get('search') . '%');
        }
        if ($request->get('status') != null) {
            $query->where('status', $request->get('status'));
        }
        if ($request->get('featured') != null) {
            $query->where('featured', $request->get('featured'));
        }
        if ($request->get('blog_category_id')) {
            $query->where('blog_category_id', $request->get('blog_category_id'));
        }
        $categories = $query->latest()->paginate(50);

        $f_categories = collect();
        if ($request->get('filter')) {
            $f_categories = BlogCategory::select('id', 'name', 'slug', 'blog_category_id')->with('parentCategory:id,name,slug,blog_category_id')->orderBy('name')->get();
        }

        return View::first(
            ['admin.blog.categories.index', 'ablog::admin.blog.categories.index'],
            compact('categories', 'f_categories')
        );
    }

    public function create()
    {
        $this->authorize('blog_categories_create');
        $categories = BlogCategory::orderBy('name')->get();

        return View::first(
            ['admin.blog.categories.create', 'ablog::admin.blog.categories.create'],
            compact('categories')
        );
    }

    public function store(Request $request, BlogCategoryAction $action)
    {
        $this->authorize('blog_categories_create');
        $request->validate([
            'name'          =>  'required',
            'blog_category_id'  =>  'nullable|numeric',
            'status'        =>  'nullable|boolean',
            'featured'      =>  'nullable|boolean',
            'meta_title'    =>  'nullable|max:255',
        ]);

        $category = new BlogCategory();
        $category = $action->save($request, $category);

        return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! New category is successfully added.');
    }

    public function edit(BlogCategory $category)
    {
        $this->authorize('blog_categories_update');
        $categories = BlogCategory::orderBy('name')->get();
        return View::first(
            ['admin.blog.categories.edit', 'ablog::admin.blog.categories.edit'],
            compact('categories', 'category')
        );
    }

    public function update(Request $request, BlogCategory $category, BlogCategoryAction $action)
    {
        $this->authorize('blog_categories_update');
        $request->validate([
            'name'          =>  'required',
            'blog_category_id'  =>  'nullable|numeric',
            'status'        =>  'nullable|boolean',
            'featured'      =>  'nullable|boolean',
            'meta_title'    =>  'nullable|max:255',
        ]);

        $category = $action->save($request, $category);

        return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! New category is successfully updated.');
    }

    public function statusToggle(BlogCategory $category)
    {
        $this->authorize('blog_categories_update');
        $category->update([
            'status' => ($category->status) ? false : true
        ]);
        return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! Categories is successfully updated.');
    }

    public function featuredToggle(BlogCategory $category)
    {
        $this->authorize('blog_categories_update');
        $category->update([
            'featured' => ($category->featured) ? false : true
        ]);
        return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! Featured category is successfully updated.');
    }

    public function destroy(BlogCategory $category)
    {
        $this->authorize('blog_categories_delete');
        Storage::delete([
            $category->image_sm,
            $category->image_md,
            $category->image_lg,
        ]);

        $category->delete();
        return redirect()->route('admin.blog.categories.index')->withSuccess('SUCCESS !! Category is successfully deleted');
    }
}

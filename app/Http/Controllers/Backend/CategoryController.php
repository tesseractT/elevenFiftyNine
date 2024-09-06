<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param CategoryDataTable $categoryDataTable
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:255', 'unique:categories,name'],
            'status' => ['required'],
        ]);

        $category = new Category();

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Category created successfully!');

        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return View
     * @param string $id
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:255', 'unique:categories,name,' . $id],
            'status' => ['required'],
        ]);

        $category = Category::findOrFail($id);

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Category updated successfully!');

        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response(['status' => 'success', 'message' => 'Category deleted successfully!']);
    }

    /**
     * Change status of the specified resource.
     * @param Request $request
     * @return Response
     */

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $subCategories = SubCategory::where('category_id', $category->id)->count();

        if ($subCategories > 0) {
            return response(['status' => 'error', 'message' => 'This category has sub-categories. Please delete them first!']);
        }


        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['status' => 'success', 'message' => 'Status updated successfully!']);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ChildCategoryDataTable $dataTable
     * @return Response
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }


    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.child-category.create', compact('categories'));
    }


    /**
     * Get sub categories by category id
     * @param Request $request
     * @return mixed
     */
    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
        return $subCategories;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'sub_category' => ['required', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:child_categories,name'],
            'status' => ['required'],
        ]);

        $childCategory = new ChildCategory();
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();

        toastr()->success('Child Category created successfully!');

        return redirect()->route('admin.child-category.index');
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
     * @param string $id
     * @return View
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $childCategory = ChildCategory::findOrFail($id);
        $subCategories = SubCategory::where('category_id', $childCategory->category_id)->where('status', 1)->get();
        return view('admin.child-category.edit', compact('categories', 'childCategory', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'sub_category' => ['required', 'exists:sub_categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:child_categories,name,' . $id],
            'status' => ['required'],
        ]);

        $childCategory = ChildCategory::findOrFail($id);
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();

        toastr()->success('Child Category updated successfully!');

        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);
        $childCategory->delete();

        toastr()->success('Child Category deleted successfully!');

        return redirect()->route('admin.child-category.index');
    }

    /**
     * Change status of the specified resource
     * @param Request $request
     * @return mixed
     */
    public function changeStatus(Request $request)
    {
        $childCategory = ChildCategory::findOrFail($request->id);
        $childCategory->status = !$childCategory->status;
        $childCategory->save();

        return response()->json(['success' => 'Status changed successfully!']);
    }
}

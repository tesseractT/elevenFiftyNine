<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param SubCategoryDataTable $dataTable
     * @return Response
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }


    /**
     * Show the form for creating a new resource.
     * @return View
     *
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:sub_categories,name'],
            'status' => ['required', 'in:1,0'],
        ]);

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr()->success('Sub Category created successfully');

        return redirect()->route('admin.sub-category.index');
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
        $subCategory = SubCategory::find($id);
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255', 'unique:sub_categories,name,' . $id],
            'status' => ['required', 'in:1,0'],
        ]);

        $subCategory = SubCategory::findOrFail($id);

        $subCategory->category_id = $request->category;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr()->success('Sub Category updated successfully');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     *  @return RedirectResponse
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();

        toastr()->success('Sub Category deleted successfully');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Change status of the specified resource from storage.
     * @param Request $request
     * @return Response
     */

    public function changeStatus(Request $request)
    {
        $subCategory = SubCategory::findOrFail($request->id);

        $childCategory = ChildCategory::where('sub_category_id', $subCategory->id)->count();

        if ($childCategory > 0) {
            return response()->json(['message' => 'This sub category has child categories. Please delete them first.']);
        }

        $subCategory->status = !$subCategory->status;
        $subCategory->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}

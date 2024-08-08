<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     * @param SliderDataTable $dataTable
     * @return View
     * @throws \Exception
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'type' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'start_price' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'url'],
            'serial_no' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        $slider = new Slider();

        /* handle image upload */

        $imagePath =  $this->uploadImage($request, 'banner', 'uploads');

        $slider->banner = $imagePath;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->start_price = $request->start_price;
        $slider->url = $request->url;
        $slider->serial_no = $request->serial_no;
        $slider->status = $request->status;
        $slider->save();

        toastr()->success('Slider created successfully!');

        return redirect()->back();
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
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'banner' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'type' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'start_price' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'url'],
            'serial_no' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        $slider = Slider::findOrFail($id);



        $imagePath =  $this->updateImage($request, 'banner', 'uploads', $slider->banner);
        $slider->banner = empty($imagePath) ? $slider->banner : $imagePath;


        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->start_price = $request->start_price;
        $slider->url = $request->url;
        $slider->serial_no = $request->serial_no;
        $slider->status = $request->status;
        $slider->save();

        toastr()->success('Slider updated successfully!');

        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     */

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $this->deleteImage($slider->banner);
        $slider->delete();

        return response(['status' => 'success', 'message' => 'Slider deleted successfully!']);
    }
}

@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Slider</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Preview</label>
                                    <br>
                                    <img width="100" src="{{ asset($slider->banner) }}">
                                </div>
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" name="type" class="form-control"
                                        value="{{ old('type', $slider->type) }}">
                                </div>

                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $slider->title) }}">
                                </div>

                                <div class="form-group">
                                    <label>Start Price</label>
                                    <input type="text" name="start_price" class="form-control"
                                        value="{{ old('start_price', $slider->start_price) }}">
                                </div>

                                <div class="form-group">
                                    <label>Button Url</label>
                                    <input type="text" name="url" class="form-control"
                                        value="{{ old('url', $slider->url) }}">
                                </div>

                                <div class="form-group">
                                    <label>Serial No</label>
                                    <input type="text" name="serial_no" class="form-control"
                                        value="{{ old('serial_no', $slider->serial_no) }}">
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option {{ $slider->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $slider->status == 0 ? 'selected' : '' }} value="0">Inactive
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

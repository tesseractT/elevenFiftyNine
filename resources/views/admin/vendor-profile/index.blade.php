@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Vendor Profile</h1>

        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Vendor Profile</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.vendor-profile.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Preview</label>
                                    <br>
                                    <img width="200px" src="{{ asset($profile->banner) }}" alt=""
                                        class="img-fluid">
                                </div>
                                <div class="form-group">
                                    <label>Banner</label>
                                    <input type="file" name="banner" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="phone" name="phone" class="form-control"
                                        value="{{ old('phone', $profile->phone) }}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $profile->email) }}">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $profile->address) }}">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="summernote">{{ old('description', $profile->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Facebook Url</label>
                                    <input type="text" name="fb_link" class="form-control"
                                        value="{{ old('fb_link', $profile->fb_link) }}">
                                </div>

                                <div class="form-group">
                                    <label>Twitter Url</label>
                                    <input type="text" name="twitter_link" class="form-control"
                                        value="{{ old('twitter_link', $profile->twitter_link) }}">
                                </div>

                                <div class="form-group">
                                    <label>Insta Url</label>
                                    <input type="text" name="insta_link" class="form-control"
                                        value="{{ old('insta_link', $profile->insta_link) }}">
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

@extends('backend.layouts.app', ['modal' => 'lg'])
@section('title', 'Category Bulk Import')
@section('page_name')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="h3 mb-0">Category Bulk Import</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house-add-fill"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Category Bulk Import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        <strong>Step One:</strong>
                        <p>1. Download the skeleton file and fill it with proper data.</p>
                        <p>2. You can download the example file to understand how the data must be filled.</p>
                        <p>3. Once you have downloaded and filled the skeleton file, upload it in the form below and submit.</p>
                        <p>4. After uploading category you can edit them and set images and others.</p>
                    </div>
                    <br>
                    <div class="">
                        <a class="btn btn-sm btn-info" href="{{ asset('download/category_bulk_demo.xlsx') }}" download>
                            Download CSV
                        </a>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <form action="{{ route('admin.upload.category') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mt-3 form-group">
                                <h4>Upload Category File</h4>
                            </div>
                            <div class="col-md-4 mt-3 form-group">
                                <input type="file" name="file" id="file" required accept=".csv, .xls, .xlsx" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3 form-group">
                                <button type="submit" class="btn btn-sm btn-outline-success"  id="submit">
                                    <i class="bi bi-send"></i>
                                    Upload
                                </button>
                                <button class="btn btn-sm btn-outline-warning" style="display: none;" id="submitting" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('script')
    <script>
        
    </script>
@endpush
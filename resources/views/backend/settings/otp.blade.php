@extends('backend.layouts.app')
@section('title', 'System Configuration | General')
@push('style')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/dropify.min.css') }}">
@endpush
@section('content')
<div class="row mt-5">
    <div class="col-lg-7 mx-auto col-md-7">
        <div class="card mb-4">
            <div class="card-header">
                <h1 class="h5 mb-0">OTP SMS Templates</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="content_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <div class="align-items-start">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-phone-number-verification-tab" data-bs-toggle="pill" data-bs-target="#v-pills-phone-number-verification" type="button" role="tab" aria-controls="v-pills-phone-number-verification" aria-selected="true">
                                                Phone Number Verification
                                            </button>
                                            <button class="nav-link" id="v-pills-password-reset-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password-reset" type="button" role="tab" aria-controls="v-pills-password-reset" aria-selected="false">
                                                Password Reset
                                            </button>
                                            <button class="nav-link" id="v-pills-order-placement-tab" data-bs-toggle="pill" data-bs-target="#v-pills-order-placement" type="button" role="tab" aria-controls="v-pills-order-placement" aria-selected="false">
                                                Order Placement
                                            </button>
                                            <button class="nav-link" id="v-pills-delivery-status-change-tab" data-bs-toggle="pill" data-bs-target="#v-pills-delivery-status-change" type="button" role="tab" aria-controls="v-pills-delivery-status-change" aria-selected="false">
                                                Delivery Status Change
                                            </button>
                                            <button class="nav-link" id="v-pills-payment-status-change-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payment-status-change" type="button" role="tab" aria-controls="v-pills-payment-status-change" aria-selected="false">
                                                Payment Status Change
                                            </button>
                                            <button class="nav-link" id="v-pills-assign-delivery-body-tab" data-bs-toggle="pill" data-bs-target="#v-pills-assign-delivery-body" type="button" role="tab" aria-controls="v-pills-assign-delivery-body" aria-selected="false">
                                                Assign Delivery Boy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-phone-number-verification" role="tabpanel" aria-labelledby="v-pills-phone-number-verification-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_phone_number_verification_template">SMS Body</label>
                                                        <textarea name="sms_phone_number_verification_template" id="sms_phone_number_verification_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_phone_number_verification_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-password-reset" role="tabpanel" aria-labelledby="v-pills-password-reset-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_password_reset_template">SMS Body</label>
                                                        <textarea name="sms_password_reset_template" id="sms_password_reset_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_password_reset_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-order-placement" role="tabpanel" aria-labelledby="v-pills-order-placement-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_order_placement_status">Activation</label>
                                                        <select name="sms_order_placement_status" id="sms_order_placement_status" class="form-control select">
                                                            <option {{ get_settings('sms_order_placement_status') == 1 ? 'selected' : '' }} value="1">Activate</option>
                                                            <option {{ get_settings('sms_order_placement_status') == 0 ? 'selected' : '' }} value="0">Deactivate</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_online_order_placement_template">SMS Body</label>
                                                        <textarea name="sms_online_order_placement_template" id="sms_online_order_placement_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_online_order_placement_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-delivery-status-change" role="tabpanel" aria-labelledby="v-pills-delivery-status-change-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_delivery_status_change">Activation</label>
                                                        <select name="sms_delivery_status_change" id="sms_delivery_status_change" class="form-control select">
                                                            <option {{ get_settings('sms_delivery_status_change') == 1 ? 'selected' : '' }} value="1">Activate</option>
                                                            <option {{ get_settings('sms_delivery_status_change') == 0 ? 'selected' : '' }} value="0">Deactivate</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_delivery_status_change_template">SMS Body</label>
                                                        <textarea name="sms_delivery_status_change_template" id="sms_delivery_status_change_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_delivery_status_change_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-payment-status-change" role="tabpanel" aria-labelledby="v-pills-payment-status-change-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_payment_change_status">Activation</label>
                                                        <select name="sms_payment_change_status" id="sms_payment_change_status" class="form-control select">
                                                            <option {{ get_settings('sms_payment_change_status') == 1 ? 'selected' : '' }} value="1">Activate</option>
                                                            <option {{ get_settings('sms_payment_change_status') == 0 ? 'selected' : '' }} value="0">Deactivate</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_payment_status_change_template">SMS Body</label>
                                                        <textarea name="sms_payment_status_change_template" id="sms_payment_status_change_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_payment_status_change_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-assign-delivery-body" role="tabpanel" aria-labelledby="v-pills-assign-delivery-body-tab">
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_delivery_boy_status">Activation</label>
                                                        <select name="sms_delivery_boy_status" id="sms_delivery_boy_status" class="form-control select">
                                                            <option {{ get_settings('sms_delivery_boy_status') == 1 ? 'selected' : '' }} value="1">Activate</option>
                                                            <option {{ get_settings('sms_delivery_boy_status') == 0 ? 'selected' : '' }} value="0">Deactivate</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 form-group mb-3">
                                                        <label for="sms_assign_delivery_boy_template">SMS Body</label>
                                                        <textarea name="sms_assign_delivery_boy_template" id="sms_assign_delivery_boy_template" class="form-control" cols="30" rows="4">{{ get_settings('sms_assign_delivery_boy_template') }}</textarea>
                                                        <span class="text-danger">Do not change the variable [[ ____ ]]</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group text-end">
                            <button type="submit" id="submit" class="btn btn-soft-success">
                                <i class="bi bi-send"></i>
                                Update
                            </button>
                            <button type="button" style="display: none;" id="submitting" class="btn btn-soft-warning">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
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
        _componentSelect();
        _formValidation();
    </script>
@endpush
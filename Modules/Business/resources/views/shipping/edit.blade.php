@extends('business::layouts.master')

@section('title')
    Edit Shipping Service
@endsection

@section('main_content')
<div class="erp-table-section">
    <div class="container-fluid">
        <div class="card">
            <div class="card-bodys">
                <div class="table-header p-16">
                    <h4>Edit Shipping Service</h4>
                   
                        <a href="{{ route('business.shipping.index') }}" class="add-order-btn rounded-2 active"><i class="far fa-list me-1" aria-hidden="true"></i> {{ __('View List') }}</a>
                  
                </div>
                <div class="order-form-section p-16">
                    <form action="{{ route('business.shipping.store') }}"  enctype="multipart/form-data" method="POST" class="ajaxform_instant_reload">
                        @csrf
                        <div class="add-suplier-modal-wrapper d-block">
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <label>Platform Name</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Company Name">
                                </div>


                                <div class="col-lg-6 mb-2"> 
                               <label>Select Service</label>
                              <div class="gpt-up-down-arrow position-relative">
               <select name="shipping_company_id" id="shipping_company" class="form-control table-select w-100 role">
                            <option value="">Select Service</option>
                            
               @foreach ($shipping_companys as $shipping_company)
                <option value="{{ $shipping_company->id }}" 
                        data-credential="{{ $shipping_company->first_r_credential_lable}}"
                        data-label="{{ $shipping_company->first_r_credential_lable}}"
                        data-second-credential="{{ $shipping_company->second_r_credential_lable}}"
                        data-second-label="{{ $shipping_company->second_r_credential_lable}}">
                    {{ ucfirst($shipping_company->name) }}
                </option>
            @endforeach
          </select>
        </div>
        </div>
                                <div class="col-lg-6 mb-2">
                                    <label id="first_r_credential_lable"></label>
                                    <input type="text" name="first_r_credential" class="form-control" placeholder="Please select a shipping service">
                                </div>

                                <div class="col-lg-6 mb-2">
                                    <label id="second_r_credential_lable"></label>
                                    <input type="text" name="second_r_credential" class="form-control" placeholder="Please select a shipping service">
                                </div>

                                <div class="col-lg-12">
                                    <div class="button-group text-center mt-5">
                                        <button type="reset" class="theme-btn border-btn m-2">{{ __('Cancel') }}</button>
                                        <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectElement = document.getElementById("shipping_company");

        // First Credential Elements
        const firstInput = document.getElementById("first_r_credential_input");
        const firstLabel = document.getElementById("first_r_credential_lable");

        // Second Credential Elements
        const secondInput = document.getElementById("second_r_credential_input");
        const secondLabel = document.getElementById("second_r_credential_lable");



        selectElement.addEventListener("change", function() {
            let selectedOption = selectElement.options[selectElement.selectedIndex];

            let firstCredential = selectedOption.getAttribute("data-credential");
            let firstCredentialLabel = selectedOption.getAttribute("data-label");

            let secondCredential = selectedOption.getAttribute("data-second-credential");
            let secondCredentialLabel = selectedOption.getAttribute("data-second-label");

            // Update first required credential
            if (firstCredential && firstCredentialLabel) {
                firstLabel.textContent = firstCredentialLabel;
                firstInput.value = firstCredential;
            } else {
                firstLabel.textContent = "";
                firstInput.value = "";
            }

            // Update second required credential
            if (secondCredential && secondCredentialLabel) {
                secondLabel.textContent = secondCredentialLabel;
                secondInput.value = secondCredential;
            } else {
                secondLabel.textContent = "";
                secondInput.value = "";
            }
        });
    });
</script>

@endsection

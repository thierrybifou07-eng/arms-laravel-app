@extends('layouts.app')

@section('content')
    <div class="row fv-plugins-icon-container">
        <div class="col-md-12">
            <div class="card mb-6">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Create a new room</h5>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body pt-4">
                    <form id="formAccountSettings" method="POST" action="{{ route('contracts.store') }}"
                        class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                        @csrf
                        <div class="row g-6">
                            <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                                <label for="rent_amount" class="form-label">Rent</label>
                                <div class="input-group input-group-merge">

                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class="icon-base bx bx-money"></i></span>
                                    <span id="basic-icon-default-message2" class="input-group-text">FCFA</span>
                                    <input class="form-control" type="number" id="rent_amount" name="rent_amount"
                                        value="{{ old('rent_amount') }}" placeholder="Enter the amount Ex: 100000"
                                        aria-label="Enter the rent amount" autofocus="">
                                </div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input type="date" id="multicol-birthdate" class="form-control dob-picker flatpickr-input"
                                    placeholder="MM-DD-YYYY" name="start_date" value="{{ old('start_date') }}"
                                    aria-label="MM-DD-YYYY">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                                <label class="form-label" for="end_date">End Date</label>
                                <input type="date" id="multicol-birthdate" class="form-control dob-picker flatpickr-input"
                                    placeholder="MM-DD-YYYY" name="end_date" value="{{ old('end_date') }}"
                                    aria-label="MM-DD-YYYY">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6"><div class="row mb-6 select2-primary" data-select2-id="27">
          <label class="col-sm-3 col-form-label" for="multicol-country">Country</label>
          <div class="col-sm-9" data-select2-id="26">
            <div class="position-relative" data-select2-id="25"><select id="multicol-country" class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="multicol-country" tabindex="-1" aria-hidden="true">
              <option value="" data-select2-id="2">Select</option>
              <option value="Australia" data-select2-id="31">Australia</option>
              <option value="Bangladesh" data-select2-id="32">Bangladesh</option>
              <option value="Belarus" data-select2-id="33">Belarus</option>
              <option value="Brazil" data-select2-id="34">Brazil</option>
              <option value="Canada" data-select2-id="35">Canada</option>
              <option value="China" data-select2-id="36">China</option>
              <option value="France" data-select2-id="37">France</option>
              <option value="Germany" data-select2-id="38">Germany</option>
              <option value="India" data-select2-id="39">India</option>
              <option value="Indonesia" data-select2-id="40">Indonesia</option>
              <option value="Israel" data-select2-id="41">Israel</option>
              <option value="Italy" data-select2-id="42">Italy</option>
              <option value="Japan" data-select2-id="43">Japan</option>
              <option value="Korea" data-select2-id="44">Korea, Republic of</option>
              <option value="Mexico" data-select2-id="45">Mexico</option>
              <option value="Philippines" data-select2-id="46">Philippines</option>
              <option value="Russia" data-select2-id="47">Russian Federation</option>
              <option value="South Africa" data-select2-id="48">South Africa</option>
              <option value="Thailand" data-select2-id="49">Thailand</option>
              <option value="Turkey" data-select2-id="50">Turkey</option>
              <option value="Ukraine" data-select2-id="51">Ukraine</option>
              <option value="United Arab Emirates" data-select2-id="52">United Arab Emirates</option>
              <option value="United Kingdom" data-select2-id="53">United Kingdom</option>
              <option value="United States" data-select2-id="54">United States</option>
            </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--open" dir="ltr" data-select2-id="1" style="width: 468.25px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="true" tabindex="0" aria-disabled="false" aria-labelledby="select2-multicol-country-container" aria-owns="select2-multicol-country-results" aria-activedescendant="select2-multicol-country-result-y9bx-Turkey"><span class="select2-selection__rendered" id="select2-multicol-country-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select value</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span><span class="select2-container select2-container--default select2-container--open" style="position: absolute; top: 38px; left: 0px;"><span class="select2-dropdown select2-dropdown--below" dir="ltr" style="width: 758.5px;"><span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" aria-controls="select2-multicol-country-results" aria-activedescendant="select2-multicol-country-result-y9bx-Turkey"></span><span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-multicol-country-results" aria-expanded="true" aria-hidden="false"><li class="select2-results__option" id="select2-multicol-country-result-k2mi-Australia" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-k2mi-Australia">Australia</li><li class="select2-results__option" id="select2-multicol-country-result-bv8n-Bangladesh" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-bv8n-Bangladesh">Bangladesh</li><li class="select2-results__option" id="select2-multicol-country-result-zou1-Belarus" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-zou1-Belarus">Belarus</li><li class="select2-results__option" id="select2-multicol-country-result-yoy9-Brazil" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-yoy9-Brazil">Brazil</li><li class="select2-results__option" id="select2-multicol-country-result-xz0s-Canada" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-xz0s-Canada">Canada</li><li class="select2-results__option" id="select2-multicol-country-result-vcth-China" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-vcth-China">China</li><li class="select2-results__option" id="select2-multicol-country-result-tm85-France" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-tm85-France">France</li><li class="select2-results__option" id="select2-multicol-country-result-xy5q-Germany" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-xy5q-Germany">Germany</li><li class="select2-results__option" id="select2-multicol-country-result-xfkp-India" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-xfkp-India">India</li><li class="select2-results__option" id="select2-multicol-country-result-npf8-Indonesia" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-npf8-Indonesia">Indonesia</li><li class="select2-results__option" id="select2-multicol-country-result-2f0f-Israel" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-2f0f-Israel">Israel</li><li class="select2-results__option" id="select2-multicol-country-result-qxr1-Italy" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-qxr1-Italy">Italy</li><li class="select2-results__option" id="select2-multicol-country-result-1vi3-Japan" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-1vi3-Japan">Japan</li><li class="select2-results__option" id="select2-multicol-country-result-63ip-Korea" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-63ip-Korea">Korea, Republic of</li><li class="select2-results__option" id="select2-multicol-country-result-37fp-Mexico" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-37fp-Mexico">Mexico</li><li class="select2-results__option" id="select2-multicol-country-result-pyfs-Philippines" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-pyfs-Philippines">Philippines</li><li class="select2-results__option" id="select2-multicol-country-result-0s4f-Russia" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-0s4f-Russia">Russian Federation</li><li class="select2-results__option" id="select2-multicol-country-result-i43f-South Africa" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-i43f-South Africa">South Africa</li><li class="select2-results__option" id="select2-multicol-country-result-vpi9-Thailand" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-vpi9-Thailand">Thailand</li><li class="select2-results__option select2-results__option--highlighted" id="select2-multicol-country-result-y9bx-Turkey" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-y9bx-Turkey">Turkey</li><li class="select2-results__option" id="select2-multicol-country-result-2j0k-Ukraine" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-2j0k-Ukraine">Ukraine</li><li class="select2-results__option" id="select2-multicol-country-result-b9y4-United Arab Emirates" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-b9y4-United Arab Emirates">United Arab Emirates</li><li class="select2-results__option" id="select2-multicol-country-result-7boc-United Kingdom" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-7boc-United Kingdom">United Kingdom</li><li class="select2-results__option" id="select2-multicol-country-result-hpp7-United States" role="option" aria-selected="false" data-select2-id="select2-multicol-country-result-hpp7-United States">United States</li></ul></span></span></span></div>
          </div>
        </div></div>
                            <div class="col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <div class="position-relative"><select id="language"
                                        class="select2 form-select select2-hidden-accessible" data-select2-id="language"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="4">Select Language</option>
                                        <option value="en">English</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="pt">Portuguese</option>
                                    </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                        data-select2-id="3" style="width: 414.688px;"><span class="selection"><span
                                                class="select2-selection select2-selection--single" role="combobox"
                                                aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                aria-disabled="false" aria-labelledby="select2-language-container"><span
                                                    class="select2-selection__rendered" id="select2-language-container"
                                                    role="textbox" aria-readonly="true" title="Select Language">Select
                                                    Language</span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                            </div>
                            <div class="col-md-6">
                                <label for="timeZones" class="form-label">Timezone</label>
                                <div class="position-relative"><select id="timeZones"
                                        class="select2 form-select select2-hidden-accessible" data-select2-id="timeZones"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="6">Select Timezone</option>
                                        <option value="-12">(GMT-12:00) International Date Line West</option>
                                        <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                                        <option value="-10">(GMT-10:00) Hawaii</option>
                                        <option value="-9">(GMT-09:00) Alaska</option>
                                        <option value="-8">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                        <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                                        <option value="-7">(GMT-07:00) Arizona</option>
                                        <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                        <option value="-7">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                        <option value="-6">(GMT-06:00) Central America</option>
                                        <option value="-6">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                        <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                        <option value="-6">(GMT-06:00) Saskatchewan</option>
                                        <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="-5">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                        <option value="-5">(GMT-05:00) Indiana (East)</option>
                                        <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                                        <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                                    </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                        data-select2-id="5" style="width: 414.688px;"><span class="selection"><span
                                                class="select2-selection select2-selection--single" role="combobox"
                                                aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                aria-disabled="false" aria-labelledby="select2-timeZones-container"><span
                                                    class="select2-selection__rendered" id="select2-timeZones-container"
                                                    role="textbox" aria-readonly="true" title="Select Timezone">Select
                                                    Timezone</span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                            </div>
                            <div class="col-md-6">
                                <label for="currency" class="form-label">Currency</label>
                                <div class="position-relative"><select id="currency"
                                        class="select2 form-select select2-hidden-accessible" data-select2-id="currency"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="8">Select Currency</option>
                                        <option value="usd">USD</option>
                                        <option value="euro">Euro</option>
                                        <option value="pound">Pound</option>
                                        <option value="bitcoin">Bitcoin</option>
                                    </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                        data-select2-id="7" style="width: 414.688px;"><span class="selection"><span
                                                class="select2-selection select2-selection--single" role="combobox"
                                                aria-haspopup="true" aria-expanded="false" tabindex="0"
                                                aria-disabled="false" aria-labelledby="select2-currency-container"><span
                                                    class="select2-selection__rendered" id="select2-currency-container"
                                                    role="textbox" aria-readonly="true" title="Select Currency">Select
                                                    Currency</span><span class="select2-selection__arrow"
                                                    role="presentation"><b
                                                        role="presentation"></b></span></span></span><span
                                            class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
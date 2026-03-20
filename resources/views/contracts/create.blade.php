@extends('layouts.app')

@section('content')
<div class="col-xxl" data-select2-id="63">
    <div class="card" data-select2-id="62">
      <h5 class="card-header">Form Label Alignment</h5>
      <form class="card-body" data-select2-id="61">
        <h6>1. Account Details</h6>
        <div class="row mb-6">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-username">Username</label>
          <div class="col-sm-9">
            <input type="text" id="alignment-username" class="form-control" placeholder="john.doe">
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-email">Email</label>
          <div class="col-sm-9">
            <div class="input-group input-group-merge">
              <input type="text" id="alignment-email" class="form-control" placeholder="john.doe" aria-label="john.doe" aria-describedby="alignment-email2">
              <span class="input-group-text" id="alignment-email2">@example.com</span>
            </div>
          </div>
        </div>
        <div class="row mb-6 form-password-toggle">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-password">Password</label>
          <div class="col-sm-9">
            <div class="input-group input-group-merge">
              <input type="password" id="alignment-password" class="form-control" placeholder="············" aria-describedby="alignment-password2">
              <span class="input-group-text cursor-pointer" id="alignment-password2"><i class="icon-base bx bx-hide"></i></span>
            </div>
          </div>
        </div>
        <hr class="my-6 mx-n6">
        <h6>2. Personal Info</h6>
        <div class="row mb-6">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-full-name">Full Name</label>
          <div class="col-sm-9">
            <input type="text" id="alignment-full-name" class="form-control" placeholder="John Doe">
          </div>
        </div>
        <div class="row mb-6" data-select2-id="60">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-country">Country</label>
          <div class="col-sm-9" data-select2-id="59">
            <div class="position-relative" data-select2-id="58"><select id="alignment-country" class="select2 form-select select2-hidden-accessible" data-allow-clear="true" data-select2-id="alignment-country" tabindex="-1" aria-hidden="true">
              <option value="" data-select2-id="9">Select</option>
              <option value="Australia" data-select2-id="64">Australia</option>
              <option value="Bangladesh" data-select2-id="65">Bangladesh</option>
              <option value="Belarus" data-select2-id="66">Belarus</option>
              <option value="Brazil" data-select2-id="67">Brazil</option>
              <option value="Canada" data-select2-id="68">Canada</option>
              <option value="China" data-select2-id="69">China</option>
              <option value="France" data-select2-id="70">France</option>
              <option value="Germany" data-select2-id="71">Germany</option>
              <option value="India" data-select2-id="72">India</option>
              <option value="Indonesia" data-select2-id="73">Indonesia</option>
              <option value="Israel" data-select2-id="74">Israel</option>
              <option value="Italy" data-select2-id="75">Italy</option>
              <option value="Japan" data-select2-id="76">Japan</option>
              <option value="Korea" data-select2-id="77">Korea, Republic of</option>
              <option value="Mexico" data-select2-id="78">Mexico</option>
              <option value="Philippines" data-select2-id="79">Philippines</option>
              <option value="Russia" data-select2-id="80">Russian Federation</option>
              <option value="South Africa" data-select2-id="81">South Africa</option>
              <option value="Thailand" data-select2-id="82">Thailand</option>
              <option value="Turkey" data-select2-id="83">Turkey</option>
              <option value="Ukraine" data-select2-id="84">Ukraine</option>
              <option value="United Arab Emirates" data-select2-id="85">United Arab Emirates</option>
              <option value="United Kingdom" data-select2-id="86">United Kingdom</option>
              <option value="United States" data-select2-id="87">United States</option>
            </select><span class="select2 select2-container select2-container--default select2-container--below select2-container--focus" dir="ltr" data-select2-id="8" style="width: 468.25px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-alignment-country-container"><span class="select2-selection__rendered" id="select2-alignment-country-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select value</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div>
          </div>
        </div>
        <div class="row mb-6 select2-primary">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-language">Language</label>
          <div class="col-sm-9">
            <div class="position-relative"><select id="alignment-language" class="select2 form-select select2-hidden-accessible" multiple="" data-select2-id="alignment-language" tabindex="-1" aria-hidden="true">
              <option value="en" selected="" data-select2-id="11">English</option>
              <option value="fr" selected="" data-select2-id="12">French</option>
              <option value="de">German</option>
              <option value="pt">Portuguese</option>
            </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="10" style="width: 468.25px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-selection__choice" title="English" data-select2-id="13"><span class="select2-selection__choice__remove" role="presentation">×</span>English</li><li class="select2-selection__choice" title="French" data-select2-id="14"><span class="select2-selection__choice__remove" role="presentation">×</span>French</li><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div>
          </div>
        </div>
        <div class="row mb-6">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-birthdate">Birth Date</label>
          <div class="col-sm-9">
            <input type="text" id="alignment-birthdate" class="form-control dob-picker flatpickr-input" placeholder="YYYY-MM-DD" readonly="readonly">
          </div>
        </div>
        <div class="row">
          <label class="col-sm-3 col-form-label text-sm-end" for="alignment-phone">Phone No</label>
          <div class="col-sm-9">
            <input type="text" id="alignment-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941">
          </div>
        </div>
        <div class="pt-6">
          <div class="row justify-content-end">
            <div class="col-sm-9">
              <button type="submit" class="btn btn-primary me-3">Submit</button>
              <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
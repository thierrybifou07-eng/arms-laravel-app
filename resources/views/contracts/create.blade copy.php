@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Create Contract</h5>
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="GET" onsubmit="return false"
                class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                <div class="row g-6">
                    <div class="col-md-6" data-select2-id="11">
                        <label for="language" class="form-label">Language</label>
                        <div class="position-relative" data-select2-id="10"><select id="language"
                                class="select2 form-select select2-hidden-accessible" data-select2-id="language"
                                tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="4">Select Language</option>
                                <option value="en" data-select2-id="14">English</option>
                                <option value="fr" data-select2-id="15">French</option>
                                <option value="de" data-select2-id="16">German</option>
                                <option value="pt" data-select2-id="17">Portuguese</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <label for="language" class="form-label">student</label>
                        <div class="position-relative"><select id="language"
                                class="select2 form-select select2-hidden-accessible" data-select2-id="language"
                                tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="4">Select the student</option>
                                <option value="en">English</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                data-select2-id="3" style="width: 414.688px;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox"
                                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-language-container"><span
                                            class="select2-selection__rendered" id="select2-language-container"
                                            role="textbox" aria-readonly="true" title="Select Language">Select
                                            Language</span><span class="select2-selection__arrow" role="presentation"><b
                                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                    aria-hidden="true"></span></span></div>
                    </div> --}}
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Rent amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="PhoneNumber" name="rent_amount" class="form-control" placeholder="50000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="input-group input-group-merge">
                            <input type="date" id="DateTime" name="start_date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="input-group input-group-merge">
                            <input type="date" id="DateTime" name="end_date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                        <label for="lastName" class="form-label">Rent Amount</label>
                        <input class="form-control" type="text" name="lastName" id="lastName" value="Doe">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" type="text" id="email" name="email" value="john.doe@example.com"
                            placeholder="john.doe@example.com">
                    </div>
                    <div class="col-md-6">
                        <label for="organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="organization" name="organization"
                            value="ThemeSelection">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phoneNumber">Phone Number</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">US (+1)</span>
                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                placeholder="202 555 0111">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="country">Country</label>
                        <div class="position-relative"><select id="country"
                                class="select2 form-select select2-hidden-accessible" data-select2-id="country"
                                tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="2">Select</option>
                                <option value="Australia">Australia</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr"
                                data-select2-id="1" style="width: 414.688px;"><span class="selection"><span
                                        class="select2-selection select2-selection--single" role="combobox"
                                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-country-container"><span
                                            class="select2-selection__rendered" id="select2-country-container"
                                            role="textbox" aria-readonly="true" title="Select">Select</span><span
                                            class="select2-selection__arrow" role="presentation"><b
                                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                    aria-hidden="true"></span></span></div>
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
                                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-timeZones-container"><span
                                            class="select2-selection__rendered" id="select2-timeZones-container"
                                            role="textbox" aria-readonly="true" title="Select Timezone">Select
                                            Timezone</span><span class="select2-selection__arrow" role="presentation"><b
                                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                    aria-hidden="true"></span></span></div>
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
                                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                                        aria-labelledby="select2-currency-container"><span
                                            class="select2-selection__rendered" id="select2-currency-container"
                                            role="textbox" aria-readonly="true" title="Select Currency">Select
                                            Currency</span><span class="select2-selection__arrow" role="presentation"><b
                                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                                    aria-hidden="true"></span></span></div>
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
    {{-- <div class="select-container">
        <input type="hidden" name="student_id" id="student_id">
        <div class="select-box" onclick="toggleDropdown()">
            <span class="selected-text" id="selected-text">Select Student</span>
            <span class="arrow">▼</span>

        </div>
        <div class="row mb-6 dropdown" id="dropdown">
            <label class="col-sm-3 col-form-label text-sm-end" for="student_id">Student</label>
            <div class="col-sm-9" data-select2-id="59">
                <input type="text" id="search" placeholder="Search students..." onkeyup="filterList()">

                <div class="position-relative"><select id="alignment-country" name="student_id" required
                        class="options select2 form-select select2-hidden-accessible" data-allow-clear="true" id="options"
                        tabindex="-1" aria-hidden="true">
                        @foreach ($students as $student)
                        <option data-id="{{ $student->id }}" onclick="selectOption(this)" value="{{ $student->id }}">{{
                            $student->surname }} {{ $student->given_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div> --}}
    {{--
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        function selectOption(element) {
            document.getElementById("selected-text").innerText = element.innerText;
            document.getElementById("dropdown").style.display = "none";
            const studentId = element.getAttribute("data-id");
            document.getElementById("student_id").value = studentId;
        }

        function filterList() {
            let input = document.getElementById("search").value.toLowerCase();
            let options = document.getElementsByClassName("option");

            for (let i = 0; i < options.length; i++) {
                let text = options[i].innerText.toLowerCase();
                options[i].style.display = text.includes(input) ? "" : "none";
            }
        }

        /* Fermer si on clique ailleurs */
        document.addEventListener("click", function (e) {
            const container = document.querySelector(".select-container");
            if (!container.contains(e.target)) {
                document.getElementById("dropdown").style.display = "none";
            }
        });
    </script> --}}

    @push('scripts')

    @endpush
@endsection
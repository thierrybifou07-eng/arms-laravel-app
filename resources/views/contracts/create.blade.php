@extends('layouts.app')

@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Create Contract</h5>
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="GET" onsubmit="return false"
                class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                <div class="row g-6">
                    <div class="col-md-6">
                        <label for="language" class="form-label">Student</label>
                        <div class="position-relative"><select id="language" class="select2 form-select" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select Student</option>
                                <option value="en">Thierry</option>
                                <option value="fr">Passy</option>
                                <option value="de">Chacha</option>
                                <option value="pt">Arthur</option>
                                <option value="pt">Mathieu</option>
                                <option value="pt">Trésor</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Rent amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="PhoneNumber" name="rent_amount" class="form-control" placeholder="50000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="position-relative">
                            <input type="date" id="DateTime" name="start_date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="position-relative">
                            <input type="date" id="DateTime" name="end_date" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="country">Country</label>
                        <div class="position-relative"><select id="country" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->surname }} {{ $student->given_name }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-6">
                        <label for="currency" class="form-label">Currency</label>
                        <div class="position-relative"><select id="currency" class="select2 form-select" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Select Currency</option>
                                <option value="usd">USD</option>
                                <option value="euro">Euro</option>
                                <option value="pound">Pound</option>
                                <option value="bitcoin">Bitcoin</option>
                            </select>
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
    @push('scripts')
        <script>
            console.log($.fn.select2);
            console.log("Select2 init");
            $(document).ready(function () {

                $('#country').select2({
                    placeholder: "Select country",
                    allowClear: true,
                    width: '100%'
                });

                $('#currency').select2({
                    placeholder: "Select currency",
                    allowClear: true,
                    width: '100%'
                });

                $('#language').select2({
                    placeholder: "Select language",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection
Nous avons quelque soucis...deja quand je creer le contrat le montant n,est pas affiche comme on le voulais...aussi bien
que jai choisie une chambre, le message d'erreur precise que le champ room est required donc la requete n;est pas
effectuer...tiens les images et le code de la vue contracts.crerate

@extends('layouts.app')
@section('content')
    <div class="card mb-6">
        <h5 class="card-header">Create Contract</h5>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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
            <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" action="{{ route('contracts.store') }}">
                @csrf
                <div class="row g-6">
                    <div class="col-md-6">
                        <label for="student_id" class="form-label">Student</label>
                        <div class="position-relative"><select name="student_id" id="student_id" class="select2 form-select"
                                tabindex="-1" aria-hidden="true">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->surname }} {{ $student->given_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- Select residence
                    --}}<div class="col-md-6">
                        <label class="form-label">Residence</label>
                        <select id="residence" class="select2 form-select">
                            <option value="">Select residence</option>
                            @foreach(\App\Models\Residence::all() as $residence)
                                <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Building</label>
                        <select id="building" class="select2 form-select"></select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Floor</label>
                        <select id="floor" class="select2 form-select"></select>
                    </div>
                    {{-- Select residence
                    --}} <div class="col-md-6">
                        <label class="form-label">Room</label>
                        <div class="position-relative"><select id="room_id" name="room_id"
                                class="select2 form-select"></select>
                        </div>
                    </div>

                    {{-- Auto calcul total rent_amount
                    --}} <div class="col-md-6">
                        <label class="form-label" for="start_date">Start date</label>
                        <div class="position-relative">
                            <input type="date" value="{{ old('start_date') }}" id="start_date" name="start_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="end_date">End date</label>
                        <div class="position-relative">
                            <input type="date" id="end_date" value="{{ old('end_date') }}" name="end_date"
                                class="form-control" placeholder="" required>
                        </div>
                    </div>
                    {{-- Billing Period --}}
                    <div class="col-md-6">
                        <label class="form-label" for="billing_period_id">Billing Period</label>
                        <div class="position-relative"><select name="billing_period_id" id="billing_period"
                                class="select2 form-select">
                                <option value="" disabled selected>Select Billing Period</option>
                                @foreach($billingPeriods as $billingPeriod)
                                    <option placeholder="Select billing period" value="{{ $billingPeriod->id }}">
                                        {{ $billingPeriod->label }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Calculated Amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="calculated_amount" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Payment Schedule Preview</label>
                        <ul id="payment_schedule" class="list-group"></ul>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary me-3">Create Contract</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                    <input type="hidden">
            </form>
        </div>
    </div>
    @push('scripts')
        {{--
        <script>
            console.log($.fn.select2);
            console.log("Select2 init");
            $(document).ready(function () {

                $('#resident').select2({
                    placeholder: "Select resident",
                    allowClear: true,
                    width: '100%'
                });

                $('#room').select2({
                    placeholder: "Select room",
                    allowClear: true,
                    width: '100%'
                });

                /*                  $('#billing_period').select2({
                                    placeholder: "Select billing period",
                                    allowClear: true,
                                    width: '100%'
                                }); */
            });

            $(document).ready(function () {

                $('#resident, #residence, #building, #floor, #room_id').select2({
                    width: '100%',
                    placeholder: 'Select option'
                });
                //triggers
                $('#room_id, #billing_period').on('change', calculateAmount);
                // Residence → Buildings
                $('#residence').on('change', function () {
                    let id = $(this).val();

                    $('#building').empty();
                    $('#floor').empty();
                    $('#room_id').empty();

                    fetch(`/buildings/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            $('#building').append('<option></option>');
                            data.forEach(b => {
                                $('#building').append(`<option value="${b.id}">${b.name}</option>`);
                            });
                        });
                });

                // Building → Floors
                $('#building').on('change', function () {
                    let id = $(this).val();

                    $('#floor').empty();
                    $('#room_id').empty();

                    fetch(`/floors/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            $('#floor').append('<option></option>');
                            data.forEach(f => {
                                $('#floor').append(`<option value="${f.id}">Floor ${f.number}</option>`);
                            });
                        });
                });

                // Floor → Rooms
                $('#floor').on('change', function () {
                    let id = $(this).val();

                    $('#room_id').empty();

                    fetch(`/rooms/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            $('#room_id').append('<option></option>');
                            data.forEach(r => {
                                $('#room_id').append(
                                    `<option value="${r.id}">Room ${r.number} - ${r.rent} FCFA</option>`
                                );
                            });
                        });
                });

            });

            //Auto calcul


            function calculateAmount() {

                let roomId = $('#room_id').val();
                let billingText = $('#billing_period option:selected').text();

                if (!roomId || !billingText) return;

                let roomOption = $('#room_id option:selected').text();

                                        // extrait le rent depuis le label (ex: "Room 101 - 50000 FCFA")
                                        /* let rentMatch = roomOption.match(/(\d+)\s*FCFA/);
                                         */             let rentMatch = roomOption.match(/([\d.]+)\s*FCFA/);
                if (!rentMatch) return;
                let rent = parseFloat(rentMatch[1]);

                let multiplier = 1;

                if (billingText.toLowerCase().includes('quarter')) multiplier = 3;
                if (billingText.toLowerCase().includes('year')) multiplier = 12;

                let amount = rent * multiplier;

                $('#calculated_amount').val(amount);
            } 
        </script> --}}
        <script>
            $(document).ready(function () {

                // INIT SELECT2
                $('#student_id, #residence, #building, #floor, #room_id, #billing_period')
                    .select2({ width: '100%', placeholder: 'Select option' });

                // =========================
                // CASCADE SELECTS
                // =========================

                $('#residence').on('change', function () {
                    let id = $(this).val();

                    $('#building, #floor, #room_id').empty().trigger('change');

                    fetch(`/buildings/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(b => {
                                options += `<option value="${b.id}">${b.name}</option>`;
                            });
                            $('#building').html(options).trigger('change');
                        });
                });

                $('#building').on('change', function () {
                    let id = $(this).val();

                    $('#floor, #room_id').empty().trigger('change');

                    fetch(`/floors/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(f => {
                                options += `<option value="${f.id}">Floor ${f.number}</option>`;
                            });
                            $('#floor').html(options).trigger('change');
                        });
                });

                $('#floor').on('change', function () {
                    let id = $(this).val();

                    $('#room_id').empty().trigger('change');

                    fetch(`/rooms/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option></option>';
                            data.forEach(r => {
                                options += `
                                        <option value="${r.id}" data-rent="${r.rent}">
                                            Room ${r.number} - ${r.rent} FCFA
                                        </option>`;
                            });
                            $('#room_id').html(options).trigger('change');
                        });
                });

                // =========================
                // TRIGGERS
                // =========================

                $('#room_id, #billing_period, #start_date, #end_date')
                    .on('change select2:select', function () {
                        calculateAmount();
                        generateSchedulePreview();
                    });

                // =========================
                // CALCUL MONTANT
                // =========================

                function calculateAmount() {
                    let rent = $('#room_id option:selected').data('rent');
                    let billingText = $('#billing_period option:selected').text();

                    if (!rent || !billingText) return;

                    let multiplier = 1;

                    if (billingText.toLowerCase().includes('monthly')) multiplier = 1;
                    if (billingText.toLowerCase().includes('quarter')) multiplier = 3;
                    if (billingText.toLowerCase().includes('half_yearly')) multiplier = 6;
                    if (billingText.toLowerCase().includes('year')) multiplier = 12;
                    if (billingText.toLowerCase().includes('once')) multiplier = 12;

                    let amount = rent * multiplier;

                    $('#calculated_amount').val(amount);
                }

                // =========================
                // PREVIEW ÉCHÉANCES 
                // =========================

                function generateSchedulePreview() {

                    let startDate = $('#start_date').val();
                    let endDate = $('#end_date').val();
                    let rent = $('#room_id option:selected').data('rent');
                    let billingText = $('#billing_period option:selected').text();

                    if (!startDate || !endDate || !rent || !billingText) {
                        $('#payment_schedule').html('');
                        return;
                    }

                    let start = new Date(startDate);
                    let end = new Date(endDate);

                    let interval = 1;

                    if (billingText.toLowerCase().includes('monthly')) interval = 1;
                    if (billingText.toLowerCase().includes('quarter')) interval = 3;
                    if (billingText.toLowerCase().includes('half_yearly')) interval = 6;
                    if (billingText.toLowerCase().includes('year')) interval = 12;
                    if (billingText.toLowerCase().includes('once')) interval = 1;

                    let scheduleHTML = '';

                    let current = new Date(start);

                    while (current < end) {

                        let dueDate = new Date(current);

                        let amount = rent * interval;

                        scheduleHTML += `
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>${formatDate(dueDate)}</span>
                                    <strong>${amount} FCFA</strong>
                                </li>
                            `;

                        current.setMonth(current.getMonth() + interval);
                    }

                    $('#payment_schedule').html(scheduleHTML);
                }

                // =========================
                // FORMAT DATE
                // =========================

                function formatDate(date) {
                    return date.toISOString().split('T')[0];
                }
            });
        </script>
    @endpush
@endsection

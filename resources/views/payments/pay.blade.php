@extends('layouts.app')

@section('content')
<p class="class">j'espere que tu te rapelle qu'apres tout cela on devrat bloquer certaines actions en fonction des roles que le super admin aura assigne a chaque user...deja le role de base est celui de student...mais on a pas encore implementer l'interface permettant au super admin d'attribuer des roles au users...j'espere que ca ne pose pas de probleme si on ait qu'un seul interface et qu'on configure le comportement de ce meme interface pour qu'il s'adapte en fonction des roles de l'user, si ce fait posera probleme ensuite on devrat donc creer des vues en fonction de chaque role, et les middleware et controller s'occuperons de diriger chaque user vers differentes vues ou interface en fonction de leur roles...donc ce que je pensais c'est que la table student pourrait perdre son importance...bref c'est un peu embrouiler dans ma tete...fais moi tes retours...et si on peu ce permettre de continuer ainsi, on s'ocuppe des vues de paiement(sache que la seul vue configure de ce cote est la vue pay.blade.php et meme elle n'est pas encore operationnel...le code est plus bas). Deja tiens un apercu de la structure de mes vues actuellement</p>
    <div class="card mb-6">
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <h5 class="card-header">PAYMENT — FORMULAIRE DE PAIEMENT</h5>
        <div class="card-body pt-4">
            <form id="formAccountSettings" method="POST" class="fv-plugins-bootstrap5 fv-plugins-framework"
                novalidate="novalidate" action="{{ route('payments.pay') }}">
                @csrf
                <div class="row g-6">
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Expected Amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="text" id="PhoneNumber" value="{{ $payment->expected_amount }}" disabled
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="rent_amount">Paid amount</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">FCFA</span>
                            <input type="number" id="PhoneNumber" name="paid_amount" required
                                value="{{ old('paid_amount') }}" class="form-control" placeholder="50000">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="payment_method_id" class="form-label">Payment Methods</label>
                        <div class="position-relative"><select name="payment_method_id" id="resident"
                                class="select2 form-select" tabindex="-1" aria-hidden="true" required>
                                @foreach($PaymentMethods as $PaymentMethod)
                                    <option value="{{ $PaymentMethod->id }}">{{ $PaymentMethod->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card accordion-item active">
                        <h2 class="accordion-header" id="headingPaymentMethod">
                            <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePaymentMethod" aria-expanded="true"
                                aria-controls="collapsePaymentMethod">
                                <font dir="auto" style="vertical-align: inherit;">
                                    <font dir="auto" style="vertical-align: inherit;">Mode de paiement</font>
                                </font>
                            </button>
                        </h2>
                        <div id="collapsePaymentMethod" class="accordion-collapse collapse show"
                            aria-labelledby="headingPaymentMethod" data-bs-parent="#collapsibleSection" style="">
                            <form>
                                <div class="accordion-body">
                                    <div class="mb-6">
                                        <div class="form-check form-check-inline">
                                            <input name="collapsible-payment"
                                                class="form-check-input form-check-input-payment" type="radio"
                                                value="credit-card" id="collapsible-payment-cc" checked="">
                                            <label class="form-check-label" for="collapsible-payment-cc">
                                                <font dir="auto" style="vertical-align: inherit;">
                                                    <font dir="auto" style="vertical-align: inherit;">Carte de
                                                        crédit/débit/GAB</font>
                                                </font><i class="icon-base bx bx-credit-card-alt"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input name="collapsible-payment"
                                                class="form-check-input form-check-input-payment" type="radio" value="cash"
                                                id="collapsible-payment-cash">
                                            <label class="form-check-label" for="collapsible-payment-cash">
                                                <font dir="auto" style="vertical-align: inherit;">
                                                    <font dir="auto" style="vertical-align: inherit;">
                                                        Paiement à la livraison
                                                    </font>
                                                </font><i class="icon-base bx bx-help-circle" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    aria-label="Vous pouvez payer une fois le produit reçu."
                                                    data-bs-original-title="You can pay once you receive the product."></i>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="form-credit-card" class="row">
                                        <div class="col-12 col-md-8 col-xl-6">
                                            <div class="mb-6">
                                                <label class="form-label w-100" for="creditCardMask">
                                                    <font dir="auto" style="vertical-align: inherit;">
                                                        <font dir="auto" style="vertical-align: inherit;">Numéro de carte
                                                        </font>
                                                    </font>
                                                </label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="creditCardMask" name="creditCardMask"
                                                        class="form-control credit-card-mask"
                                                        placeholder="1356 3215 6548 7898"
                                                        aria-describedby="creditCardMask2">
                                                    <span class="input-group-text cursor-pointer" id="creditCardMask2"><span
                                                            class="card-type"></span></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="collapsible-payment-name">
                                                            <font dir="auto" style="vertical-align: inherit;">
                                                                <font dir="auto" style="vertical-align: inherit;">Nom</font>
                                                            </font>
                                                        </label>
                                                        <input type="text" id="collapsible-payment-name"
                                                            class="form-control" placeholder="John Doe">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="collapsible-payment-expiry-date">
                                                            <font dir="auto" style="vertical-align: inherit;">
                                                                <font dir="auto" style="vertical-align: inherit;">Date
                                                                    d'expiration</font>
                                                            </font>
                                                        </label>
                                                        <input type="text" id="collapsible-payment-expiry-date"
                                                            class="form-control expiry-date-mask" placeholder="MM/AA">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="mb-6">
                                                        <label class="form-label" for="collapsible-payment-cvv">
                                                            <font dir="auto" style="vertical-align: inherit;">
                                                                <font dir="auto" style="vertical-align: inherit;">Code CVV
                                                                </font>
                                                            </font>
                                                        </label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="text" id="collapsible-payment-cvv"
                                                                class="form-control cvv-code-mask" maxlength="3"
                                                                placeholder="654">
                                                            <span class="input-group-text cursor-pointer"
                                                                id="collapsible-payment-cvv2"><i
                                                                    class="icon-base bx bx-help-circle text-body-secondary"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    aria-label="Valeur de vérification de la carte"
                                                                    data-bs-original-title="Card Verification Value"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <button type="submit" class="btn btn-primary me-4">
                                            <font dir="auto" style="vertical-align: inherit;">
                                                <font dir="auto" style="vertical-align: inherit;">Soumettre</font>
                                            </font>
                                        </button>
                                        <button type="reset" class="btn btn-label-secondary">
                                            <font dir="auto" style="vertical-align: inherit;">
                                                <font dir="auto" style="vertical-align: inherit;">Annuler</font>
                                            </font>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-6">
                        <form action="{{ route('payments.validate', $payment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary me-3">Validate</button>
                        </form>
                        <form action="{{ route('payments.cancel', $payment->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-label-secondary" type="submit">Cancel</button>
                        </form>
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

        </script>
    @endpush
@endsection
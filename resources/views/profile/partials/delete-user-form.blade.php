<div class="card h-100">

    <h5 class="card-header">Delete Account</h5>

    <div class="card-body">

        <div class="mb-6 col-12 mb-0">
            <div class="alert alert-warning">
                <h5 class="alert-heading mb-1">
                    Are you sure you want to delete your account?
                </h5>
                <p class="mb-0">
                    Once you delete your account, there is no going back.
                    Please be certain.
                </p>
            </div>
        </div>
        <form id="deleteAccountForm" method="POST" action="{{ route('profile.destroy') }}">

            @csrf
            @method('DELETE')

            <!-- Checkbox -->
            <div class="form-check my-4">
                <input class="form-check-input" type="checkbox" id="accountActivation">

                <label class="form-check-label" for="accountActivation">
                    I confirm I want to delete my account
                </label>
            </div>

            <!-- PASSWORD FIELD (hidden) -->



            <div class="col-lg-12 d-none" id="passwordContainer">
                <label for="deletePassword" class="form-label">Confirm your password</label>

                <input type="password" name="password"
                    class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="deletePassword"
                    placeholder="Enter your password" required>
                @error('password', 'userDeletion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="invalid-feedback" id="passwordError"></div>
            </div>
        </form>

        <div class="col-lg-6 d-flex align-items-end mt-2"> <!-- Align the button to the bottom -->
            <button type="submit" form="deleteAccountForm" class="btn btn-danger deactivate-account mb-1" id="deleteBtn"
                disabled>
                Delete Account
            </button>
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const checkbox = document.getElementById("accountActivation");
            const passwordBox = document.getElementById("passwordContainer");
            const deleteBtn = document.getElementById("deleteBtn");
            if (!checkbox) return;

            checkbox.addEventListener("change", function () {

                if (checkbox.checked) {
                    passwordContainer.classList.remove("d-none")
                    deleteBtn.disabled = false;

                } else {
                    passwordContainer.classList.add("d-none")
                    deleteBtn.disabled = true;

                }

            });

        });
    </script>
</div>
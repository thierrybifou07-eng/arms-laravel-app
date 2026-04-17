<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^\(\+?[0-9]+\)\s[0-9\s\-\(\)]+$/', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($this->oldInputWithoutDialCode($request));
        }

        $validated = $validator->validated();

        $activeId = UserStatus::firstOrCreate(
            ['code' => UserStatus::ACTIVE],
            ['label' => 'Active']
        )->id;
        $user = User::create([
            'firstname' => $validated['firstname'] ?? null,
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'user_status_id' => $activeId, // Assuming active is the default status
        ]);

        $studentRoleId = Role::firstOrCreate(
            ['name' => Role::STUDENT],
            ['label' => 'Student']
        )->id;

        $user->roles()->sync([$studentRoleId]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    private function oldInputWithoutDialCode(Request $request): array
    {
        return array_merge(
            $request->except(['password', 'password_confirmation', 'phone', 'phone_display']),
            [
            'phone' => $request->input('phone_display', $this->extractNationalPhone($request->input('phone'))),
            'phone_country' => $request->input('phone_country'),
            ]
        );
    }

    private function extractNationalPhone(?string $phone): string
    {
        if (! $phone) {
            return '';
        }

        return trim((string) preg_replace('/^\(\+?\d+\)\s*/', '', $phone));
    }
}

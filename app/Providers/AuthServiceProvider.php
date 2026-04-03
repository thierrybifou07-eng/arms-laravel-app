<?php

namespace App\Providers;

use App\Models\BillingPeriod;
use App\Models\Building;
use App\Models\BuildingStatus;
use App\Models\Contract;
use App\Models\ContractStatus;
use App\Models\EventPaymentType;
use App\Models\Floor;
use App\Models\FloorStatus;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Permission;
use App\Models\Residence;
use App\Models\ResidenceStatus;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomStatus;
use App\Models\User;
use App\Models\UserStatus;
use App\Policies\BillingPeriodPolicy;
use App\Policies\BuildingPolicy;
use App\Policies\BuildingStatusPolicy;
use App\Policies\ContractPolicy;
use App\Policies\ContractStatusPolicy;
use App\Policies\EventPaymentTypePolicy;
use App\Policies\FloorPolicy;
use App\Policies\FloorStatusPolicy;
use App\Policies\PaymentHistoryPolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\PaymentStatusPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ResidencePolicy;
use App\Policies\ResidenceStatusPolicy;
use App\Policies\RolePolicy;
use App\Policies\RoomPolicy;
use App\Policies\RoomStatusPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserStatusPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // User Policies
        User::class => UserPolicy::class,

        // Real Estate Policies
        Residence::class => ResidencePolicy::class,
        Building::class => BuildingPolicy::class,
        Floor::class => FloorPolicy::class,
        Room::class => RoomPolicy::class,

        // Contract & Payment Policies
        Contract::class => ContractPolicy::class,
        Payment::class => PaymentPolicy::class,
        PaymentHistory::class => PaymentHistoryPolicy::class,

        // Billing Policies
        BillingPeriod::class => BillingPeriodPolicy::class,

        // Role & Permission Policies (Administrative)
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,

        // Status Policies
        BuildingStatus::class => BuildingStatusPolicy::class,
        FloorStatus::class => FloorStatusPolicy::class,
        RoomStatus::class => RoomStatusPolicy::class,
        ResidenceStatus::class => ResidenceStatusPolicy::class,
        ContractStatus::class => ContractStatusPolicy::class,
        PaymentStatus::class => PaymentStatusPolicy::class,
        UserStatus::class => UserStatusPolicy::class,

        // Payment Method & Event Payment Type Policies
        PaymentMethod::class => PaymentMethodPolicy::class,
        EventPaymentType::class => EventPaymentTypePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Define gates for common authorization checks
         * These can be used in addition to policies
         */

        // Gate for viewing admin panel
        Gate::define('access-admin', function (User $user) {
            return $user->hasRole('super_admin') || $user->hasRole('admin');
        });

        // Gate for managing billing
        Gate::define('manage-billing', function (User $user) {
            return $user->hasRole('staff') || $user->hasRole('super_admin') || $user->hasRole('admin');
        });

        // Gate for managing payments
        Gate::define('manage-payments', function (User $user) {
            return $user->hasRole('teller') || $user->hasRole('super_admin') || $user->hasRole('admin');
        });

        // Gate for managing users
        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('super_admin');
        });

        // Gate for viewing reports
        Gate::define('view-reports', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('super_admin') || $user->hasRole('staff');
        });

        // Gate for exporting data
        Gate::define('export-data', function (User $user) {
            return $user->hasRole('admin') || $user->hasRole('super_admin') || $user->hasRole('staff');
        });

        // Gate for viewing financial data
        Gate::define('view-financial', function (User $user) {
            return $user->hasRole('teller') || $user->hasRole('admin') || $user->hasRole('super_admin');
        });
    }
}

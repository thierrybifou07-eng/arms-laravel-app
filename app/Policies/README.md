# Authorization Policies Documentation

## Overview

This document describes the authorization policies for the ARMS application. Policies are used to enforce role-based access control (RBAC) across all models in the system.

## Role Hierarchy

The application has 5 roles with the following hierarchy (from highest to lowest privilege):

### 1. **Super Admin** (`super_admin`)
- Full access to all resources
- Can manage users, roles, and permissions
- Can access all administrative functions
- Only role that can permanently delete resources

### 2. **Admin** (`admin`)
- Nearly full access to all resources
- Can create, read, update resources
- Cannot delete users or modify core roles
- Can manage most system configurations

### 3. **Staff** (`staff`)
- Can manage buildings, floors, rooms, residences
- Can create and manage contracts
- Can view and manage billing periods
- Can view payment data
- Cannot delete resources
- Cannot access admin functions

### 4. **Teller** (`teller`)
- Specialized role for payment processing
- Can create, read, and update payments
- Can view payment histories
- Can validate and process payments
- Can view contracts and billing information
- Limited view access to residences and rooms

### 5. **Student** (`student`)
- Limited to personal resources
- Can view their own profile
- Can view their own contracts
- Can view their own payments
- Can update their own student record
- Cannot create or manage other resources

## Base Policy Trait

All policies inherit from the `BasePolicy` trait which provides common authorization logic:

- `isSuperAdmin()` - Checks if user is Super Admin or Admin
- `isStaff()` - Checks if user is Staff or above
- `isTeller()` - Checks if user is Teller or above
- `isStudent()` - Checks if user is a Student
- `hasPermission()` - Checks if user has specific permission

**Location:** `app/Policies/BasePolicy.php`

## Model Policies

### User Models

#### UserPolicy
- **ViewAny**: Staff and above
- **View**: Super Admin/Admin can view anyone; others can only view themselves
- **Create**: Super Admin only
- **Update**: Super Admin can update anyone; users can update themselves
- **Delete**: Super Admin only
- **ManageRoles**: Super Admin only
- **ManageStatus**: Super Admin only

#### StudentPolicy
- **ViewAny**: Staff and above
- **View**: Staff+ can view any; students can only view themselves
- **Create**: Staff and above
- **Update**: Staff+ can update any; students can update themselves
- **Delete**: Super Admin only

### Real Estate Models

#### ResidencePolicy
- **ViewAny**: Staff and above
- **View**: Staff+, Teller can view
- **Create**: Super Admin only
- **Update**: Super Admin only
- **Delete**: Super Admin only
- **ManageStatus**: Super Admin only

#### BuildingPolicy
- **ViewAny**: Staff and above
- **View**: Staff+, Teller can view
- **Create**: Super Admin only
- **Update**: Super Admin, Staff
- **Delete**: Super Admin only
- **ManageStatus**: Super Admin, Staff

#### FloorPolicy
- **ViewAny**: Staff and above
- **View**: Staff+, Teller can view
- **Create**: Super Admin only
- **Update**: Super Admin, Staff
- **Delete**: Super Admin only
- **ManageStatus**: Super Admin, Staff

#### RoomPolicy
- **ViewAny**: Staff and above
- **View**: Staff+, Teller, Students can view
- **Create**: Super Admin only
- **Update**: Super Admin, Staff
- **Delete**: Super Admin only
- **ManageStatus**: Super Admin, Staff

### Contract & Payment Models

#### ContractPolicy
- **ViewAny**: Staff+, Teller
- **View**: Staff+, Teller, Students (own contracts only)
- **Create**: Staff and above
- **Update**: Staff+ can update any; students can update their own
- **Delete**: Super Admin only
- **ManageStatus**: Staff and above
- **ViewPaymentHistory**: Staff+, Teller, Students (own only)

#### PaymentPolicy
- **ViewAny**: Staff+, Teller
- **View**: Staff+, Teller, Students (own payments only)
- **Create**: Teller only
- **Update**: Super Admin, Teller
- **Delete**: Super Admin only
- **ValidatePayment**: Teller only
- **CancelPayment**: Staff and above
- **ProcessPayment**: Teller only
- **ManageStatus**: Teller only
- **CheckOverdue**: Staff+, Teller

#### PaymentHistoryPolicy
- **ViewAny**: Staff+, Teller
- **View**: Staff+, Teller, Students (own history only)
- **Create**: Teller, Staff
- **Update**: Super Admin only (rarely needed)
- **Delete**: Super Admin only
- **Export**: Staff and above

### Billing Models

#### BillingPeriodPolicy
- **ViewAny**: Staff+, Teller
- **View**: Staff+, Teller
- **Create**: Super Admin only
- **Update**: Super Admin, Staff
- **Delete**: Super Admin only
- **Activate**: Staff and above
- **Close**: Staff and above
- **GenerateBilling**: Staff and above

### Administrative Models

#### RolePolicy
- **ViewAny**: Super Admin only
- **Create**: Super Admin only
- **Update**: Super Admin only (cannot modify core roles)
- **Delete**: Super Admin only (cannot delete core roles)
- **ManagePermissions**: Super Admin only
- **AssignToUsers**: Super Admin only

#### PermissionPolicy
- **ViewAny**: Super Admin only
- **Create**: Super Admin only
- **Update**: Super Admin only
- **Delete**: Super Admin only
- **AssignToRoles**: Super Admin only

### Status Models

All status models (BuildingStatus, FloorStatus, RoomStatus, ResidenceStatus, ContractStatus, PaymentStatus, UserStatus) follow similar patterns:

- **ViewAny**: Staff and above
- **View**: Staff and above
- **Create**: Super Admin only
- **Update**: Super Admin only
- **Delete**: Prevented (always returns false)
- **ForceDelete**: Prevented (always returns false)

Status models are considered system-reference data and cannot be deleted.

### Payment & Configuration Models

#### PaymentMethodPolicy
- **ViewAny**: Teller only
- **View**: Teller only
- **Create**: Super Admin only
- **Update**: Super Admin only
- **Delete**: Prevented
- **ForceDelete**: Prevented

#### EventPaymentTypePolicy
- **ViewAny**: Staff and above
- **View**: Staff and above
- **Create**: Super Admin only
- **Update**: Super Admin only
- **Delete**: Prevented
- **ForceDelete**: Prevented

## Using Policies in Controllers

### Authorization Check

```php
// In a controller method
public function edit(User $user, Building $building)
{
    // This will check the 'update' policy automatically
    $this->authorize('update', $building);
    
    // Continue with editing logic
}
```

### Using Gate Checks

```php
// In a controller or blade template
if (Gate::allows('access-admin')) {
    // User is admin
}

if (Gate::allows('manage-payments')) {
    // User can manage payments
}
```

## Using Policies in Blade Templates

### Checking Single Policies

```blade
@can('view', $building)
    <p>Building: {{ $building->name }}</p>
@endcan

@cannot('delete', $building)
    <!-- User cannot delete -->
@endcannot
```

### Using Gates in Blade

```blade
@if(auth()->user()->can('access-admin'))
    <a href="/admin">Admin Panel</a>
@endif
```

### Using Role/Permission Directives

```blade
@role('super_admin')
    <a href="/system-settings">System Settings</a>
@endrole

@permission('manage_users')
    <a href="/users">Manage Users</a>
@endpermission
```

## Using Policies in Requests

### Form Request Validation with Authorization

```php
class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $contract = Contract::find($this->input('contract_id'));
        return $this->user()->can('create', Payment::class) &&
               $this->user()->can('viewPaymentHistory', $contract);
    }

    public function rules(): array
    {
        // Validation rules
    }
}
```

## Super Admin Gate

There's a global `Gate::before()` in AppServiceProvider that automatically grants access to Super Admin users for all actions:

```php
Gate::before(function ($user, $ability) {
    if ($user->hasRole('super_admin')) {
        return true;
    }
    return null;
});
```

This means Super Admin users bypass all policy checks.

## Authorization Gates Summary

| Gate | Allowed Roles | Purpose |
|------|---|---|
| `access-admin` | Super Admin, Admin | Access admin panel |
| `manage-billing` | Staff, Admin, Super Admin | Manage billing |
| `manage-payments` | Teller, Admin, Super Admin | Manage payments |
| `manage-users` | Super Admin | Manage users |
| `view-reports` | Admin, Super Admin, Staff | View reports |
| `export-data` | Admin, Super Admin, Staff | Export data |
| `view-financial` | Teller, Admin, Super Admin | View financial data |

## Testing Authorization

Example test case:

```php
public function test_student_can_view_own_contract()
{
    $student = Student::factory()->create();
    $user = $student->user; // Get the associated user
    $contract = Contract::factory()->create(['student_id' => $student->id]);
    
    $this->assertTrue($user->can('view', $contract));
}

public function test_student_cannot_view_others_contract()
{
    $student1 = Student::factory()->create();
    $student2 = Student::factory()->create();
    $user1 = $student1->user;
    $contract = Contract::factory()->create(['student_id' => $student2->id]);
    
    $this->assertFalse($user1->can('view', $contract));
}
```

## Best Practices

1. **Always use policies in controllers** - Don't rely on manual permissions checks
2. **Fail securely** - When in doubt, deny access (policies default to false)
3. **Use Super Admin bypass carefully** - It's useful for admin functions but test policies explicitly
4. **Keep policies focused** - Each policy should handle only one model
5. **Document custom authorization logic** - Add comments explaining business rules
6. **Test policies thoroughly** - Authorization is critical to security
7. **Review role assignments regularly** - Ensure users have appropriate roles

## File Structure

```
app/Policies/
├── BasePolicy.php                    # Trait with common logic
├── UserPolicy.php
├── StudentPolicy.php
├── ResidencePolicy.php
├── BuildingPolicy.php
├── FloorPolicy.php
├── RoomPolicy.php
├── ContractPolicy.php
├── PaymentPolicy.php
├── PaymentHistoryPolicy.php
├── BillingPeriodPolicy.php
├── RolePolicy.php
├── PermissionPolicy.php
├── BuildingStatusPolicy.php
├── FloorStatusPolicy.php
├── RoomStatusPolicy.php
├── ResidenceStatusPolicy.php
├── ContractStatusPolicy.php
├── PaymentStatusPolicy.php
├── UserStatusPolicy.php
├── PaymentMethodPolicy.php
└── EventPaymentTypePolicy.php

app/Providers/
└── AuthServiceProvider.php           # Policy registration & gates
```

## Troubleshooting

### Policy not working?
1. Ensure the model is registered in `AuthServiceProvider::$policies`
2. Check that the policy class is properly namespaced
3. Verify the user has the required role
4. Check the `boot()` method in AuthServiceProvider is being called

### Getting "This action is not authorized" error?
1. Check the specific policy method being called
2. Verify the user's roles using `$user->roles()->get()`
3. Check your policy's role checking logic
4. Review the Gate::before() logic for Super Admin

### Role not working?
1. Verify the role exists in the database
2. Check the user has the role assigned: `$user->roles()->pluck('name')`
3. Ensure role name matches the constant (e.g., `Role::ADMIN` not `'Admin'`)

## References

- [Laravel Authorization Documentation](https://laravel.com/docs/authorization)
- [Laravel Gates & Policies](https://laravel.com/docs/authorization#gates)
- [User Model Role Methods](../Models/User.php)
- [Role Model](../Models/Role.php)

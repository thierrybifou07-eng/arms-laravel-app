# Authorization Policies Documentation

## Overview

The application now uses 4 active roles for authorization:

- `super_admin`
- `admin`
- `staff`
- `student`

The former `teller` role has been merged into `staff`. Any payment-processing capabilities previously assigned to `teller` are now handled by `staff`.

## Base Policy Helpers

Shared helpers live in `app/Policies/BasePolicy.php`:

- `isSuperAdmin()` checks `super_admin` or `admin`
- `isStaff()` checks `staff` or higher
- `isStudent()` checks `student`
- `hasPermission()` checks named permissions on the user role

## Access Summary

- `super_admin` has full access to all resources
- `admin` has broad operational access
- `staff` covers operational and payment workflows
- `student` is limited to personal resources

## Important Policy Notes

- Contracts, payments, payment histories, billing data, residences, buildings, floors, rooms, and payment methods are all accessible to `staff` according to the corresponding policy methods.
- Students can only access their own contracts, payments, and payment histories where applicable.
- Core system roles cannot be edited or deleted through `RolePolicy`.
- Status entities remain protected system reference data.

## Gates

Defined in `app/Providers/AuthServiceProvider.php`:

| Gate | Allowed Roles |
| --- | --- |
| `access-admin` | `super_admin`, `admin` |
| `manage-billing` | `staff`, `admin`, `super_admin` |
| `manage-payments` | `staff`, `admin`, `super_admin` |
| `manage-users` | `super_admin` |
| `view-reports` | `staff`, `admin`, `super_admin` |
| `export-data` | `staff`, `admin`, `super_admin` |
| `view-financial` | `staff`, `admin`, `super_admin` |

## Maintenance

- If you add a new protected action, update both the relevant policy and the matching gate or middleware rule if one exists.
- If you seed or migrate roles, keep `staff` as the single operational role for payment handling.

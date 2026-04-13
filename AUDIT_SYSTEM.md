# Audit Logs System - Setup Complete

## Overview
A comprehensive audit logging system has been installed and configured for your ARMS Laravel application. This system allows super_admin users to view, filter, export, and manage audit logs with password-protected sensitive operations.

## Features

### 1. **Audit Logging**
- Automatically tracks all CREATE, UPDATE, DELETE, and RESTORE events
- Records user information, IP address, user agent, and request URL
- Captures old and new values for updated records
- Models currently audited:
  - User
  - Payment
  - PaymentHistory
  - Contract
  - Room
  - Floor
  - Residence
  - PaymentReceipt

### 2. **Audit Dashboard** 
- Access: `/super-admin/audits` (super_admin only)
- Location in sidebar: Admin > Audit Logs

### 3. **Key Features**
- **Filtering**: By event type (created, updated, deleted, restored), model type, date range, search
- **Viewing**: Detailed audit records with old/new values, change comparison
- **Deletion**: Delete individual or multiple records (password protected)
- **Export**: Export as CSV or Excel (password protected)
- **UI**: Clean, responsive interface with Bootstrap 5

## Files Created

### Controllers
- `app/Http/Controllers/Admin/AuditController.php` - Main controller for audit operations

### Models
- `app/Models/Audit.php` - Custom Audit model extending OwenIt package with helpful scopes

### Policies
- `app/Policies/AuditPolicy.php` - Authorization policy for audit operations

### Services
- `app/Services/AuditExportService.php` - Handles CSV/Excel exports

### Views
- `resources/views/super_admin/audits/index.blade.php` - List view with filters
- `resources/views/super_admin/audits/show.blade.php` - Detail view with data comparison
- `resources/views/super_admin/audits/scripts.blade.php` - JavaScript interactions

### Configuration
- `config/audit.php` - Updated to use custom Audit model
- `app/Providers/AuthServiceProvider.php` - Registered AuditPolicy
- `routes/web.php` - Added audit routes
- `resources/views/layouts/partials/aside.blade.php` - Added sidebar link

## Usage

### Accessing Audit Logs
1. Login as super_admin user
2. Click "Audit Logs" in the sidebar menu
3. Or navigate to `/super-admin/audits`

### Filtering Audits
- **Event**: created, updated, deleted, restored
- **Model**: Select from available models (User, Payment, etc.)
- **Date Range**: Start and end dates
- **Search**: Search by URL or tags

### Viewing Details
1. Click the eye icon in the Actions column
2. View three tabs:
   - Old Values: Values before the change
   - New Values: Values after the change
   - Comparison: Side-by-side field comparison

### Deleting Records
**Individual Delete:**
1. Click trash icon in audit row
2. Enter your password in the modal
3. Click Delete

**Bulk Delete:**
1. Select records using checkboxes
2. Click "Delete Selected" button
3. Enter your password when prompted
4. Confirm deletion

### Exporting Audits
1. Click "Export" button
2. Select format (CSV or Excel)
3. Enter your password
4. File will be downloaded

## Security Features

### Access Control
- Only super_admin role can access audit system
- Middleware enforces: `checkRole:super_admin`
- Policy-based authorization via `AuditPolicy`

### Password Protection
- Delete operations require current password verification
- Export operations require current password verification
- Uses Laravel's native `current_password` validation rule
- Prevents accidental or unauthorized deletions/exports

### Data Protection
- Audit records stored in database
- Old and new values JSON encoded
- User agent truncated to 1023 characters
- IP address captured for every action

## API Reference

### Routes Available (Super Admin Only)

**List audits**
```
GET /super-admin/audits
Parameters: event, model, user_id, start_date, end_date, search
```

**Show audit detail**
```
GET /super-admin/audits/{audit}
```

**Delete single audit**
```
DELETE /super-admin/audits/{audit}
Data: password (required)
```

**Delete multiple audits**
```
POST /super-admin/audits/delete-multiple
Data: audit_ids[], password (required)
```

**Export audits**
```
POST /super-admin/audits/export
Data: format (csv|excel), password (required), filters (optional)
```

## Adding Auditable Models

To track audits for a model:

1. Import the trait:
```php
use OwenIt\Auditing\Contracts\Auditable;
```

2. Use the trait:
```php
class YourModel extends Model implements HasMedia
{
    use \OwenIt\Auditing\Auditable;
}
```

3. The model will automatically be audited on create, update, delete, restore

## Customization

### Customizing Audit Events
Edit `config/audit.php`:
```php
'events' => [
    'created',
    'updated',
    'deleted',
    'restored',
    // Add custom events here
],
```

### Excluding Fields
In your model:
```php
protected $auditExcluded = [
    'password',     // Exclude password field
    'remember_token' // Exclude remember token
];
```

### Filtering Audit Display
The `AuditController` has scopes available:
- `byModel($modelType)` - Filter by model
- `byEvent($event)` - Filter by event
- `byUser($userId)` - Filter by user
- `byDateRange($start, $end)` - Filter by date

## Troubleshooting

### Audits not appearing
1. Ensure model has `use \OwenIt\Auditing\Auditable;` trait
2. Check `config/audit.php` has `'enabled' => true`
3. Verify migrations were run: `php artisan migrate`
4. Ensure auditable model has the trait applied

### Password verification failing
1. Confirm user's password is correct
2. Check user credentials are valid
3. Ensure 'current_password' is enabled in Laravel config

### Export not working
1. Check your storage is writable
2. Verify `config/filesystems.php` is configured
3. Check temp directory has write permissions

## Database

### Audits Table
Created by migration: `2026_04_10_201843_create_audits_table.php`

**Columns:**
- id (bigIncrement)
- user_id, user_type (morphs - who made the change)
- event (created, updated, deleted, restored)
- auditable_id, auditable_type (morphs - what was changed)
- old_values (JSON)
- new_values (JSON)
- url (text)
- ip_address (IP)
- user_agent (string)
- tags (string)
- created_at, updated_at (timestamps)

## Performance Considerations

### Optimization Tips
1. Old audits can be pruned/archived
2. Use pagination (default 50 per page)
3. Apply filters to reduce query size
4. Consider date range filters for large datasets
5. Archive old audits > 6 months for performance

### Rotation/Cleanup
Consider adding a scheduled task:
```php
// In app/Console/Kernel.php
$schedule->command('audits:cleanup')->monthly();
```

## Support & Maintenance

- Audit records are immutable (cannot be edited, only deleted)
- Deleted audits are permanently removed
- Regular backups recommended if audits are critical
- Monitor database size for audit table growth

---

**System Setup Date**: April 10, 2026
**Package**: OwenIt/Auditing
**Framework**: Laravel 11

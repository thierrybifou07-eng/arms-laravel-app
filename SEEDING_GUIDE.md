# 🌱 Database Seeding Guide - ARMS Laravel

## Complete Seeding Solution

This seeding setup populates your ARMS (Apartment Residences Management System) database with comprehensive test data.

### What Gets Created

✅ **Users (500 total)**
- 1 Super Administrator
- 5 Administrators
- 15 Staff members
- 20 Tellers
- 459 Students

✅ **Infrastructure**
- 10 Residences (spread across different cities)
- 30-50 Buildings (3-5 per residence)
- 300-750 Floors (10-15 per building)
- 6,000-18,750 Rooms (20-25 per floor)

✅ **Contracts (1000+)**
- With all status types:
  - ✓ Pending (future contracts)
  - ✓ Active (ongoing contracts)
  - ✓ Overdue (contracts with unpaid fees)
  - ✓ Expired (contracts past end date)
  - ✓ Archived (old contracts)
  - ✓ Cancelled (terminated contracts)

✅ **Payments (5000+)**
- With all status variations:
  - Pending (unpaid)
  - Processing (in progress)
  - Validated (completed)
  - Cancelled (rejected)
- Each payment tracked with 1-3 history entries
- Receipts generated for validated payments

### Files Created/Modified

**New Factories:**
```
database/factories/BuildingFactory.php
database/factories/FloorFactory.php
database/factories/RoomFactory.php
database/factories/ContractFactory.php
database/factories/PaymentFactory.php
database/factories/PaymentHistoryFactory.php
```

**New Seeders:**
```
database/seeders/EnumSeeder.php                           # Reference data
database/seeders/UserSeeder.php (updated)                 # 500 users
database/seeders/ResidenceInfrastructureSeeder.php        # Buildings hierarchy
database/seeders/AdminResidenceAssignmentSeeder.php       # Admin ↔ Residence mapping
database/seeders/ContractSeeder.php                       # Contracts
database/seeders/PaymentSeeder.php                        # Payments & history
database/seeders/PaymentReceiptSeeder.php                 # Receipt generation
database/seeders/DatabaseSeeder.php (updated)             # Main orchestrator
```

### How to Use

#### Option 1: Full Fresh Database (Recommended for first setup)

```bash
# Reset the database completely and seed
php artisan migrate:fresh --seed

# Or with specific seed output
php artisan migrate:fresh --seed --verbose
```

#### Option 2: Seed Existing Database

```bash
# Only seed (if tables already exist)
php artisan db:seed

# Or seed specific seeder
php artisan db:seed --class=UserSeeder
```

#### Option 3: Selective Seeding

```bash
# Seed only enum/reference tables
php artisan db:seed --class=EnumSeeder

# Seed only users
php artisan db:seed --class=UserSeeder

# Seed only infrastructure
php artisan db:seed --class=ResidenceInfrastructureSeeder

# Seed only transactions
php artisan db:seed --class=ContractSeeder
php artisan db:seed --class=PaymentSeeder
```

### Test Credentials

After seeding, you can log in with:

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `super@admin.com` | `password` |
| Admin | `admin1@arms.test` to `admin5@arms.test` | `password` |
| Staff | `staff1@arms.test` to `staff15@arms.test` | `password` |
| Teller | `teller1@arms.test` to `teller20@arms.test` | `password` |
| Student | `student1@arms.test` to `student459@arms.test` | `password` |

### Seeding Order (Important!)

The `DatabaseSeeder` executes seeders in this specific order to respect foreign key constraints:

1. **Enum & Reference Tables**
   - UserStatus, ContractStatus, PaymentStatus
   - RoomStatus, FloorStatus, BuildingStatus, ResidenceStatus
   - PaymentMethod, EventPaymentType
   - BillingPeriod, Roles, Permissions

2. **Core Data**
   - Users with role assignments
   - Super admin permissions

3. **Infrastructure**
   - Residences, Buildings, Floors, Rooms
   - Admin-to-Residence assignments

4. **Business Logic**
   - Contracts (linked to students and rooms)
   - Payments (linked to contracts)
   - Payment Receipts (for validated payments)

### Performance Notes

- **Total Records Created**: ~40,000+
- **Execution Time**: ~3-5 minutes (depending on system)
- **Database Size**: ~50-100 MB (depending on file storage)

### Troubleshooting

#### Error: "Field 'X' doesn't have a default value"
- Make sure all migrations have run: `php artisan migrate`
- Run EnumSeeder first if using partial seeding

#### Error: "SQLSTATE[HY000]: General error"
- Clear cache: `php artisan cache:clear`
- Rebuild compiled classes: `php artisan dump-autoload`

#### Error: "Unique constraint violation"
- Database still contains old data
- Solution: Run `php artisan migrate:fresh --seed`

#### Slow Performance
- Seeds may take time with so many records
- Be patient or reduce counts in seeder files
- Consider increasing PHP memory limit: `php -d memory_limit=512M artisan db:seed`

### Customization

To modify seeding behavior, edit these files:

- **Change user count**: Edit `UserSeeder.php` (lines with for loops)
- **Change residences**: Edit `ResidenceInfrastructureSeeder.php` residences array
- **Change buildings/floors/rooms ratio**: Edit loops in `ResidenceInfrastructureSeeder.php`
- **Change contracts per student**: Edit `ContractSeeder.php` `numberBetween()` call
- **Change payments per contract**: Edit `PaymentSeeder.php` `numberBetween()` call

### Example: Reduce Dataset

To seed with smaller dataset (faster):

1. Edit `database/seeders/UserSeeder.php`:
   - Change `459` to `100` for student count

2. Edit `database/seeders/ResidenceInfrastructureSeeder.php`:
   - Reduce residences array (keep only 3-4)
   - Change `numberBetween(3, 5)` to `numberBetween(1, 2)` for buildings
   - Change `numberBetween(10, 15)` to `numberBetween(5, 8)` for floors
   - Change `numberBetween(20, 25)` to `numberBetween(10, 15)` for rooms

3. Run seeding:
   ```bash
   php artisan migrate:fresh --seed
   ```

### Next Steps

After seeding:

1. **Test the dashboard**: `admin@arms.test` to verify statistics compute correctly
2. **Check contracts**: Verify contract statuses are properly set
3. **Verify payments**: Check payment distributions match expected statuses
4. **Test filters**: Use admin dashboard filters on generated data
5. **Generate reports**: Test report generation with real data

---

**Happy Seeding! 🚀**

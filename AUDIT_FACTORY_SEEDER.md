# Factory et Seeder pour Audit Logs

## 📋 Vue d'ensemble

Un système complet pour générer des données de test (factory) et remplir la base de données (seeder) avec des logs d'audit réalistes.

---

## 🏭 Factory: AuditLogFactory

Situé dans: `database/factories/AuditLogFactory.php`

### Utilisation Basique

```php
use App\Models\AuditLog;

// Créer 1 log aléatoire
$log = AuditLog::factory()->create();

// Créer 10 logs
$logs = AuditLog::factory()->count(10)->create();
```

### États Prédéfinis (States)

#### ✅ `forCreation()` - Créations
```php
AuditLog::factory()->forCreation()->create();
// Résultat: action=CREATE avec old_values=null, new_values remplies
```

#### ✅ `forUpdate()` - Modifications
```php
AuditLog::factory()->forUpdate()->create();
// Résultat: action=UPDATE avec old_values et new_values
```

#### ✅ `forDeletion()` - Suppressions
```php
AuditLog::factory()->forDeletion()->create();
// Résultat: action=DELETE avec old_values, new_values=null
```

#### ✅ `forLogin()` - Connexions
```php
AuditLog::factory()->forLogin()->create();
// Résultat: action=LOGIN
```

#### ✅ `forLogout()` - Déconnexions
```php
AuditLog::factory()->forLogout()->create();
// Résultat: action=LOGOUT
```

#### ✅ `forExport()` - Exportations
```php
AuditLog::factory()->forExport()->create();
// Résultat: action=EXPORT
```

### Modificateurs de Date

#### `thisWeek()` - 7 derniers jours
```php
AuditLog::factory()->count(20)->thisWeek()->create();
```

#### `today()` - Aujourd'hui
```php
AuditLog::factory()->count(10)->today()->create();
```

### Modificateur d'Utilisateur

#### `forUser($userId)` - Utilisateur spécifique
```php
AuditLog::factory()->count(5)->forUser(3)->create();
```

### Exemples Complets

#### Créer 50 logs de création
```php
AuditLog::factory()->count(50)->forCreation()->create();
```

#### Créer 30 logs de modification cette semaine
```php
AuditLog::factory()->count(30)->thisWeek()->forUpdate()->create();
```

#### Créer 10 logs d'aujourd'hui pour un utilisateur spécifique
```php
AuditLog::factory()
    ->count(10)
    ->today()
    ->forUser(5)
    ->forCreation()
    ->create();
```

#### Mélanger plusieurs types
```php
// 20 créations
AuditLog::factory()->count(20)->forCreation()->create();

// 15 modifications
AuditLog::factory()->count(15)->forUpdate()->create();

// 10 suppressions
AuditLog::factory()->count(10)->forDeletion()->create();

// 8 connexions
AuditLog::factory()->count(8)->forLogin()->create();

// 5 exportations
AuditLog::factory()->count(5)->forExport()->create();
```

---

## 🌱 Seeder: AuditLogSeeder

Situé dans: `database/seeders/AuditLogSeeder.php`

### Utilisation

#### Depuis tinker
```bash
php artisan tinker

>>> Illuminate\Database\Eloquent\Factories\Sequence
>>> Seed the database with audit logs
>>> Artisan::call('db:seed --class=AuditLogSeeder');
```

#### Via commande
```bash
php artisan db:seed --class=AuditLogSeeder
```

#### Inclus automatiquement dans db:seed
```bash
php artisan db:seed
# Exécute DatabaseSeeder qui inclut AuditLogSeeder
```

### Données Générées

Le seeder crée **~220+ logs d'audit** répartis ainsi:

```
50 créations (variées)
40 modifications (variées)
20 suppressions (variées)
30 connexions
10 déconnexions
15 exportations

+ Données d'aujourd'hui (30 logs):
  15 créations
  10 modifications
  5 connexions

+ Données cette semaine (35 logs):
  20 créations
  15 modifications
```

**Total: ~250+ logs**

---

## 📊 Données Générées

### Champs Aléatoires
- `user_id` - Utilisateur aléatoire de la base
- `action` - CREATE, UPDATE, DELETE, LOGIN, LOGOUT, EXPORT
- `model_type` - Modèle aléatoire (User, Contract, Payment, etc.)
- `model_id` - ID aléatoire
- `ip_address` - Adresse IP aléatoire
- `user_agent` - User Agent aléatoire
- `method` - Méthode HTTP aléatoire (GET, POST, PUT, DELETE, PATCH)
- `url` - URL aléatoire
- `created_at` - Date aléatoire (derniers 30 jours ou comme spécifié)

### Valeurs JSON
Pour les créations, modifications et suppressions:
- `old_values` - Valeurs avant changement
- `new_values` - Valeurs après changement

---

## 🎯 Cas d'Usage

### Test 1: Vérifier le dashboard Super Admin
```bash
# 1. Migrer
php artisan migrate

# 2. Seeder les types d'audit
php artisan db:seed --class=AuditTypeSeeder

# 3. Seeder les logs d'audit
php artisan db:seed --class=AuditLogSeeder

# 4. Aller sur /super_admin/dashboard
# Vous verrez tous les stats d'audit remplis!
```

### Test 2: Test l'export CSV
```php
# 1. Créer quelques logs
$logs = AuditLog::factory()->count(50)->create();

# 2. Aller sur /audit-logs
# 3. Exporter en CSV
# Le fichier inclura tous les 50 logs
```

### Test 3: Test les filtres
```php
# 1. Créer des logs mixtes
AuditLog::factory()->count(30)->forCreation()->create();
AuditLog::factory()->count(30)->forUpdate()->create();
AuditLog::factory()->count(30)->forDeletion()->create();

# 2. Aller sur /audit-logs
# 3. Filtrer par action "CREATE" → Voir seulement les 30 créations
```

### Test 4: Test la recherche
```php
# 1. Créer des logs pour des utilisateurs spécifiques
$users = User::take(3)->get();
foreach($users as $user) {
    AuditLog::factory()
        ->count(20)
        ->forUser($user->id)
        ->create();
}

# 2. Aller sur /audit-logs
# 3. Rechercher le nom d'un utilisateur
```

---

## 💡 Commandes Utiles

### Générer des logs uniquement
```bash
php artisan tinker

>>> use Database\Seeders\AuditLogSeeder;
>>> (new AuditLogSeeder)->run();
```

### Générer 100 logs rapidement
```php
php artisan tinker

>>> AuditLog::factory()->count(100)->create();
```

### Générer par type
```php
php artisan tinker

# 50 créations
>>> AuditLog::factory()->count(50)->forCreation()->create();

# 30 modifications
>>> AuditLog::factory()->count(30)->forUpdate()->create();

# 20 suppressions
>>> AuditLog::factory()->count(20)->forDeletion()->create();

# 40 connexions
>>> AuditLog::factory()->count(40)->forLogin()->create();
```

### Vérifier les données créées
```php
php artisan tinker

>>> AuditLog::count()                                    # Total logs
>>> AuditLog::where('action', 'CREATE')->count()        # Créations
>>> AuditLog::whereDate('created_at', today())->count() # Aujourd'hui
>>> AuditLog::latest()->first()                         # Dernier log
```

---

## 🧪 Testing avec la Factory

### Flash la base et réenseeder
```php
// Dans les tests
public function setUp(): void
{
    parent::setUp();
    $this->artisan('migrate:fresh');
    $this->artisan('db:seed --class=AuditTypeSeeder');
}

// Test 1: Vérifier la création de logs
public function test_audit_log_factory_creates_correctly()
{
    $log = AuditLog::factory()->forCreation()->create();
    
    $this->assertEquals('CREATE', $log->action);
    $this->assertNull($log->old_values);
    $this->assertNotNull($log->new_values);
}

// Test 2: Vérifier les timestamps
public function test_audit_log_timestamps()
{
    $log = AuditLog::factory()->today()->create();
    
    $this->assertTrue($log->created_at->isToday());
}

// Test 3: Vérifier le filtrage
public function test_audit_log_filtering()
{
    AuditLog::factory()->count(10)->forCreation()->create();
    AuditLog::factory()->count(10)->forUpdate()->create();
    
    $creates = AuditLog::where('action', 'CREATE')->count();
    $this->assertEquals(10, $creates);
}
```

---

## 📋 Checklist Implementation

- [x] Factory créée avec tous les états
- [x] Seeder créé avec variété de données
- [x] Intégré dans DatabaseSeeder
- [x] Documenté avec exemples
- [x] Tests possibles avec la factory
- [x] Dashboard super_admin affiche les stats

---

## 🚀 Mise à Jour du Dashboard

Le dashboard super_admin affiche maintenant:

✅ **Statistiques d'Audit**
- Total des logs
- Logs d'aujourd'hui
- Créations, modifications, suppressions
- Connexions et exportations

✅ **Top 5 Utilisateurs les Plus Actifs**
- Avec le nombre d'actions
- Email et statut

✅ **10 Derniers Logs d'Audit**
- Date/heure
- Utilisateur
- Action (badge colorée)
- Détails
- Adresse IP

---

## 🌟 Utilisation Recommandée

### Pour le Développement
```bash
# Seeder complet incluant les logs
php artisan db:seed

# Les logs remplissent automatiquement le dashboard
# Les filtres fonctionnent correctement
# L'export CSV contient les données
```

### Pour les Tests
```bash
# Créer des logs spécifiques pour un test
$user = User::factory()->create();
AuditLog::factory()
    ->count(10)
    ->forUser($user->id)
    ->forCreation()
    ->create();
```

### Pour la Démo
```bash
# Générer beaucoup de logs pour impressionner
AuditLog::factory()->count(500)->create();

# Voir le dashboard rempli!
# /super_admin/dashboard
```

---

## 📞 Support

**Questions?** Consultez:
- `database/factories/AuditLogFactory.php` - Code de la factory
- `database/seeders/AuditLogSeeder.php` - Code du seeder
- `AUDIT_GUIDE.md` - Documentation complète
- `AUDIT_EXAMPLES.md` - Exemples pratiques

---

**Factory et Seeder pour Audit Logs** | Version 1.0 | Avril 2026

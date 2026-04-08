# Mise en Place du Système d'Audit

## ⚡ Installation Rapide (5 minutes)

### Étape 1: Exécuter les migrations
```bash
php artisan migrate
```

### Étape 2: Seeder les types d'audit
```bash
php artisan db:seed --class=AuditTypeSeeder
```

Ou simplement exécuter tous les seeders:
```bash
php artisan db:seed
```

### Étape 3: Ajouter le trait aux modèles (Optionnel)

Pour auditer automatiquement les modifications, ajoutez le trait `Auditable` aux modèles:

```php
<?php

namespace App\Models;

use App\Traits\Auditable;

class MyModel extends Model
{
    use Auditable;
    // ...
}
```

### Étape 4: Accéder aux logs

1. Connectez-vous en tant que **Super Admin**
2. Allez à: **http://votre-app/audit-logs**
3. Explorez les logs avec les filtres disponibles

## 📋 Fichiers Créés/Modifiés

### Nouveaux Fichiers
- ✅ `app/Models/AuditLog.php` - Modèle principal
- ✅ `app/Models/AuditType.php` - Types d'audit
- ✅ `app/Traits/Auditable.php` - Trait d'audit automatique
- ✅ `app/Http/Controllers/AuditLogController.php` - Contrôleur
- ✅ `app/Policies/AuditLogPolicy.php` - Autorisation
- ✅ `app/Http/Middleware/AuditLoginLogout.php` - Middleware
- ✅ `database/migrations/2026_04_08_000000_enhance_audits_table.php` - Migration
- ✅ `database/seeders/AuditTypeSeeder.php` - Seeder
- ✅ `resources/views/audit-logs/index.blade.php` - Vue liste
- ✅ `resources/views/audit-logs/show.blade.php` - Vue détails
- ✅ `AUDIT_GUIDE.md` - Documentation complète

### Fichiers Modifiés
- 📝 `routes/web.php` - Routes ajoutées
- 📝 `app/Providers/AuthServiceProvider.php` - Policy enregistrée
- 📝 `bootstrap/app.php` - Middleware global
- 📝 `database/seeders/DatabaseSeeder.php` - AuditTypeSeeder ajouté

## 🔍 Vérification

Pour vérifier que tout fonctionne:

```bash
# 1. Vérifier la table
php artisan tinker
>>> App\Models\AuditLog::count()

# 2. Créer un test
>>> App\Models\AuditLog::log('TEST', details: 'Test audit system');
>>> App\Models\AuditLog::latest()->first();
```

## 🛡️ Sécurité

✅ **Accès Super Admin uniquement** - Vérifiez la Policy  
✅ **Modal de confirmation de mot de passe** - Pour export/suppression  
✅ **Enregistrement IP et User Agent** - Traçabilité complète  
✅ **Logs de création/modification/suppression** - Automatique avec le trait  

## 📊 Utilisation

### Interface Web
1. **Liste des logs**: `/audit-logs`
2. **Détails d'un log**: `/audit-logs/{id}`
3. **Exporter**: Cliquez sur "Exporter" (nécessite mot de passe)
4. **Vider les logs**: Cliquez sur "Vider" (nécessite mot de passe)

### Filtres Disponibles
- Type d'action (CREATE, UPDATE, DELETE, etc.)
- Type d'audit
- Utilisateur
- Type d'élément
- Plage de dates
- Recherche libre

### Enregistrement Manuel
```php
use App\Models\AuditLog;

AuditLog::log(
    action: 'CUSTOM_ACTION',
    userId: auth()->id(),
    modelType: 'App\Models\Contract',
    modelId: 123,
    details: 'Action personnalisée effectuée'
);
```

## 🗂️ Architecture

```
┌─ AuditLog (Modèle)
├─ Auditable (Trait) → Capture CRUD automatiquement
├─ AuditLogController → Affichage + Filtres + Export
├─ AuditLogPolicy → Autorisation Super Admin
├─ AuditLoginLogout (Middleware) → Login/Logout
└─ Routes → /audit-logs
```

## 📝 Notes

- 🟢 **Tout est opérationnel** après `php artisan migrate && php artisan db:seed`
- 🔵 Ajoutez `use Auditable;` aux modèles pour auditer
- 🟠 L'export/suppression nécessite confirmation du mot de passe
- 🔴 Seul le Super Admin peut accéder à cette section

## 🆘 Dépannage

**"Access Denied" ?**
- Vérifiez que vous êtes connecté en tant que Super Admin
- Vérifiez la Policy `AuditLogPolicy`

**"Aucun log affiché" ?**
- Exécutez la migration: `php artisan migrate`
- Ajoutez le trait `Auditable` aux modèles

**"Erreur lors de l'export" ?**
- Vérifiez les permissions du dossier `storage`
- Vérifiez que le mot de passe est correct

---

**Système complet d'audit ARMS Laravel**  
Prêt à l'emploi avec sécurité maximale! 🚀

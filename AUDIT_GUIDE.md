# Guide du Système d'Audit Complet

## Vue d'ensemble

Ce système d'audit complet enregistre **toutes les actions** effectuées dans l'application par tous les utilisateurs, y compris:

- **Qui** : L'utilisateur qui a effectué l'action
- **Quoi** : Le type de modification (Création, Modification, Suppression)
- **Quand** : La date et l'heure exacte
- **Où** : Adresse IP, navigateur, URL accédée
- **Comment** : Méthode HTTP utilisée
- **Sur quel élément** : Le modèle affecté et son ID
- **Valeurs** : Les valeurs avant/après (pour les modifications)

## Architecture

### 1. **Modèle `AuditLog`**
Situé dans [app/Models/AuditLog.php](app/Models/AuditLog.php), ce modèle gère toutes les opérations d'audit.

**Attributs principaux:**
- `user_id` - ID de l'utilisateur
- `audit_type_id` - Type d'audit (CREATE, UPDATE, DELETE, etc.)
- `model_type` - Classe du modèle affecté
- `model_id` - ID de l'enregistrement affecté
- `action` - Type d'action
- `old_values` - Valeurs précédentes (JSON)
- `new_values` - Nouvelles valeurs (JSON)
- `ip_address` - Adresse IP du client
- `user_agent` - Navigateur utilisé
- `method` - Méthode HTTP
- `url` - URL accédée

### 2. **Trait `Auditable`**
Situé dans [app/Traits/Auditable.php](app/Traits/Auditable.php), ce trait capture automatiquement les changements CRUD.

**Utilisation dans les modèles:**
```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    use Auditable; // Ajouter ce trait
    
    // ... reste du modèle
}
```

**Comportement automatique:**
- ✅ Enregistre les **créations** avec toutes les valeurs initiales
- ✅ Enregistre les **modifications** avec avant/après pour chaque champ
- ✅ Enregistre les **suppressions** avec toutes les valeurs effacées

### 3. **Contrôleur `AuditLogController`**
Situé dans [app/Http/Controllers/AuditLogController.php](app/Http/Controllers/AuditLogController.php)

**Méthodes disponibles:**

#### `index()` - Affiche tous les logs avec filtres
```
GET /audit-logs
```

**Filtres disponibles:**
- `action` - Type d'action (CREATE, UPDATE, DELETE, etc.)
- `audit_type` - Type d'audit
- `user_id` - ID de l'utilisateur
- `model_type` - Type de modèle
- `start_date` - Date début
- `end_date` - Date fin
- `search` - Recherche dans les détails

#### `show()` - Affiche les détails d'un log
```
GET /audit-logs/{auditLog}
```

#### `export()` - Exporte les logs en CSV
```
POST /audit-logs/export
```
**Nécessite**: Confirmation du mot de passe super_admin

#### `clear()` - Supprime tous les logs (Super Admin uniquement)
```
DELETE /audit-logs/clear
```
**Nécessite**: Confirmation du mot de passe

### 4. **Policy `AuditLogPolicy`**
Situé dans [app/Policies/AuditLogPolicy.php](app/Policies/AuditLogPolicy.php)

**Autorisations:**
- `viewAny()` : Voir tous les logs → **Super Admin uniquement**
- `view()` : Voir un log détaillé → **Super Admin uniquement**
- `delete()` : Supprimer des logs → **Super Admin uniquement**
- `deleteAll()` : Vider les logs → **Super Admin uniquement**

### 5. **Middleware `AuditLoginLogout`**
Situé dans [app/Http/Middleware/AuditLoginLogout.php](app/Http/Middleware/AuditLoginLogout.php)

Enregistre automatiquement:
- ✅ Les connexions utilisateur (LOGIN)
- ✅ Les déconnexions utilisateur (LOGOUT)

### 6. **Routes**
Toutes les routes sont configurées pour le **Super Admin uniquement**:

```php
Route::middleware($superAdminOnly)->group(function () {
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::post('/audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
    Route::delete('/audit-logs/clear', [AuditLogController::class, 'clear'])->name('audit-logs.clear');
});
```

## Installation et Configuration

### 1. **Exécuter les migrations**
```bash
php artisan migrate
```

Cela créera/enrichira la table `audits` avec toutes les colonnes nécessaires.

### 2. **Seeder les types d'audit**
```bash
php artisan db:seed --class=AuditTypeSeeder
```

Ou inclure dans le DatabaseSeeder (déjà fait).

### 3. **Ajouter le trait aux modèles**
Pour chaque modèle dont vous voulez auditer les actions:

```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use Auditable;
    
    // ... reste du modèle
}
```

## Types d'Audit Disponibles

| Code | Label | Description |
|------|-------|-------------|
| `create` | Création | Enregistrement créé |
| `update` | Modification | Enregistrement modifié |
| `delete` | Suppression | Enregistrement supprimé |
| `read` | Lecture | Enregistrement consulté |
| `login` | Connexion | Utilisateur connecté |
| `logout` | Déconnexion | Utilisateur déconnecté |
| `download` | Téléchargement | Fichier téléchargé |
| `export` | Exportation | Données exportées |
| `import` | Importation | Données importées |
| `other` | Autre | Autre action |

## Vues

### 1. **Liste des logs** (`/audit-logs`)
- Affichage paginé (50 par page)
- Filtres par action, type, utilisateur, modèle
- Filtrage par plage de dates
- Recherche par utilisateur/détails
- Boutons d'export et de suppression

### 2. **Détails du log** (`/audit-logs/{id}`)
- Informations générales complètes
- Détails techniques (IP, User Agent, URL)
- Tableau des changements avant/après
- Navigation facile vers la liste

## Sécurité

### Accès Protégé

1. **Middleware `checkRole:super_admin`** : Seul le super admin peut accéder
2. **Policy `AuditLogPolicy`** : Vérification supplémentaire au niveau du code
3. **Confirmation du mot de passe** : Pour exporter ou supprimer les logs
   - Un modal Bootstrap demande le mot de passe
   - Vérification avec `Hash::check()`
   - Le champ est nettoyé après fermeture du modal

### Données Tracées

**Jamais enregistrés:**
- Les mots de passe (marqués comme hidden dans le modèle)
- Les tokens d'authentification
- Les données sensibles que vous spécifiez

**Enregistrés:**
- Toutes les actions CRUD
- Les utilisateurs qui les ont effectuées
- Les adresses IP
- Les navigateurs
- Les heures exactes

## Exemples d'Utilisation

### Example 1: Auditer un modèle existant

#### Avant
```php
class Building extends Model
{
    // ... définition du modèle
}
```

#### Après
```php
use App\Traits\Auditable;

class Building extends Model
{
    use Auditable;
    
    // ... reste du modèle
}
```

**Résultat:** Tous les CRUD sur `Building` seront automatiquement enregistrés.

### Example 2: Enregistrer une action personnalisée

```php
use App\Models\AuditLog;

// Dans votre contrôleur ou service
AuditLog::log(
    action: 'EXPORT',
    userId: auth()->id(),
    modelType: 'App\Models\Payment',
    modelId: null,
    details: 'Export de 150 paiements',
);
```

### Example 3: Filtrer les logs

```php
use App\Models\AuditLog;

// Tous les UPDATE
$updates = AuditLog::byAction('UPDATE')->get();

// Modifications par un utilisateur spécifique
$userLogs = AuditLog::byUser(1)->get();

// Modifications d'un modèle spécifique  
$contractLogs = AuditLog::byModelType('App\Models\Contract')->get();

// Plage de dates
$weeklyLogs = AuditLog::byDateRange(
    now()->subWeek(),
    now()
)->get();

// Recherche combinée
$results = AuditLog::byAction('CREATE')
    ->byModelType('App\Models\User')
    ->byDateRange('2026-04-01', '2026-04-08')
    ->get();
```

### Example 4: Afficher un log formaté

```php
@foreach($auditLogs as $log)
    <tr>
        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
        <td>{{ $log->user->firstname }} {{ $log->user->lastname }}</td>
        <td>{{ $log->action }}</td>
        <td>{{ $log->details }}</td>
        <td>{{ $log->ip_address }}</td>
    </tr>
@endforeach
```

## Gestion des Performances

### Optimisations incluses

1. **Indexes sur la base de données**
   - Index sur `user_id`
   - Index sur `created_at`
   - Index sur `model_type`

2. **Pagination automatique**
   - 50 logs par page
   - Réduit la charge mémoire

3. **Relations optimisées**
   - `with(['user', 'auditType'])` chargé au par page

### Recommandations

1. **Archives anciennes** : Supprimez les logs après 90 jours
   ```bash
   // Dans une commande Laravel
   AuditLog::where('created_at', '<', now()->subDays(90))->delete();
   ```

2. **Monitorer la taille**
   - Vérifiez régulièrement la taille de la table `audits`
   - Ajustez la rétention selon vos besoins

3. **Backup réguliers**
   - Incluez la table `audits` dans vos sauvegardes
   - Exportez les logs critiques en CSV

## Maintenance

### Commandes Utiles

```bash
# Voir le nombre de logs
php artisan tinker
>>> App\Models\AuditLog::count()

# Supprimer les logs anciens (90 jours)
>>> App\Models\AuditLog::where('created_at', '<', now()->subDays(90))->delete();

# Exporter tous les logs en CSV programmatiquement
>>> $logs = App\Models\AuditLog::with(['user', 'auditType'])->get();
>>> // Votre logique d'export
```

### Résolution des Problèmes

1. **Les logs ne s'enregistrent pas**
   - Vérifiez que le trait `Auditable` est utilisé
   - Vérifiez les permissions du middleware
   - Regardez les erreurs Laravel dans `storage/logs`

2. **Erreur lors de l'export**
   - Assurez-vous que le Super Admin a confirmé le mot de passe
   - Vérifiez les permissions d'écriture du dossier `storage`

3. **Performance lente**
   - Supprimez les logs anciens
   - Ajoutez des indexes supplémentaires si nécessaire
   - Réduisez la plage de dates dans les filtres

## Notes de Développement

### Structure de la Table

```sql
ALTER TABLE audits ADD COLUMN (
    model_type VARCHAR(255),
    model_id BIGINT UNSIGNED,
    action VARCHAR(50),
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    method VARCHAR(10),
    url TEXT
);
```

### Routes Disponibles

```php
// Affichage
GET     /audit-logs           // Liste avec filtres
GET     /audit-logs/{id}      // Détails

// Actions
POST    /audit-logs/export    // Export CSV (avec confirmati de mot de passe)
DELETE  /audit-logs/clear     // Suppression (avec confirmation de mot de passe)
```

### Fonctionnalités Futures Possibles

- [ ] Webhooks pour actions spécifiques
- [ ] Email notifications pour actions critiques
- [ ] Graphiques/statistiques d'audit
- [ ] Comparaison d'historique entre deux dates
- [ ] Annulation d'actions (undo) pour admins
- [ ] Chiffrement des données sensibles

## Support

Pour toute question ou problème, vérifiez:
1. Les logs d'erreur dans `storage/logs/laravel.log`
2. La console de débogage (si disponible)
3. Les tests unitaires dans `tests/`

---

**Version:** 1.0.0  
**Dernière mise à jour:** Avril 2026  
**Auteur:** Système d'Audit ARMS Laravel

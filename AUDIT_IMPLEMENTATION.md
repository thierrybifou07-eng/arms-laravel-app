# Implémentation du Trait Auditable

## Guide Pas à Pas

Ce guide montre comment ajouter l'audit automatique aux modèles existants de votre application.

## Étape 1: Ajouter le trait

Pour tout modèle que vous voulez auditer, ajoutez simplement le trait `Auditable`:

```php
<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use Auditable;  // ← Ajouter cette ligne
    
    // ... reste du code du modèle
}
```

## Étape 2: C'est tout !

Une fois le trait ajouté, **tous les CRUD** seront automatiquement enregistrés:

- ✅ Création → Enregistrée avec toutes les valeurs
- ✅ Modification → Enregistrée avec avant/après
- ✅ Suppression → Enregistrée avec les valeurs supprimées

## Exemples de Modèles à Auditer

### Modèles Recommandés:

```php
// Modèles de gestion résidences/contrats
class Residence extends Model {
    use Auditable;
}

class Building extends Model {
    use Auditable;
}

class Contract extends Model {
    use Auditable;
}

class Payment extends Model {
    use Auditable;
}

// Modèles de gestion utilisateurs
class User extends Model {
    use Auditable;
}

class Role extends Model {
    use Auditable;
}

class Permission extends Model {
    use Auditable;
}
```

## Comment ça Fonctionne

Le trait utilise les **événements Laravel** sur les modèles:

```
created  → Enregistre CREATE avec $model->getAttributes()
updating → Enregistre UPDATE avec before/after
deleted  → Enregistre DELETE avec $model->getAttributes()
```

### Exemple: Modification d'un contrat

**Avant le trait:**
```php
$contract = Contract::find(1);
$contract->update(['status' => 'completed']);
```

**Après le trait:**
- ✅ CREATE log: `id=1, contract_type=rent, status=pending, ...`
- ⚠️ UPDATE log: `status: 'pending' → 'completed'` (seuls les changements)
- 🗑️ (Si suppression) DELETE log: `id=1, contract_type=rent, status=pending, ...`

## Exclure Certains Modèles

Si vous ne voulez PAS auditer un modèle, ne le modifiez pas.

## Exclure Certains Champs

Pour éviter d'enregistrer certains champs (ex: password):

```php
// Dans le trait, modifier la méthode logModelActivity()
$excludedFields = ['password', 'remember_token', 'api_token'];

foreach ($changes as $key => $newValue) {
    if (in_array($key, $excludedFields)) {
        continue;
    }
    // ... enregistrer le changement
}
```

## Tester L'Audit

### Via la Web UI

1. Allez à `/audit-logs`
2. Filtrez par action: **CREATE**, **UPDATE**, **DELETE**
3. Vérifiez que les changements sont correctement enregistrés

### Via Tinker

```bash
php artisan tinker

# Créer
>>> $contract = App\Models\Contract::create(['status' => 'pending']);
   # Vérifier: AuditLog::latest()->first()

# Modifier
>>> $contract->update(['status' => 'completed']);
   # Vérifier: AuditLog::latest()->first()

# Supprimer
>>> $contract->delete();
   # Vérifier: AuditLog::latest()->first()
```

### Via Le Commande de Test

```bash
php artisan audit:test
```

## Queries Avancées

### Cas d'Usage: Voir tous les changements d'un utilisateur aujourd'hui

```php
use App\Models\AuditLog;

$userId = 5;
$today = now()->startOfDay();

$logs = AuditLog::where('user_id', $userId)
    ->where('created_at', '>=', $today)
    ->orderBy('created_at', 'desc')
    ->with(['user', 'auditType'])
    ->get();

foreach ($logs as $log) {
    echo "$log->action: $log->details\n";
}
```

### Cas d'Usage: Qui a créé ce contrat et quand ?

```php
$contractId = 123;

$creation = AuditLog::where('model_type', 'App\Models\Contract')
    ->where('model_id', $contractId)
    ->where('action', 'CREATE')
    ->first();

if ($creation) {
    echo "Créé par: {$creation->user->firstname}\n";
    echo "À: {$creation->created_at}\n";
    echo "IP: {$creation->ip_address}\n";
}
```

### Cas d'Usage: Historique complet d'un enregistrement

```php
$contractId = 123;

$history = AuditLog::where('model_type', 'App\Models\Contract')
    ->where('model_id', $contractId)
    ->orderBy('created_at', 'asc')
    ->with('user')
    ->get();

foreach ($history as $entry) {
    echo "[{$entry->created_at}] {$entry->user->firstname}: {$entry->action}\n";
    if ($entry->old_values) {
        echo "  Avant: " . json_encode($entry->old_values) . "\n";
    }
    if ($entry->new_values) {
        echo "  Après: " . json_encode($entry->new_values) . "\n";
    }
}
```

## Performance

### Considérations

1. **Chaque CRUD génère une entrée de log**
   - 1000 contrats créés = 1000 logs
   - 500 paiements modifiés = 500 logs

2. **Table `audits` grandi rapidement**
   - ~1 KB par log en moyenne
   - 1M de logs = ~1-2 GB

### Recommandations

1. **Archive les logs vieux** (> 90 jours)
   ```php
   // Dans une commande schedulée
   AuditLog::where('created_at', '<', now()->subDays(90))->delete();
   ```

2. **Ajouter des indexes** (déjà fait dans la migration)
   ```sql
   CREATE INDEX idx_audits_user_id ON audits(user_id);
   CREATE INDEX idx_audits_created_at ON audits(created_at);
   CREATE INDEX idx_audits_model_type ON audits(model_type);
   ```

3. **Utiliser la pagination** pour les requêtes
   ```php
   AuditLog::paginate(50);  // Pas tout à la fois
   ```

## Dépannage

### "Les logs ne s'enregistrent pas"

1. ✅ Vérifiez que le trait est utilisé: `use Auditable;`
2. ✅ Vérifiez la table: `php artisan tinker → App\Models\AuditLog::count()`
3. ✅ Vérifiez les erreurs: `tail -f storage/logs/laravel.log`

### "Certains champs ne s'enregistrent pas"

C'est normal ! Le trait n'enregistre que les champs **réellement modifiés**:

```php
$contract->update([
    'status' => 'completed',  // ← Ceci est enregistré
    'status' => 'completed'   // ← Même champ, pas re-enregistré
]);
```

### "Erreur: SQLSTATE[23000]: Integrity constraint"

- Vérifiez que la migration a été exécutée
- Vérifiez que `audit_types` table existe
- Exécutez: `php artisan migrate:fresh` (développement uniquement!)

## Statut de l'Implémentation

| Élément | Statut | Modèle |
|---------|--------|--------|
| Trait Auditable | ✅ Actif | [app/Traits/Auditable.php](app/Traits/Auditable.php) |
| Modèle AuditLog | ✅ Actif | [app/Models/AuditLog.php](app/Models/AuditLog.php) |
| Migration | ✅ Createé | [database/migrations/...](database/migrations/) |
| Contrôleur | ✅ Actif | [app/Http/Controllers/AuditLogController.php](app/Http/Controllers/AuditLogController.php) |
| Routes | ✅ Actif | [routes/web.php](routes/web.php) |
| Vues | ✅ Actif | [resources/views/audit-logs/](resources/views/audit-logs/) |

## Prochaines Étapes

1. **Ajouter le trait** à vos modèles principaux
2. **Exécuter une migration**: `php artisan migrate`
3. **Vérifier les logs**: Allez à `/audit-logs`
4. **Ajuster la rétention** si nécessaire

---

Pour des questions, consultez [AUDIT_GUIDE.md](AUDIT_GUIDE.md) pour la documentation complète.

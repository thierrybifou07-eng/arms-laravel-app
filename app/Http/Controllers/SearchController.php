<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Residence;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $user = $request->user();
        $sections = collect();

        if ($query !== '') {
            if ($user->hasRole(Role::SUPER_ADMIN)) {
                $sections = collect([
                    $this->usersSection($query),
                    $this->auditsSection($query),
                ])->filter();
            } elseif ($user->hasRole(Role::ADMIN)) {
                $sections = collect([
                    $this->usersSection($query),
                    $this->residencesSection($query, $user),
                    $this->contractsSection($query, $user),
                    $this->paymentsSection($query, $user),
                    $this->paymentHistoriesSection($query, $user),
                ])->filter();
            } elseif ($user->hasRole(Role::STAFF)) {
                $sections = collect([
                    $this->contractsSection($query, $user),
                    $this->paymentsSection($query, $user),
                    $this->paymentHistoriesSection($query, $user),
                ])->filter();
            } elseif ($user->hasRole(Role::STUDENT)) {
                $sections = collect([
                    $this->profileSection($query, $user),
                    $this->studentPaymentsSection($query, $user),
                ])->filter();
            }
        }

        return view('search.index', [
            'query' => $query,
            'sections' => $sections,
            'totalResults' => $sections->sum(fn (array $section) => count($section['items'])),
        ]);
    }

    private function usersSection(string $query): ?array
    {
        $items = User::query()
            ->with('roles')
            ->where(fn (Builder $builder) => $this->applyUserSearch($builder, $query))
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (User $user) => [
                'title' => trim("{$user->firstname} {$user->lastname}"),
                'meta' => $user->email,
                'description' => $user->getRoleLabel() ?? 'User',
                'url' => route('users.show', $user),
            ]);

        return $this->makeSection('Users', 'bx-user', $items);
    }

    private function auditsSection(string $query): ?array
    {
        $items = Audit::query()
            ->with('user')
            ->where(function (Builder $builder) use ($query) {
                $this->applyBasicSearch($builder, $query, ['event', 'auditable_type', 'auditable_id']);
                $builder->orWhereHas('user', fn (Builder $userQuery) => $this->applyUserSearch($userQuery, $query));
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Audit $audit) => [
                'title' => $audit->event_label.' '.$audit->model_name,
                'meta' => 'Audit #'.$audit->id,
                'description' => trim(($audit->user?->firstname ?? 'System').' '.($audit->user?->lastname ?? '')),
                'url' => route('super_adminaudits.show', $audit),
            ]);

        return $this->makeSection('Audit Logs', 'bx-history', $items);
    }

    private function residencesSection(string $query, User $user): ?array
    {
        $items = Residence::query()
            ->whereHas('users', fn (Builder $builder) => $builder->where('users.id', $user->id))
            ->where(fn (Builder $builder) => $this->applyBasicSearch($builder, $query, ['name', 'city', 'address']))
            ->orderBy('name')
            ->limit(8)
            ->get()
            ->map(fn (Residence $residence) => [
                'title' => $residence->name,
                'meta' => $residence->city,
                'description' => $residence->address,
                'url' => route('residences.show', $residence),
            ]);

        return $this->makeSection('Residences', 'bx-home', $items);
    }

    private function contractsSection(string $query, User $user): ?array
    {
        $items = Contract::query()
            ->with(['user', 'status'])
            ->forManager($user)
            ->where(function (Builder $builder) use ($query) {
                $this->applyBasicSearch($builder, $query, ['id']);
                $builder->orWhereHas('user', fn (Builder $userQuery) => $this->applyUserSearch($userQuery, $query));
                $builder->orWhereHas('status', fn (Builder $statusQuery) => $this->applyBasicSearch($statusQuery, $query, ['code', 'label']));
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Contract $contract) => [
                'title' => 'Contract #'.$contract->id,
                'meta' => trim(($contract->user?->firstname ?? '').' '.($contract->user?->lastname ?? '')),
                'description' => $contract->status?->label ?? 'Contract',
                'url' => route('contracts.show', $contract),
            ]);

        return $this->makeSection('Contracts', 'bx-food-menu', $items);
    }

    private function paymentsSection(string $query, User $user): ?array
    {
        $items = Payment::query()
            ->with(['contract.user', 'status'])
            ->forManager($user)
            ->where(function (Builder $builder) use ($query) {
                $this->applyBasicSearch($builder, $query, ['id', 'expected_amount', 'paid_amount']);
                $builder->orWhereHas('status', fn (Builder $statusQuery) => $this->applyBasicSearch($statusQuery, $query, ['code', 'label']));
                $builder->orWhereHas('contract.user', fn (Builder $userQuery) => $this->applyUserSearch($userQuery, $query));
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Payment $payment) => [
                'title' => 'Payment #'.$payment->id,
                'meta' => trim(($payment->contract?->user?->firstname ?? '').' '.($payment->contract?->user?->lastname ?? '')),
                'description' => $payment->status?->label ?? 'Payment',
                'url' => route('payments.show.pay', $payment),
            ]);

        return $this->makeSection('Payments', 'bx-money', $items);
    }

    private function paymentHistoriesSection(string $query, User $user): ?array
    {
        $items = PaymentHistory::query()
            ->with(['payment.contract.user', 'recordedBy'])
            ->forManager($user)
            ->where(function (Builder $builder) use ($query) {
                $this->applyBasicSearch($builder, $query, ['id', 'payment_id', 'notes']);
                $builder->orWhereHas('payment.contract.user', fn (Builder $userQuery) => $this->applyUserSearch($userQuery, $query));
                $builder->orWhereHas('recordedBy', fn (Builder $userQuery) => $this->applyUserSearch($userQuery, $query));
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (PaymentHistory $history) => [
                'title' => 'History #'.$history->id,
                'meta' => 'Payment #'.$history->payment_id,
                'description' => $history->notes ?: 'Recorded by '.trim(($history->recordedBy?->firstname ?? '').' '.($history->recordedBy?->lastname ?? '')),
                'url' => route('payment_histories.show', $history),
            ]);

        return $this->makeSection('Payment Histories', 'bx-history', $items);
    }

    private function profileSection(string $query, User $user): ?array
    {
        $matches = collect([$user])->filter(function (User $profileUser) use ($query) {
            $searchable = strtolower(implode(' ', [
                $profileUser->firstname,
                $profileUser->lastname,
                $profileUser->email,
                $profileUser->phone,
            ]));

            return str_contains($searchable, strtolower($query));
        })->map(fn (User $profileUser) => [
            'title' => trim("{$profileUser->firstname} {$profileUser->lastname}"),
            'meta' => $profileUser->email,
            'description' => 'My profile',
            'url' => route('profile.show'),
        ]);

        return $this->makeSection('My Profile', 'bx-user', $matches);
    }

    private function studentPaymentsSection(string $query, User $user): ?array
    {
        $items = Payment::query()
            ->with(['contract.user', 'status'])
            ->whereHas('contract', fn (Builder $builder) => $builder->where('user_id', $user->id))
            ->where(function (Builder $builder) use ($query) {
                $this->applyBasicSearch($builder, $query, ['id', 'expected_amount', 'paid_amount']);
                $builder->orWhereHas('status', fn (Builder $statusQuery) => $this->applyBasicSearch($statusQuery, $query, ['code', 'label']));
            })
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Payment $payment) => [
                'title' => 'Payment #'.$payment->id,
                'meta' => $payment->status?->label ?? 'Payment',
                'description' => 'My payment',
                'url' => route('payments.show.pay', $payment),
            ]);

        return $this->makeSection('My Payments', 'bx-money', $items);
    }

    private function makeSection(string $title, string $icon, Collection $items): ?array
    {
        if ($items->isEmpty()) {
            return null;
        }

        return [
            'title' => $title,
            'icon' => $icon,
            'items' => $items->values()->all(),
        ];
    }

    private function applyUserSearch(Builder $builder, string $query): void
    {
        $this->applyBasicSearch($builder, $query, ['firstname', 'lastname', 'email', 'phone']);
    }

    private function applyBasicSearch(Builder $builder, string $query, array $columns): void
    {
        $terms = preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        foreach ($terms as $term) {
            $builder->where(function (Builder $termQuery) use ($columns, $term) {
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $termQuery->{$method}($column, 'like', '%'.$term.'%');
                }
            });
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BillingPeriod;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = 'super_admin'; // default
        $dashboardData = [];

        if ($user->hasRole('super_admin')) {
            $role = 'super_admin';
            $dashboardData = $this->getSuperAdminStats();
        } elseif ($user->hasRole('admin')) {
            $role = 'admin';
            $dashboardData = $this->getAdminStats();
        } elseif ($user->hasRole('staff')) {
            $role = 'staff';
            $dashboardData = $this->getStaffStats();
        } elseif ($user->hasRole('teller')) {
            $role = 'teller';
            $dashboardData = $this->getTellerStats();
        } elseif ($user->hasRole('student')) {
            $role = 'student';
            $dashboardData = $this->getStudentStats($user);
        }

        return view('dashboard', compact('role', 'dashboardData'));
    }

    private function getSuperAdminStats()
    {
        return [
            'role' => 'super_admin',
            'totalStudents' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'totalContracts' => Contract::count(),
            'activeContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'totalPayments' => Payment::count(),
            'validatedPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'totalPaymentHistories' => PaymentHistory::count(),
            'recentHistories' => PaymentHistory::latest()->take(5)->get(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
        ];
    }

    private function getAdminStats()
    {
        return [
            'role' => 'admin',
            'totalStudents' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'totalContracts' => Contract::count(),
            'activeContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'totalPayments' => Payment::count(),
            'validatedPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
        ];
    }

    private function getStaffStats()
    {
        return [
            'role' => 'staff',
            'totalStudents' => User::whereHas('roles', fn ($q) => $q->where('name', 'student'))->count(),
            'totalContracts' => Contract::count(),
            'activeContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'active'))->count(),
            'pendingContracts' => Contract::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'recentContracts' => Contract::with(['user', 'room', 'status'])->latest()->take(5)->get(),
            'totalBillingPeriods' => BillingPeriod::count(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
        ];
    }

    private function getTellerStats()
    {
        return [
            'role' => 'teller',
            'totalPayments' => Payment::count(),
            'validatedPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'validated'))->count(),
            'pendingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'pending'))->count(),
            'processingPayments' => Payment::whereHas('status', fn ($q) => $q->where('code', 'processing'))->count(),
            'totalPaymentHistories' => PaymentHistory::count(),
            'recentHistories' => PaymentHistory::latest()->take(5)->get(),
            'recentPayments' => Payment::with(['contract.user', 'status'])->latest()->take(10)->get(),
        ];
    }

    private function getStudentStats($user)
    {
        $contracts = $user->contracts;

        if (! $contracts->count()) {
            return ['role' => 'student', 'message' => 'No contracts assigned'];
        }

        $payments = Payment::with('method')->whereHas('contract', fn ($q) => $q->where('user_id', $user->id))->get();

        return [
            'role' => 'student',
            'studentName' => $user->firstname . ' ' . $user->lastname,
            'totalContracts' => $contracts->count(),
            'activeContracts' => $contracts->filter(fn ($c) => $c->status->code === 'active')->count(),
            'totalPayments' => $payments->count(),
            'PaidPayments' => $payments->filter(fn ($p) => $p->status->code === 'validated')->count(),
            'pendingPayments' => $payments->filter(fn ($p) => $p->status->code === 'pending')->count(),
            'recentContracts' => $contracts,
            'payments' => $payments,
        ];
    }
}

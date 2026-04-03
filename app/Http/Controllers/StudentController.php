<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Student::class);
        
        $students = Student::with('user')->paginate(15);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Student::class);
        
        $users = User::whereDoesntHave('student')->get();
        return view('students.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $student = Student::create($request->validated());
        
        return redirect()->route('students.show', $student)
            ->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $this->authorize('view', $student);
        
        $contracts = $student->contracts()->with('room', 'status')->get();
        return view('students.show', compact('student', 'contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $this->authorize('update', $student);
        
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());
        
        return redirect()->route('students.show', $student)
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);
        
        $student->delete();
        
        return redirect()->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $companies = Company::select('id', 'name')->get();
        $employees = Employee::with(['company'])->paginate($perPage);
        return response()->json(['companies' => $companies, 'employees' => [
            'current_page' => $employees->currentPage(),
            'last_page' => $employees->lastPage(),
            'previous_page' => $employees->previousPageUrl(),
            'next_page' => $employees->nextPageUrl(),
            'data' => EmployeeResource::collection($employees)
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = Employee::create([
            'first_name' => $request->first_name ?? '',
            'last_name' => $request->last_name ?? '',
            'company_id' => $request->company_id ?? '',
            'email' => $request->email ?? '',
            'phone' => $request->phone ?? ''
        ]);

        return response()->json(['message' => 'Employee created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEmployeeRequest $request, string $id)
    {
        $employee = Employee::find($id);
        $employee->first_name = $request->first_name ?? '';
        $employee->last_name = $request->last_name ?? '';
        $employee->company_id = $request->company_id ?? null;
        $employee->email = $request->email ?? '';
        $employee->phone = $request->phone ?? '';
        $employee->save();

        return response()->json(['message' => 'Employee updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}

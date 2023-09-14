<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $companies = Company::query()->paginate($perPage);
        return response()->json(['companies' => [
            'current_page' => $companies->currentPage(),
            'last_page' => $companies->lastPage(),
            'previous_page' => $companies->previousPageUrl(),
            'next_page' => $companies->nextPageUrl(),
            'data' => CompanyResource::collection($companies)
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
    public function store(CreateCompanyRequest $request, FileUploadService $fileUploadService)
    {
        $companyData = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'website' => $request->website ?? ''
        ];

        if ($request->hasFile('logo')) {
            $companyData['logo'] = $fileUploadService->uploadFile($request->logo);
        }

        $company = Company::create($companyData);

        return response()->json(['message' => 'Company created successfully'], 201);
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
    public function update(Request $request, string $id, FileUploadService $fileUploadService)
    {
        $company = Company::find($id);
        $company->name =  $request->name ?? '';
        $company->email =  $request->email ?? '';
        $company->website =  $request->website ?? '';

        if ($request->hasFile('logo')) {
            $company->logo = $fileUploadService->uploadFile($request->logo);
        }

        $company->save();

        return response()->json(['message' => 'Company updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}

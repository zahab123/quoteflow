<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first();
        return view('settings.company', compact('company'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'website' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $company = Company::first() ?? new Company();

        // Logo Upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logo', 'public');
            $company->logo = $logoPath;
        }

        // Save all info
        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->website = $request->website;
        $company->address = $request->address;

        $company->save();

        return back()->with('success', 'Company details saved successfully!');
    }
    

    public function show()
    {
    $company = Company::first(); 
    return view('view', compact('company'));
    }

}

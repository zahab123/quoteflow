<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Quotations;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first();
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

        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first() ?? new Company();
        $company->user_id = $userId; // Associate with current user

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company_logo', 'public');
            $company->logo = $logoPath;
        }

        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->website = $request->website;
        $company->address = $request->address;

        $company->save();

        return back()->with('success', 'Company details saved successfully!');
    }

    public function showQuotation($id)
    {
        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first();
        $quotation = Quotations::with('items', 'client')
            ->where('user_id', $userId)
            ->findOrFail($id);

        return view('view', compact('company', 'quotation'));
    }

    public function edit()
    {
        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first();
        return view('setting', compact('company'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first() ?? new Company();
        $company->user_id = $userId;

        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->website = $request->website;
        $company->address = $request->address;

        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::exists($company->logo)) {
                Storage::delete($company->logo);
            }
            $company->logo = $request->file('logo')->store('company_logos', 'public');
        }

        $company->save();

        return redirect()->route('company.settings.edit')->with('success', 'Company details saved successfully!');
    }

    public function settings()
    {
        $userId = auth()->id();
        $company = Company::where('user_id', $userId)->first();

        return view('setting', compact('company'));
    }
}

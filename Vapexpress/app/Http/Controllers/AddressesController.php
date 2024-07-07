<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (Auth::user()->rol != 'admin') {
                DB::beginTransaction();
                $addresses  = Auth::user()->address;
                DB::commit();
                return view('addresses.index', compact('addresses'));
            } else {
                return view('client.profile')->with('error', 'El administrador no puede tener direcciones');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            if (Auth::user()->rol != 'admin') {
                return view('addresses.create');
            } else {
                return view('client.profile')->with('error', 'El administrador no puede tener direcciones');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:9|min:9',
            'direction' => 'required|string|max:255',
            'city' => 'required|string|max:30',
            'province' => 'required|string|max:30',
            'zip_code' => 'required|string|max:5',
        ]);
        try {
            DB::beginTransaction();
            $address = new Address();
            $address->user_id = Auth::user()->id;
            $address->full_name = $validatedData['full_name'];
            $address->contact_phone = $validatedData['contact_phone'];
            $address->direction = $validatedData['direction'];
            $address->city = $validatedData['city'];
            $address->province = $validatedData['province'];
            $address->zip_code = $validatedData['zip_code'];
            $address->save();
            DB::commit();
            return redirect()->route('addresses.index')->with('success', 'Dirección creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to fetch addresses.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function profile()
    {

        try {
            if (Auth::check()) {
                DB::beginTransaction();
                $user_name = Auth::user()->name;
                $user_id = Auth::user()->id;
                DB::commit();
                return view('client.profile', compact('user_name', 'user_id'));
            } else {
                return view('auth.verify-email');
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
    public function edit(int $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            DB::commit();
            return view('client.update', compact('user'));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            //Comprobamos los datos
            $request->validate([
                'email' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
            ]);
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->email = $request->email;
            $user->name = $request->name;
            $user->save();
            DB::commit();

            return redirect()->route('user.profile')->with('success', 'Tu perfil ha sido actualizado');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('user.profile')->with('error', 'Error al actualizar el usuario.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

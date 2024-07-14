<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //comprobamos si hay una búsqueda
        $query = $request->input('search');
        //comprobamos si se va ordenar por algún campo
        $sortField = $request->input('sort', 'name');
        //comprobamos si la dirección para ordenar es ascendente o descendente
        $sortDirection = $request->input('direction', 'asc');

        $suppliers = Supplier::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                ->orWhere('contact_name', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        if ($suppliers->isEmpty()) {
            return redirect()->route("suppliers.index")
                ->with("error", "No se han encontrado resultados de la consulta realizada: $query");
        }

        return view("admin.suppliers.index", compact("suppliers", "query", "sortField", "sortDirection"));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

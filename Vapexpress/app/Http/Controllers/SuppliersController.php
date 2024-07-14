<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

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
        return view("admin.suppliers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:9',
            'email' => 'required|email|max:255',
        ]);

        try {
            DB::beginTransaction();

            $supplier = new Supplier();
            $supplier->name = $validatedData['name'];
            $supplier->contact_name = $validatedData['contact_name'];
            $supplier->phone = $validatedData['phone'];
            $supplier->email = $validatedData['email'];
            $supplier->save();

            DB::commit();

            return redirect()->route('suppliers.index')
                ->with('success', 'El proveedor ha sido creado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('suppliers.create')
                ->with('error', 'Ocurrió un error al crear el proveedor: ' . $e->getMessage())
                ->withInput();
        }
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
        try {
            $supplier = Supplier::findOrFail($id);
            return view('admin.suppliers.edit', compact('supplier'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al editar el proveedor: ', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:9',
            'email' => 'required|email|max:255',
        ]);

        try {
            DB::beginTransaction();

            $supplier->name = $validatedData['name'];
            $supplier->contact_name = $validatedData['contact_name'];
            $supplier->phone = $validatedData['phone'];
            $supplier->email = $validatedData['email'];
            $supplier->save();

            DB::commit();

            return redirect()->route('suppliers.index')
                ->with('success', 'El proveedor ha sido actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('suppliers.edit', $supplier->id)
                ->with('error', 'Ocurrió un error al actualizar el proveedor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {

            DB::beginTransaction();
            $supplier->delete();
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el proveedor: ', $supplier->name);
        }
    }
}

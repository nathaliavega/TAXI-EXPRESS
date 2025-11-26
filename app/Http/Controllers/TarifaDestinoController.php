<?php

namespace App\Http\Controllers;

use App\Models\TarifaDestino;
use Illuminate\Http\Request;

class TarifaDestinoController extends Controller
{
    // Método para mostrar la lista (GET)
    public function index()
    {
        $tarifas = TarifaDestino::all();
        return view('admin.tarifas-destino.index', compact('tarifas'));
    }

    // Método para mostrar el formulario de creación (GET)
    public function create()
    {
        return view('admin.tarifas-destino.create');
    }

    // Método para guardar los datos del formulario (POST)
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            // Agrega aquí los campos que tenga tu tabla
        ]);

        // Guardar en la base de datos
        TarifaDestino::create($validated);

        return redirect()->route('tarifas-destino.index')
            ->with('success', 'Tarifa creada exitosamente');
    }

    // Método para editar (GET)
    public function edit($id)
    {
        $tarifa = TarifaDestino::findOrFail($id);
        return view('admin.tarifas-destino.edit', compact('tarifa'));
    }

    // Método para actualizar (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $tarifa = TarifaDestino::findOrFail($id);
        $tarifa->update($validated);

        return redirect()->route('tarifas-destino.index')
            ->with('success', 'Tarifa actualizada exitosamente');
    }

    // Método para eliminar (DELETE)
    public function destroy($id)
    {
        $tarifa = TarifaDestino::findOrFail($id);
        $tarifa->delete();

        return redirect()->route('tarifas-destino.index')
            ->with('success', 'Tarifa eliminada exitosamente');
    }
}
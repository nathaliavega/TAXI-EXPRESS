<?php

namespace App\Http\Controllers;

use App\Models\TarifaDestino;
use Illuminate\Http\Request;

class TarifaDestinoController extends Controller
{
    public function index()
    {
        $tarifas = TarifaDestino::all();
        return view('admin.tarifas-destino', compact('tarifas'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre_destino' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'tarifa_base' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            
        ]);

        // Crear la tarifa
        TarifaDestino::create([
            'nombre_destino' => $validated['nombre_destino'],
            'ciudad' => $validated['ciudad'],
            'departamento' => $validated['departamento'],
            'tarifa_base' => $validated['tarifa_base'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'estado' => 'nullable|in:Activa,Inactiva',
        ]);

        return redirect()->route('admin.tarifas-destino')
            ->with('success', 'Tarifa creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_destino' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'departamento' => 'required|string|max:255',
            'tarifa_base' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Activa,Inactiva',
        ]);

        $tarifa = TarifaDestino::findOrFail($id);
        $tarifa->update($validated);

        return redirect()->route('admin.tarifas-destino')
            ->with('success', 'Tarifa actualizada exitosamente');
    }

    public function destroy($id)
    {
        $tarifa = TarifaDestino::findOrFail($id);
        $tarifa->delete();

        return redirect()->route('admin.tarifas-destino.')
            ->with('success', 'Tarifa eliminada exitosamente');
    }
}
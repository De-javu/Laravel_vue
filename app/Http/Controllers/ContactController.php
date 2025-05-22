<?php

namespace App\Http\Controllers;

use App\Models\Contac;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('contacts/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('contacts/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //* Valida los datos que llegan del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'vatar' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
            'privacity' => 'required|in:public,private',
        ]);
    // 
    $data  = $request->except('vatar');

    if ($request->hasFile('vatar')) {
        $file = $request->file('vatar');
        $extension = $file->getClientOriginalExtension();
        // Limpiar el nombre y teléfono para el nombre del archivo
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->name);
        $safePhone = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->phone);
        $fileName = $safeName . '_' . $safePhone . '.' . $extension;
        $routeNama = $file->storeAs('vatar', $fileName, ['disk' => 'public']);
        $data['vatar'] = $routeNama;
    }

    $data['user_id'] = Auth::id();
    Contac::create($data);
    dd('usuaria creada');

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

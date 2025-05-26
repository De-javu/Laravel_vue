<?php

namespace App\Http\Controllers;

use App\Models\Contac;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts= Contac::where('user_id', Auth::user()->id)->get();
        
        return Inertia::render('contacts/index', compact('contacts'));
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
    $validated = $request->validate([
        'name' => 'required|string|max:50',
        'phone' => 'required|string|max:20',
        'vatar' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        'privacity' => 'required|in:public,private',
    ]);

    $data  = $request->except('vatar');

    if ($request->hasFile('vatar')) {
        $file = $request->file('vatar');
        $extension = $file->getClientOriginalExtension();
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->name);
        $safePhone = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->phone);
        $fileName = $safeName . '_' . $safePhone . '.' . $extension;
        $routeNama = $file->storeAs('vatar', $fileName, ['disk' => 'public']);
        $data['vatar'] = $routeNama;
    }

    $data['user_id'] = Auth::id();

    
        $contact = new Contac($data);
        $contact->save();
        return redirect()->route('contact.index');
    
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
    public function edit(Contac $id)
    
{
    //dd($id);
    //die();
    return Inertia::render('contacts/edit', [
        'contact' => $id,
    ]);
}
    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, Contac $id)
    {
  $validated = $request->validate([
        'name' => 'required|string|max:50',
        'phone' => 'required|string|max:20',
        'vatar' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        'privacity' => 'required|in:public,private',
    ]);

    $data = $request->except('vatar');

     // Se encarga de eliminar la imagne anterior para no llenar el disco
        if ($id->vatar) {
            Storage::disk('public')->delete($id->vatar);

      if ($request->hasFile('vatar')) {
        $file = $request->file('vatar');
        $extension = $file->getClientOriginalExtension();
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->name);
        $safePhone = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->phone);
        $fileName = $safeName . '_' . $safePhone . '.' . $extension;
        $routeNama = $file->storeAs('vatar', $fileName, ['disk' => 'public']);
        $data['vatar'] = $routeNama;

               
            
        }
    }
    $data['user_id'] = Auth::id();
    
    $id->update($data);
    return redirect()->route('contact.index');

       //return Inertia::render('contacts/update', compact('id'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Inertia::render('contacts/destroy');
    }
}

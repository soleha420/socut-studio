<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stylist;
use Illuminate\Http\Request;

class StylistController extends Controller
{
    public function index()
    {
        $stylists = Stylist::latest()->get();

        return view('admin.stylists.index', compact('stylists'));
    }

    public function create()
    {
        return view('admin.stylists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'specialist' => 'required',
            'gender' => 'required',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Name wajib diisi',
            'specialist.required' => 'Specialist wajib diisi',
            'gender.required' => 'Gender wajib dipilih',
            'photo.image' => 'File harus berupa gambar',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('stylists', 'public');
        }

        Stylist::create([
            'name' => $request->name,
            'specialist' => $request->specialist,
            'gender' => $request->gender,
            'photo' => $photoPath,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.stylists.index')
            ->with('success', 'Stylist berhasil ditambahkan');
    }

    public function edit(Stylist $stylist)
    {
        return view('admin.stylists.edit', compact('stylist'));
    }

    public function update(Request $request, Stylist $stylist)
    {
        $request->validate([
            'name' => 'required',
            'specialist' => 'required',
            'gender' => 'required',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Name wajib diisi',
            'specialist.required' => 'Specialist wajib diisi',
            'gender.required' => 'Gender wajib dipilih',
            'photo.image' => 'File harus berupa gambar',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = [
            'name' => $request->name,
            'specialist' => $request->specialist,
            'gender' => $request->gender,
            'description' => $request->description,
        ];

        if ($request->hasFile('photo')) {
            if ($stylist->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($stylist->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($stylist->photo);
            }
            $data['photo'] = $request->file('photo')->store('stylists', 'public');
        }

        $stylist->update($data);

        return redirect()
            ->route('admin.stylists.index')
            ->with('success', 'Stylist berhasil diupdate');
    }

    public function destroy(Stylist $stylist)
    {
        $stylist->delete();

        return redirect()
            ->route('admin.stylists.index')
            ->with('success', 'Stylist berhasil dihapus');
    }
}
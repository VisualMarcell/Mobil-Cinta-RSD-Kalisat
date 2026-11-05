<?php

namespace App\Http\Controllers\MobilCinta\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobilCinta\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RuanganController extends Controller
{
    /**
     * Menampilkan daftar ruangan.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $query = Ruangan::query()
            ->withCount('journeys')
            ->orderBy('nama_ruangan');

        if ($search !== '') {
            $query->where(
                'nama_ruangan',
                'like',
                '%' . $search . '%'
            );
        }

        $ruangans = $query
            ->paginate(10)
            ->withQueryString();

        $totalRuangan = Ruangan::count();
        $ruanganTerpakai = Ruangan::has('journeys')->count();
        $ruanganBelumTerpakai = $totalRuangan - $ruanganTerpakai;

        return view(
            'mobil-cinta.admin.ruangan.index',
            compact(
                'ruangans',
                'search',
                'totalRuangan',
                'ruanganTerpakai',
                'ruanganBelumTerpakai'
            )
        );
    }

    /**
     * Menyimpan ruangan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'nama_ruangan' => trim((string) $request->input('nama_ruangan')),
            '_form_context' => 'room-create',
        ]);

        $validated = $request->validate([
            'nama_ruangan' => [
                'required',
                'string',
                'max:50',
                'unique:ruangans,nama_ruangan',
            ],
        ], [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
            'nama_ruangan.max' => 'Nama ruangan maksimal 50 karakter.',
            'nama_ruangan.unique' => 'Nama ruangan sudah terdaftar.',
        ]);

        Ruangan::create([
            'nama_ruangan' => trim($validated['nama_ruangan']),
        ]);

        return redirect()
            ->route('mobil-cinta.admin.ruangan.index')
            ->with('status', 'Ruangan berhasil ditambahkan.');
    }

    /**
     * Memperbarui nama ruangan.
     */
    public function update(
        Request $request,
        Ruangan $ruangan
    ): RedirectResponse {
        $request->merge([
            'nama_ruangan' => trim((string) $request->input('nama_ruangan')),
            '_form_context' => 'room-edit',
            'ruangan_id' => $ruangan->id,
        ]);

        $validated = $request->validate([
            'nama_ruangan' => [
                'required',
                'string',
                'max:50',
                Rule::unique('ruangans', 'nama_ruangan')
                    ->ignore($ruangan->id),
            ],
        ], [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
            'nama_ruangan.max' => 'Nama ruangan maksimal 50 karakter.',
            'nama_ruangan.unique' => 'Nama ruangan sudah digunakan.',
        ]);

        $ruangan->update([
            'nama_ruangan' => trim($validated['nama_ruangan']),
        ]);

        return redirect()
            ->route('mobil-cinta.admin.ruangan.index')
            ->with('status', 'Nama ruangan berhasil diperbarui.');
    }

    /**
     * Menghapus ruangan yang belum pernah digunakan.
     */
    public function destroy(Ruangan $ruangan): RedirectResponse
    {
        if ($ruangan->journeys()->exists()) {
            return redirect()
                ->route('mobil-cinta.admin.ruangan.index')
                ->with(
                    'error',
                    'Ruangan tidak dapat dihapus karena sudah memiliki riwayat perjalanan.'
                );
        }

        $ruangan->delete();

        return redirect()
            ->route('mobil-cinta.admin.ruangan.index')
            ->with('status', 'Ruangan berhasil dihapus.');
    }
}
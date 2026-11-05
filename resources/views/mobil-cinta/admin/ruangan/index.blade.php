@extends('mobil-cinta.layouts.app')

@section('title', 'Master Ruangan')

@section('content')

    <style>
        .room-page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 23px;
        }

        .room-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .room-summary-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #fff;
            border: 1px solid #dceee2;
            border-radius: 14px;
            box-shadow: 0 5px 18px rgba(8, 100, 55, .04);
        }

        .room-summary-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 12px;
            background: #eaf8f0;
            color: #078b48;
            font-size: 23px;
        }

        .room-summary-card small {
            display: block;
            color: #718078;
            font-size: 11px;
            font-weight: 700;
        }

        .room-summary-card strong {
            display: block;
            color: #18352a;
            font-size: 23px;
            font-weight: 800;
            line-height: 1.3;
        }

        .room-filter-grid {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) auto;
            align-items: end;
            gap: 12px;
        }

        .room-filter-grid .form-group {
            margin: 0;
        }

        .room-name {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: #18352a;
            font-size: 13px;
            font-weight: 700;
        }

        .room-name-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: #eaf8f0;
            color: #078b48;
            font-size: 17px;
        }

        .room-count {
            color: #68786e;
            font-size: 12px;
        }

        .room-action-group {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .room-btn-sm {
            padding: 7px 10px;
            font-size: 11px;
        }

        .room-delete-disabled {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #87938b;
            font-size: 11px;
            font-weight: 700;
        }

        .room-empty-state {
            padding: 38px 15px;
            text-align: center;
            color: #718078;
        }

        .room-empty-state i {
            display: block;
            margin-bottom: 8px;
            color: #08a653;
            font-size: 38px;
        }

        .room-alert {
            margin-bottom: 16px;
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 13px;
        }

        .room-alert-success {
            color: #12683b;
            background: #eaf8f0;
            border: 1px solid #c8ead5;
        }

        .room-alert-error {
            color: #a52834;
            background: #fff0f1;
            border: 1px solid #f3c9cd;
        }

        /* MODAL */

        .room-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 2100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(20, 35, 24, .58);
            backdrop-filter: blur(3px);
        }

        .room-modal-overlay.is-open {
            display: flex;
        }

        .room-modal {
            width: 100%;
            max-width: 480px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            background: #fff;
            border: 1px solid #dceee2;
            border-radius: 17px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .2);
            animation: roomModalFade .2s ease;
        }

        @keyframes roomModalFade {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.985);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .room-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 23px;
            border-bottom: 1px solid #e7efe9;
        }

        .room-modal-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .room-modal-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: #eaf8f0;
            color: #078b48;
            font-size: 21px;
        }

        .room-modal-title {
            margin: 0;
            color: #18352a;
            font-size: 17px;
            font-weight: 800;
        }

        .room-modal-subtitle {
            margin: 2px 0 0;
            color: #718078;
            font-size: 11px;
        }

        .room-modal-close {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dce9df;
            border-radius: 9px;
            background: #fff;
            color: #62756a;
            font-size: 20px;
            cursor: pointer;
        }

        .room-modal-close:hover {
            background: #eaf8f0;
            color: #078b48;
            border-color: #08a653;
        }

        .room-modal-body {
            padding: 23px;
        }

        .room-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 16px 23px;
            border-top: 1px solid #e7efe9;
            background: #fbfdfb;
        }

        .room-modal-error {
            display: block;
            margin-top: 6px;
            color: #dc3545;
            font-size: 11px;
        }

        .room-modal-help {
            display: block;
            margin-top: 6px;
            color: #718078;
            font-size: 11px;
        }

        .room-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 18px;
        }

        .room-pagination a,
        .room-pagination span {
            min-width: 36px;
            height: 36px;
            padding: 0 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dceee2;
            border-radius: 8px;
            background: #fff;
            color: #078b48;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: .2s ease;
        }

        .room-pagination a:hover {
            background: #eaf8f0;
            border-color: #08a653;
        }

        .room-pagination .active {
            background: #078b48;
            color: #fff;
            border-color: #078b48;
        }

        .room-pagination .disabled {
            color: #a5afa9;
            background: #f7faf8;
            cursor: not-allowed;
        }

        @media (max-width: 760px) {
            .room-summary {
                grid-template-columns: 1fr 1fr;
            }

            .room-filter-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .room-summary {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .room-summary-card {
                padding: 14px;
            }

            .room-modal-overlay {
                padding: 10px;
            }

            .room-modal {
                max-height: calc(100vh - 20px);
            }

            .room-modal-header,
            .room-modal-body {
                padding: 17px;
            }

            .room-modal-footer {
                padding: 14px 17px;
            }
        }
    </style>

    {{-- HEADER HALAMAN --}}

    <div class="room-page-heading">
        <div>
            <span class="role">
                <i class="bx bx-building-house"></i>
                ADMINISTRASI
            </span>

            <h1 style="margin-top:10px;">Master Ruangan</h1>

            <p class="page-subtitle">
                Pengelolaan data ruangan dan unit kerja Mobil Cinta RSD Kalisat.
            </p>
        </div>

        <button type="button" class="btn btn-primary" id="openCreateRoom">
            <i class="bx bx-plus-circle"></i>
            Tambah Ruangan
        </button>
    </div>

    {{-- NOTIFIKASI --}}

    @if (session('status'))
        <div class="room-alert room-alert-success">
            <i class="bx bx-check-circle"></i>
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="room-alert room-alert-error">
            <i class="bx bx-error-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- RINGKASAN RUANGAN --}}

    <div class="room-summary">

        <div class="room-summary-card">
            <div class="room-summary-icon">
                <i class="bx bx-building-house"></i>
            </div>

            <div>
                <small>Total Ruangan</small>
                <strong>
                    {{ number_format($totalRuangan, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="room-summary-card">
            <div class="room-summary-icon">
                <i class="bx bx-link"></i>
            </div>

            <div>
                <small>Sudah Digunakan</small>
                <strong>
                    {{ number_format($ruanganTerpakai, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="room-summary-card">
            <div class="room-summary-icon">
                <i class="bx bx-check-shield"></i>
            </div>

            <div>
                <small>Belum Digunakan</small>
                <strong>
                    {{ number_format($ruanganBelumTerpakai, 0, ',', '.') }}
                </strong>
            </div>
        </div>

    </div>

    {{-- DAFTAR RUANGAN --}}

    <section class="card card-accent">

        <h2 class="section-heading" style="margin-top:0;">
            <i class="bx bx-list-ul" style="color:#08A653;"></i>
            Daftar Ruangan
        </h2>

        {{-- PENCARIAN --}}

        <form method="GET" action="{{ route('mobil-cinta.admin.ruangan.index') }}">
            <div class="room-filter-grid">

                <div class="form-group">
                    <label class="form-label" for="roomSearch">
                        Cari Nama Ruangan
                    </label>

                    <input type="text" id="roomSearch" name="q" value="{{ $search }}"
                        placeholder="Masukkan nama ruangan..." autocomplete="off">
                </div>

                <div class="room-action-group">

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-search"></i>
                        Cari
                    </button>

                    <a href="{{ route('mobil-cinta.admin.ruangan.index') }}" class="btn btn-outline">
                        Reset
                    </a>

                </div>

            </div>
        </form>

        {{-- TABEL RUANGAN --}}

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th width="60">No.</th>
                        <th>Nama Ruangan</th>
                        <th>Riwayat Perjalanan</th>
                        <th width="210">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($ruangans as $ruangan)
                        <tr>

                            <td>
                                {{ $ruangans->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <span class="room-name">
                                    <span class="room-name-icon">
                                        <i class="bx bx-building-house"></i>
                                    </span>

                                    {{ $ruangan->nama_ruangan }}
                                </span>
                            </td>

                            <td>
                                <span class="room-count">
                                    {{ number_format($ruangan->journeys_count, 0, ',', '.') }}
                                    perjalanan
                                </span>
                            </td>

                            <td>

                                <div class="room-action-group">

                                    <button type="button" class="btn btn-outline room-btn-sm js-edit-room"
                                        data-id="{{ $ruangan->id }}" data-name="{{ $ruangan->nama_ruangan }}">
                                        <i class="bx bx-edit"></i>
                                        Edit
                                    </button>

                                    @if ((int) $ruangan->journeys_count === 0)
                                        <form method="POST"
                                            action="{{ route('mobil-cinta.admin.ruangan.destroy', $ruangan) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus ruangan {{ $ruangan->nama_ruangan }}?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger room-btn-sm">
                                                <i class="bx bx-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="room-delete-disabled"
                                            title="Ruangan sudah memiliki riwayat perjalanan">
                                            <i class="bx bx-lock-alt"></i>
                                            Terkunci
                                        </span>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4">
                                <div class="room-empty-state">
                                    <i class="bx bx-building-house"></i>

                                    <strong>
                                        Data ruangan tidak ditemukan
                                    </strong>

                                    <p>
                                        Tambahkan ruangan baru atau ubah kata kunci pencarian.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}

        @if ($ruangans->hasPages())
            <nav class="room-pagination" aria-label="Navigasi halaman">

                @if ($ruangans->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $ruangans->previousPageUrl() }}">
                        ‹
                    </a>
                @endif

                @foreach ($ruangans->getUrlRange(max(1, $ruangans->currentPage() - 2), min($ruangans->lastPage(), $ruangans->currentPage() + 2)) as $page => $url)
                    @if ($page == $ruangans->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($ruangans->hasMorePages())
                    <a href="{{ $ruangans->nextPageUrl() }}">
                        ›
                    </a>
                @else
                    <span class="disabled">›</span>
                @endif

            </nav>
        @endif

        <p class="page-subtitle" style="margin-top:12px;">
            Menampilkan {{ $ruangans->count() }}
            dari {{ $ruangans->total() }} ruangan.
        </p>

    </section>

    {{-- MODAL TAMBAH DAN EDIT RUANGAN --}}

    <div class="room-modal-overlay" id="roomModal" aria-hidden="true">
        <div class="room-modal" role="dialog" aria-modal="true" aria-labelledby="roomModalTitle">

            <div class="room-modal-header">

                <div class="room-modal-title-wrap">

                    <div class="room-modal-icon">
                        <i class="bx bx-building-house"></i>
                    </div>

                    <div>
                        <h2 class="room-modal-title" id="roomModalTitle">
                            Tambah Ruangan
                        </h2>

                        <p class="room-modal-subtitle" id="roomModalSubtitle">
                            Masukkan nama ruangan baru.
                        </p>
                    </div>

                </div>

                <button type="button" class="room-modal-close" id="closeRoomModal" aria-label="Tutup modal">
                    <i class="bx bx-x"></i>
                </button>

            </div>

            <form id="roomForm" method="POST" action="{{ route('mobil-cinta.admin.ruangan.store') }}">
                @csrf

                <input type="hidden" name="_method" id="roomMethod" value="PUT" disabled>

                <input type="hidden" name="_form_context" id="roomFormContext" value="room-create">

                <input type="hidden" name="ruangan_id" id="roomId" value="">

                <div class="room-modal-body">

                    <div class="form-group" style="margin-bottom:0;">

                        <label class="form-label" for="roomNameInput">
                            Nama Ruangan
                        </label>

                        <input type="text" name="nama_ruangan" id="roomNameInput" maxlength="50"
                            placeholder="Contoh: RUANG RAWAT INAP" autocomplete="off" required>

                        <small class="room-modal-help">
                            Nama ruangan maksimal 50 karakter.
                        </small>

                        @error('nama_ruangan')
                            <small class="room-modal-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

                <div class="room-modal-footer">

                    <button type="button" class="btn btn-outline" id="cancelRoomModal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary" id="saveRoomButton">
                        <i class="bx bx-save"></i>
                        Simpan Ruangan
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('roomModal');
            const form = document.getElementById('roomForm');
            const input = document.getElementById('roomNameInput');

            const methodInput = document.getElementById('roomMethod');
            const contextInput = document.getElementById('roomFormContext');
            const roomIdInput = document.getElementById('roomId');

            const title = document.getElementById('roomModalTitle');
            const subtitle = document.getElementById('roomModalSubtitle');
            const saveButton = document.getElementById('saveRoomButton');

            if (!modal || !form || !input) {
                return;
            }

            const storeUrl = @json(route('mobil-cinta.admin.ruangan.store'));

            const updateUrlTemplate = @json(route('mobil-cinta.admin.ruangan.update', ['ruangan' => '__ROOM__']));

            let lastTrigger = null;

            function openModal(mode, data = {}, trigger = null) {

                lastTrigger = trigger || lastTrigger;

                if (mode === 'edit') {

                    title.textContent = 'Edit Ruangan';
                    subtitle.textContent = 'Perbarui nama ruangan.';
                    saveButton.innerHTML = '<i class="bx bx-save"></i> Simpan Perubahan';

                    form.action = updateUrlTemplate.replace(
                        '__ROOM__',
                        encodeURIComponent(String(data.id))
                    );

                    methodInput.disabled = false;
                    methodInput.value = 'PUT';

                    contextInput.value = 'room-edit';
                    roomIdInput.value = data.id;
                    input.value = data.name || '';

                } else {

                    title.textContent = 'Tambah Ruangan';
                    subtitle.textContent = 'Masukkan nama ruangan baru.';
                    saveButton.innerHTML = '<i class="bx bx-save"></i> Simpan Ruangan';

                    form.action = storeUrl;

                    methodInput.disabled = true;
                    methodInput.value = 'PUT';

                    contextInput.value = 'room-create';
                    roomIdInput.value = '';
                    input.value = '';
                }

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';

                setTimeout(function() {
                    input.focus();
                }, 80);
            }

            function closeModal() {

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';

                if (lastTrigger) {
                    lastTrigger.focus();
                }
            }

            document
                .getElementById('openCreateRoom')
                ?.addEventListener('click', function() {
                    openModal('create', {}, this);
                });

            document.querySelectorAll('.js-edit-room')
                .forEach(function(button) {

                    button.addEventListener('click', function() {

                        openModal('edit', {
                            id: this.dataset.id,
                            name: this.dataset.name
                        }, this);

                    });

                });

            document
                .getElementById('closeRoomModal')
                ?.addEventListener('click', closeModal);

            document
                .getElementById('cancelRoomModal')
                ?.addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {

                if (event.target === modal) {
                    closeModal();
                }

            });

            document.addEventListener('keydown', function(event) {

                if (
                    event.key === 'Escape' &&
                    modal.classList.contains('is-open')
                ) {
                    closeModal();
                }

            });

            const oldContext = @json(old('_form_context'));
            const oldRoomId = @json(old('ruangan_id'));
            const oldName = @json(old('nama_ruangan', ''));

            if (oldContext === 'room-create') {

                openModal('create');
                input.value = oldName;

            } else if (oldContext === 'room-edit' && oldRoomId) {

                const editButton = Array.from(
                    document.querySelectorAll('.js-edit-room')
                ).find(function(button) {
                    return button.dataset.id === String(oldRoomId);
                });

                if (editButton) {

                    openModal('edit', {
                        id: oldRoomId,
                        name: oldName || editButton.dataset.name
                    }, editButton);

                }
            }

        });
    </script>
@endpush

@extends('template')

@section('content')
<style>
    .sticky-col-day {
        position: sticky;
        left: 0;
        background-color: #f8f9fa !important;
        z-index: 10;
        width: 100px;
        min-width: 100px;
        border-right: 2px solid #dee2e6 !important;
    }
    .sticky-col-time {
        position: sticky;
        left: 100px;
        background-color: #f8f9fa !important;
        z-index: 10;
        width: 130px;
        min-width: 130px;
        border-right: 2px solid #dee2e6 !important;
    }
    /* Sticky headers (z-index needs to be higher to float over sticky column body cells) */
    th.sticky-col-day {
        z-index: 110 !important;
        background-color: #212529 !important;
        color: #fff !important;
    }
    th.sticky-col-time {
        z-index: 110 !important;
        background-color: #212529 !important;
        color: #fff !important;
    }
</style>

<div class="container-fluid p-0">
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3><strong>{{ $title }}</strong></h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
            <a href="{{ route('jadwal') }}" class="btn btn-secondary me-1">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button id="btnSaveJadwal" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan Jadwal
            </button>
        </div>
    </div>

    <!-- Alert Panel -->
    <div class="alert alert-info border-0 shadow-sm mb-3">
        <div class="alert-message">
            <i class="fas fa-info-circle me-2"></i><strong>Petunjuk Editor:</strong> 
            Pilihlah Guru & Mata Pelajaran pada sel rombel kelas yang sesuai. Sistem akan secara otomatis mendeteksi bentrok jika Guru yang sama dijadwalkan mengajar pada slot waktu yang sama di rombel kelas yang berbeda.
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title text-white mb-0">Matriks Penyusunan Jadwal Pembelajaran</h5>
                </div>
                <div class="card-body p-0">
                    <form id="formJadwal">
                        @csrf
                        <input type="hidden" name="version_id" value="{{ $version->id }}">
                        
                        <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                            <table class="table table-bordered table-striped table-hover align-middle mb-0" style="min-width: 1200px;">
                                <thead class="table-dark sticky-top" style="z-index: 100;">
                                    <tr>
                                        <th style="width: 100px;" class="text-center sticky-col-day">Hari</th>
                                        <th style="width: 130px;" class="text-center sticky-col-time">Waktu</th>
                                        @foreach($rombels as $rombel)
                                            @php
                                                $alias = '';
                                                $badgeClass = 'bg-secondary';
                                                if ($rombel->jurusan) {
                                                    $namaJurusan = $rombel->jurusan->kons_keahlian;
                                                    if (str_contains(strtolower($namaJurusan), 'akuntansi')) {
                                                        $alias = 'AKL';
                                                        $badgeClass = 'bg-success';
                                                    } elseif (str_contains(strtolower($namaJurusan), 'perangkat') || str_contains(strtolower($namaJurusan), 'pplg') || str_contains(strtolower($namaJurusan), 'rpl')) {
                                                        $alias = 'PPLG';
                                                        $badgeClass = 'bg-primary';
                                                    } else {
                                                        $alias = $rombel->jurusan->kode_nomenklatur;
                                                    }
                                                }
                                            @endphp
                                            <th class="text-center">
                                                {{ $rombel->nama_rombel }}<br>
                                                <span class="badge {{ $badgeClass }} fw-normal">{{ $alias }}</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentDay = '';
                                    @endphp
                                    @foreach($slotWaktus as $slot)
                                        <tr>
                                            <!-- Hari Column with Rowspan Grouping -->
                                            @if($currentDay !== $slot->hari)
                                                @php
                                                    $dayCount = $slotWaktus->where('hari', $slot->hari)->count();
                                                    $currentDay = $slot->hari;
                                                @endphp
                                                <td rowspan="{{ $dayCount }}" class="text-center fw-bold align-middle text-primary sticky-col-day">
                                                    {{ strtoupper($slot->hari) }}
                                                </td>
                                            @endif

                                            <!-- Waktu / Jam ke Column -->
                                            <td class="text-center sticky-col-time">
                                                @if($slot->is_istirahat)
                                                    <span class="text-muted fw-bold">ISTIRAHAT</span>
                                                @else
                                                    <span class="fw-bold">Jam ke-{{ $slot->jam_ke }}</span>
                                                @endif
                                                <br>
                                                <small class="text-muted">{{ substr($slot->waktu_mulai, 0, 5) }} - {{ substr($slot->waktu_selesai, 0, 5) }}</small>
                                            </td>

                                            <!-- Rombel Cells -->
                                            @if($slot->is_istirahat)
                                                <!-- Istirahat spans across all rombel columns -->
                                                <td colspan="{{ $rombels->count() }}" class="text-center bg-warning-subtle py-2 text-warning-emphasis fw-bold text-uppercase tracking-wider">
                                                    -- Istirahat / Sela KBM --
                                                </td>
                                            @else
                                                @foreach($rombels as $rombel)
                                                    @php
                                                        $options = $pembelajaranData->get($rombel->id, collect());
                                                        $selectedAssignment = isset($currentJadwal[$slot->id][$rombel->id]) 
                                                            ? $currentJadwal[$slot->id][$rombel->id]->pembelajaran_id 
                                                            : null;
                                                    @endphp
                                                    <td class="cell-jadwal" style="padding: 0; min-width: 160px; vertical-align: stretch;">
                                                        @php
                                                            $selectedItem = isset($currentJadwal[$slot->id][$rombel->id]) 
                                                                ? $currentJadwal[$slot->id][$rombel->id]->pembelajaran 
                                                                : null;
                                                        @endphp
                                                        <div class="jadwal-display py-2 px-1 text-center" style="cursor: pointer; min-height: 48px; display: flex; flex-direction: column; justify-content: center;">
                                                            @if($selectedItem)
                                                                <div class="fw-bold text-dark text-truncate" style="font-size: 8pt; line-height: 1.2;" title="{{ $selectedItem->mataPelajaran->kode_mapel }} - {{ $selectedItem->mataPelajaran->nama_mapel }}">
                                                                    {{ $selectedItem->mataPelajaran->kode_mapel }} - {{ $selectedItem->mataPelajaran->nama_mapel }}
                                                                </div>
                                                                <div class="text-muted text-truncate mt-1" style="font-size: 7.2pt; line-height: 1.1;" title="{{ $selectedItem->guru->nama_lengkap ?? '' }}">
                                                                    {{ $selectedItem->guru->nama_lengkap ?? 'Tanpa Guru' }}
                                                                </div>
                                                            @else
                                                                <span class="text-muted" style="font-size: 7.5pt;">- Kosong -</span>
                                                            @endif
                                                        </div>
                                                        <select name="assignments[{{ $slot->id }}][{{ $rombel->id }}]" class="form-select form-select-sm select-jadwal d-none" style="font-size: 8.5pt; width: 100%; height: 100%;">
                                                            <option value="" data-mapel="- Kosong -" data-guru="">- Batal / Kosong -</option>
                                                            @foreach($options as $p)
                                                                <option value="{{ $p->id }}" {{ $selectedAssignment == $p->id ? 'selected' : '' }}
                                                                    data-mapel="{{ $p->mataPelajaran->kode_mapel }} - {{ $p->mataPelajaran->nama_mapel }}"
                                                                    data-guru="{{ $p->guru->nama_lengkap ?? 'Tanpa Guru' }}">
                                                                    {{ $p->mataPelajaran->kode_mapel }} - {{ $p->guru->nama_lengkap ?? 'Tanpa Guru' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnSave = document.getElementById('btnSaveJadwal');
        
        btnSave.addEventListener('click', function() {
            // Show loader
            const loader = document.getElementById('loader');
            if (loader) loader.style.display = 'flex';

            const form = document.getElementById('formJadwal');
            const formData = new FormData(form);

            fetch("{{ route('jadwal.save') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => {
                if (loader) loader.style.display = 'none';
                return response.json().then(data => ({ status: response.status, body: data }));
            })
            .then(({ status, body }) => {
                if (status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: body.message,
                        confirmButtonColor: '#3b7ddd'
                    }).then(() => {
                        window.location.reload();
                    });
                } else if (status === 422) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal (Bentrok)',
                        text: body.message,
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: body.message || 'Terjadi kesalahan sistem.',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                if (loader) loader.style.display = 'none';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kegagalan koneksi atau server.',
                    confirmButtonColor: '#d33'
                });
                console.error(error);
            });
        });

        // In-place click-to-edit triggers
        document.querySelectorAll('.jadwal-display').forEach(display => {
            display.addEventListener('click', function() {
                // Close other open selects
                document.querySelectorAll('.select-jadwal:not(.d-none)').forEach(sel => {
                    sel.dispatchEvent(new Event('blur'));
                });

                const td = this.closest('td');
                const select = td.querySelector('.select-jadwal');
                this.classList.add('d-none');
                select.classList.remove('d-none');
                select.focus();
            });
        });

        document.querySelectorAll('.select-jadwal').forEach(select => {
            const handleClose = function() {
                const td = this.closest('td');
                const display = td.querySelector('.jadwal-display');
                const selectedOption = this.options[this.selectedIndex];
                
                const mapel = selectedOption.getAttribute('data-mapel');
                const guru = selectedOption.getAttribute('data-guru');

                if (this.value === '') {
                    display.innerHTML = '<span class="text-muted" style="font-size: 7.5pt;">- Kosong -</span>';
                } else {
                    display.innerHTML = `
                        <div class="fw-bold text-dark text-truncate" style="font-size: 8pt; line-height: 1.2;" title="${mapel}">${mapel}</div>
                        <div class="text-muted text-truncate mt-1" style="font-size: 7.2pt; line-height: 1.1;" title="${guru}">${guru}</div>
                    `;
                }

                this.classList.add('d-none');
                display.classList.remove('d-none');
            };

            select.addEventListener('change', handleClose);
            select.addEventListener('blur', handleClose);
        });
    });
</script>
@endpush

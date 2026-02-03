<!-- Modal Detail Perizinan -->
<div class="modal fade" id="student-permission-modal-{{ $permission->id }}" tabindex="-1" aria-labelledby="permissionModalLabel-{{ $permission->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
            <div class="modal-header px-4 py-3"
                style="background-color: #098FC6; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title text-white fw-semibold" id="permissionModalLabel-{{ $permission->id }}" style="font-size: 1.1rem;">
                    Lihat Perizinan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) brightness(200%); opacity: 1;"></button>
            </div>
            <div class="modal-body p-4">
                @php
                    $student = $permission->student;
                    $permissionTypeLabel = \App\Enums\PermissionTypeEnum::tryFrom($permission->permission_type)?->label() ?? ucfirst($permission->permission_type);
                     
                    $typeColors = [
                        'sick' => ['bg' => '#FFF4E5', 'text' => '#FA896B'],
                        'permit' => ['bg' => '#E8F7FF', 'text' => '#5D87FF'],
                        'dinas' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                        'other' => ['bg' => '#F5F5F5', 'text' => '#6B7280'],
                    ];
                    $currentTypeColor = $typeColors[$permission->permission_type] ?? $typeColors['other'];
                @endphp
                
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Siswa</label>
                    <input type="text" class="form-control" value="{{ $student?->user?->name ?? 'N/A' }}" readonly
                        style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($permission->date)->locale('id')->translatedFormat('d/m/Y') }}" readonly
                                style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                            <i
                                class="ti ti-calendar position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Durasi</label>
                        <input type="text" class="form-control" value="{{ $permission->duration ?? 1 }} Hari" readonly
                            style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                    </div> -->
                </div>

                <div class="row mb-4 align-items-start">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Alasan Izin</label>
                        <textarea class="form-control" rows="2" readonly
                            style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280; resize: none;">{{ $permission->proof ?? '-' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark d-block">Jenis Izin</label>
                        <span class="badge px-4 py-2 rounded-2 fw-semibold"
                            style="background-color: {{ $currentTypeColor['bg'] }}; color: {{ $currentTypeColor['text'] }}; font-size: 0.9rem;">{{ $permissionTypeLabel }}</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark">Surat/Bukti Izin</label>
                    <div class="rounded-3 overflow-hidden" style="max-width: 100%; height: auto;">
                        @if($permission->proof_image)
                            <img src="{{ asset('storage/' . $permission->proof_image) }}" class="img-fluid rounded-3"
                                alt="Bukti Izin" style="width: 300px; max-height: 300px; object-fit: cover;">
                        @else
                            <div class="text-muted d-flex align-items-center justify-content-center border rounded-3" 
                                style="width: 300px; height: 200px; background-color: #f5f5f5;">
                                <div class="text-center">
                                    <i class="ti ti-file-x fs-1 d-block mb-2"></i>
                                    <span>Tidak ada bukti</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($permission->status === 'pending')
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <form action="{{ route('teacher.classroom-permission.reject', $permission->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="classroom" value="{{ $permission->classroom_id }}">
                            <button type="submit" class="btn text-white px-5 py-2"
                                style="background-color: #DC3545; border-radius: 8px; font-weight: 500;">Tolak</button>
                        </form>
                        <form action="{{ route('teacher.classroom-permission.approve', $permission->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="classroom" value="{{ $permission->classroom_id }}">
                            <button type="submit" class="btn text-white px-5 py-2"
                                style="background-color: #13DEB9; border-radius: 8px; font-weight: 500;">Setujui</button>
                        </form>
                    </div>
                @else
                    <div class="d-flex justify-content-center mt-4">
                        @php
                            $statusColors = [
                                'pending' => ['bg' => '#FFF4E5', 'text' => '#FFAE1F'],
                                'approved' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                                'rejected' => ['bg' => '#FBE4E4', 'text' => '#FA5A7D'],
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'approved' => 'Disetujui', 
                                'rejected' => 'Ditolak',
                            ];
                            $currentStatus = $statusColors[$permission->status] ?? $statusColors['pending'];
                            $currentStatusLabel = $statusLabels[$permission->status] ?? 'Menunggu';
                        @endphp
                        <span class="badge px-5 py-3 rounded-2 fw-semibold fs-4"
                            style="background-color: {{ $currentStatus['bg'] }}; color: {{ $currentStatus['text'] }};">
                            Status: {{ $currentStatusLabel }}
                        </span>
                    </div>
                    @if($permission->approvedBy)
                        <div class="text-center mt-2 text-muted">
                            <small>Diproses oleh: {{ $permission->approvedBy->name ?? 'N/A' }}</small>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

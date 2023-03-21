@extends('layouts.landing.master')
@section('title', 'Pengaduan Saya')
<style>
    #mainNav {
        background-color: #212529 !important;
    }
</style>
@section('content')

    <section class="page-section mt-5" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Data Pengaduan Saya</h2>
            </div>
            <div class="row text-center">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Tanggapan</th>
                                <th>Status Pengaduan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{!! $complaint->description !!}</td>
                                    <td>
                                        @if($complaint->status == 'PENDING')
                                            <span class="badge alert-warning">PENDING</span>
                                        @elseif($complaint->status == 'REJECTED')
                                        <span class="badge alert-danger">REJECTED</span>
                                        @elseif($complaint->status == 'DONE')
                                        <span class="badge alert-success">DONE</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" target="_blank"><img src="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" style="max-height:200px;max-width:100px;"></a></td>
                                    <td>
                                        @if($complaint->responses()->count() > 0)
                                            <ol>
                                                @foreach($complaint->responses()->get() as $response)
                                                    <li>{!! $response->response !!}</li>
                                                    @if($response->file)
                                                    <a href="{{ Storage::disk('local')->url('response-file/'. $response->file) }}" target="_blank"><i class="fas fa-eye"></i> File Lampiran</a>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @else
                                            Belum ada tanggapan
                                        @endif
                                    </td>
                                    <td>
                                            @if($complaint->status_pengaduan == 'belum_selesai')
                                                <span class="btn btn-warning btn-xs">Belum Selesai</span>
                                            @elseif($complaint->status_pengaduan == 'selesai')
                                            <span class="btn btn-success btn-xs">Selesai</span>
                                            @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm" data-bs-target="#update-status" data-bs-toggle="modal"
                                        data-id="{{ $complaint->id }}" data-status_pengaduan="{{ $complaint->status_pengaduan }}"><i class="fas fa-pencil-alt"></i> Ubah Status Pengaduan</a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    
<div class="modal fade" id="update-status" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('landing.my_complaint.update_status') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status Pengaduan</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_pengaduan">Status Pengaduan</label>
                        <select name="status_pengaduan" id="status_pengaduan" class="form-control" required>
                            <option value="">~ Pilih ~</option>
                            <option value="belum_selesai">Belum Selesai</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#update-status').on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var status_pengaduan = $(e.relatedTarget).data('status_pengaduan');
            
            $('#update-status').find('input[name="id"]').val(id);
            $('#update-status').find('select[name="status_pengaduan"]').val(status_pengaduan);
        });
    });
</script>
@endpush
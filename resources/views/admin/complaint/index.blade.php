@extends('layouts.admin.master')
@section('content')
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.cs"> --}}
<div class="midde_cont">
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Data Pengaduan</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- table section -->
            <div class="col-md-12">
               <div class="white_shd full margin_bottom_30">
                  <div class="full graph_head">
                     <div class="heading1 margin_0">
                        <form action="{{ route('complaint.index') }}" method="GET" id="search-q-form">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Cari ..." name="q" value="{{ request()->q }}">
                                <div class="input-group-append">
                                    <span class="input-group-text" onclick="document.getElementById('search-q-form').submit();" style="cursor: pointer;">Cari</span>
                                </div>
                            </div>
                        </form>
                     </div>
                  </div>
                  <div class="table_section padding_infor_info">
                     <div class="table-responsive-sm">
                        <table class="table table-hover" id="datatable">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Nama Pengadu</th>
                                 <th>Judul</th>
                                 <th>Keterangan</th>
                                 <th>Gambar</th>
                                 <th>Status</th>
                                 <th>Tanggapan</th>
                                 <th>Aksi</th>
                              </tr>
                           </thead>
                           <tbody>
                            @foreach($complaints as $key => $complaint)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $complaint->user->name }}</td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{!! $complaint->description !!}</td>
                                    <td><a target="_blank" href="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}">Lihat</a></td>
                                    <td>
                                        @if($complaint->status == 'PENDING')
                                            <span class="btn btn-warning btn-xs">PENDING</span>
                                        @elseif($complaint->status == 'REJECTED')
                                        <span class="btn btn-danger btn-xs">REJECTED</span>
                                        @elseif($complaint->status == 'DONE')
                                        <span class="btn btn-success btn-xs">DONE</span>
                                        @endif
                                    </td>
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
                                        <table>
                                            <tr>
                                                <td><a href="{{ route('complaint.make_response', $complaint->code) }}"><i class="fa fa-eye"></i> Tanggapi</a></td>
                                                <td><a href="#" data-toggle="modal" data-target="#delete" data-code="{{ $complaint->code }}"><i class="fa fa-trash"></i> Hapus</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>
                        </table>
                     </div>
                     {{ $complaints->appends(request()->all())->links('pagination::bootstrap-4') }}
                  </div>
               </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('complaint.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="code">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Pengaduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Data Pengaduan ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
    @include('layouts.admin.footer')
</div>
@endsection
@push('scripts')
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}
<script>
    $('#delete').on('show.bs.modal', (e) => {
        var code = $(e.relatedTarget).data('code');
        $('#delete').find('input[name="code"]').val(code);
    });
    $('#datatable').DataTable();
</script>
@endpush
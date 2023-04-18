@extends('layouts.admin.master')
@section('title', 'Data Pengaduan')
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
        <form action="{{ route('complaint.index') }}" method="GET">
            <div class="row no-gutters">
                <div class="col-lg-3 col-md-2 col-sm-12">
                    <label for="filter">Filter</label>
                    <select name="filter" id="filter" class="form-control">
                        <option value="">~ Pilih ~</option>
                        <option value="mingguan" {{ request()->filter == 'mingguan' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulanan" {{ request()->filter == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahunan" {{ request()->filter == 'tahunan' ? 'selected' : '' }}>Tahun ini</option>
                        <option value="date_range" {{ request()->filter == 'date_range' ? 'selected' : '' }}>Rentang Tanggal</option>
                    </select>
                </div>
                <div class="col-lg-3 date-range d-none ml-1">
                    <label for="from">Dari Tanggal</label>
                    <input type="date" name="from" id="from" value="{{ request()->from }}" class="form-control" required>
                </div>
                <div class="col-lg-3 date-range d-none ml-1">
                    <label for="to">Sampai Tanggal</label>
                    <input type="date" name="to" id="to" value="{{ request()->to }}" class="form-control" required>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-4 ml-1">
                    <label for="filter" style="opacity: 0;">Submit</label><br>
                    <button type="submit" id="filter" class="btn btn-primary btn-md">Filter</button>
                </form>
                <form action="{{ route('complaint.export_pdf') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="filter" value="{{ request()->filter }}">
                    <input type="hidden" name="from" value="{{ request()->from }}">
                    <input type="hidden" name="to" value="{{ request()->to }}">
                    <button type="submit" id="export_pdf" class="btn btn-success btn-md"><i class="fa fa-download"></i> Export PDF</button>
                </form>
                </div>
            </div>
        <div class="row mt-3">
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
                                 <th>Link Video</th>
                                 <th>Gambar</th>
                                 <th>Status</th>
                                 <th>Ditanggapi Oleh</th>
                                 <th>Tanggapan</th>
                                 <th>Status Pengaduan</th>
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
                                    <td><a target="_blank" href="{{ $complaint->link_video }}">{{ $complaint->link_video }}</a></td>
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
                                    <td>{{ $complaint->responded_by ? $complaint->respondedBy->name : 'Belum ada tanggapan' }}</td>
                                    <td>
                                        
                                        @if($complaint->responses()->count() > 0 && $complaint->responded_by)
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
                                        <table>
                                            <tr>
                                                <td>
                                                    @if(auth()->user()->role == 'user' && checkComplaintRespondedUser($complaint->id) > 0)
                                                        <a href="#" data-toggle="modal" data-target="#modalAlert"><i class="fa fa-eye"></i> Tanggapi</a>
                                                    @else
                                                        <a href="{{ route('complaint.make_response', $complaint->code) }}"><i class="fa fa-eye"></i> Tanggapi</a>
                                                    @endif
                                                </td>
                                                <td><a href="#" data-toggle="modal" data-target="#delete" data-code="{{ $complaint->code }}"><i class="fa fa-trash"></i> Hapus</a></td>
                                                @if(auth()->user()->role == 'admin')
                                                    <td>
                                                        <a href="#" class="btn btn-primary btn-sm" data-target="#update-status" data-toggle="modal"
                                                        data-id="{{ $complaint->id }}" data-status_pengaduan="{{ $complaint->status_pengaduan }}"><i class="fa fa-edit"></i> Ubah Status Pengaduan</a>
                                                    </td>
                                                @endif
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
    
<div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('complaint.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="code">
                <div class="modal-header">
                    <h5 class="modal-title">Perhatian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Anda belum dapat menanggapi pengaduan ini dikarenakan masih terdapat status pengaduan yang belum selesai pada pengaduan yang lain
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

<div class="modal fade" id="update-status" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('landing.my_complaint.update_status') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status Pengaduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
{{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}
<script>
    $(document).ready(function() {
        CheckDateRange();
        $('#delete').on('show.bs.modal', (e) => {
            var code = $(e.relatedTarget).data('code');
            $('#delete').find('input[name="code"]').val(code);
        });
        $("#filter").on('change', function() {
            let val = $(this).find('option:selected').val()
            if(val == 'date_range') {
                $(".date-range").removeClass('d-none');
                $('#from').prop('required', true);
                $('#to').prop('required', true);
            }else{
                $(".date-range").addClass('d-none');
                $('#from').prop('required', false);
                $('#to').prop('required', false);
                $('#from').val('');
                $('#to').val('');
            }
        })
        function CheckDateRange(){
            let from = $('#from').val();
            let to = $('#to').val();
            if(from != '' || to != ''){
                $(".date-range").removeClass('d-none');
            }
        }
        
        $('#update-status').on('show.bs.modal', (e) => {
            var id = $(e.relatedTarget).data('id');
            var status_pengaduan = $(e.relatedTarget).data('status_pengaduan');
            
            $('#update-status').find('input[name="id"]').val(id);
            $('#update-status').find('select[name="status_pengaduan"]').val(status_pengaduan);
        });
    });
</script>
@endpush
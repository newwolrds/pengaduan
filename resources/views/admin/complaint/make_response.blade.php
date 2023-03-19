@extends('layouts.admin.master')
@section('content')

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
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header"><a class="btn btn-primary btn-xs" href="#" data-toggle="modal" data-target="#change_status"><i class="fa fa-exchange"></i> Ubah Status Pengaduan</a></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Status Pengaduan</th>
                                    <th>:</th>
                                    <th>
                                        @if($complaint->status == 'PENDING')
                                            <span class="btn btn-warning btn-xs">PENDING</span>
                                        @elseif($complaint->status == 'REJECTED')
                                        <span class="btn btn-danger btn-xs">REJECTED</span>
                                        @elseif($complaint->status == 'DONE')
                                        <span class="btn btn-success btn-xs">DONE</span>
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>Nama Pengadu</th>
                                    <th>:</th>
                                    <th>{{ $complaint->user->name }}</th>
                                </tr>
                                <tr>
                                    <th>Judul</th>
                                    <th>:</th>
                                    <th>{{ $complaint->title }}</th>
                                </tr>
                                <tr>
                                    <th>Keterangan Lengkap</th>
                                    <th>:</th>
                                    <th>{!! $complaint->description !!}</th>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <th>:</th>
                                    <th>{{ Carbon\Carbon::parse($complaint->created_at)->isoFormat('dddd, D MMMM Y') }} {{ date('H:i', strtotime($complaint->created_at)) }}</th>
                                </tr>
                                <tr>
                                    <th>Gambar Penjelas</th>
                                    <th>:</th>
                                    <th><a target="_blank" href="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image ) }}"><img src="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image ) }}" style="min-height:200px;max-height:200px;width:100%;"></a></th>
                                </tr>
                                <tr>
                                    <th>Kategori Pengaduan</th>
                                    <th>:</th>
                                    <th>
                                        @if($complaint->level == 'rendah')
                                            <span class="btn btn-info btn-xs">{{ ucFirst($complaint->level) }}</span>
                                        @elseif($complaint->level == 'sedang')
                                            <span class="btn btn-warning btn-xs">{{ ucFirst($complaint->level) }}</span>
                                        @elseif($complaint->level == 'tinggi')
                                            <span class="btn btn-danger btn-xs">{{ ucFirst($complaint->level) }}</span>
                                        @endif
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 mt-2">
                <div class="card">
                    <div class="card-body">     
                        <form action="{{ route('complaint.store_response') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">
                            <div class="form-group">
                                <label for="response"><h5>Tanggapan</h5></label>
                                <textarea name="response" id="response" cols="5" class="form-control @error('response') is-invalid @enderror">{!! old('response') !!}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="response"><h5>Lampiran</h5> <small>*Optional</small></label>
                                <input type="file" name="file" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Tanggapi</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card mt-2">
                    <div class="card-header">Riwayat Tanggapan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggapan</th>
                                        <th>Lampiran</th>
                                        <th>Dibuat Pada</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($responses as $key =>  $response)
                                        <tr>
                                            <td>{!! $response->response !!}</td>
                                            <td>
                                                @if($response->file)
                                                <a class="btn btn-primary btn-xs" href="{{ Storage::disk('local')->url('response-file/'. $response->file) }}" target="_blank"><i class="fa fa-eye"></i> File Lampiran</a>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($response->created_at)->isoFormat('dddd, D MMMM Y') }} {{ date('H:i', strtotime($response->created_at)) }}</td>
                                            <td><a href="#" data-toggle="modal" data-target="#delete" data-id="{{ $response->id }}"><i class="fa fa-trash"></i> Hapus</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    @include('layouts.admin.footer')
</div>

<div class="modal fade" id="change_status" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('complaint.change_status') }}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="id" value="{{ $complaint->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status Pengaduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="status" id="status" class="form-control">
                        <option value="">~ Pilih ~</option>
                        <option value="PENDING" {{ $complaint->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                        <option value="REJECTED" {{ $complaint->status == 'REJECTED' ? 'selected' : '' }}>REJECTED</option>
                        <option value="DONE" {{ $complaint->status == 'DONE' ? 'selected' : '' }}>DONE</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('response.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Tanggapan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus Data Tanggapan ini ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script>
  
  ClassicEditor
  .create(document.querySelector('#response'), {
      removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed','Link'],
  })
  .catch( error => {
      console.error( error );
  } );
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        $('#delete').find('input[name="id"]').val(id);
    });
    
</script>
@endpush
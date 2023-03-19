@extends('layouts.landing.master')
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
    
@endsection
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
                                    <td>{{ $complaint->status }}</td>
                                    <td><a href="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" target="_blank"><img src="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" style="max-height:200px;max-width:100px;"></a></td>
                                    <td>{{ $complaint->responses()->count() > 0 ? $complaint->responses()->first()->response : 'Belum ada tanggapan' }}</td>
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
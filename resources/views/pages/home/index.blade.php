@extends('layouts.landing.master')
@section('content')

    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading"></div>
            <div class="masthead-heading text-uppercase">Pengaduan Masyarakat</div>
            @guest
            <a class="btn btn-primary btn-xl text-uppercase" href="{{ route('login') }}">Buat Pengaduan</a>
            @else
            <a class="btn btn-primary btn-xl text-uppercase" href="#contact">Buat Pengaduan</a>
            @endguest
        </div>
    </header>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Alur Pengaduan</h2>
                {{-- <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3> --}}
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Daftar Akun Pengaduan</h4>
                    <p class="text-muted">Daftarkan Akun agar Anda dapat mengajukan pengaduan melalui sistem Kami.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-pencil-alt fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Buat Pengaduan</h4>
                    <p class="text-muted">Sampaikan pengaduan Anda dengan mengisi form dan mengirim gambar untuk memperjelas detail pengeduan.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Konfirmasi</h4>
                    <p class="text-muted">Data Pengaduan yang Anda buat akan segera Kami Konfirmasi.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio Grid-->
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Pengaduan Terbaru</h2>
                <h3 class="section-subheading text-muted">Riwayat pengaduan masyarakat</h3>
            </div>
            <div class="row">
                @foreach($complaints as $key => $complaint)
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <!-- Portfolio item 1-->
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#complaint-modal-{{ $key }}">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" src="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" alt="..." />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading">{{ $complaint->title }}</div>
                                <div class="portfolio-caption-subheading text-muted">{!! limit_text($complaint->description, 10) !!}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Portfolio item 1 modal popup-->
                    <div class="portfolio-modal modal fade" id="complaint-modal-{{ $key }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="close-modal" data-bs-dismiss="modal"><img src="{{ asset('template/landing/assets/img/close-icon.svg') }}" alt="Close modal" /></div>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="modal-body">
                                                <!-- Project details-->
                                                <h2 class="text-uppercase">{{ $complaint->title }}</h2>
                                                <img class="img-fluid d-block mx-auto" src="{{ Storage::disk('local')->url('complaint-image/'. $complaint->complaintImages()->first()->image) }}" alt="..." />
                                                <p>{!! $complaint->description !!}</p>
                                                <ul class="list-inline">
                                                    <li>
                                                        <strong>Nama Pengadu:</strong>
                                                        {{ $complaint->user->name }}
                                                    </li>
                                                    <li>
                                                        <strong>Kategori Pengaduan:</strong>
                                                        @if($complaint->level == 'rendah')
                                                            <span class="badge alert-info">{{ ucFirst($complaint->level) }}</span>
                                                        @elseif($complaint->level == 'sedang')
                                                        <span class="badge alert-warning">{{ ucFirst($complaint->level) }}</span>
                                                        @elseif($complaint->level == 'tinggi')
                                                        <span class="badge alert-danger">{{ ucFirst($complaint->level) }}</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                                <button class="btn btn-primary btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                                    <i class="fas fa-xmark me-1"></i>
                                                    Tutup Jendela
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="page-section" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Form Pengaduan</h2>
                <h3 class="section-subheading text-muted">Isi form pengaduan dibawah ini.</h3>
            </div>
            <!-- * * * * * * * * * * * * * * *-->
            <!-- * * SB Forms Contact Form * *-->
            <!-- * * * * * * * * * * * * * * *-->
            <!-- This form is pre-integrated with SB Forms.-->
            <!-- To make this form functional, sign up at-->
            <!-- https://startbootstrap.com/solution/contact-forms-->
            <!-- to get an API token!-->
            <form id="contactForm" action="{{ route('landing.complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-stretch mb-5">
                    <div class="col-md-6">
                        <div class="form-group mb-md-0">
                            <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Judul pengaduan"/>
                            <div class="invalid-feedback">A judul harus diisi.</div>
                        </div>  
                        <div class="form-group form-group-textarea mb-md-0 mt-1">
                            <!-- Message input-->
                            <textarea class="form-control" id="description" name="description" placeholder="Keterangan lengkap *" >{{ old('description') }}</textarea>
                            <div class="invalid-feedback">Keterangan lengkap.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-md-0">
                            <!-- Phone number input-->
                            <div class="card mb-1">
                                <div class="card-header"><label for="image_description">Gambar Penjelas</label></div>
                            </div>
                            
                            <input class="form-control" id="image_description" type="file" name="image_description"/>
                            <div class="invalid-feedback">A phone number is required.</div>
                        </div>  
                    </div>
                </div>
                <!-- Submit success message-->
                <!---->
                <!-- This is what your users will see when the form-->
                <!-- has successfully submitted-->
                <div class="d-none" id="submitSuccessMessage">
                    <div class="text-center text-white mb-3">
                        <div class="fw-bolder">Form submission successful!</div>
                        To activate this form, sign up at
                        <br />
                        <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                    </div>
                </div>
                <!-- Submit error message-->
                <!---->
                <!-- This is what your users will see when there is-->
                <!-- an error submitting the form-->
                {{-- <div id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div> --}}
                <!-- Submit Button-->
                <div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" id="submit" type="submit">Kirim Pengaduan</button></div>
            </form>
        </div>
    </section>
    
@endsection
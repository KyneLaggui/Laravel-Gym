@extends('layout')
@section('content')


    <form method="post" action="{{ route('registration.post') }}">
        @csrf
        <section class="vh-100" style="background-color: #eee;">
            <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
        
                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
        
                        <form class="mx-1 mx-md-4">

                            {{-- Start of Name --}}
                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="name" id="form3Example1c" class="form-control" />
                                    <label class="form-label" for="form3Example1c">Your Name</label>
                                    @if ($errors-> has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- End of Name --}}

                            {{-- Start of Email --}}
                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="email" name="email" id="form3Example3c" class="form-control" />
                                    <label class="form-label" for="form3Example3c">Your Email</label>
                                    @if ($errors-> has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- End of Email --}}
        
                            {{-- Start of Password --}}
                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="password" name="password" id="form3Example4c" class="form-control" />
                                    <label class="form-label" for="form3Example4c">Password</label>
                                    @if ($errors-> has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- End of Password --}}
                            
                            {{-- Start of Button --}}
                            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                <button type="Submit" name="submit" value="Submit" class="btn btn-primary btn-lg" style="width: 100%;">Register</button>
                            </div>
                            {{-- End of Button --}}
        
                        </form>
        
                        </div>
                        <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
        
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                            class="img-fluid" alt="Sample image">
        
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </form>
@endsection
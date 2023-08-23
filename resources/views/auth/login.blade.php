@extends('layout')
@section('content')
@if (Session::has('danger'))

@endif
    <form method="post" action="{{ route('login.post') }}">
        @csrf
        <section class="vh-100">
            <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
        
                    <div class="mb-md-5 mt-md-4 pb-5">
            
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-black-50 mb-5">Please enter your login and password!</p>
                            @if (Session::has("success"))
                                
                                <script type="text/javascript">
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                        })
                                
                                        Toast.fire({
                                        icon: 'success',
                                        title: '{{ Session::get('success')->first() }}'
                                    })
                                </script>
                                
                            @elseif (Session::has("errors"))
                                <script type="text/javascript">
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                        })
                                
                                        Toast.fire({
                                        icon: 'error',
                                        title: '{{ Session::get('errors')->first() }}'
                                    })
                                </script>
                            @endif
                            <div class="form-outline mb-4">
                                <input type="email" id="typeEmailX" class="form-control form-control-lg border-black" name="email" />
                                <label class="form-label" for="typeEmailX">Email</label>
                                {{-- @if ($errors-> has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif --}}
                            </div>
            
                            <div class="form-outline mb-4">
                                <input type="password" id="typePasswordX" class="form-control form-control-lg border-black" name="password"/>
                                <label class="form-label" for="typePasswordX" >Password</label>
                                {{-- @if ($errors-> has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif --}}
                            </div>
            
                            <p class="small mb-5 pb-lg-2"><a class="text-black-50" href="#!">Forgot password?</a></p>
                        
        
                        <button class="btn btn-outline-black btn-lg px-5" name="submit" type="submit" style="width: 100%">Login</button>
        
                        
        
                    </div>
        
                    <div>
                        <p class="mb-0">Don't have an account? <a href="{{ url('registration') }}" class="text-black-50 fw-bold">Sign Up</a>
                        </p>
                    </div>
        
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    </form>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.css') }}">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>

    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <div class="container py-3">
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                    <span class="fs-4">{{ config('app.name') }}</span>
                </a>

                @if(Route::has('login'))
                    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="me-3 py-2 text-dark text-decoration-none">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="me-3 py-2 text-dark text-decoration-none">Log in</a>

                            @if(Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 me-3 py-2 text-dark text-decoration-none">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main>
            <section>
                <img src="screenshot.png" alt="screenshot" width="100%"  />
            </section>
            <section class="mt-4">
                <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4 fw-normal">Pricing</h1>
                    <p class="fs-5 text-muted">Quickly build an effective pricing table for your potential customers
                        with
                        this Bootstrap example. It’s built with default Bootstrap components and utilities with little
                        customization.</p>
                </div>
                <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Starter</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$99<small
                                        class="text-muted fw-light">/mo</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>100 jobs - per day</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-outline-primary">Sign up for
                                    free</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Intermediate</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$249<small
                                        class="text-muted fw-light">/mo</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>300 jobs - per day</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Get started</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-primary">
                            <div class="card-header py-3 text-white bg-primary border-primary">
                                <h4 class="my-0 fw-normal">Advanced</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$449<small
                                        class="text-muted fw-light">/mo</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>1000 jobs - per day</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Contact us</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="pt-4 my-md-5 pt-md-5 border-top">
        </footer>
    </div>
</body>

</html>

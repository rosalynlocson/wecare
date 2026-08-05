<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare — Clinic Management System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=quicksand:600,700|manrope:400,500,600|ibm-plex-mono:500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy: #1B3E6F;
            --teal: #1EA99C;
            --accent: #2D6BB0;
            --slate: #5B6B7A;
            --paper: #F7FBFA;
        }
        body {
            background: var(--paper);
            color: #1A2B3C;
            font-family: 'Manrope', sans-serif;
        }
        .font-display { font-family: 'Quicksand', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }

        .blob {
            position: absolute;
            border-radius: 999px;
            filter: blur(80px);
            opacity: 0.22;
            z-index: 0;
        }

        .status-dot { animation: dotpulse 2.4s ease-in-out infinite; }
        @keyframes dotpulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.35; }
        }

        .module-card {
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }
        .module-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(27, 62, 111, 0.22);
            border-color: var(--teal);
        }

        .hero-icon {
            animation: float 5s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (prefers-reduced-motion: reduce) {
            .status-dot, .hero-icon { animation: none !important; }
            .module-card:hover { transform: none; }
        }

        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--teal);
            outline-offset: 3px;
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden">

    <div class="blob w-96 h-96 -top-16 -right-16" style="background: var(--teal)"></div>
    <div class="blob w-80 h-80 top-1/3 -left-24" style="background: var(--accent)"></div>

    <div class="relative z-10">
        <!-- Nav -->
        <header class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5">
                <img src="{{ asset('images/we-icon.png') }}" alt="" class="h-9 w-9" aria-hidden="true">
                <span class="font-display text-xl font-bold tracking-tight">
                    <span style="color: var(--teal)">We</span><span style="color: var(--navy)">Care</span>
                </span>
            </a>
            <a href="{{ route('login') }}"
               class="font-mono text-xs px-5 py-2.5 rounded-full text-white transition-transform hover:-translate-y-0.5"
               style="background: var(--teal)">
                Sign in &rarr;
            </a>
        </header>

        <!-- Hero -->
        <section class="max-w-6xl mx-auto px-6 pt-6 pb-20 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 mb-7 px-3 py-1.5 rounded-full font-mono text-xs tracking-wide"
                     style="background: rgba(30,169,156,0.1); color: var(--teal)">
                    <span class="status-dot inline-block w-1.5 h-1.5 rounded-full" style="background: var(--teal)"></span>
                    Systems nominal
                </div>

                <h1 class="font-display text-4xl sm:text-5xl font-bold leading-[1.15]" style="color: var(--navy)">
                    Run the front desk without losing the thread.
                </h1>

                <p class="mt-6 text-lg max-w-md leading-relaxed" style="color: var(--slate)">
                    Patients, appointments, records, and billing — one shared chart,
                    every desk in sync.
                </p>

                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 mt-9 px-7 py-3.5 rounded-full text-white font-semibold text-sm transition-transform hover:-translate-y-0.5"
                   style="background: var(--teal); box-shadow: 0 10px 24px -8px rgba(30,169,156,0.4)">
                    Sign in to WeCare
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="flex justify-center">
                <img src="{{ asset('images/we-icon.png') }}" alt="WeCare — a heart, a hand, and a cross"
                     class="hero-icon w-56 sm:w-72">
            </div>
        </section>

        <!-- Module cards -->
        <section class="max-w-6xl mx-auto px-6 pb-20">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="module-card p-6 rounded-2xl bg-white" style="border: 1.5px solid rgba(27,62,111,0.1)">
                    <svg class="w-6 h-6 mb-3" fill="none" viewBox="0 0 24 24" stroke="var(--teal)" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="font-display font-bold" style="color: var(--navy)">Patients</p>
                    <p class="text-sm mt-1.5 leading-relaxed" style="color: var(--slate)">Register, search, and edit patient charts in seconds.</p>
                </div>

                <div class="module-card p-6 rounded-2xl bg-white" style="border: 1.5px solid rgba(27,62,111,0.1)">
                    <svg class="w-6 h-6 mb-3" fill="none" viewBox="0 0 24 24" stroke="var(--teal)" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="font-display font-bold" style="color: var(--navy)">Appointments</p>
                    <p class="text-sm mt-1.5 leading-relaxed" style="color: var(--slate)">Book by doctor and time slot — double-bookings blocked automatically.</p>
                </div>

                <div class="module-card p-6 rounded-2xl bg-white" style="border: 1.5px solid rgba(27,62,111,0.1)">
                    <svg class="w-6 h-6 mb-3" fill="none" viewBox="0 0 24 24" stroke="var(--teal)" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="font-display font-bold" style="color: var(--navy)">Records</p>
                    <p class="text-sm mt-1.5 leading-relaxed" style="color: var(--slate)">Visit notes, attachments, and an audit trail on every entry.</p>
                </div>

                <div class="module-card p-6 rounded-2xl bg-white" style="border: 1.5px solid rgba(27,62,111,0.1)">
                    <svg class="w-6 h-6 mb-3" fill="none" viewBox="0 0 24 24" stroke="var(--teal)" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="font-display font-bold" style="color: var(--navy)">Billing</p>
                    <p class="text-sm mt-1.5 leading-relaxed" style="color: var(--slate)">Generate, track, and print invoices per visit.</p>
                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer class="max-w-6xl mx-auto px-6 pb-10 flex items-center gap-2">
            <img src="{{ asset('images/we-icon.png') }}" alt="" class="h-5 w-5 opacity-60" aria-hidden="true">
            <p class="font-mono text-xs" style="color: var(--slate)">
                WeCare &middot; San Pablo City, Laguna &middot; Staff sign-in only
            </p>
        </footer>
    </div>

</body>
</html>
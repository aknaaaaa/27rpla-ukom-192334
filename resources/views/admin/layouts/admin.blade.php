<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - D\'Kasuari')</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --text-main: #2c2c2c;
            --muted: #9a9a9a;
            --badge-bg: #d9d9d9;
            --shadow: 0 14px 22px rgba(0,0,0,0.08);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            color: var(--text-main);
            background: #f9f9f9;
        }
        .dashboard-shell { display: flex; min-height: 100vh; }
        .sidebar {
            width: 230px;
            background: #fff;
            box-shadow: 8px 0 26px rgba(0,0,0,0.06);
            padding: 28px 22px;
            position: relative;
            z-index: 2;
        }
        .brand { margin-bottom: 18px; }
        .brand__name {
            font-family: 'Mea Culpa', cursive;
            font-size: 28px;
            margin: 0;
            line-height: 1.1;
        }
        .brand__address {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            letter-spacing: 0.4px;
            color: var(--muted);
            text-transform: uppercase;
        }
        .menu { margin-top: 40px; display: grid; gap: 18px; padding: 0; list-style: none; }
        .menu__item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: 1px;
            font-size: 13px;
            text-transform: uppercase;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .menu__item:hover { color: #000; transform: translateX(4px); }
        .menu__item.is-active { font-weight: 600; }
        .menu__icon { font-size: 20px; width: 22px; text-align: center; }
        .main {
            flex: 1;
            position: relative;
            padding: 20px 34px 40px;
            overflow: hidden;
            background: #fcfcfc;
        }
        .main::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(120deg, rgba(0,0,0,0.04) 0, rgba(0,0,0,0.04) 1px, transparent 1px, transparent 22px),
                repeating-linear-gradient(60deg, rgba(0,0,0,0.035) 0, rgba(0,0,0,0.035) 1px, transparent 1px, transparent 26px);
            opacity: 0.35;
            pointer-events: none;
        }
        .content { position: relative; z-index: 1; }
        .top-line { border-bottom: 1px solid #e0e0e0; margin: 8px 0 20px; }
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.35);
            z-index: 30;
            padding: 16px;
            font-family: 'Aboreto', sans-serif;
        }
        .modal.is-open { display: flex; }
        .form-card{
            background: #fff;
            border: 1px solid #d8d8d8;
            border-radius: 12px;
            padding: 18px;
            box-shadow: var(--shadow);
            width: min(700px, 100%);
            max-height: 90vh;
            overflow: auto;
        }
        .form-grid{
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        .field label{
            display: block;
            font-size: 12px;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }
        .field input,
        .field textarea,
        .field select{
            width: 100%;
            border: 1px solid #cfcfcf;
            background: #f4f4f4;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
        }
        .field textarea{ min-height: 72px; resize: vertical; }
        .actions-inline{
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .btn-new {
            display: inline-block;
            padding: 10px 18px;
            background: #2d2b2b;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.5px;
            font-size: 13px;
            font-family: 'Aboreto', sans-serif;
        }
        .btn-new:hover {
            background: #000;
        }
        .tutup-btn {
            background: #999;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Aboreto', sans-serif;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        .tutup-btn:hover {
            background: #777;
        }
        h1, h2, h3 {
            margin: 0 0 12px 0;
            letter-spacing: 1px;
        }
    </style>
    @yield('extra-css')
</head>
<body>
<div class="dashboard-shell">
    @include('admin.partials.sidebar', ['active' => $active ?? null])
    <main class="main">
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@yield('extra-js')
</body>
</html>

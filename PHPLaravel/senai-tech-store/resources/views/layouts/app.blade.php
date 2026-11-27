<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'SENAI Tech Store — Loja de Informática')</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0f172a; margin: 0; color: #f8fafc; }
        header { background: #1e293b; padding: 16px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; }
        header h1 { font-size: 1.2rem; color: #38bdf8; margin: 0; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .card { background: #1e293b; border-radius: 8px; padding: 25px; border: 1px solid #334155; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.3); }
        .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.88rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #334155; }
        th { color: #94a3b8; font-weight: 600; background: #0f172a; }
        .btn { display: inline-block; background: #0284c7; color: white; padding: 8px 14px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.85rem; border: none; cursor: pointer; }
        .btn:hover { background: #0369a1; }
        footer { text-align: center; padding: 25px 0; color: #64748b; font-size: 0.8rem; border-top: 1px solid #1e293b; margin-top: 50px; }
        .pagination { display: flex; gap: 8px; margin-top: 25px; justify-content: center; list-style: none; padding: 0; }
        .pagination li a, .pagination li span { background: #1e293b; border: 1px solid #334155; color: #cbd5e1; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .pagination li.active span { background: #0284c7; color: white; border-color: #0284c7; }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <h1>💻 SENAI Tech Store</h1>
        <span style="font-size: 0.85rem; color: #94a3b8;">Catálogo Oficial de Hardware e Periféricos</span>
    </header>

    <main class="container">
        @yield('conteudo')
    </main>

    <footer>
        SENAI-SP — Habilitação Técnica em Desenvolvimento de Sistemas | Módulo 3: Migrations, Seeders & Factories
    </footer>
    @stack('scripts')
</body>
</html>

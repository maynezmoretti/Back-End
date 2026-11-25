
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0f172a;
            margin: 0;
            color: #f8fafc;
        }

        .container {
            max-width: 750px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header span {
            color: #38bdf8;
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .header p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .card {
            background: #1e293b;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #334155;
        }

        h1 {
            font-size: 1.5rem;
            color: #38bdf8;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .descricao {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            background: #0f172a;
            padding: 20px;
            border: 1px solid #334155;
            border-radius: 8px;
        }

        .info-item label {
            display: block;
            color: #94a3b8;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .info-item strong {
            color: #f8fafc;
            font-size: 1rem;
        }

        .status {
            margin-top: 25px;
            padding: 15px;
            background: #0c2638;
            border: 1px solid #075985;
            border-radius: 7px;
            color: #7dd3fc;
            font-size: 0.85rem;
        }

        .acoes {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .link-voltar {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .link-voltar:hover {
            color: #38bdf8;
        }

        footer {
            text-align: center;
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 25px;
        }

        @media (max-width: 550px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <span>SENAI ASSET MANAGER</span>
            <p>Gestão de parceiros e contratos industriais</p>
        </div>

        <div class="card">

            <h1>📄 {{ $titulo }}</h1>

            <p class="descricao">
                Consulta de contratos vinculados ao parceiro industrial.
            </p>

            <div class="info-grid">

                <div class="info-item">
                    <label>CLIENTE INDUSTRIAL</label>
                    <strong>{{ $cliente->razao_social }}</strong>
                </div>

                <div class="info-item">
                    <label>ANO DE REFERÊNCIA</label>
                    <strong>{{ $ano }}</strong>
                </div>

            </div>

            <div class="status">
                ✓ Consulta realizada com sucesso.
                Os contratos poderão ser apresentados nesta área
                quando houver registros disponíveis.
            </div>

            <div class="acoes">
                <a href="{{ route('clientes.index') }}" class="link-voltar">
                    ← Voltar para clientes
                </a>
            </div>

        </div>

        <footer>
            SENAI Asset Manager · Sistema de Gestão Industrial
        </footer>

    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Entrada - {{ $ticket->uuid }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f172a;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
        }
        .ticket-container {
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            background-color: #ffffff;
            overflow: hidden;
            border-collapse: collapse;
            width: 100%;
        }
        .header {
            background-color: #1e293b;
            color: #ffffff;
            padding: 25px 30px;
            text-align: left;
        }
        .header h1 {
            margin: 5px 0 0 0;
            font-size: 24px;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        .header h2 {
            margin: 0;
            font-size: 10px;
            color: #3b82f6;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .content {
            padding: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
        }
        .label {
            font-size: 9px;
            color: #64748b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .qr-section {
            text-align: center;
            vertical-align: middle;
            width: 35%;
        }
        .qr-image {
            width: 140px;
            height: 140px;
            display: inline-block;
            border: 1px solid #e2e8f0;
            padding: 8px;
            background-color: #ffffff;
            border-radius: 8px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 15px;
            text-align: center;
            font-size: 8px;
            color: #64748b;
            font-weight: bold;
            letter-spacing: 2px;
            line-height: 1.6;
            border-top: 1px solid #f1f5f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            background-color: #dcfce7;
            color: #15803d;
            border-radius: 9999px;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h2>Official Digital Ticket</h2>
            <h1>{{ $ticket->match->homeTeam->name }} VS {{ $ticket->match->awayTeam->name }}</h1>
            <p style="margin: 8px 0 0 0; font-size: 11px; color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                {{ $ticket->match->competition }} &bull; {{ \Carbon\Carbon::parse($ticket->match->match_date)->translatedFormat('d \d\e F, Y - H:i') }} h
            </p>
        </div>
        
        <div class="content">
            <table class="info-table">
                <tr>
                    <td style="width: 65%;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 50%; padding-bottom: 20px;">
                                    <div class="label">Sector / Zona</div>
                                    <div class="value" style="text-transform: uppercase;">{{ $ticket->seat->sector->name }}</div>
                                </td>
                                <td style="width: 50%; padding-bottom: 20px;">
                                    <div class="label">Fila / Asiento</div>
                                    <div class="value">Fila {{ $ticket->seat->row }} &bull; Asiento {{ $ticket->seat->number }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-bottom: 20px;">
                                    <div class="label">Titular de la Entrada</div>
                                    <div class="value">{{ $ticket->user->name }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50%;">
                                    <div class="label">Inversión</div>
                                    <div class="value" style="color: #2563eb;">{{ number_format($ticket->price_paid, 2) }}€</div>
                                </td>
                                <td style="width: 50%;">
                                    <div class="label">Estado</div>
                                    <div><span class="badge">Válida</span></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="qr-section">
                        @if($qrBase64)
                            <img src="{{ $qrBase64 }}" class="qr-image" alt="QR Code">
                        @else
                            <div style="border: 1px solid #cbd5e1; width: 140px; height: 140px; line-height: 140px; color: #94a3b8; font-size: 10px;">QR CODE</div>
                        @endif
                        <div style="font-size: 8px; color: #64748b; font-weight: bold; margin-top: 8px; letter-spacing: 1px;">
                            ID: {{ strtoupper(explode('-', $ticket->uuid)[0]) }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            ESTA ENTRADA ES PERSONAL E INTRANSFERIBLE &bull; PROHIBIDA LA REVENTA<br>
            © LAB STOCKS &bull; ENTERPRISE TICKETING SOLUTIONS
        </div>
    </div>
</body>
</html>

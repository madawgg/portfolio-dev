<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background-color:#0f172a;padding:20px 32px;">
                            <p style="margin:0;color:#34d399;font-size:14px;font-family:monospace;">&lt;/&gt; Portfolio</p>
                            <h1 style="margin:8px 0 0;color:#ffffff;font-size:20px;">Has recibido un correo en el portfolio</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px;">
                            <p style="margin:0 0 6px;color:#64748b;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">De</p>
                            <p style="margin:0 0 20px;color:#0f172a;font-size:15px;">{{ $contactMessage->sender_email }}</p>

                            <p style="margin:0 0 6px;color:#64748b;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Motivo</p>
                            <p style="margin:0 0 20px;color:#0f172a;font-size:15px;">{{ $contactMessage->subject }}</p>

                            <p style="margin:0 0 6px;color:#64748b;font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Mensaje</p>
                            <p style="margin:0;color:#0f172a;font-size:15px;line-height:1.6;white-space:pre-line;">{{ $contactMessage->message }}</p>

                            <a href="{{ route('admin.mensajes.show', $contactMessage) }}"
                               style="display:inline-block;margin-top:24px;background-color:#10b981;color:#0f172a;font-weight:bold;font-size:15px;padding:12px 28px;border-radius:8px;text-decoration:none;">
                                Ver el mensaje en el panel
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px;background-color:#f8fafc;border-top:1px solid #e2e8f0;">
                            <p style="margin:0;color:#94a3b8;font-size:12px;">
                                Recibido el {{ $contactMessage->created_at->format('d/m/Y H:i') }}.
                                Puedes responder directamente a este correo. El enlace al panel requiere iniciar sesión.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

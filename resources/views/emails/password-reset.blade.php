<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - BSMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-container {
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px 20px;
            background: white;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1 style="margin: 0; font-size: 28px;">🔐 BSMS</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Bank Server Management System</p>
        </div>
        
        <div class="email-body">
            <h2 style="color: #667eea; margin-top: 0;">Réinitialisation de votre mot de passe</h2>
            
            <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
            
            <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte BSMS associé à l'adresse email <strong>{{ $user->email }}</strong>.</p>
            
            <div class="info-box">
                <strong>📧 Informations de votre compte :</strong><br>
                • Email : {{ $user->email }}<br>
                • Rôle : <span style="text-transform: capitalize;">{{ $user->role }}</span><br>
                • Demande effectuée le : {{ now()->format('d/m/Y à H:i') }}
            </div>
            
            <p>Pour créer un nouveau mot de passe, cliquez sur le bouton ci-dessous :</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="btn">
                    🔑 Réinitialiser mon mot de passe
                </a>
            </div>
            
            <p>Ou copiez et collez ce lien dans votre navigateur :</p>
            <p style="word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                {{ $url }}
            </p>
            
            <div class="warning-box">
                <strong>⚠️ Important :</strong><br>
                • Ce lien est valide pendant <strong>24 heures</strong> seulement<br>
                • Il ne peut être utilisé qu'une seule fois<br>
                • Si vous n'avez pas demandé cette réinitialisation, ignorez cet email<br>
                • Votre mot de passe actuel reste inchangé tant que vous n'utilisez pas ce lien
            </div>
            
            <h3 style="color: #667eea;">Conseils pour un mot de passe sécurisé :</h3>
            <ul>
                <li>Au moins 8 caractères</li>
                <li>Mélange de lettres majuscules et minuscules</li>
                <li>Inclure des chiffres</li>
                <li>Utiliser des caractères spéciaux (!@#$%^&*)</li>
                <li>Éviter les informations personnelles</li>
            </ul>
            
            <p>Si vous avez des questions ou des problèmes, contactez l'équipe d'administration BSMS.</p>
            
            <p>Cordialement,<br>
            <strong>L'équipe BSMS</strong></p>
        </div>
        
        <div class="email-footer">
            <p>Cet email a été envoyé automatiquement par le système BSMS.<br>
            Merci de ne pas répondre à cet email.</p>
            <p style="margin-top: 10px;">
                <strong>Bank Server Management System</strong><br>
                Système de gestion sécurisé des serveurs bancaires
            </p>
        </div>
    </div>
</body>
</html>

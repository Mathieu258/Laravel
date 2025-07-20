<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre demande - Eat&Drink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ef4444;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ef4444;
            margin-bottom: 10px;
        }
        .info-icon {
            font-size: 48px;
            color: #ef4444;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
        .highlight {
            background-color: #fef2f2;
            padding: 15px;
            border-left: 4px solid #ef4444;
            margin: 20px 0;
        }
        .motif {
            background-color: #f8fafc;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🍽️ Eat&Drink</div>
            <div class="info-icon">ℹ️</div>
            <h1 style="color: #ef4444; margin: 0;">Réponse à votre demande</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $user->name }}</strong>,</p>

            <p>Nous avons examiné votre demande d'inscription en tant qu'entrepreneur pour l'événement <strong>Eat&Drink</strong>.</p>

            <div class="highlight">
                <p><strong>📋 Statut de votre demande :</strong></p>
                <p>Après analyse de votre dossier, nous regrettons de vous informer que votre demande n'a pas pu être acceptée pour cette édition de l'événement.</p>
            </div>

            @if($motif)
                <div class="motif">
                    <p><strong>📝 Motif :</strong></p>
                    <p>{{ $motif }}</p>
                </div>
            @endif

            <p>Nous vous remercions pour l'intérêt que vous portez à notre événement et nous espérons pouvoir vous accueillir lors d'une prochaine édition.</p>

            <p>Si vous souhaitez plus d'informations ou si vous pensez qu'il y a eu une erreur, n'hésitez pas à nous contacter.</p>

            <div style="text-align: center;">
                <a href="{{ route('welcome') }}" class="button">Retourner sur le site</a>
            </div>

            <p>Cordialement,<br>
            <strong>L'équipe Eat&Drink</strong></p>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
            <p>© 2025 Eat&Drink - Tous droits réservés</p>
        </div>
    </div>
</body>
</html> 
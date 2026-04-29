<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Gestion des notes</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/auth/authenticate" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" 
                       value="<?= old('email', $default_email ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" 
                       value="<?= $default_password ?? '' ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
<header class="bg-primary text-white d-flex justify-content-center p-3">
    <h1>TodoList</h1>
</header>
<main class="d-flex align-items-center flex-column">
    <section class="d-flex align-items-center flex-column w-75 my-1">
        <?php if (isset($notifications)) { ?>
            <?php foreach ($notifications as $key => $notification) { ?>
                <div class="alert alert-<?= $notification["type"] ?>" role="alert">
                    <?= $notification["message"] ?>
                </div>
            <?php } ?>
        <?php } ?>
        <h2>Connexion</h2>
        <form action="/login" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Surnom</label>
                <input type="text" class="form-control" id="username" name="username" autocomplete="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password"
                    autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <hr>
            <a href="/register">Vous n'avez pas un compte ? inscrivez-vous !</a>
        </form>
    </section>
</main>
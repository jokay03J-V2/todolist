<header class="bg-primary text-white d-flex justify-content-center p-3">
    <h1>TodoList</h1>
</header>
<main>
    <?php if (isset($notifications)) { ?>
        <?php foreach ($notifications as $key => $notification) { ?>
            <div class="alert alert-<?= $notification["type"] ?>" role="alert">
                <?= $notification["message"] ?>
            </div>
        <?php } ?>
    <?php } ?>
    <a href="/" class="d-block mx-auto">Retourner à l'accueil</a>
</main>
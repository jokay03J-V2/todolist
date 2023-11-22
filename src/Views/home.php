<header class="bg-primary text-white d-flex justify-content-center p-3">
    <h1>TodoList</h1>
</header>
<main class="d-flex align-items-center flex-column justify-content-center pt-4 w-100">
    <form class="d-flex align-items-center mb-2 gap-1" action="/" method="POST">
        <input type="text" maxlength="255" required class="form-control" id="todo" placeholder="Entrer votre todo"
            name="content">
        <button type="submit" class="btn btn-success h-fit">Envoyer</button>
    </form>
    <div class="w-75 d-flex flex-column align-items-center gap-2">
        <?php if (isset($todos)) { ?>
            <?php foreach ($todos as $key => $todo) { ?>
                <hr class="w-100 my-2">
                <div class="w-75 d-flex align-items-center justify-content-between todocontainer"
                    data-id="<?= htmlspecialchars($todo["TODO_ID"]) ?>">
                    <div class="h-100 w-15">
                        <div>
                            <?= htmlspecialchars($todo["TODO_CONTENT"]) ?>
                        </div>
                        <div>
                            <?= date("d-m-Y H:i:s", strtotime($todo["TODO_CREATED_AT"])) ?>
                        </div>
                    </div>
                    <div class="w-15">
                        <button type="button" class="btn btn-warning text-white editBtn">
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                        </button>
                        <a href="/todo/delete?id=<?= $todo["TODO_ID"] ?>" class="btn btn-danger text-white">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</main>
<script src="<?= $ressources->get("js/edit.js") ?>"></script>
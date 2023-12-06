<?php
// Load css
$ressources->css("css/todo.css");
?>
<header class="bg-primary text-white d-flex justify-content-evenly p-3">
    <h1>TodoList</h1>
    <?php if ($userConnected) { ?>
        <a href="/account/logout" class="btn btn-danger d-flex align-items-center justify-content-center">Se déconnecter</a>
    <?php } ?>
</header>
<main class="d-flex align-items-center flex-column justify-content-center pt-4 w-100">
    <form class="d-flex align-items-center mb-2 gap-1" action="/" method="POST">
        <input type="text" maxlength="255" required class="form-control" id="todo" placeholder="Entrer votre todo"
            name="content">
        <button type="submit" class="btn btn-success h-fit">Envoyer</button>
    </form>
    <div class="d-flex flex-column align-items-center gap-2">
        <?php if (isset($todos)) { ?>
            <ul class="list-group d-flex flex-column align-items-center">
                <?php foreach ($todos as $key => $todo) { ?>
                    <li class="list-group-item w-75" data-id="<?= htmlspecialchars($todo["TODO_ID"]) ?>">
                        <div class="w-100 mw-100 d-flex align-items-center gap-1 justify-content-between todocontainer"
                            data-id="<?= htmlspecialchars($todo["TODO_ID"]) ?>">
                            <div class="h-100 max-vw-100 todo">
                                <div class="w-100 text-wrap text-break">
                                    <?= trim(stripslashes(htmlentities($todo["TODO_CONTENT"], ENT_HTML5))) ?>
                                </div>
                                <div>
                                    <?= date("d-m-Y H:i:s", strtotime($todo["TODO_CREATED_AT"])) ?>
                                </div>
                            </div>
                            <div class="w-15 gap-1 todo-controls">
                                <button type="button" class="btn btn-warning text-white editBtn">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </button>
                                <a href="/todo/delete?id=<?= htmlspecialchars($todo["TODO_ID"]) ?>"
                                    class="btn btn-danger text-white">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</main>
<?php
// Load js files
$ressources->js("js/edit.js");
?>
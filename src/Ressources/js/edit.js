const todosContainer = document.querySelectorAll(".todocontainer");
const editBtns = document.querySelectorAll(".todocontainer .editBtn");

for (let index = 0; index < editBtns.length; index++) {
    const editBtn = editBtns[index];
    editBtn.addEventListener("click", () => {

        // Create form
        const form = document.createElement("form");
        form.classList.add("d-flex", "align-items-center", "justify-content-center", "gap-2", "w-100")
        form.action = "/todo/update";
        form.method = "POST";
        // Create input
        const input = document.createElement("input");
        // Set value of todo
        input.value =
            todosContainer[index].children[0].children[0].textContent.trim();
        input.classList.add("form-control")
        input.name = "content";

        // Create submit button
        const buttonSubmit = document.createElement("button")
        buttonSubmit.classList.add("btn", "btn-success");
        buttonSubmit.textContent = "Changer"

        // Append input and submit button in the form
        form.appendChild(input);
        form.appendChild(buttonSubmit);
        // Hide all children
        const children = [...todosContainer[index].children]
        children.forEach((el) => el.style.display = "none")

        // Append form to container
        todosContainer[index].appendChild(form);

        // Handle submit of form
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            // Access to form data
            const dataForm = new FormData(form, buttonSubmit);
            const request = new XMLHttpRequest();
            request.open("POST", "/todo/update");

            // Data to be send to the API
            const bodyTobeSend = new FormData();
            // Append todo content and todo id to be updated
            bodyTobeSend.append("content", dataForm.get("content"));
            bodyTobeSend.append("id", todosContainer[index].dataset["id"]);

            request.onreadystatechange = (e) => {
                // Check if request is done
                if (request.readyState === XMLHttpRequest.DONE) {
                    // Check if response has been correctly updated todo
                    if (request.status === 204) {
                        document.location.href = "/";
                    } else {
                        alert("Une erreur est survenue veuillez réessayer plus tard.")
                    }
                }
            }
            request.send(bodyTobeSend);
        })
    })
}
const todosContainer = document.querySelectorAll(".todocontainer");
const editBtns = document.querySelectorAll(".todocontainer .editBtn");
const todoControls = document.querySelectorAll(".todocontainer > .todo-controls");

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
        input.maxLength = "255";
        input.required = true;

        // Create submit button
        const buttonSubmit = document.createElement("button")
        buttonSubmit.classList.add("btn", "btn-success");
        buttonSubmit.textContent = "Changer"

        // Append input and submit button in the form
        form.appendChild(input);
        form.appendChild(buttonSubmit);
        // Get only valid element(don't blank html node)
        const children = [...todosContainer[index].childNodes].filter((el) => el.nodeName !== "#text");
        // Hide all children
        children.forEach((el) => el.classList.add("hidden"))

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
                    if (request.status === 200) {
                        const response = JSON.parse(request.response);
                        // Update text content
                        todosContainer[index].children[0].children[0].textContent = response["content"];
                        // Update date
                        todosContainer[index].children[0].children[1].textContent = response["updatedAt"];
                        // Set element at first
                        const firstTodo = document.querySelector(".list-group-item:first-of-type");
                        // Get current li
                        const elementToByPlaced = document.querySelector(`li[data-id="${todosContainer[index].dataset["id"]}"]`)
                        // Insert current li before first li
                        firstTodo.insertAdjacentElement("beforebegin", elementToByPlaced);
                        // Display todo
                        children.forEach((el) => el.classList.remove("hidden"));
                        // Remove update form
                        form.remove();
                    } else {
                        alert("Une erreur est survenue veuillez réessayer plus tard.")
                    }
                }
            }
            request.send(bodyTobeSend);
        })
    })
}
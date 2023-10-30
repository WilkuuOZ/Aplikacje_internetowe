const addBtn = document.getElementById("addBtn");
const inputTask = document.getElementById("inputAdd");
const divTask = document.getElementById("container");
const inputSearch=document.getElementById("searchInput");
const inputDate=document.getElementById("inputDate");
const arrayTask = loadLocalstorage() || [];
let idCounter = 0;

function addTask() {
    const taskValue = inputTask.value;
    const dateValue = inputDate.value;
    const today = new Date();
    const userInput = new Date(dateValue);

    if (taskValue.trim() !== "" && taskValue.length >= 3 && taskValue.length <= 255) {
        if (dateValue === "" || userInput >= today) {
            const task = {
                id: idCounter++,
                deadLine: dateValue,
                text: taskValue,
            };
            arrayTask.push(task);
            inputTask.value = "";
            inputDate.value = "";
            saveToLocalStorage();
            renderList();
        } else {
            window.alert(`Data musi być pusta lub w przyszłości.
            Proszę wprowadź dane jeszcze raz :).`);
        }
    } else {
        window.alert("Zadanie nie może być puste oraz musi zawierać od 3 do 255 znaków.");
    }
}

function deleteTask(id, item) {
    const index = arrayTask.findIndex(function (task) {
        return task.id === id;
    });
    if (index !== -1) {
        arrayTask.splice(index, 1);
        saveToLocalStorage();
        divTask.removeChild(item);
    }
}
inputSearch.addEventListener("input",function(){

    renderList();
});

addBtn.addEventListener("click", addTask);

function renderList() {
    const searchPhrase = inputSearch.value.toLowerCase().trim();

    divTask.innerHTML = "";
    for (const task of arrayTask) {
        const phrase = task.text;
        const item = document.createElement("li");

    
        const taskText = document.createElement("span");
        taskText.textContent = task.text;
        taskText.addEventListener("click", function () {
            console.log("kliknieto w zadanie");
            editTaskText(task, taskText, item, deleteBtn);
        });

        
        const taskDate = document.createElement("span");
        taskDate.textContent = `Czas wykonania: ${task.deadLine}`;
        taskDate.addEventListener("click", function () {
            console.log("kliknieto w date");
            editTaskDate(task, taskDate, item, deleteBtn);
        });

        item.appendChild(taskText);
        item.appendChild(taskDate);

        if (searchPhrase && phrase.toLowerCase().includes(searchPhrase)) {
            const mark = phrase.replace(new RegExp(searchPhrase, 'gi'), match => `<mark>${match}</mark>`);
            taskText.innerHTML = `${mark}`;
            taskDate.textContent = ` Czas wykonania: ${task.deadLine}`;
            item.style.display = 'block';
        } else if (!searchPhrase) {
            taskText.textContent = `Zadanie: ${task.text}`;
            taskDate.textContent = ` Czas wykonania: ${task.deadLine}`;
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }

        divTask.appendChild(item);

        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Usuń zadanie";
        deleteBtn.addEventListener("click", function () {
            deleteTask(task.id, item);
        });
        item.appendChild(deleteBtn);
    }
}


function saveToLocalStorage() {
    localStorage.setItem("tasks", JSON.stringify(arrayTask));
}

function loadLocalstorage() {
    const tasks = localStorage.getItem("tasks");
    return tasks ? JSON.parse(tasks) : null;
}

document.addEventListener("click", function (event) {
    if (event.target !== inputText && event.target !== inputDate) {
       
        saveToLocalStorage();
        renderList();
    }
});



//Funkcja obsługująca edycje treści zadania
function editTaskText(task, taskText, item, deleteBtn) {
    const inputText = document.createElement("input");
    inputText.type = "text";
    inputText.value = task.text;

  
    inputText.addEventListener("input", function () {
        const newText = inputText.value;
        task.text = newText;
        saveToLocalStorage();
    });

    inputText.addEventListener("blur", function () {
        taskText.style.display = "inline"; 
        inputText.style.display = "none"; 
        deleteBtn.style.display = "inline"; 
        renderList(); 
    });

    taskText.style.display = "none"; 
    item.appendChild(inputText);
    inputText.focus(); 
    deleteBtn.style.display = "none"; 
}


//Funckja obsługująca edycje daty
function editTaskDate(task, taskDate, item, deleteBtn) {
    const inputDate = document.createElement("input");
    inputDate.type = "date";
    inputDate.value = task.deadLine;

    inputDate.addEventListener("input", function () {
        const newDate = inputDate.value;
        task.deadLine = newDate;
        saveToLocalStorage();
    });

    inputDate.addEventListener("blur", function () {
        taskDate.style.display = "inline"; 
        inputDate.style.display = "none"; 
        deleteBtn.style.display = "inline"; 
        renderList(); 
    });

    taskDate.style.display = "none"; 
    item.appendChild(inputDate);
    inputDate.focus(); 
    deleteBtn.style.display = "none";  
}

function checkLocalStorage() {
    const storedData = loadLocalstorage();
    if (storedData) {
        console.log("Zawartość Local Storage:");
        console.log(storedData);
    } else {
        console.log("Local Storage jest puste lub nie zawiera danych.");
    }

    console.log("Zawartość tablicy arrayTask:");
    console.log(arrayTask);
}

checkLocalStorage();



renderList();
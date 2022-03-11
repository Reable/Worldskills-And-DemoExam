function getAllTasks(){
    return JSON.parse(localStorage.getItem('tasks')||'[]')
}
function preparationDataWithRender(){
    let allTasks = getAllTasks()
    let html  = `<div class="allTasks">`;
    let app = document.getElementById('app')

    allTasks.map((elem,i) =>{
        if(elem.deleteMarker !== 1){
            if(elem.completed !== 1){
                html += renderTasks(elem)
            }
        }
    })
    html += `</div>`
    app.innerHTML = html

    document.querySelectorAll('div.allTasks div.block #checkboxAdd').forEach(elem => elem.addEventListener('click',()=>{
        completeTask(elem.parentNode.parentNode.id)
    }))
    document.querySelectorAll('div.allTasks div.block #checkboxDelete').forEach(elem => elem.addEventListener('click',()=>{
        deleteTask(elem.parentNode.parentNode.id)
        console.log(elem.parentNode.parentNode.id)
    }))
    taskOverdue()
}
function renderTasks(data){
    let completed
    let idCheckbox;
    switch (data.completed){
        case 0: completed = 'Активно';idCheckbox = '<input id="checkboxAdd" type="checkbox">'; break
        case 1: completed = 'Завершено';
            idCheckbox = '';
        break
        case 2: completed = 'Просрочено';idCheckbox = '<input id="checkboxDelete" type="button" value="Удалить">'; break
    }
    return `
        <div class="block" id="block_${data.id}">
            <div class="name-task">
                <h3>${data.task}</h3>${idCheckbox}
            </div>
            <div class="task-all-description">
                <p>Информация о задаче ${completed}</p>
                <p>Срок выполнения до ${new Date(data.date).toLocaleDateString()}</p>
            </div>
        </div>
    `
}
//Завершенные работы
function renderCompletedTask(){
    let allTasks = getAllTasks()
    let html  = `<div class="allTasks">`;
    let app = document.getElementById('app')

    allTasks.map((elem,i) =>{
       if(elem.completed === 1){
           html += renderTasks(elem)
       }
    })

    html += `</div>`
    app.innerHTML = html
    colorsTaskCompleted()
}
function renderActiveTask(){
    let allTasks = getAllTasks()
    let html  = `<div class="allTasks">`;
    let app = document.getElementById('app')

    allTasks.map((elem,i) =>{
        if(elem.completed === 0){
            html += renderTasks(elem)
        }
    })
    html += `</div>`
    app.innerHTML = html
}

function taskOverdue(){
    let allTasks = getAllTasks()
    let overdueTask = []
    allTasks.forEach(elem => {
        if(new Date(elem.date) < new Date){
            elem.completed = 2
        }
        overdueTask.push(elem)
    })
    localStorage.setItem('tasks',JSON.stringify(overdueTask))
    colorsTaskOverdue()
}
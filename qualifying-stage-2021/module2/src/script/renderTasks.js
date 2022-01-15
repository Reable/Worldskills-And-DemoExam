function getAllTasks(){
    return JSON.parse(localStorage.getItem('tasks')||'[]')
}
function preparationDataWithRender(){
    let allTasks = getAllTasks()
    let html  = `<div class="allTasks">`;
    let app = document.getElementById('app')

    allTasks.map((elem,i) =>{
        if(elem.completed !== 1){
            html += renderTasks(elem)
        }
    })
    html += `</div>`
    app.innerHTML = html

    document.querySelectorAll('div.allTasks div.block #checkbox')
        .forEach(elem => elem.addEventListener('click',()=>{
        completeTask(elem.parentNode.parentNode.id)
    }))
    taskOverdue()
}
function renderTasks(data){
    let completed
    switch (data.completed){
        case 0: completed = 'Активно'; break
        case 1: completed = 'Завершено'; break
        case 2: completed = 'Просрочено'; break
    }
    return `
        <div class="block" id="block${data.id}">
            <div class="name-task">
                <h3>${data.task}</h3><input id="checkbox" type="checkbox">
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
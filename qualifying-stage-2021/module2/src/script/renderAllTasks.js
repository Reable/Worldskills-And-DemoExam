function getAllTasks(){
    return JSON.parse(localStorage.getItem('tasks')||'[]')
}
function preparationDataWithRender(){
    let allTasks = getAllTasks()
    let html;
    let app = document.getElementById('app')
    allTasks.map(elem =>{
        html += renderAllTasks(elem)
    })
    app.innerHTML = html
}

function renderAllTasks(data){
    return `
        <div class="allTasks">
            <div class="block">
                <div class="name-task">
                    <h3>${data.task}</h3>
                </div>
                <div class="task-all-description">
                    <p>${new Date(data.date).getFullYear()}</p>
                </div>
                
            </div>
        </div>
    `
}
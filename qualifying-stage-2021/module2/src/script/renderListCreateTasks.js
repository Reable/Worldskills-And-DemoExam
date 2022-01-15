function renderListCreateTasks(){
    return `
        <div class="create-task-form">
            <h2>Добавление задачи</h2>
            <form id="create-task-form">
                <input type="text" name="task" placeholder="Введите задачу">
                <input type="datetime-local" name="date" placeholder="Выберите срок">
                <button type="submit" id="createUnderTasks">Добавить подзадачу</button>
                <button type="submit" id="createTask">Добавить задачу</button>
            </form>
        </div>
    `
}
//Функция добавления добавления вопросов
function buttonCreateTask(event){
    event.preventDefault()
    let task = {}
    let allTasks = getAllTasks()
    let form = document.forms['create-task-form']

    let id = allTasks.length

    if(isValidForm(form)){
        task = {
            id:id,
            task:form.elements['task'].value,
            date:form.elements['date'].value,
            completed:0
        }
        allTasks.push(task)
        localStorage.setItem('tasks',JSON.stringify(allTasks))

        preparationDataWithRender()
    }else{
        alert('Ошибка ввода данных( Проверьте поле: даты или поле: задачи )')
    }

}
function isValidForm(form){
    let task = form.elements['task'].value
    let date = form.elements['date'].value
    if(new Date(date) < new Date()) {
        return false
    } else if(task === '' || date === ''){
        return false
    }
    return true
}
//Функция завершения задачи
function completeTask(idBlock){
    let block = document.getElementById(`block${idBlock}`)
    block.style = 'border-left:10px solid green;box-shadow:0 0 20px green;'
    let idTask = getAllTasks().findIndex(elem => elem.id === Number(idBlock))
    let allTasks = getAllTasks()
    allTasks[idTask].completed = 1
    localStorage.setItem('tasks',JSON.stringify(allTasks))
}
//Перекрашивание всех завершенных заданий
function colorsTaskCompleted(){
    let allTasks = getAllTasks()
    allTasks.forEach((elem,i) => {
        if(elem.completed === 1){
            document.getElementById(`block${elem.id}`).style = 'border-left:10px solid green;box-shadow:0 0 20px green;'
        }
    })
}
function colorsTaskOverdue(){
    let allTasks = getAllTasks()
    allTasks.forEach((elem,i) => {
        if(elem.completed === 2){
            document.getElementById(`block${elem.id}`).style = 'border-left:10px solid red;box-shadow:0 0 20px red;'
        }
    })
}
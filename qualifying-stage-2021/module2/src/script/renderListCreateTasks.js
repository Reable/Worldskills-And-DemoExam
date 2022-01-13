function renderListCreateTasks(){
    return `
        <div class="create-task-form">
            <h2>Добавление задачи</h2>
            <form id="create-task-form">
                <input type="text" name="task" placeholder="Введите задачу">
                <input type="date" name="date" placeholder="Выберите срок">
                <button type="submit" id="createUnderTasks">Добавить подзадачу</button>
                <button type="submit" id="createTask">Добавить задачу</button>
            </form>
        </div>
    `
}
function buttonCreateTask(event){
    event.preventDefault()
    let task = {}
    let allTasks = getAllTasks()
    let button = document.querySelector('div.create-task-form #createTask')
    let form = document.forms['create-task-form']
    if(!isValidForm(form)){
        task = {
            task:form.elements['task'].value,
            date:form.elements['date'].value
        }
    }else{
        return alert('Вы забыли ввести данные')
    }
    button.disabled = true
    allTasks.push(task)
    localStorage.setItem('tasks',JSON.stringify(allTasks))
    button.disabled = false
    preparationDataWithRender()
}
function isValidForm(form){
    let task = form.elements['task'].value
    let date = form.elements['date'].value
    return task === '' || date === '' || date <= new Date()
}
let dateNow,app

//Подключение к месту DOM
app = document.getElementById('app')

window.addEventListener('load',()=>{
    worksWithHeader()
    colorWeek()
    preparationDataWithRender()
    outputFormCreateTasks()
    document.querySelector('header div.create-task h2').addEventListener('click',()=>{
        preparationDataWithRender()
    })
    document.querySelector('header p.completed').addEventListener('click',()=>{
        renderCompletedTask()
    })
    document.querySelector('header p.active').addEventListener('click',()=>{
        renderActiveTask()
    })
})


function outputFormCreateTasks(){
    const button = document.querySelector('header #openFormCreate')

    button.addEventListener('click',(e)=>{
        app.innerHTML = renderListCreateTasks()

        document.querySelector('#app #createTask').addEventListener('click',(event)=>{
            buttonCreateTask(event)
        })
    })
}

function worksWithHeader(){
    dateNow = new Date().toLocaleDateString()
    document.getElementById('date').innerHTML = dateNow
}
function colorWeek(){
    let color = [
        'red','#FF3235','orange','yellow','green'
    ]
    let data = document.querySelectorAll('div.date-week h3')
    data.forEach((elem,i) =>{
        elem[i] = `border:2px solid ${color[i]};`
    })
}
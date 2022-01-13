outputFormCreateTasks()
console.log(new Date('2022-01-21').toTimeString())
preparationDataWithRender()
let app = document.getElementById('app')

function outputFormCreateTasks(){
    const button = document.querySelector('header #openFormCreate')
    button.addEventListener('click',(e)=>{
        app.innerHTML = renderListCreateTasks()
        document.querySelector('#app #createTask').addEventListener('click',(event)=>{
            buttonCreateTask(event)
        })
    })
}

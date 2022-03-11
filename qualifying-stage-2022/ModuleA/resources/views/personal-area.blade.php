@extends('layout')

@section('title')

@endsection

@section('main')
    <div class="content">
        <div class="info-page">
            <h2>Personal Area</h2>
        </div>
        <div class="personal-area">
            <div class="info">
                <div class="image"></div>
                <div class="data">
                    <h2 id="name">Name: </h2>
                    <h2 id="login">Login: </h2>
                    <a href=""></a>
                </div>
            </div>
            <div class="news">
                <div class="info-page">
                    <h2>Добавлние новости</h2>
                </div>
                <form enctype="multipart/form-data" id="addNews">
                    <input type="text" name="company" id="company" placeholder="Название компании">
                    <input type="text" name="title" id="title" placeholder="Название новости">
                    <input type="text" name="category" id="category" placeholder="Категория новости">
                    <label for="image" class="image-label">
                        Добавьте обложку картинке
                        <input type="file" id="image" name="image">
                    </label>
                    <textarea name="description" id="description" placeholder="Описание новости"></textarea>
                    <button>Добавить новость</button>
                </form>
                <div class="info-page">
                    <h2>Ваши новости</h2>
                </div>
                <div class="all-news"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let user = JSON.parse(localStorage.getItem('user'))
        if(!user){
            location.href = '/'
        }

        window.addEventListener('load',()=>{
            updateInfoPerson()
            getMyNews()
        })

        function updateInfoPerson(){
            if(user.image !== undefined || user.image){
                let image = document.querySelector('div.image')
                image.innerHTML += `<img src="{{asset('storage/app')}}/${user.image}">`
            }
            let info = document.querySelectorAll('div.info h2')
            for(key in user){
                info.forEach(elem =>{
                    if(elem.id === key){
                        elem.append(user[key])
                    }
                })
            }
        }

        function getMyNews(){
            fetch('http://module/api/my-news/'+user.id)
                .then(res => res.json())
                .then(res => {
                    let allNews = document.querySelector('div.all-news')
                    if(res.data.news.length <=0){
                        allNews.innerHTML = '<h3>На данный момент записей не опубликованно</h3>'
                    }else{
                        let html = ``
                        res.data.news.forEach(elem =>{
                            html += `
                            <div class="oneNew">
                                <div class="image"><img src="{{asset('storage/app')}}/${elem.image}" alt=""></div>
                                <div class="infoNews">
                                    <h2 class="title">${elem.title}</h2>
                                    <p class="category">Категория: ${elem.category}</p>
                                    <p class="description">${elem.description}</p>
                                    <div class="about">
                                        <p class="gray small">${elem.company}</p>
                                    </div>
                                </div>
                            </div>
                        `
                        })
                        allNews.innerHTML = html
                    }
                })
        }

        let form = document.querySelector('form#addNews')
        form.addEventListener('submit',(e)=>{
            e.preventDefault()

            let data = document.forms['addNews']
            let formData = new FormData()

            formData.append('user_id',user.id)
            formData.append('company',data.elements['company'].value)
            formData.append('title',data.elements['title'].value)
            formData.append('category',data.elements['category'].value)
            formData.append('image',data.elements['image'].files[0])
            formData.append('description',data.elements['description'].value)

            fetch('http://module/api/add-news',{
                method:'POST',
                body:formData
            })
                .then(res => res.json())
                .then(res => {

                    let allInput = document.querySelectorAll('form input')
                    let textarea = document.querySelector('form textarea')

                    allInput.forEach(elem => {
                        if(elem.id !== 'image'){
                            elem.style.border = '1px solid black'
                        }
                    })
                    textarea.style.border = '1px solid black'

                    if(res.error){
                        for(key in res.error.errors){
                            allInput.forEach(elem =>{
                                if(elem.id === key){
                                    elem.style.border = '2px solid red'
                                }
                            })
                            if(key === 'description'){
                                textarea.style.border = '2px solid red'
                            }
                        }
                    }else if(res.data){
                        let message = document.querySelector('p.message')
                        message.innerHTML = res.data.message
                        setTimeout(()=>{
                            message.innerHTML = ''
                        },3000)
                        allInput.forEach(elem =>{
                            elem.value = ''
                        })
                        textarea.value = ''
                    }
                })

        })



        let exit = document.getElementById('exit')
        exit.addEventListener('click',()=>{
            localStorage.clear()
        })
    </script>
@endsection

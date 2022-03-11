@extends('layout')

@section('title')
    REGISTER
@endsection

@section('main')
    <div class="content">
        <div class="info-page">
            <h2>Register page</h2>
        </div>
        <form enctype="multipart/form-data" id="register">
            <label for="login">Введите логин:</label>
            <input type="text" id="login" name="login">

            <label for="name">Введите имя:</label>
            <input type="text" id="name" name="name">

            <label for="password">Введите пароль:</label>
            <input type="password" id="password" name="password">

            <label for="image" class="image-label">
                Добавьте картинку
                <input type="file" id="image" name="image">
            </label>

            <button>Регистрация</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        let form = document.querySelector('form#register')
        form.addEventListener('submit',(event)=>{
            event.preventDefault()

            let data = document.forms[0]
            let formData = new FormData()

            formData.append('login',data.elements['login'].value)
            formData.append('name',data.elements['name'].value)
            formData.append('password',data.elements['password'].value)
            formData.append('image',data.elements['image'].files[0])

            fetch('http://module/api/register',{
                method:'POST',
                body:formData,
            })
                .then(res => {
                    return res.json()
                })
                .then(res => {
                    if(res.error){
                        let input = document.querySelectorAll('form input')
                        input.forEach(elem =>{
                            if(!input.name === 'image'){
                                elem.style.border = '1px solid black'
                            }
                        })

                        for(key in res.error.errors){
                            input.forEach(elem =>{
                                if(elem.name === key){
                                    elem.style.border = '2px solid red'
                                    elem.placeholder = res.error.errors[key][0]
                                }
                            })
                        }
                    }
                    if(res.data){
                        location.href = '/login'
                    }
                })
        })
    </script>
@endsection

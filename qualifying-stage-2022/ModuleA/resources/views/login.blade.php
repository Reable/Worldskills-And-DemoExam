@extends('layout')

@section('title')
    LOGIN
@endsection

@section('main')
    <div class="content">
        <div class="info-page">
            <h2>Login page</h2>
        </div>
        <form enctype="multipart/form-data" id="login">
            <label for="login">Введите логин:</label>
            <input type="text" id="login" name="login">

            <label for="password">Введите пароль:</label>
            <input type="password" id="password" name="password">

            <button>Авторизироваться</button>
        </form>
    </div>

@endsection

@section('script')
    <script>
        let form = document.querySelector('form#login')
        form.addEventListener('submit',(event)=>{
            event.preventDefault()

            let data = document.forms[0]
            let formData = new FormData()

            formData.append('login',data.elements['login'].value)
            formData.append('password',data.elements['password'].value)

            fetch('http://module/api/login',{
                method:'POST',
                body:formData
            })
                .then(res => {
                    return res.json()
                })
                .then(res => {
                    if(res.error){
                        let input = document.querySelectorAll('form input')
                        input.forEach(elem => elem.style.border = '1px solid black')

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
                        localStorage.setItem('user',JSON.stringify(res.data.user))
                        localStorage.setItem('open',JSON.stringify(res.data.open))
                        location.href = '/personal-area'
                    }
                })
        })
    </script>
@endsection

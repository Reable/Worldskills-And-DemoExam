@extends('layout')

@section('title')
    Главная
@endsection

@section('main')
    <div class="content">
        <div class="info-page">
            <h2>Все новости</h2>
        </div>
        <div class="all-news">

        </div>
    </div>
@endsection

@section('script')
    <script>
        let user = JSON.parse(localStorage.getItem('user') || '[]')
        let userId = user.id
        fetch('http://module/api/all-news')
            .then(res=>res.json())
            .then(res => {
                let allNews = document.querySelector('div.all-news')
                if(res.data.news.length <=0){
                    allNews.innerHTML = '<h3>На данный момент записей не опубликованно</h3>'
                }else{
                    let html = ``
                    res.data.news.forEach(elem =>{
                        html += `
                            <div class="oneNew" id="news_${elem.news_id}">
                                <div class="image"><img src="{{asset('storage/app')}}/${elem.image}" alt=""></div>
                                <div class="infoNews">
                                    <h2 class="title">${elem.title}</h2>
                                    <p class="category">Категория: ${elem.category}</p>
                                    <p class="description">${elem.description}</p>
                                    <div class="about">
                                        <p class="gray small">${elem.company}</p>
                                    </div>
                                    <button id="new_${elem.news_id}_user_${userId}">Подписаться</button>
                                </div>
                            </div>
                        `
                    })
                    allNews.innerHTML = html
                }

            })
    </script>
@endsection

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('public/src/style.css')}}">
    <title>NEWS | @yield('title')</title>
</head>
<body>
    <header>
        <nav class="content">
            <div class="name-site">
                <a href="/"><h1>News Blog</h1></a>
                <p>site about news testing</p>
            </div>
            <div class="navbar">
                <a href="/">HOME</a>
                <a href="/login" class="whiteHref">LOGIN</a>
                <a href="/register" class="orangeHref">REGISTER</a>
                <a href="/personal-area" class="orangeHref">PERSONAL AREA</a>
                <a href="/" class="orangeHref" id="exit">EXIT</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="message">
            <p class="message">{{$errors->message->first()}}</p>
        </div>
        @yield('main')
    </main>

    <footer>
        <p>Copyrighting &copy; 2022 WorldSkills</p>
    </footer>

    @yield('script')
    <script>

    </script>
</body>
</html>


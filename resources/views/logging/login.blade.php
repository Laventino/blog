 
@extends('logging.index')
@section('title', 'Page Title')
@section('content')
<style>
    .loggin-container{
        height: 100%;
        width: 100%;
        background-color:white;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .loggin-container .card-wrapper{
        width: 390px;
        height: 500px;
        background-color:white;
        box-shadow: 0px 0px 12px 0px #e3e3e3;
        border-radius:2px;
        position: relative;
    }
    .loggin-container .title-main{
        font-size:72px;
        text-align:center;
        margin-top:8px;
        font-family:sans-serif;
    }
    .loggin-container .form-login{
        padding:30px;
    }
    .loggin-container .form-login input{
        width:100%;
        margin:0;
        box-sizing: border-box;
    }
    .loggin-container .Login{
    }
    .loggin-container .btn-submit{
        position: absolute;
        bottom:0;
        right:0;
        margin:30px;
    }
</style>
    <div class="loggin-container">
        <div class="card-wrapper">
            <div class="title-main">Login</div>
            <form action="" method="post" class="form-login">
                <label for="email">email</label><br>
                <input type="email" name="email" id=""><br><br>
                <label for="password">password</label><br>
                <input type="password" name="password" id="">
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
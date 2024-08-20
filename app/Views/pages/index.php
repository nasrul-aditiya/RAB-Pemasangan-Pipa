<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:200,300,400,500,600,700,800,900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'poppins', sans-serif;
        }

        section {
            position: absolute;
            width: 100%;
            min-height: 100vh;
            padding: 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F0F0F0;
        }

        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            position: relative;
            max-width: 80px;
        }

        .content {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content .textBox {
            position: relative;
            max-width: 600px;
        }

        .content .textBox h2 {
            color: #333;
            font-size: 3.7em;
            line-height: 1.4em;
            font-weight: 500;
        }

        .content .textBox h2 span {
            color: #074e7a;
            font-size: 1.2em;
            font-weight: 900;
        }

        .content .textBox a {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 20px;
            background: #5DB05C;
            border-radius: 40px;
            font-weight: 500;
            color: #fff;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .circle {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #696969;
            clip-path: circle(600px at right 800px);
        }
    </style>
</head>

<body>
    <section>
        <div class="circle"></div>
        <header>
            <a href="https://pdamtirtakhatulistiwa.com/" target="_blank">
                <img src="/img/logo.png" class="logo" alt="logo">
            </a>
        </header>
        <div class="content">
            <div class="textBox">
                <h2>Mudah Membuat RAB<br> Dengan <span>E-rab</span></h2>
                <p>Nikmati Kemudahan dan Kecepatan dalam Membuat Rencana Anggaran Biaya untuk Proyek Anda, dengan Fitur-Fitur yang Siap Membantu Anda Mengelola Setiap Detail dari Awal Hingga Akhir.</p>
                <a href="/login">Mulai Sekarang</a>
            </div>
            <div class="imgBox">
                <img src="/img/konstruksi2.png" alt="" class="Konstruksi">
            </div>
        </div>
    </section>
</body>

</html>
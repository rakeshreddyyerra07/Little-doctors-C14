
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Successful - Little Doctors</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(180deg, #dff5ff 0%, #f8fcff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        /* Background decorations */
        .cloud {
            position: absolute;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 100px;
            width: 150px;
            height: 55px;
            opacity: 0.8;
        }

        .cloud::before,
        .cloud::after {
            content: "";
            position: absolute;
            background: white;
            border-radius: 50%;
        }

        .cloud::before {
            width: 65px;
            height: 65px;
            left: 25px;
            top: -30px;
        }

        .cloud::after {
            width: 80px;
            height: 80px;
            right: 20px;
            top: -40px;
        }

        .cloud-one {
            top: 12%;
            left: 5%;
        }

        .cloud-two {
            top: 22%;
            right: 4%;
            transform: scale(0.8);
        }

        .cross {
            position: absolute;
            color: rgba(52, 152, 219, 0.12);
            font-size: 70px;
            font-weight: bold;
        }

        .cross-one {
            left: 8%;
            bottom: 15%;
        }

        .cross-two {
            right: 9%;
            bottom: 20%;
        }

        .star {
            position: absolute;
            color: rgba(255, 193, 7, 0.25);
            font-size: 45px;
        }

        .star-one {
            top: 12%;
            right: 20%;
        }

        .star-two {
            bottom: 12%;
            left: 20%;
        }

        /* Success card */
        .success-card {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 28px;
            padding: 45px 35px;
            text-align: center;
            box-shadow: 0 20px 55px rgba(44, 95, 128, 0.16);
            position: relative;
            z-index: 5;
        }

        .logo {
            width: 190px;
            max-width: 80%;
            height: auto;
            margin-bottom: 25px;
        }

        .success-icon {
            width: 78px;
            height: 78px;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: #e7f8ee;
            border: 3px solid #38b873;
            color: #25a55f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: bold;
        }

        h1 {
            margin: 0 0 14px;
            color: #193b56;
            font-size: 30px;
        }

        .message {
            margin: 0 auto 30px;
            max-width: 390px;
            color: #617487;
            font-size: 16px;
            line-height: 1.7;
        }

        .login-button {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 12px;
            background: #2497d8;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .login-button:hover {
            background: #1684c2;
            transform: translateY(-1px);
        }

        @media (max-width: 600px) {
            body {
                padding: 20px;
            }

            .success-card {
                padding: 35px 22px;
                border-radius: 22px;
            }

            h1 {
                font-size: 25px;
            }

            .message {
                font-size: 15px;
            }

            .cross,
            .star {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="cloud cloud-one"></div>
    <div class="cloud cloud-two"></div>

    <div class="cross cross-one">+</div>
    <div class="cross cross-two">+</div>

    <div class="star star-one">★</div>
    <div class="star star-two">★</div>

    <div class="success-card">

        <img
            src="<?= base_url('assets/images/logo.png') ?>"
            alt="Little Doctors"
            class="logo"
        >

        <div class="success-icon">✓</div>

        <h1>Registration Successful!</h1>

        <p class="message">
            Your Little Doctors account has been created successfully.
            You can now login and start your Little Doctors journey.
        </p>

        <a
            href="<?= base_url('login') ?>"
            class="login-button"
        >
            Go to Login
        </a>

    </div>

</body>
</html>


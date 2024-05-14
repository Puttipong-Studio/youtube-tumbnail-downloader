<?php
    if(isset($_POST['button'])){
        $imgUrl = $_POST['imgurl'];
        $ch = curl_init($imgUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $downloadImg = curl_exec($ch);
        curl_close($ch);
        header('Content-type: image/jpg');
        header('Content-Disposition: attachment;filename="thumbnail.jpg"');
        echo $downloadImg;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Thumbnail Downloader</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <style>
        /* Import Google font - Poppins & Noto */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600;700&family=Poppins:wght@400;500;600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Noto Sans Thai", sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #2F9599;
        }

        ::selection {
            color: #fff;
            background: #2F9599;
        }

        form {
            width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 10px 10px 13px rgba(0, 0, 0, 0.1);
        }

        form header {
            text-align: center;
            font-size: 28px;
            font-weight: 500;
            margin-top: 10px;
            color: #2F9599;
        }

        .url-input .title {
            font-size: 17px;
            color: #373737;
        }

        .url-input .field input {
            height: 100%;
            width: 100%;
            border: none;
            outline: none;
            padding: 10px;
            font-size: 15px;
            margin: 5px 0 10px 0;
            background: #F1F1F7;
            border-bottom: 2px solid #ccc;
            font-family: 'Noto Sans', sans-serif;
        }

        .url-input .field input::placeholder {
            color: #b3b3b3;
        }

        .url-input .field .bottom-line {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 100%;
            background: #2F9599;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        form .preview-area {
            border-radius: 5px;
            height: 220px;
            display: flex;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 2px dashed #E9C46A;
        }

        .preview-area .icon {
            color: #E9C46A;
            font-size: 80px;
        }

        .preview-area span {
            color: #E9C46A;
            margin-top: 25px;
        }

        .download-btn {
            color: #fff;
            height: 53px;
            width: 100%;
            outline: none;
            border: none;
            font-size: 17px;
            font-weight: 500;
            cursor: pointer;
            margin: 30px 0 20px 0;
            border-radius: 5px;
            background: #2F9599;
            pointer-events: none;
            transition: background 0.3s ease;
        }

        .download-btn:hover {
            background: #E76F51;
        }

        @media screen and (max-width: 460px) {
            body {
                padding: 0 20px;
            }

            form header {
                font-size: 24px;
            }

            .url-input .field,
            .download-btn {
                height: 45px;
            }

            .download-btn {
                font-size: 15px;
            }

            .preview-area {
                height: 130px;
            }

            .preview-area .icon {
                font-size: 50px;
            }

            .preview-area span {
                margin-top: 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <header><b>โหลดภาพหน้าปกคลิปวีดีโอ Youtube</b></header>
    <div class="url-input">
        <span class="title">วางลิ้งก์ของวีดีโอที่นี่ :</span>
        <div class="field">
            <input type="text" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ" required>
            <input class="hidden-input" type="hidden" name="imgurl">
            <span class="bottom-line"></span>
        </div>
    </div>
    <h3 class="error" style="display: none;color:red;">ไม่พบภาพหน้าปกคลิปวีดีโอ กรุณาตรวจสอบ URL!</h3>
    <div class="preview-area" style="display: none;">
        <img class="thumbnail" src="" alt="">
        <i class="icon fas fa-cloud-download-alt"></i>
        <span>วางลิ้งก์ของวีดีโอเพื่อดูพรีวิวภาพหน้าปก</span>
    </div>
    <button class="download-btn" type="submit" name="button" style="display: none;">โหลดภาพหน้าปกคลิปวีดีโอ</button>
</form>

<script>
    const urlField = document.querySelector(".field input"),
        previewArea = document.querySelector(".preview-area"),
        imgTag = previewArea.querySelector(".thumbnail"),
        hiddenInput = document.querySelector(".hidden-input"),
        button = document.querySelector(".download-btn");
        error = document.querySelector(".error");

    urlField.onkeyup = () => {
        let imgUrl = urlField.value;
        previewArea.classList.add("active");
        button.style.pointerEvents = "auto";
        if (imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1) {
            let vidId = imgUrl.split('v=')[1].substring(0, 11);
            let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
            imgTag.src = ytImgUrl;
            previewArea.style.display = '';
            button.style.display = '';
            error.style.display = 'none';

        } else if (imgUrl.indexOf("https://youtu.be/") != -1) {
            let vidId = imgUrl.split('be/')[1].substring(0, 11);
            let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
            imgTag.src = ytImgUrl;
            previewArea.style.display = '';
            button.style.display = '';
            error.style.display = 'none';

        } else {
            imgTag.src = "";
            button.style.pointerEvents = "none";
            previewArea.classList.remove("active");
            previewArea.style.display = 'none';
            button.style.display = 'none';
            error.style.display = '';
        }
        hiddenInput.value = imgTag.src;
    }
</script>


    
</body>
</html>

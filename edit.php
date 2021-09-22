<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
    <title>Document</title>
</head>

<body>
    <form method="POST">
        <textarea id="editor">

        </textarea>
        <script>
        CKEDITOR.replace('editor');
        </script>
    </form>
</body>

</html>
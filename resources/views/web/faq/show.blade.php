<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>{{ $faqHtml->title }}</title>
    <link rel="stylesheet" href="http://src.mysada.com/faq/file/css/base2.css"/>
    <link rel="stylesheet" href="http://src.mysada.com/helpSada/file/css/index.css"/>
</head>
<body id="body">
    <div class="text fontFamily">
        <div class="text_header">
            <h1 class="title fontFamilyBold">{{ $faqHtml->title }}</h1>
        </div>
        <div class="text_content">
			{!! $faqHtml->content !!}
        </div>
    </div>
</body>
</html>
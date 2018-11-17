<html>
<head>
    <title>Tests your webserver, PHP and composer class loading</title>
</head>
<body>
    <p>
        <?= hex2bin('70687020776f726b7321') ?>
    </p>
    <p><?php
        require '../vendor/autoload.php';
        use Elasticsearch\ClientBuilder;
        use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

        new ObjectNormalizer();
        ClientBuilder::create();

        print hex2bin('76656e646f7220636c617373657320617265206c6f6164656420636f72726563746c79'). '.';
        ?>
    </p>

</body>
</html>

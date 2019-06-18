<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Microsoft Azure | Dicoding</title>
    <style>
        body {
            font-family: Source Code Pro, monospace;
        }
    </style>
</head>

<body>
    <?php

    require_once 'vendor/autoload.php';
    require_once "./random_string.php";

    use MicrosoftAzure\Storage\Blob\BlobRestProxy;
    use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
    use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
    use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
    use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

    $connectionString = "DefaultEndpointsProtocol=https;AccountName=nasystorage;AccountKey=SXWwmYuRwoohUvibFtYaOzZ8ivryEqiLWACOnt/ZgptfjkyF3AKeEjKqIP2sXfGOefQoeOBPBrQAo8ZMRV4unw==;";

    $blobClient = BlobRestProxy::createBlobService($connectionString);

    $fileToUpload = "img/working.jpg";

    $createContainerOptions = new CreateContainerOptions();
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");

    $containerName = "blockblobs" . generateRandomString();

    try {
        $blobClient->createContainer($containerName, $createContainerOptions);
        $myfile = fopen($fileToUpload, "w") or die("Unable to open file!");
        fclose($myfile);

        echo "Uploading BlockBlob: " . PHP_EOL;
        echo $fileToUpload;
        echo "<br />";

        $content = fopen($fileToUpload, "r");
        $blobClient->createBlockBlob($containerName, $fileToUpload, $content);
        $listBlobsOptions = new ListBlobsOptions();
        $listBlobsOptions->setPrefix("Football");
        echo "These are the blobs present in the container: ";
        do {
            $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob) {
                echo $blob->getName() . ": " . $blob->getUrl() . "<br />";
            }

            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while ($result->getContinuationToken());
        echo "<br />";
        echo "This is the content of the blob uploaded: ";
        $blob = $blobClient->getBlob($containerName, $fileToUpload);
        fpassthru($blob->getContentStream());
        echo "<br />";
    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code . ": " . $error_message . "<br />";
    } catch (InvalidArgumentTypeException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code . ": " . $error_message . "<br />";
    }
    ?>

</body>

</html>
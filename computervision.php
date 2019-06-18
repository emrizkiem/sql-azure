<?php
    if(isset($_POST['submit'])) {
        if(isset($_POST['url'])) {
            $url = $_POST['url'];
        } else {
            header("Location: blob.php");
        }
    } else {
        header("Location: blob.php");
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Microsoft Azure | Dicoding</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <style>
        body {
            font-family: Source Code Pro, monospace;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            font-size: 16px;
            border: 1px solid #DEDEDE;
            padding: 3px 5px;
            color: #303030;
        }

        th {
            background: #cccccc;
            font-size: 16px;
            border-color: #b0b0b0;
        }
    </style>
</head>

<body>
    <h2 style="font-style: bold">Hasil Analisa Cover Buku</h2>
    <p>Berikut ini merupakan hasil analisa foto cover buku yang anda upload.<br> Karakteristik foto tersebut terdapat di kolom <b>Response</b>.</p>
    
    <script type="text/javascript">
        $(document).ready(function() {
            // Replace <Subscription Key> with your valid subscription key.
            var subscriptionKey = "62ead22b8b044cf2951612a22ffbd366";

            // This region.
            var uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

            // Request parameters.
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            // Display the image.
            var sourceImageUrl = "<?php echo $url ?>";
            document.querySelector("#sourceImage").src = sourceImageUrl;

            // Make the REST API call.
            $.ajax({
                url: uriBase + "?" + $.param(params),
 
                // Request headers.
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },
 
                type: "POST",
 
                // Request body.
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })

            .done(function(data) {
                // Show formatted JSON on webpage.
                $("#responseTextArea").val(JSON.stringify(data, null, 2));
            }) 

            .fail(function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
        });
    </script>

    <div id="wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            Response:
            <br><br>
            <textarea id="responseTextArea" class="UIInput" style="width:580px; height:400px;"></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;">
            Source image:
            <br><br>
            <img id="sourceImage" width="400" />
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Microsoft Azure | Dicoding</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <style>
        body {
            font-family: Source Code Pro, monospace;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        function processImage() {
            var subscriptionKey = "62ead22b8b044cf2951612a22ffbd366";
            var uriBase =
                "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };

            var sourceImageUrl = document.getElementById("inputImage").value;
            document.querySelector("#sourceImage").src = sourceImageUrl;

            $.ajax({
                    url: uriBase + "?" + $.param(params),

                    beforeSend: function(xhrObj) {
                        xhrObj.setRequestHeader("Content-Type", "application/json");
                        xhrObj.setRequestHeader(
                            "Ocp-Apim-Subscription-Key", subscriptionKey);
                    },

                    type: "POST",

                    data: '{"url": ' + '"' + sourceImageUrl + '"}',
                })

                .done(function(data) {
                    $("#responseTextArea").val(JSON.stringify(data, null, 2));
                    $("#desc").text(data.description.captions[0].text);

                })

                .fail(function(jqXHR, textStatus, errorThrown) {
                    var errorString = (errorThrown === "") ? "Error. " :
                        errorThrown + " (" + jqXHR.status + "): ";
                    errorString += (jqXHR.responseText === "") ? "" :
                        jQuery.parseJSON(jqXHR.responseText).message;
                    alert(errorString);
                });
        }
    </script>
    <h1>Analyze image:</h1>
    Enter the URL to an image, then click the <strong>Analyze image</strong> button.
    <br><br>
    Image to analyze:
    <input type="text" name="inputImage" id="inputImage" value="https://nasystorage.blob.core.windows.net/emrizkiemzfqtnq/cover-kotlin.jpg" />
    <button onclick="processImage();" style="font-family: Source Code Pro, monospace;">Analyze image</button>
    <br><br>
    <div id=" wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;" style="font-family: Source Code Pro, monospace;">
            Response:
            <br><br>
            <textarea id=" responseTextArea" class="UIInput" style="width:580px; height:400px;"></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;" style="font-family: Source Code Pro, monospace;">
            Source image:
            <br><br>
            <img id=" sourceImage" width="400" />
            <br>
            <p id="desc"></p>
        </div>
    </div>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["data"])) {
    $data = json_decode($_POST["data"], true);
    $phpVariable = $data;
    echo "Data assigned to PHP variable successfully!";
} else {
    http_response_code(400);
    echo "Invalid request!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitch Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .pitch-detail {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }

        .pitch-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .pitch-detail button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .pitch-detail p {
            margin: 10px 0;
        }

        .pitch-detail img {
            width: 100px;
            height: auto;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .pitch-detail form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- <div id="pitch-detail-container">
        <h1>Loading...</h1>
    </div> -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const params = new URLSearchParams(window.location.search);
            const id = params.get('id');

            if (id) {
                fetch(`http://localhost/simple_project_kmd/view/client/test.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.error) {
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'process_data.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                    if (xhr.status === 200) {
                                        console.log(xhr.responseText);
                                    } else {
                                        console.error('Error:', xhr.statusText);
                                    }
                                }
                            };
                            xhr.send(`data=${JSON.stringify(data)}`);
                        } else {
                            document.getElementById('pitch-detail-container').innerHTML = `<p class='error'>${data.error}</p>`;
                        }
                    })
                    .catch(error => {
                        document.getElementById('pitch-detail-container').innerHTML = `<p class='error'>Error: ${error.message}</p>`;
                    });
            } else {
                document.getElementById('pitch-detail-container').innerHTML = `<p class='error'>Error: ID parameter is missing.</p>`;
            }
        });
    </script>
</body>

</html>
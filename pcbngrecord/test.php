<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Input Dynamically with Scrollbar</title>
    <style>
        #container {
            max-height: 80px;
            /* กำหนดความสูงสูงสุดของคอนเทนเนอร์ */
            overflow-y: auto;
            /* เพิ่ม scrollbar เมื่อเกินความสูงสูงสุด */
        }

        .input-group {
            margin-bottom: 10px;
        }

        .remove-btn {
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <form method="post" action="store_data.php">
        <div id="container">
            <div class="input-group">
                <input type="text" name="input[]" placeholder="Enter text">
                <button type="button" class="remove-btn" onclick="removeInput(this)">Remove</button>
            </div>
        </div>

        <button type="button" onclick="addInput()">Add Input</button>
        <button type="submit">Submit</button>
    </form>

    <script>
        function addInput() {
            var container = document.getElementById('container');
            var inputGroup = document.createElement('div');
            inputGroup.className = 'input-group';
            inputGroup.innerHTML = '<input type="text" name="input[]" placeholder="Enter text"><button type="button" class="remove-btn" onclick="removeInput(this)">Remove</button>';
            container.appendChild(inputGroup);
        }

        function removeInput(button) {
            var inputGroup = button.parentNode;
            inputGroup.parentNode.removeChild(inputGroup);
        }
    </script>

</body>

</html>
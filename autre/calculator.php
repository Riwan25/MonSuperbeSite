<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .calculator {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="number"]:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e8;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #2e7d32;
        }
        .error {
            background-color: #ffebee;
            border-color: #f44336;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Basic Calculator</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="num1">First Number:</label>
                <input type="number" step="any" id="num1" name="num1" 
                       value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="operation">Operation:</label>
                <select id="operation" name="operation" required>
                    <option value="">Choose operation</option>
                    <option value="add" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'add') ? 'selected' : ''; ?>>
                        Addition (+)
                    </option>
                    <option value="subtract" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'subtract') ? 'selected' : ''; ?>>
                        Subtraction (-)
                    </option>
                    <option value="multiply" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'multiply') ? 'selected' : ''; ?>>
                        Multiplication (×)
                    </option>
                    <option value="divide" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'divide') ? 'selected' : ''; ?>>
                        Division (÷)
                    </option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="num2">Second Number:</label>
                <input type="number" step="any" id="num2" name="num2" 
                       value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>" 
                       required>
            </div>
            
            <button type="submit" class="btn">Calculate</button>
        </form>

        <?php
        // Process the calculation when form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];
            $operation = $_POST['operation'];
            
            // Validate inputs
            if (is_numeric($num1) && is_numeric($num2) && !empty($operation)) {
                $num1 = floatval($num1);
                $num2 = floatval($num2);
                $result = null;
                $error = false;
                
                // Perform calculation based on operation
                switch ($operation) {
                    case 'add':
                        $result = $num1 + $num2;
                        $operationSymbol = '+';
                        break;
                    case 'subtract':
                        $result = $num1 - $num2;
                        $operationSymbol = '-';
                        break;
                    case 'multiply':
                        $result = $num1 * $num2;
                        $operationSymbol = '×';
                        break;
                    case 'divide':
                        if ($num2 == 0) {
                            $error = true;
                            $errorMessage = "Error: Division by zero is not allowed!";
                        } else {
                            $result = $num1 / $num2;
                            $operationSymbol = '÷';
                        }
                        break;
                    default:
                        $error = true;
                        $errorMessage = "Error: Invalid operation!";
                }
                
                // Display result or error
                if ($error) {
                    echo '<div class="result error">' . $errorMessage . '</div>';
                } else {
                    // Format result to remove unnecessary decimals
                    if (floor($result) == $result) {
                        $formattedResult = number_format($result, 0);
                    } else {
                        $formattedResult = number_format($result, 2);
                    }
                    
                    echo '<div class="result">';
                    echo $num1 . ' ' . $operationSymbol . ' ' . $num2 . ' = ' . $formattedResult;
                    echo '</div>';
                }
            } else {
                echo '<div class="result error">Error: Please enter valid numbers and select an operation!</div>';
            }
        }
        ?>
    </div>
</body>
</html>
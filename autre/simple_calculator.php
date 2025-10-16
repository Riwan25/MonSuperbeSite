<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .calculator {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>Simple Calculator</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <input type="number" name="number1" placeholder="Enter first number" step="any" required 
                       value="<?php echo isset($_POST['number1']) ? htmlspecialchars($_POST['number1']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <select name="operation" required>
                    <option value="">Select operation</option>
                    <option value="add" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'add') ? 'selected' : ''; ?>>Addition (+)</option>
                    <option value="subtract" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'subtract') ? 'selected' : ''; ?>>Subtraction (-)</option>
                    <option value="multiply" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'multiply') ? 'selected' : ''; ?>>Multiplication (×)</option>
                    <option value="divide" <?php echo (isset($_POST['operation']) && $_POST['operation'] == 'divide') ? 'selected' : ''; ?>>Division (÷)</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="number" name="number2" placeholder="Enter second number" step="any" required 
                       value="<?php echo isset($_POST['number2']) ? htmlspecialchars($_POST['number2']) : ''; ?>">
            </div>
            
            <button type="submit">Calculate</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $number1 = $_POST['number1'];
            $number2 = $_POST['number2'];
            $operation = $_POST['operation'];
            
            // Validate inputs
            if (is_numeric($number1) && is_numeric($number2) && !empty($operation)) {
                $num1 = floatval($number1);
                $num2 = floatval($number2);
                $result = null;
                $error = false;
                $operationSymbol = '';
                
                switch ($operation) {
                    case 'add':
                        $result = $num1 + $num2;
                        $operationName = "Addition";
                        $operationSymbol = '+';
                        break;
                    case 'subtract':
                        $result = $num1 - $num2;
                        $operationName = "Subtraction";
                        $operationSymbol = '-';
                        break;
                    case 'multiply':
                        $result = $num1 * $num2;
                        $operationName = "Multiplication";
                        $operationSymbol = '×';
                        break;
                    case 'divide':
                        if ($num2 == 0) {
                            $error = true;
                            $errorMessage = "Error: Division by zero is not allowed!";
                        } else {
                            $result = $num1 / $num2;
                            $operationName = "Division";
                            $operationSymbol = '÷';
                        }
                        break;
                    default:
                        $error = true;
                        $errorMessage = "Error: Invalid operation!";
                }
                
                if ($error) {
                    echo '<div class="result error">' . $errorMessage . '</div>';
                } else {
                    echo '<div class="result success">';
                    echo '<strong>' . $operationName . ' Result:</strong><br>';
                    echo $num1 . ' ' . $operationSymbol . ' ' . $num2 . ' = ' . $result;
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
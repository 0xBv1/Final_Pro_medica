<?php
if($_SERVER["REQUEST_METHOD"] ==="GET"){
    // echo "GET";
    $data = $_GET;
    printf("Data: %s", json_encode($data));
}
// $label_mapping = {
//     'gender': {'Male': 1, 'Female': 0},
//     'yes_no': {'Yes': 1, 'No': 0},
//     'thyroid_function': {'Normal': 0, 'Abnormal': 1},
//     'focality': {'Unifocal': 0, 'Multifocal': 1},
//     'risk': {'Low': 0, 'Intermediate': 1, 'High': 2},
//     'stage': {'I': 0, 'II': 1, 'III': 2, 'IV': 3},
//     'response': {'Excellent': 0, 'Indeterminate': 1, 'Biochemical Incomplete': 2, 'Structural Incomplete': 3}
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="get" >
        <div class="user-details">
            <!-- Input for Age -->
            <div class="regist_input_box">
                <span class="details">Age</span>
                <!-- <input type="text" placeholder="Clump Thickness" required> -->
                <input type="number" name="age" placeholder="Enter Age" required>
            </div>
            <!-- Input for Gender -->
            <div class="regist_input_box">
                <span class="details">Gender</span>
                <!-- <input type="text" placeholder="Uniform Cell Size" required> -->
                <select name="gender">
                    <option value="Gender" disabled selected hidden>Choose Gender</option> 
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                </select>
            </div>
            <!-- Input for Smoking -->
            <div class="regist_input_box">
                <span class="details">Smoking</span>
                <!-- <input type="text" placeholder="Uniform Cell Shape" required> -->
                <select name="smoking">
                    <option value="" disabled selected hidden>Choose Smoking</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Input for History of Smoking -->
            <div class="regist_input_box">
                <span class="details">History of Smoking</span>
                <!-- <input type="text" placeholder="Marginal Adhesion" required> -->
                <select name="hx_smoking">
                    <option value="" disabled selected hidden>Choose History of Smoking</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Input for History of Radiotherapy -->
            <div class="regist_input_box">
                <span class="details">History of Radiotherapy</span>
                <!-- <input type="text" placeholder="Single Epithelial Cell Size" required> -->
                <select name="hx_radiotherapy">
                    <option value="" disabled selected hidden>Choose History of Radiotherapy</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Input for Thyroid Function -->
            <div class="regist_input_box">
                <span class="details">Thyroid Function</span>
                <!-- <input type="text" placeholder="Bare Nuclei" required> -->
                <select name="thyroid_function">
                    <option value="" disabled selected hidden>Choose Thyroid Function</option>
                    <option value="0">Normal</option>
                    <option value="1">Abnormal</option>
                </select>
            </div>
            <!-- Input for Physical Examination -->
            <div class="regist_input_box">
                <span class="details">Physical Examination</span>
                <!-- <input type="text" placeholder="Bland Chromatin" required> -->
                <select name="physical_exam">
                    <option value="" disabled selected hidden>Choose Physical Examination</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Input for Adenopathy -->
            <div class="regist_input_box">
                <span class="details">Adenopathy</span>
                <!-- <input type="text" placeholder="Normal Nucleoli" required> -->
                <select name="adenopathy">
                    <option value="" disabled selected hidden>Choose Adenopathy</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <!-- Input for Pathology -->
            <div class="regist_input_box">
                <span class="details">Pathology</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <input type="number" name="pathology" placeholder="Enter Pathology" required>
            </div>
            <!-- Input for Focality -->
            <div class="regist_input_box">
                <span class="details">Focality</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <select name="focality">
                    <option value="" disabled selected hidden>Choose Focality</option>
                    <option value="0">Unifocal</option>
                    <option value="1">Multifocal</option>
                </select>
            </div>
            <!-- Input for Risk -->
            <div class="regist_input_box">
                <span class="details">Risk</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <select name="risk">
                    <option value="" disabled selected hidden>Choose Risk</option>
                    <option value="0">Low</option>
                    <option value="1">Intermediate</option>
                    <option value="2">High</option>
                </select>
            </div>
            <!-- Input for Tumor size classification -->
            <div class="regist_input_box">
                <span class="details">Tumor size classification</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <input type="number" name="t" placeholder="Enter Tumor size classification" required>
            </div>
            <!-- Input for Lymph node involvement -->
            <div class="regist_input_box">
                <span class="details">Lymph node involvement</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <input type="number" name="n" placeholder="Enter Lymph node involvement" required>
            </div>
            <!-- Input for Metastasis -->
            <div class="regist_input_box">
                <span class="details">Metastasis</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <input type="number" name="m" placeholder="Enter Metastasis" required>
            </div>
            <!-- Input for Stage -->
            <div class="regist_input_box">
                <span class="details">Stage</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <select name="stage">
                    <option value="" disabled selected hidden>Choose Stage</option>
                    <option value="0">I</option>
                    <option value="1">II</option>
                    <option value="2">III</option>
                    <option value="3">IV</option>
                </select>
            </div>
            <!-- Input for Response -->
            <div class="regist_input_box">
                <span class="details">Response</span>
                <!-- <input type="text" placeholder="Mitoses" required> -->
                <select name="response">
                    <option value="" disabled selected hidden>Choose Response</option>
                    <option value="0">Excellent</option>
                    <option value="1">Indeterminate</option>
                    <option value="2">Biochemical Incomplete</option>
                    <option value="3">Structural Incomplete</option>
                </select>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="button">
            <input type="submit" value="Predict Cancer">
        </div>
    </form>


<div id="prediction-result"></div>

<script>
document.getElementById("cancer-prediction-form").addEventListener("submit", async function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    let jsonObject = {};
    formData.forEach((value, key) => { jsonObject[key] = value; });

    try {
        let response = await fetch("http://127.0.0.1:5000/predict", {  // استبدلها بعنوان السيرفر الحقيقي
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(jsonObject)
        });

        let result = await response.json();
        document.getElementById("prediction-result").innerText = "Prediction: " + result.prediction;
    } catch (error) {
        console.error("Error:", error);
        document.getElementById("prediction-result").innerText = "Error occurred while making prediction.";
    }
});
</script>
</body>
</html>
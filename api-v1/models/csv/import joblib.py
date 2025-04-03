import joblib
import numpy as np

def load_model(model_path):
    """Load the pre-trained thyroid cancer detection model."""
    return joblib.load(model_path)

def preprocess_input(age, gender, smoking, hx_smoking, hx_radiotherapy, thyroid_function,
                     physical_exam, adenopathy, pathology, focality, risk, t, n, m, stage, response):
    age = (age - 50) / 15  # Adjust mean and scale based on training data

    return np.array([[age, gender, smoking, hx_smoking, hx_radiotherapy, thyroid_function,
                      physical_exam, adenopathy, pathology, focality, risk, t, n, m, stage, response]])

def predict(model, patient_data):
    """Make a prediction using the trained model."""
    prediction = model.predict(patient_data)
    return 'Cancer Recurred' if prediction[0] == 1 else 'Cancer Not Recurred'

if __name__ == "__main__":
    
    model_path = 'api-v1/models/csv/thyroid_cancer_model.pkl'

    # Load the pre-trained model
    model = load_model(model_path)

    # Collect patient information from user input
    print("Enter patient information:")
    patient_data = preprocess_input(
        age=float(input("Age: ")),
        gender=input("Gender (Male/Female): "),
        smoking=input("Smoking (Yes/No): "),
        hx_smoking=input("History of Smoking (Yes/No): "),
        hx_radiotherapy=input("History of Radiotherapy (Yes/No): "),
        thyroid_function=input("Thyroid Function (Normal/Abnormal): "),
        physical_exam=input("Physical Examination (Yes/No): "),
        adenopathy=input("Adenopathy (Yes/No): "),
        pathology=int(input("Pathology (numeric value): ")),
        focality=input("Focality (Unifocal/Multifocal): "),
        risk=input("Risk (Low/Intermediate/High): "),
        t=input("T (Tumor size classification, numeric): "),
        n=input("N (Lymph node involvement, numeric): "),
        m=input("M (Metastasis, numeric): "),
        stage=input("Stage (I/II/III/IV): "),
        response=input("Response (Excellent/Indeterminate/Biochemical Incomplete/Structural Incomplete): ")
    )

    # Make prediction
    result = predict(model, patient_data)
    print(f"Prediction: {result}")
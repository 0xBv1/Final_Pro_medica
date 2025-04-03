import numpy as np
import joblib

class ThyroidCancerPredictor:
    def __init__(self):
        """Load the trained thyroid cancer model."""
        self.model = joblib.load('api-v1/models/csv/thyroid_cancer_model.pkl')

    def preprocess_input(self, age, gender, smoking, hx_smoking, hx_radiotherapy, thyroid_function,
                         physical_exam, adenopathy, pathology, focality, risk, t, n, m, stage, response):
        age = int(age)
        age = (age - 50) / 15  

        return np.array([[age, gender, smoking, hx_smoking, hx_radiotherapy, thyroid_function,
                          physical_exam, adenopathy, pathology, focality, risk, t, n, m, stage, response]])

    def predict(self, patient_data):
        """Predict thyroid cancer recurrence."""
        processed_data = self.preprocess_input(**patient_data)
        prediction = self.model.predict(processed_data)
        return "Cancer Recurred" if prediction[0] == 1 else "Cancer Not Recurred"

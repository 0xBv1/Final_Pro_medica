import numpy as np
import joblib

class ProstateCancerPredictor:
    def __init__(self):
        """Load the trained prostate cancer model."""
        self.model = joblib.load('api-v1/models/csv/prostate_cancer_model.pkl')

    def predict(self, patient_data):
        """Predict prostate cancer status."""
        processed_data = self.preprocess_input(**patient_data)
        prediction = self.model.predict(processed_data)
        return "Cancer Detected" if prediction[0] == 1 else "Cancer Not Detected"

    def preprocess_input(self, **patient_data):
        """
        Ensure the input features match the format expected by the model.
        You may need to adjust this based on your feature set.
        """
        # Example: Convert input data into a numpy array (reshape if needed)
        feature_values = [
            patient_data['Radius'], patient_data['Area'],
            patient_data['Smoothness'], patient_data['Compactness'],
            patient_data['Symmetry']
        ]
        return np.array(feature_values).reshape(1, -1)


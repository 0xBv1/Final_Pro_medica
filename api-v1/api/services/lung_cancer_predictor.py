# Structured data ML class
import numpy as np
import joblib

class LungCancerPredictor:
    def __init__(self):
        """Load the trained lung cancer model."""
        self.model = joblib.load('api-v1/models/csv/lung_cancer_model.pkl')

    def predict(self, features):
        """Predict lung cancer based on structured data."""
        X_new = np.array([features])
        prediction = self.model.predict(X_new)
        return "Positive" if prediction[0] == 1 else "Negative"

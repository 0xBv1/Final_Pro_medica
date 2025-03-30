# Routes for structured data predictions
from flask import Blueprint, request, jsonify
from api.services.lung_cancer_predictor import LungCancerPredictor

data_bp = Blueprint('data', __name__)
lung_cancer_predictor = LungCancerPredictor()

@data_bp.route("/predict_lung_cancer", methods=["POST"])
def receive_data():
    """Endpoint to predict lung cancer from structured data."""
    data = request.get_json()
    required_fields = ['gender', 'age', 'smoking', 'yellow_fingers', 'anxiety', 'peer_pressure',
                       'chronic_disease', 'fatigue', 'allergy', 'wheezing', 'alcohol_consumption',
                       'coughing', 'shortness_of_breath', 'swallowing_difficulty', 'chest_pain']

    if not all(field in data for field in required_fields):
        return jsonify({"status": "error", "message": "Missing required fields"}), 400
    
    features = [data[field] for field in required_fields]
    
    prediction_result = lung_cancer_predictor.predict(features)
    return jsonify({"status": "success", "prediction": prediction_result}), 200

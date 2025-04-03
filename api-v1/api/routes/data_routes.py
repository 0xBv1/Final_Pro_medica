# Routes for structured data predictions
from flask import Blueprint, request, jsonify
from flask import Blueprint, request, jsonify
from api.services.lung_cancer_predictor import LungCancerPredictor
from api.services.thyroid_canser_predictor import ThyroidCancerPredictor
from api.services.predict_prostate_cancer import ProstateCancerPredictor


data_bp = Blueprint('data', __name__)
thyroid_bp = Blueprint('thyroid', __name__)
prostate_bp = Blueprint('prostate', __name__)

lung_cancer_predictor = LungCancerPredictor()
thyroid_cancer_predictor = ThyroidCancerPredictor()
predict_prostate =ProstateCancerPredictor()

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

@thyroid_bp.route("/predict_thyroid_cancer", methods=["POST"])
def predict_thyroid():
    """Endpoint to predict thyroid cancer recurrence."""
    data = request.get_json()

    required_fields = ['age', 'gender', 'smoking', 'hx_smoking', 'hx_radiotherapy', 'thyroid_function',
                       'physical_exam', 'adenopathy', 'pathology', 'focality', 'risk', 't', 'n', 'm', 'stage', 'response']

    if not all(field in data for field in required_fields):
        return jsonify({"status": "error", "message": "Missing required fields"}), 400



    prediction_result = thyroid_cancer_predictor.predict(data)
    return jsonify({"status": "success", "prediction": prediction_result}), 200



@prostate_bp.route("/predict_prostate_cancer", methods=["POST"])
def predict_prostate_cancer():
    """Endpoint to predict prostate cancer detection."""
    data = request.get_json()

    # Check if the correct features are provided
    required_features = ["Radius", "Area", "Smoothness", "Compactness", "Symmetry"]
    if not all(feature in data for feature in required_features):
        return jsonify({"error": "Missing required features"}), 400

    # Instantiate the predictor and make a prediction
    predict_prostate = ProstateCancerPredictor()
    prediction = predict_prostate.predict(data)

    return jsonify({
        "status": "success","prediction": prediction
    }), 200
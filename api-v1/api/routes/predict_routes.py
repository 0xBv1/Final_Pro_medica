# Routes for handling predictions
import os
import tempfile
from flask import Blueprint, request, jsonify
from werkzeug.utils import secure_filename
from api.utils.validation import validate_request
from api.services.image_predictor import ImagePredictor

predict_bp = Blueprint('predict', __name__)
image_predictor = ImagePredictor()

@predict_bp.route('/one_for_all', methods=['POST'])
def handle_post():
    """Endpoint to classify medical images."""
    file, valid = validate_request(request)
    if not valid:
        return jsonify(file), 400

    filename = secure_filename(file.filename)
    with tempfile.NamedTemporaryFile(delete=False) as temp_file:
        image_path = temp_file.name
        file.save(image_path)

    id = request.form.get('id', '')
    result = image_predictor.predict(id, image_path)
    os.remove(image_path)
    
    return jsonify({"status": "success", "message": f"{result}"}), 200

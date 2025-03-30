# Input validation functions
import os

ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif'}
ALLOWED_IDS = {"brain", "skin", "oral","breast", "lung", "colon", "kidney"}

def allowed_file(filename):
    """Check if the uploaded file has a valid extension."""
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

def validate_request(request):
    """Validate request data before processing."""
    if 'image' not in request.files:
        return {"status": "error", "message": "No image file provided"}, False

    file = request.files['image']
    if not allowed_file(file.filename):
        return {"status": "error", "message": "Invalid file format"}, False

    id = request.form.get('id', '')
    if id not in ALLOWED_IDS:
        return {"status": "error", "message": "Invalid ID provided"}, False

    return file, True

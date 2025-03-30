# image_predictor.py
import cv2
import numpy as np
from keras.models import load_model
from api.utils.image_processing import preprocess_image

class ImagePredictor:

        

    def predict(self, id, image_path):
        # print(id)
        # """Run predictions on an image using the selected model."""
        # self.models = {
        #     "brain": load_model('api-v1/models/BrainTumor10EpochsCategorical.h5'),
        #     "skin": load_model('api-v1/models/Skin_Cancer.keras'),
        #     "oral": load_model('api-v1/models/Oral_cancer.h5'),
        #     "lung": load_model('api-v1/models/lung_cancer_detector.h5'),
        #     "colon": load_model('api-v1/models/Colon_cancer_detector.h5'),
        #     "breast": load_model(r'api-v1\models\breast.keras'),
        #     "kidney": load_model(r'api-v1\\models\\kidney_disease_model_new.h5')
        # }
        # model = self.models.get(id)
        
        # if not model:            
        #     return {"status": "error", "message": "Invalid ID provided"}, 400

        if id =="brain":
            model =load_model('api-v1/models/BrainTumor10EpochsCategorical.h5')
        elif id =="skin":
            model =load_model('api-v1/models/Skin_Cancer.keras')
        elif id =="oral":
            model =load_model('api-v1/models/Oral_cancer.h5')
        elif id =="lung":
            model =load_model('api-v1/models/lung_cancer_detector.h5')
        elif id =="colon":
            model =load_model('api-v1/models/Colon_cancer_detector.h5')
        elif id =="breast":
            model =load_model(r'api-v1\models\breast.keras')
        elif id =="kidney":
            model =load_model(r'api-v1\\models\\kidney_disease_model_new.h5')
        else:            
            return {"status": "error", "message": "Invalid ID provided"}, 400
        # Define image sizes for each model
        img_size = {
            "brain": (64, 64),
            "skin": (32, 32),
            "oral": (224, 224),
            "lung": (224, 224),
            "breast": (299, 299),
            "colon": (224, 224),  # Colon cancer uses 224x224 size
            "kidney": (224, 224)
        }.get(id, (224, 224))  # Default to 224x224 if not specified

        # Preprocess the image
        input_img = preprocess_image(id,image_path, img_size)

        # Make a prediction
        prediction = model.predict(input_img)
        confidence = np.max(prediction) * 100  # Convert to percentage
        # if id == "kidney":
        #     if len(image.shape) == 2:
        #         image = cv2.cvtColor(image, cv2.COLOR_GRAY2RGB)
        # Define class labels for each model
        label_map = {
            "brain": ["Not Tumor", "Tumor"],
            "skin": ["Benign", "Malignant"],
            "oral": ["Benign", "Malignant"],
            "lung": ["Benign", "Malignant", "Squamous"],
            "breast": ["Benign", "Malignant", "Squamous"],
            "colon": ["Benign", "Malignant"],              "kidney": ["Normal", "Cyst", "Tumor", "Stone"]
        }

        predicted_class = label_map[id][np.argmax(prediction)]

        # Return JSON response with prediction
        return {
            "status": "success",
            "prediction": predicted_class,
            "confidence": f"{confidence:.2f}%" 
        }

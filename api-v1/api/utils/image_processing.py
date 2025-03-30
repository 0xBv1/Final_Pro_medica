# imgprocessing functions
import cv2
import numpy as np
from PIL import Image


def preprocess_image(id,image_path, target_size):
    """Resize and normalize the image."""
    if id == "kidney":
        img= cv2.imread(image_path, cv2.IMREAD_GRAYSCALE)
        img= cv2.resize(img, (224, 224))
        # If the model expects 3 channels, expand the grayscale to 3 channels:
        img= np.stack((img,)*3, axis=-1)
        img= img.astype('float32') / 255.0
        img= np.expand_dims(img, axis=0)
        return img
    else:
        img = Image.open(image_path).convert("RGB")
        img = img.resize(target_size)
        img = np.array(img) / 255.0
        img = np.expand_dims(img, axis=0)
        return img

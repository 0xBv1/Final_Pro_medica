from flask import Flask
from flask_limiter import Limiter
from flask_limiter.util import get_remote_address
from api.routes.predict_routes import predict_bp
from api.routes.data_routes import data_bp

app = Flask(__name__)
limiter = Limiter(get_remote_address, app=app, default_limits=["100 per hour"])

app.register_blueprint(predict_bp)
app.register_blueprint(data_bp)

if __name__ == '__main__':
    app.run(debug=True)

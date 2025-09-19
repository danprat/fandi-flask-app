import sys
import face_recognition
import json

# Ambil path gambar dari argumen command line
image_path = sys.argv[1]

try:
    # Muat gambar
    image = face_recognition.load_image_file(image_path)
    # Temukan encoding wajah (hanya ambil yang pertama jika ada banyak)
    face_encodings = face_recognition.face_encodings(image)

    if len(face_encodings) > 0:
        # Ubah ke format list Python biasa dan cetak sebagai JSON
        embedding = face_encodings[0].tolist()
        print(json.dumps({"status": "success", "embedding": embedding}))
    else:
        print(json.dumps({"status": "error", "message": "Wajah tidak terdeteksi."}))
except Exception as e:
    print(json.dumps({"status": "error", "message": str(e)}))
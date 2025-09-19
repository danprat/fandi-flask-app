import sys
import numpy as np
import json

try:
    import face_recognition
    FACE_RECOGNITION_AVAILABLE = True
except ImportError:
    FACE_RECOGNITION_AVAILABLE = False
    print("Warning: face_recognition library not available")

# Ambil path gambar baru dan path file data wajah
unknown_image_path = sys.argv[1]
known_faces_json_path = sys.argv[2]

try:
    # Muat data wajah yang sudah terdaftar dari file JSON
    with open(known_faces_json_path, 'r') as f:
        known_faces_data = json.load(f)

    known_face_encodings = [np.array(face['face_embedding']) for face in known_faces_data]
    known_face_ids = [face['id'] for face in known_faces_data]

    # Muat dan proses gambar baru
    unknown_image = face_recognition.load_image_file(unknown_image_path)
    unknown_encodings = face_recognition.face_encodings(unknown_image)

    if len(unknown_encodings) > 0:
        unknown_encoding = unknown_encodings[0]

        # Bandingkan wajah
        matches = face_recognition.compare_faces(known_face_encodings, unknown_encoding, tolerance=0.5)
        
        match_status = "not_found"
        matched_id = None

        if True in matches:
            first_match_index = matches.index(True)
            matched_id = known_face_ids[first_match_index]
            match_status = "success"
        
        print(json.dumps({"status": match_status, "warga_id": matched_id}))
    else:
        print(json.dumps({"status": "error", "message": "Wajah di gambar absensi tidak terdeteksi."}))
except Exception as e:
    print(json.dumps({"status": "error", "message": str(e)}))